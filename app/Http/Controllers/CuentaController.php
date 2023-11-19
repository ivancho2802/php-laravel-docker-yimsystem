<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmprePlancuenta;
use App\Models\Plancuenta;
use Illuminate\Support\Facades\Storage;

class CuentaController extends Controller
{
  public function index(Request $request)
  {

    //$requestBody = $request->all();
    $user = auth()->user();
    $empreId = $user->empre()->active()->id;

    $data['cuentas'] = Plancuenta::query()
      ->valid()
      ->with('empreplancuenta')
      /* ->whereHas('empreplancuenta', function($query){
          $query->active();
        }
      ) */
      ->where([
        ['rel_empre', $empreId],
      ])
      ->orderBy('id_plancuenta')
      ->paginate(15);

    return view('cuentas-list', $data);
  }

  public function store(Request $request)
  {
    $request = $request->all();

    $user = auth()->user();
    $empreId = $user->empre()->active()->id;

    try {
      $plancuenta = Plancuenta::create([

        "id_plancuenta" => $request['id_plancuenta'],
        "nom_plancuenta" => $request['nom_plancuenta'],
        "tsc" => $request['tsc'],
        "natu" => $request['natu'],
        "aux" => $request['aux'],
        "rel_empre" => $empreId,

      ]);
      $data['plancuenta'] = $plancuenta;

      $empreplancuenta = EmprePlancuenta::create([

        "cant_plancuenta" => 0,
        "rel_empre" => $empreId,
        'rel_plancuenta' => $plancuenta->id,
        'c_natu' => $request['natu'],
        'status' => true,

      ]);

      $data['empreplancuenta'] = $empreplancuenta;

      return redirect('book-shopping')->with([
        'success' => 'Factura de Compra creada con exito.'
      ]);
    } catch (\Exception $e) {
      $valid = "Fuck";
      if ($plancuenta->id) {
        Plancuenta::destroy($plancuenta->id);
        $valid = " yes" . $plancuenta->id;
      }

      return $e->getMessage() . $valid;
    }
  }

  public function update(Request $request)
  {
    $request = $request->all();

    $user = auth()->user();
    $empreId = $user->empre()->active()->id;

    try {
      $updatePlancuenta = Plancuenta::query()
        ->where([
          ['id', $request["id"]],
          ['rel_empre', $empreId]
        ])
        ->update([
          "id_plancuenta" => $request['id_plancuenta'],
          "nom_plancuenta" => $request['nom_plancuenta'],
          "tsc" => $request['tsc'],
          "natu" => $request['natu'],
          "aux" => $request['aux']
        ]);

      $data['update_plancuenta'] = $updatePlancuenta;

      return response()->json(['status' => false, 'data' => ["message" => "Cuenta actualizada con exito"]], 200);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function storeses(Request $request)
  {

    try {
      //valid number records limit
      if (empty($request->cuentas) || count($request->cuentas) >= 1000) {
        return response()->json(['false' => false, ["cuentas" => $request->cuentas]], 200);
      }

      $data = $this->formatPlancuenta($request->cuentas);


      $response['inserted'] = Plancuenta::insertOrIgnore($data); // Eloquent approach

      $dataEmprePlancuenta = $this->formatEmprePlancuenta($request->cuentas);

      $response['insertedEmprePlancuenta'] = EmprePlancuenta::insertOrIgnore($dataEmprePlancuenta);

      $response['cuentas'] = []; //[["Codigo del Plancuenta" => "1"]]

      return response()->json(['status' => true, $response], 200);
    } catch (\Exception $e) {

      return response()->json(['status' => false, ["message" => $e]], 503);
    }
  }

  public function download()
  {

    return Storage::download('Formato_de_cuentas.xlsx');
  }

  public function preview(Request $request)
  {

    $request = $request->all();

    dd($request['cuentas']);

    $data['cuentas'] = $request['cuentas']
      ->paginate(15);

    return view('cuentas-simple', $data);
  }

  public function formatPlancuenta($cuentas)
  {

    $cuentasFormated = [];
    //$user = auth()->user();
    $user = auth()->user();
    $empreId = $user->empre()->active()->id;

    for ($i = 0; $i < count($cuentas); $i++) {

      $exist = Plancuenta::where('id_plancuenta', $cuentas[$i]['Codigo del Plancuenta'])->doesntExist();
      if ($exist) {
        $cuentasFormated[$i]['aux'] = $cuentas[$i]['Axuliar'];
        $cuentasFormated[$i]['natu'] = $cuentas[$i]['Naturaleza'];
        $cuentasFormated[$i]['nom_plancuenta'] = $cuentas[$i]['Nombre del Plan de Cuenta'];
        $cuentasFormated[$i]['tsc'] = $cuentas[$i]['TSC'];
        $cuentasFormated[$i]['id_plancuenta'] = $cuentas[$i]['Codigo del Plancuenta'];
        $cuentasFormated[$i]['rel_empre'] = $empreId;
      }
    }

    return $cuentasFormated;
  }

  public function formatEmprePlancuenta($cuentasRequest)
  {

    $cuentasFormated = [];
    //$user = auth()->user();
    $user = auth()->user();
    $empreId = $user->empre()->active()->id;

    $cuentas = Plancuenta::where(["rel_empre" => $empreId])->get();

    for ($i = 0; $i < count($cuentas); $i++) {

      $exist = EmprePlancuenta::where('rel_plancuenta', $cuentas[$i]->id)->doesntExist();
      if ($exist) {
        $cuentasFormated[$i]['cant_plancuenta'] = 0;
        $cuentasFormated[$i]['c_natu'] = 0;
        $cuentasFormated[$i]['rel_plancuenta'] = $cuentas[$i]->id;
        $cuentasFormated[$i]['rel_empre'] = $empreId;
        $cuentasFormated[$i]['status'] = true;
      }
    }

    return $cuentasFormated;
  }

  public function detroy(Request $request)
  {

    try {
      //valid number records limit
      if (!$request->id) {
        return response()->json(['false' => false, ["id" => $request]], 402);
      }
      //valid if this plan is the company curent
      $user = auth()->user();
      $empreId = $user->empre()->active()->id;

      $cuentaToDeteled = Plancuenta::where([
        'id' => $request->id,
        'rel_empre' => $empreId
      ]);

      if ($cuentaToDeteled->exists() !== true) {
        return response()->json(['false' => false, ["id" => $request]], 403);
      }

      $response  = EmprePlancuenta::where([
        "rel_plancuenta" => $request->id,
        'rel_empre' => $empreId
      ])
        ->update(["status" => false]);


      if ($response !== 1) {
        return response()->json(['status' => false, ["response" => $response]], 402);
      }

      $exist = EmprePlancuenta::where(['rel_plancuenta' => $request->id, "status" => true])->exists();

      if(!$exist){
        return response()->json(['status' => true, 'data' => $exist], 200);
      }else {
        return response()->json(['status' => false, ["response" => $response]], 402);
      }

    } catch (\Exception $e) {

      return response()->json(['status' => false, ["message" => $e]], 503);
    }
  }
}
