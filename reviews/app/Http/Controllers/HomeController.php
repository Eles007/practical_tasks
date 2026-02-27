<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Review;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $cityId = session('city_id');

        if ($cityId) {
            $city = City::find($cityId);

            $reviews = Review::with('user')
                ->whereHas('cities', function ($q) use ($cityId) {
                    $q->where('city_id', $cityId);
                })
                ->get();

            return view('home', compact('city', 'reviews'));
        }

        $cityName = null;

        try {
            $response = Http::acceptJson()
                ->connectTimeout(1)
                ->timeout(2)
                ->retry(1, 200, throw: false)
                ->get('http://ip-api.com/json/', [
                    'fields' => 'status,message,city',
                    'lang' => 'ru',
                ]);

            if ($response->ok()) {
                $data = $response->json();

                if (is_array($data) && ($data['status'] ?? null) === 'success') {
                    $city = $data['city'] ?? null;

                    if (is_string($city)) {
                        $city = trim($city);
                        $cityName = $city !== '' ? $city : null;
                    }
                }
            }
        } catch (\Throwable) {
            $cityName = null;
        }

        $cities = City::orderBy('name')->get();

        $detectedCity = null;

        if ($cityName) {
            $detectedCity = City::firstOrCreate([
                'name' => $cityName,
            ]);
        }

        return view('home', compact('cities', 'detectedCity'));
    }
}
