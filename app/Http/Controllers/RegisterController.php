<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\UserRegisterRequest;

class RegisterController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $user = User::create($request->only(['name', 'password', 'email', 'phone']));

        UserRegistered::dispatch($user);

        $token = $user->createToken('auth')->plainTextToken;

        return response()->json([
            'status' => true,
            'data' => $user,
            'token' => $token,
            'message' => 'User created successfully',
        ], 201);
    }
}
