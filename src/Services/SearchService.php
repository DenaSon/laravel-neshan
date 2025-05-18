<?php

namespace Denason\Neshan\Services;

use Denason\Neshan\Contracts\SearchInterface;
use Denason\Neshan\Exceptions\NeshanException;
use Denason\Neshan\Support\IranProvinces;
use Illuminate\Support\Facades\Http;

class SearchService implements SearchInterface
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct(string $apiKey, string $baseUrl)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    protected function makeRequest(array $query = []): array
    {
        $response = Http::withHeaders([
            'Api-Key' => $this->apiKey,
        ])->get("{$this->baseUrl}/",$query);

        if ($response->failed()) {
            $status = $response->status();
            $body = $response->body();
            throw new NeshanException("Request failed with status code {$status}. Response: {$body}", $status);
        }

        return $response->json();
    }

    /**
     * {@inheritdoc}
     * @throws NeshanException
     */
    public function findByCoordinate(string $term, ?float $lat = 0, ?float $lng = 0): array
    {
        return $this->makeRequest([
            'term' => $term,
            'lat' => $lat,
            'lng' => $lng,
        ]);
    }

    /**
     * {@inheritdoc}
     * @throws NeshanException
     */
    public function findByProvince(string $term, string $province): array
    {
        $province = trim($province);
        $coordinate = IranProvinces::getCoordinates($province);

        if (!$coordinate) {
            throw new NeshanException("Invalid province name: '{$province}'");
        }

        return $this->findByCoordinate($term, $coordinate['lat'], $coordinate['lng']);
    }
}
