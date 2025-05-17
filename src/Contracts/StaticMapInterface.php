<?php

namespace Denason\Neshan\Contracts;


interface StaticMapInterface
{
    /**
     * Generate the URL for a static map image from Neshan API.
     *
     * @param float $lat        Center latitude (e.g. 35.6892)
     * @param float $lng        Center longitude (e.g. 51.3890)
     * @param int $zoom         Zoom level (default 14, valid range 4-19)
     * @param int $width Image width in pixels (default 500, min 250, max 2000)
     * @param int $height Image height in pixels (default 500, min 1, max 1200)
 * @param string|null $type Map style/type (default 'neshan').
     *                          Allowed values: 'neshan', 'dreamy', 'standard-day', 'standard-night', 'osm-bright'
     * @param string|null $markerToken Optional marker token string for the map center icon.
     *
     * @return string           Fully qualified URL to request the static map image.
     */
    public function generate(
        float $lat,
        float $lng,
        int $zoom = 14,
        int $width = 500,
        int $height = 500,
        ?string $type = 'dreamy',
        ?string $markerToken = null
    ): string;



    /**
     * Fetch the static map image binary content.
     *
     * @param string $url  Fully generated static map URL
     * @return string      Binary image data
     */
    public function fetchImage(string $url): string;


}
