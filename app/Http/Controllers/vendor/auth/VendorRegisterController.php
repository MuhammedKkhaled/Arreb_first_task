<?php

namespace App\Http\Controllers\vendor\auth;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorRegisterController extends Controller
{
    public function register()
    {
        return view("vendors.auth.register");
    }


    public function store(Request $request)
    {
        $vendorKey = "Vendor#123";
        if ($request->input('vendor_key') === $vendorKey) {

            /// Validate The incoming request 
            $request->validate([
                'name'       => 'required|string',
                'email'      => 'required|string|unique:vendors',
                'vendor_key' => 'required|string',
                'password'   => 'required|string|confirmed',
                'password_confirmation' => 'required|string',
            ]);

            //DB Store Proccess             

            $Vendor_data = $request->except(["password_confirmation", "_token", "admin_key"]);

            $Vendor_data['password'] = Hash::make($request->input('password'));

            Vendor::create($Vendor_data);

            return redirect()->route('vendor.login');
        }

        /// Otherwise 
        return redirect()->back()->with('messageError', "Invalid Credintials");
    }
}
