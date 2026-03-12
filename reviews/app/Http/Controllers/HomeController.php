<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\GeoService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(GeoService $geoService)
    {
        if (session()->has('city')) {
            $city = session('city');
            $cityModel = City::where('name', $city)->first();

            if ($cityModel) {
                return redirect()->route('city.show', ['city' => $city]);
            }

            session()->forget('city');
        }

        try {
            $ip = Http::get('https://api.ipify.org')->body();
            $data = $geoService->getLocation($ip);

            if (!$data || empty($data['city'])) {
                return redirect()->route('cities');
            }

            return view('home', compact('data'));
        } catch (\Throwable $e) {
            return redirect()->route('cities');
        }
    }
}
