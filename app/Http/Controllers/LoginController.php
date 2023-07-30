<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginVerifyRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Notifications\LoginNotification;
use Exception;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validate = $request->validated();
        try {
            $user = User::firstOrCreate([
                'phone' => $validate['phone']
            ]);
    
            if (! $user) {
                return response()->json([
                    'message' => 'Could not process a user with that phone number.',
                ], 401);
            }
    
            $user->notify(new LoginNotification());
    
            return response()->json([
                'message' => 'Text message sent'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
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
