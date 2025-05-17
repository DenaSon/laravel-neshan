<?php

namespace Denason\Neshan\Services;

use Denason\Neshan\Contracts\StaticMapInterface;
use Denason\Neshan\Exceptions\NeshanException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
/**
 * Service to generate and fetch static map images from Neshan API.
 *
 * @package Denason\Neshan\Services
 */
class StaticMapService implements StaticMapInterface
{

    protected string $api_key;
    protected string $base_url;


    /**
     * @throws NeshanException
     */
    protected function validateParameters(float$lat,float $lng,int $zoom, int $width, int $height,string $type): void
    {

        if ($lat < -90 || $lat > 90) {
            throw new NeshanException("Latitude must be between -90 and 90.");
        }

        if ($lng < -180 || $lng > 180) {
            throw new NeshanException("Longitude must be between -180 and 180.");
        }

        $allowedTypes = ['neshan', 'dreamy', 'standard-day', 'standard-night', 'osm-bright'];
        if (!in_array($type, $allowedTypes)) {
            throw new NeshanException("Invalid map type: `$type` . Allowed types: " . implode(',', $allowedTypes));
        }

        // Validate zoom
        if ($zoom < 4 || $zoom > 19) {
            throw new NeshanException("Zoom level must be between 4 and 19.");
        }

        // Validate width
        if ($width < 250 || $width > 2000) {
            throw new NeshanException("Width must be between 250 and 2000 pixels.");
        }

        // Validate height
        if ($height < 1 || $height > 1200) {
            throw new NeshanException("Height must be between 1 and 1200 pixels.");
        }
    }


    public function __construct(string $api_key, string $base_url)
    {
        $this->api_key = $api_key;
        $this->base_url = rtrim($base_url, '/');
    }

    /**
     * {@inheritdoc}
     * @throws NeshanException
     */

    public function generate(
        float   $lat,
        float   $lng,
        int     $zoom = 14,
        int     $width = 500,
        int     $height = 500,
        ?string $type = 'dreamy',
        ?string $markerToken = null

    ): string
    {
        $this->validateParameters($lat, $lng, $zoom, $width, $height, $type);


        $query = [
            'key' => $this->api_key,
            'center' => "$lat,$lng",
            'zoom' => $zoom,
            'width' => $width,
            'height' => $height,
            'type' => $type,
        ];

        if (!empty($markerToken)) {
            $query['markerToken'] = $markerToken;
        }

        return $this->base_url . '?' . http_build_query($query);
    }


    /**
     * @throws NeshanException|ConnectionException
     */
    public function fetchImage(string $url): string
    {
        $response = Http::timeout(10)->get($url);

        if ($response->failed()) {

//            \Log::error('Neshan API error', [
//                'status' => $response->status(),
//                'body' => $response->body(),
//                'url' => $url,
//            ]);

            throw new NeshanException(
                "Failed to fetch image from Neshan: {$response->status()} - " . $response->json('message', $response->body())

            );
        }

        return $response->body();
    }




}
