<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashController extends Controller
{
    public function index(Request $request)
    {
		return view('dashboard');
    }
    public function redirect(Request $request)
    {
        return redirect('dashboard');
    }
}