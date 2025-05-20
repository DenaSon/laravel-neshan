<?php

namespace Denason\Neshan\Traits;

use Denason\Neshan\Exceptions\NeshanException;

trait ValidatesMapParameters
{
    /**
     *
     * @throws NeshanException
     */
    protected function validateCoordinates($lat, $lng): void
    {

        if (is_null($lat) || is_null($lng)) {
            throw new NeshanException("Latitude and longitude cannot be null.");
        }


        if (!is_numeric($lat) || !is_numeric($lng)) {
            throw new NeshanException("Latitude and longitude must be numeric values.");
        }


        $lat = (float)$lat;
        $lng = (float)$lng;


        if ($lat < -90 || $lat > 90) {
            throw new NeshanException("Latitude must be between -90 and 90.");
        }

        if ($lng < -180 || $lng > 180) {
            throw new NeshanException("Longitude must be between -180 and 180.");
        }
    }


    protected function validateStaticMapArc(int $width, int $height, string $type): void
    {
        if ($width < 250 || $width > 2000) {
            throw new NeshanException("Width must be between 250 and 2000 pixels.");
        }

        if ($height < 1 || $height > 1200) {
            throw new NeshanException("Height must be between 1 and 1200 pixels.");
        }


        if (!property_exists($this, 'allowedTypes') || !is_array($this->allowedTypes)) {
            throw new NeshanException("Allowed map types are not defined in the class.");
        }

        if (!in_array($type, $this->allowedTypes, true)) {
            throw new NeshanException("Invalid map type: `$type`. Allowed types: " . implode(', ', $this->allowedTypes));
        }
    }


    /**
     * @throws NeshanException
     */
    protected function validateStaticMapGenerate(float $lat, float $lng, int $zoom, int $width, int $height, string $type): void
    {

        if ($lat < -90 || $lat > 90) {
            throw new NeshanException("Latitude must be between -90 and 90.");
        }

        if ($lng < -180 || $lng > 180) {
            throw new NeshanException("Longitude must be between -180 and 180.");
        }

        if (!in_array($type, $this->allowedTypes)) {
            throw new NeshanException("Invalid map type: `$type`. Allowed types: " . implode(', ', $this->allowedTypes));
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


    /**
     * @throws NeshanException
     */
    protected function validateHexColor(string $color): void
    {
        if (!preg_match('/^#([A-Fa-f0-9]{6})$/', $color)) {
            throw new NeshanException("Invalid color hex code: $color");
        }
    }

    /**
     * @throws NeshanException
     */
    protected function validateTermString(string $term): void
    {
        $term = trim($term);

        if (empty($term)) {
            throw new NeshanException("Search term cannot be empty.");
        }

        $length = mb_strlen($term);
        if ($length < 2 || $length > 60) {
            throw new NeshanException("Search term must be between 2 and 60 characters.");
        }

        if (!preg_match('/^[\p{L}\p{N} \-.,،]+$/u', $term)) {

            throw new NeshanException("Search term contains invalid characters.");
        }
    }

}
