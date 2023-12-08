<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        /// Get the Body form request and validate it 
        $fields = $request->validate([
            'name' => "required|string|min:3",
            'email' => "required|string|min:3|unique:users,email",
            'password' => "required|string|confirmed",
        ]);


        ///  Create The User (Store User in DB)
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);


        /// create Token For User for authentication
        $token = $user->createToken('user_Token')->plainTextToken;


        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }



    /// Login Service for user  
    public function login(Request $request)
    {
        /// Get the Body form request and validate it 
        $fields = $request->validate([
            'email' => "required|string|min:3",
            'password' => "required|string",
        ]);


        // check if user exist
        $user = User::where('email', $fields['email'])->first();

        // check password 
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid cedintials',
            ], 401);
        }

        // create Token For User for authentication
        $token = $user->createToken('user_Token')->plainTextToken;


        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }




    //// logout service for user 
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged out'
        ];
    }
}
