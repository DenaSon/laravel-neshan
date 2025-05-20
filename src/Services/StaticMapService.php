<?php

namespace Denason\Neshan\Services;

use Denason\Neshan\Contracts\StaticMapInterface;
use Denason\Neshan\Exceptions\NeshanException;


/**
 * Service to generate and fetch static map images from Neshan API.
 *
 * @package Denason\Neshan\Services
 */
class StaticMapService extends BaseNeshanService implements StaticMapInterface
{

    protected string $api_key;
    protected string $base_url;
    protected array $allowedTypes = ['neshan', 'dreamy', 'standard-day', 'standard-night', 'osm-bright'];



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
        $this->validateStaticMapGenerate($lat, $lng, $zoom, $width, $height, $type);

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
     * @throws NeshanException
     */
    public function fetchImage(string $url): string
    {
        return $this->sendSimpleRequest($url);

    }

        /**
         * Generate a static map with an arc line between two points.
         *
         * @throws NeshanException
         */
        public
        function generateArcMap(
            float   $fromLatitude,
            float   $fromLongitude,
            float   $toLatitude,
            float   $toLongitude,
            int     $width = 600,
            int     $height = 600,
            string  $type = 'standard-night',
            bool    $dashed = true,
            string  $color = '#FF0AA5',
            ?string $marker1Token = null,
            ?string $marker2Token = null
        ): string
        {

            $this->validateCoordinates($fromLatitude, $fromLongitude);
            $this->validateCoordinates($toLatitude, $toLongitude);
            $this->validateStaticMapArc($width, $height, $type);
            $this->validateHexColor($color);


            $query = [
                'key' => $this->api_key,
                'type' => $type,
                'from' => "$fromLongitude,$fromLatitude",
                'to' => "$toLongitude,$toLatitude",
                'width' => $width,
                'height' => $height,
                'dashed' => $dashed ? 'true' : 'false',
                'color' => $color,
            ];


            if ($marker1Token) {
                $query['marker1Token'] = $marker1Token;
            }

            if ($marker2Token) {
                $query['marker2Token'] = $marker2Token;
            }

            return $this->base_url . '/arc?' . $this->buildQuery($query);


        }


        /**
         * {@inheritdoc}
         */
        public
        function getMapTypes(): array
        {
            return $this->allowedTypes;
        }

    }
