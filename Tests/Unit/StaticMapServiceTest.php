<?php

namespace Unit;

use Denason\Neshan\Exceptions\NeshanException;
use Denason\Neshan\Services\StaticMapService;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase;


class StaticMapServiceTest extends TestCase
{
    protected StaticMapService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new StaticMapService(
            'test_api_key',
            'https://api.neshan.org/v4/statict'
        );
    }

    /** @test
     * @throws NeshanException
     */
    public function it_generates_valid_static_map_url_with_default_parameters()
    {
        $url = $this->service->generate(35.6892, 51.3890);

        $this->assertStringContainsString('https://api.neshan.org/v4/static', $url);
        $this->assertStringContainsString('key=test_api_key', $url);
        $this->assertStringContainsString('zoom=14', $url);
        $this->assertStringContainsString('width=500', $url);
        $this->assertStringContainsString('height=500', $url);
        $this->assertStringContainsString('type=dreamy', $url);
    }


    /** @test
     * @throws NeshanException
     */
    public function it_generates_static_map_url_with_custom_parameters()
    {
        $url = $this->service->generate(
            35.6892,
            51.3890,
            zoom: 16,
            width: 800,
            height: 600,
            type: 'standard-day',
            markerToken: 'abc123'
        );

        $this->assertStringContainsString('zoom=16', $url);
        $this->assertStringContainsString('width=800', $url);
        $this->assertStringContainsString('height=600', $url);
        $this->assertStringContainsString('type=standard-day', $url);
        $this->assertStringContainsString('markerToken=abc123', $url);
    }

    /** @test */
    public function it_throws_exception_for_invalid_lat_lng()
    {
        $this->expectException(NeshanException::class);
        $this->service->generate(999, 999);
    }

    public function test_it_fetches_image_content()
    {
        // Mock HTTP Client
        Http::fake([
            '*' => Http::response('image-binary-content', 200)
        ]);

        $image = $this->service->fetchImage('https://fake-url.com');

        $this->assertEquals('image-binary-content', $image);
    }
    /** @test */
    public function it_throws_exception_when_image_fetch_fails()
    {
        Http::fake([
            '*' => Http::response('Server Error', 500),
        ]);

        $this->expectException(NeshanException::class);
        $this->expectExceptionMessage('Failed to fetch image');

        $this->service->fetchImage('https://example.com/fail.png');
    }

    /** @test */
    public function it_accepts_lat_lng_edge_values()
    {
        $url = $this->service->generate(-90, 180);
        $this->assertStringContainsString('center=-90,180', urldecode($url));
    }

    /** @test */
    public function it_omits_marker_token_if_not_provided()
    {
        $url = $this->service->generate(35.6892, 51.3890);
        $this->assertStringNotContainsString('markerToken=', $url);
    }

    /** @test */
    public function it_throws_exception_when_api_key_is_invalid()
    {

        Http::fake([
            '*' => Http::response(json_encode([
                'status' => 'ERROR',
                'code' => 480,
                'message' => 'API Key not found or is not valid.',
            ]), 480),
        ]);

        $this->expectException(NeshanException::class);
        $this->expectExceptionMessage('Failed to fetch image from Neshan: 480');

        $this->service->fetchImage('https://api.neshan.org/v4/static/some-image-url');
    }

    /** @test */
    public function it_throws_exception_when_base_url_is_invalid()
    {
        Http::fake([
            '*' => Http::response(json_encode([
                'timestamp' => now()->toISOString(),
                'status' => 404,
                'error' => 'Not Found',
                'path' => '/v4/staticv',
            ]), 404),
        ]);

        $invalidService = new StaticMapService(
            'test_api_key',
            'https://api.neshan.org/v4/staticv'
        );

        $this->expectException(NeshanException::class);
        $this->expectExceptionMessage('Failed to fetch image from Neshan: 404');

        $invalidService->fetchImage('https://api.neshan.org/v4/staticv/some-image-url');
    }





}
