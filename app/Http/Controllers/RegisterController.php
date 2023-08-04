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
        try{
            $user = User::create($request->only(['name', 'password', 'email', 'phone']));

            UserRegistered::dispatch($user);

            $token = $user->createToken('auth')->plainTextToken;

            $data = [
                'user' => $user,
                'token' => $token
            ];

            return $this->successResponse('User created successfully', $data);
        } catch (\Exception $e){
            return $this->errorResponse('An error occurred'.$e->getMessage());
        }

    }
}
