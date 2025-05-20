<?php

namespace Denason\Neshan\Services;

use Denason\Neshan\Exceptions\NeshanException;
use Denason\Neshan\Traits\ValidatesMapParameters;
use Illuminate\Support\Facades\Http;

/**
 * Base abstract service class for Neshan API services.
 *
 * Provides common HTTP request methods and query builder.
 */
abstract class BaseNeshanService
{
    use ValidatesMapParameters;

    /**
     * Build a URL-encoded query string from an array of parameters.
     *
     * Boolean values are converted to 'true'/'false',
     * floats are formatted with 4 decimal places,
     * and values are rawurlencoded.
     *
     * @param array<string, mixed> $params Key-value pairs for query parameters.
     * @return string Encoded query string suitable for URLs.
     */
    protected function buildQuery(array $params): string
    {
        return collect($params)->map(function ($value, $key) {
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            } elseif (is_float($value)) {
                $value = number_format($value, 4, '.', '');
            }

            $encodedValue = implode(',', array_map('rawurlencode', explode(',', $value)));

            return rawurlencode($key) . '=' . $encodedValue;
        })->implode('&');
    }

    /**
     * Send a simple GET request to a full URL and return the response body.
     *
     * Retries 2 times on failure and times out after 10 seconds.
     *
     * @param string $url Full URL to send the GET request to.
     * @return string Raw response body.
     *
     * @throws NeshanException On HTTP failure or unexpected errors.
     */
    protected function sendSimpleRequest(string $url): string
    {
        try {
            $response = Http::retry(2)->timeout(10)->get($url);

            if ($response->failed()) {
                throw new NeshanException("Request failed with status: " . $response->status());
            }

            return $response->body();
        } catch (\Exception $e) {
            throw new NeshanException("Unexpected error occurred while requesting Neshan API.", 0, $e);
        }
    }

    /**
     * Send a GET request to an endpoint with optional query parameters and headers.
     *
     * Can return JSON-decoded array if `$asJson` is true, otherwise raw body string.
     *
     * @param string $endpoint API endpoint (full URL or relative path).
     * @param array<string, mixed> $query Optional query parameters.
     * @param array<string, string> $headers Optional HTTP headers.
     * @param bool $asJson Whether to decode response as JSON (default false).
     * @return array<string, mixed>|string JSON decoded array or raw response body.
     *
     * @throws NeshanException On HTTP failure or unexpected errors.
     */
    protected function sendRequest(string $endpoint, array $query = [], array $headers = [], bool $asJson = false): mixed
    {
        try {
            $response = Http::withHeaders($headers)
                ->retry(2)
                ->timeout(10)
                ->get($endpoint, $query);

            if ($response->failed()) {
                throw new NeshanException(
                    "Request failed with status code {$response->status()}. Response: {$response->body()}",
                    $response->status()
                );
            }

            return $asJson ? $response->json() : $response->body();

        } catch (\Exception $e) {
            throw new NeshanException("Unexpected error occurred while requesting Neshan API.", 0, $e);
        }
    }

    /**
     * Get the base URL for Neshan API.
     *
     * Can be overridden in child classes for customization.
     *
     * @return string Base API URL.
     */
    protected function getBaseUrl(): string
    {
        return 'https://api.neshan.org/v1';
    }
}
