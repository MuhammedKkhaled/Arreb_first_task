<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAdminAuthController extends Controller
{
    //
    public function register(Request $request)
    {
        /// Get the Body form request and validate it 
        $fields = $request->validate([
            'name' => "required|string|min:3",
            'email' => "required|string|min:3|unique:vendors,email",
            'password' => "required|string",
        ]);

        $vendor = Vendor::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $vendor->createToken('vendor_token')->plainTextToken;

        $response = [
            'vendor' => $vendor,
            'token' => $token,
        ];

        return response($response, 201);
    }


    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'string|required',
            'password' => "string|required",
        ]);

        $vendor = Vendor::where("email", $fields['email'])->first();

        if (!$vendor || !Hash::check($fields['password'], $vendor->password)) {
            return response([
                'message' => "Invalid Credintails",
            ], 401);
        }

        $token = $vendor->createToken('vendor_token')->plainTextToken;

        $response = [
            'vendor' => $vendor,
            'token' => $token,
        ];

        return response($response, 201);
    }
}
