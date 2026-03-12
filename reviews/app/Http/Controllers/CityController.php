<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Routing\Controller;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();

        $russianCities = $cities->filter(function ($city) {
            return preg_match('/^[а-яА-ЯёЁ]/u', $city->name);
        })->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        $englishCities = $cities->filter(function ($city) {
            return preg_match('/^[a-zA-Z]/', $city->name);
        })->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        $cities = $russianCities->merge($englishCities);

        return view('city.list', compact('cities'));
    }

    public function confirm($city)
    {
        if (!$city) {
            return redirect('/');
        }
        session(['city' => $city]);
        return redirect()->route('city.show', ['city' => $city]);
    }

    public function show($city)
    {
        if (session('city') !== $city) {
            return redirect('/');
        }

        $cityModel = City::where('name', $city)->firstOrFail();
        $reviews = $cityModel->reviews()->with('user')->get();

        return view('city.show', compact('city', 'reviews'));
    }
}
