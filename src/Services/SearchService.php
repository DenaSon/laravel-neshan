<?php

namespace Denason\Neshan\Services;

use Denason\Neshan\Contracts\SearchInterface;
use Denason\Neshan\Exceptions\NeshanException;
use Denason\Neshan\Support\IranProvinces;



class SearchService extends BaseNeshanService implements SearchInterface
{


    protected string $apiKey;
    protected string $baseUrl;

    /**
     * @throws NeshanException
     */
    protected function makeRequest(array $query = []): array
    {
        return $this->sendRequest(
            "{$this->baseUrl}/",
            $query,
            ['Api-Key' => $this->apiKey],
            true // return JSON
        );
    }

    public function __construct(string $apiKey, string $baseUrl)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
    }


    /**
     * @throws NeshanException
     */


    /**
     * {@inheritdoc}
     * @throws NeshanException
     */
    public function findByCoordinate(string $term, ?float $lat = 0, ?float $lng = 0): array
    {
        $this->validateCoordinates($lat, $lng);
        $this->validateTermString($term);

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
        $this->validateTermString($term);
        $coordinate = IranProvinces::getCoordinates($province);

        if (!$coordinate) {
            throw new NeshanException("Invalid province name: '{$province}'");
        }

        return $this->findByCoordinate($term, $coordinate['lat'], $coordinate['lng']);
    }
}
