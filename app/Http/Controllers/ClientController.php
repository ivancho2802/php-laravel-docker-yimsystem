<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClientController extends Controller
{
  //
  public function search(Request $request)
  {
    $requestBody = $request->all();
    $cliente = Cliente::query();

    //query
    if (isset($requestBody['cliente'])) {
      $cliente
        ->where('nom_cliente', 'like', '%' . $requestBody['cliente'] . '%')
        ->orWhere('ced_cliente', 'like', '%' . $requestBody['cliente'] . '%');
    }

    $data['clientes'] = $cliente->get();
    $data['origin'] = $requestBody['origin'];

    return view('clientes-simple', $data);
  }

  /**
   * nacionalidad
   * numeor de document
   */
  public function findUserByVzla(Request $request)
  {

    $curls = new \App\Http\Controllers\CurlSeniat($request['numero']);

    $responseSeniat = $curls->getInfo();

    if ($responseSeniat['code_result'] == 1) {

      $data  = array(
        "nombre" => utf8_decode($responseSeniat['seniat']->nombre),
        "agenteretencioniva" => $responseSeniat['seniat']->agenteretencioniva,
        "contribuyenteiva" => $responseSeniat['seniat']->contribuyenteiva,
        "tasa" => $responseSeniat['seniat']->tasa
      );

      return response()->json([
        'status' => true,
        'data' => $data,
      ], 201);
    }

    $pre = substr($request['numero'], 0, 1);
    $post = substr($request['numero'], 1);
    $curls = \App\Http\Controllers\CurlCne::searchCNE($pre, $post);
    // Obtener los datos fiscales
    $data = json_decode($curls);
    $data->nombre = $data->nombres . ' ' . $data->apellidos;

    return response()->json([
      'status' => true,
      'data' => $data,
    ], 201);
  }

  /**
   * update clinete by if
   */
  public function update(Request $request)
  {
    try {
      $updateCliente = Cliente::query()
        ->where("id", $request['id'])
        ->update([
          'ced_cliente' => $request['ced_cliente'],
          'nom_cliente' => $request['nom_cliente'],
          'contri_cliente' => $request['contri_cliente'],
          'email_cliente' => $request['email_cliente'],
          'tel_cliente' => $request['tel_cliente'],
          'dir_cliente' => $request['dir_cliente'],
          'fech_i_cliente' => $request['fech_i_cliente']
        ]);
      $data["updateCliente"] = $updateCliente;
      return response()->json(['status' => false, 'data' => $data], 200);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
  }

  public function store(Request $request)
  {
    $validExist = Cliente::query()
      ->where("ced_cliente", $request['ced_cliente'])
      ->orWhere("nom_cliente", $request['nom_cliente'])
      ->exists();

    if ($validExist) {
      return response()->json(['status' => false, 'message' => "Data existente"], 402);
    }

    try {
      $createCliente = Cliente::create([
        'ced_cliente' => $request['ced_cliente'],
        'nom_cliente' => $request['nom_cliente'],
        'contri_cliente' => $request['contri_cliente'],
        'email_cliente' => $request['email_cliente'],
        'tel_cliente' => $request['tel_cliente'],
        'dir_cliente' => $request['dir_cliente'],
        'fech_i_cliente' => $request['fech_i_cliente']
      ]);
      $data["createCliente"] = $createCliente;
      return response()->json(['status' => true, 'data' => $data], 200);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
  }
}
