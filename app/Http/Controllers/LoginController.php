<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginVerifyRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Notifications\LoginNotification;
use Exception;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request) : JsonResponse
    {
        $validate = $request->validated();
        try {
            $user = User::where('email', $validate['email'])->first();

            if (! Auth::attempt($request->only(['email', 'password']))) {
                return $this->badRequestResponse('Email and/or Password does not match.');
            }
            $data['user'] = $user;
            $data['token'] = $user->createToken('API TOKEN')->plainTextToken;
            $user->notify(new LoginNotification());

            return $this->successResponse('Successful Signin', $data);
        } catch (Exception $e) {
            return $this->badRequestResponse($e->getMessage());
        }


    }

    public function verify(LoginVerifyRequest $request)
    {

        $user = User::where('phone', $request->phone)
        ->where('login_code', $request->login_code)
        ->first();

        if($user) {
            $user->login_code = null;
            $user->save();
            return response()->json([
                'id' => $user->id,
                'token' => $user->createToken($request->login_code)->plainTextToken,
                'message' => 'Login Successful'
            ]);
        }

        return response()->json([
            'message' => 'Invalid Credentials'
        ], 401);
    }
}
