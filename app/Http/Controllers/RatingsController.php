<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    public function driver(Request $request)
    {
        $request->validate([
            'rating' => 'required|numeric',
        ]);

        $rating = Rating::create([
            'rating' => $request->rating,
            'is_driver' => true
        ]);

        return $this->successResponse('Rating Successful',$rating);
    }

    public function user(Request $request)
    {
        $request->validate([
            'rating' => 'required|numeric'
        ]);

        $rating = Rating::create([
            'rating' => $request->rating,
            'is_user' => true
        ]);

        return $this->successResponse('Rating Successful',$rating);
    }
}
