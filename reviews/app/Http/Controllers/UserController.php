<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function reviews(User $user)
    {
        $reviews = $user->reviews()->with('cities')->latest()->get();

        return view('user.reviews', compact('user', 'reviews'));
    }
}
