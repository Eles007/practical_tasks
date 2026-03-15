<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeoService
{
    public function getLocation(string $ip): array
    {
        return cache()->remember("city:ip:{$ip}", 3600, function () use ($ip) {
            $response = Http::timeout(10)
                ->retry(3, 100)
                ->get("http://ip-api.com/json/{$ip}?lang=ru")
                ->throw();

            $data = $response->json();

            if ($data['status'] !== 'success') {
                return [];
            }

            return [
                'city' => $data['city'],
            ];
        });
    }
}
