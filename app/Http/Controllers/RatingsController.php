<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    public function driver(Request $request, Driver $driver, User $user)
    {
        $request->validate([
            'rating' => 'required|numeric',
        ]);

        Rating::create([
            'rating' => $request->rating,
            'is_driver' => true
        ]);
    }

    public function user(Request $request, User $user)
    {
        $request->validate([
            'rating' => 'required|numeric'
        ]);

        $rating = Rating::create([
            'rating' => $request->rating,
            'is_user' => true
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User rated Successfully',
            'data' => $rating
        ], 200);
    }
}
