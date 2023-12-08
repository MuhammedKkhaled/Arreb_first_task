<?php

namespace App\Http\Controllers\vendor\auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorLoginController extends Controller
{
    protected $redirectTo = RouteServiceProvider::VENDORHOME;


    public function login()
    {
        return view('vendors.auth.login');
    }

    public function is_vendor(Request $request)
    {
        $request->validate([
            'email' => ['required', "string"],
            'password' => ['required', "string"],
        ]);

        if (Auth::guard('vendor')->attempt($request->only('email', 'password'))) {
            // return redirect()->route("vendor.home");

            // Redirect to intended  
            return redirect()->route($this->redirectTo);
        }

        return redirect()
            ->back()
            ->withInput(['email' => $request->email])
            ->withErrors(["messageError" => "Credintials Doesn't mactch"]);
    }

    /**
     * Logout From a vendor guard , Avoid logout from all sessions including user session  if exist
     */

    public function logout()
    {
        /// Define a specific guard, before you logout() unset all sessions

        Auth::guard('vendor')->logout();

        // redirect to user home if logged in 
        return redirect()->route('vendor.login');
    }
}
