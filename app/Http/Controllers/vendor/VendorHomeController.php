<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorHomeController extends Controller
{
    public function index()
    {
        return view('vendors.home');
    }
}
