<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class DashController extends Controller
{
  public function index(Request $request)
  {
    /* echo "from" . $request->from;
    echo "to:" . $request->to; */
    return view('dashboard');
  }
  public function redirect(Request $request)
  {
    return redirect('dashboard');
  }

  public function setConfig(Request $request)
  {
    $request = $request->all();
    $name = $request['origin'];

    Cookie::queue('date_op_from', $request['from'], time() + (86400 * 30 * 365));
    Cookie::queue('date_op_to', $request['to'], time() + (86400 * 30 * 365));

    return response()->json(['status' => true, 'data' => $name . "?from=" . $request['from'] . "&to=". $request['to']], 200);
  }

  public function checkExist(Request $request)
  {
    $request = $request->all();

    $exist = DB::table($request['tabla'])
    ->where($request['columna'], $request['valor'])
    ->exists();

    return response()->json(['status' => true, 'data' => $exist], 200);
  }
  
}
