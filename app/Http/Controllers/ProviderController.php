<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProviderController extends Controller
{
  //

  public function search(Request $request)
  {
    $requestBody = $request->all();
    $provider = Proveedor::query();

    //query
    if (isset($requestBody['prov'])) {
      $provider
        ->where('nombre', 'like', '%' . $requestBody['prov'] . '%')
        ->orWhere('rif', 'like', '%' . $requestBody['prov'] . '%');
    }

    $data['providers'] = $provider->get();
    $data['origin'] = $requestBody['origin'];

    return view('providers-simple', $data);
  }

  /**
   * update clinete by if
   */
  public function update(Request $request)
  {
    try {
      $updateProveedor = Proveedor::query()
        ->where("id", $request['id'])
        ->update([
          'rif' => $request['rif'],
          'nombre' => $request['nombre'],
          'telefono' => $request['telefono'],
          'direccion' => $request['direccion'],
        ]);
      $data["updateProveedor"] = $updateProveedor;
      return response()->json(['status' => false, 'data' => $data], 200);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
  }

  public function store(Request $request)
  {
    $validExist = Proveedor::query()
      ->where("rif", $request['rif'])
      ->orWhere("nombre", $request['nombre'])
      ->exists();

    if ($validExist) {
      return response()->json(['status' => false, 'message' => "Data existente"], 402);
    }

    try {
      $createProvider = Proveedor::create([
        'rif' => $request['rif'],
        'nombre' => $request['nombre'],
        'telefono' => $request['telefono'],
        'direccion' => $request['direccion'],
      ]);
      $data["createProvider"] = $createProvider;
      return response()->json(['status' => true, 'data' => $data], 200);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
  }
}
