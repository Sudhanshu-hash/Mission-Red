<?php

namespace App\Services\Location;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class GeocodingService
{
    /**
     * Convert a structured location into latitude/longitude.
     *
     * @return array{
     *     latitude: float,
     *     longitude: float
     * }
     */
    public function geocode(
        string $state,
        string $city,
        string $locality,
        ?string $pincode = null
    ): array {
        $query = $this->buildQuery(
            $state,
            $city,
            $locality,
            $pincode
        );

        $response = Http::timeout(10)
            ->retry(2, 500)
            ->withHeaders([
                'User-Agent' => config(
                    'services.nominatim.user_agent'
                ),
            ])
            ->get(
                rtrim(
                    config('services.nominatim.url'),
                    '/'
                ) . '/search',
                [
                    'q' => $query,
                    'format' => 'jsonv2',
                    'limit' => 1,
                    'addressdetails' => 1,
                ]
            );

        if ($response->failed()) {
            throw new RuntimeException(
                'Geocoding service request failed.'
            );
        }

        $results = $response->json();

        if (!is_array($results) || empty($results)) {
            throw new RuntimeException(
                'The provided location could not be geocoded.'
            );
        }

        $result = $results[0] ?? null;

        if (
            !is_array($result) ||
            !isset($result['lat'], $result['lon'])
        ) {
            throw new RuntimeException(
                'The geocoding service returned an invalid result.'
            );
        }

        if (
            !is_numeric($result['lat']) ||
            !is_numeric($result['lon'])
        ) {
            throw new RuntimeException(
                'The geocoding service returned invalid coordinates.'
            );
        }

        return [
            'latitude' => (float) $result['lat'],
            'longitude' => (float) $result['lon'],
        ];
    }

    /**
     * Build a human-readable Nominatim search query.
     */
    private function buildQuery(
        string $state,
        string $city,
        string $locality,
        ?string $pincode = null
    ): string {
        $parts = [
            trim($locality),
            trim($city),
            trim($state),
            'India',
        ];

        return collect($parts)
            ->filter(fn($part) => $part !== '')
            ->map(fn($part) => Str::squish($part))
            ->implode(', ');
    }

}