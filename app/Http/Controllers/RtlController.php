<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RtlController extends Controller
{
    public function index(Request $request)
    {
		return view('rtl');
    }
}