<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function select(Request $request)
    {
        $city = City::findOrFail($request->city_id);
        session(['city_id' => $city->id]);

        return redirect()->route('home');
    }
}
