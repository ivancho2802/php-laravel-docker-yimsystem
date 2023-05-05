<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\RegInventario;
use App\Models\InventarioRetiro;
use App\Models\Compra;
use App\Models\Venta;
use App\Models\FactCompra;
use App\Models\FactVenta;
use App\Models\Empre;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

class InventarioController extends Controller
{
  //
  public function index(Request $request)
  {
    $data = $this->find($request);

    if (isset($data['destroy'])) {
      return view('prods-list', $data)->with($data);
    }

    return view('prods-list', $data);
  }
  //
  public function search(Request $request)
  {

    $data = $this->find($request);

    return view('prods-simple', $data);
  }

  function find(Request $request)
  {
    $requestBody = $request->all();
    $userId = auth()->user()->id;

    $data['inventarios'] = Inventario::query()
      ->where([
        ['fk_usuarios', $userId]
      ])
      ->orderBy('codigo')
      ->get();

    if (isset($requestBody['simple'])) {
      return $data;
    }

    $data['dateEnd'] = $requestBody['dateTo'] ?? date("Y-m-d");
    $time = strtotime($data['dateEnd']);
    $data['dateBegin'] = $requestBody['dateFrom'] ?? date("Y-m-d", strtotime("-3 month", $time));

    $data['dateFrom'] = $requestBody['dateFrom'] ?? NULL;
    $data['dateTo'] = $requestBody['dateTo'] ?? NULL;

    //consulta de los datos de la empreas PARA SABE LA ACTIVA
    $data['empre'] = Empre::query()
      ->where([
        ['est_empre', '1'],
        ['fk_usuarios', auth()->user()->id]
      ])
      ->first();

    $factCompra = FactCompra::query()
      ->select('fecha_fact_compra AS fecha')
      ->where([
        ['fk_usuariosc', $userId]
      ]);

    $factVenta = FactVenta::query()
      ->select('fecha_fact_venta AS fecha')
      ->where([
        ['fk_usuariosV', $userId]
      ])
      ->union($factCompra);

    $inventarioDate = InventarioRetiro::query()
      ->select('fecha_inv_retiros AS fecha')
      ->where([
        ['fk_usuariosRI', $userId]
      ])
      ->union($factVenta);
    $inventarioRegistro = RegInventario::query()
      ->select('fecha_reg_inv AS fecha')
      ->where([
        ['fk_inventario', $userId]
      ])
      ->union($inventarioDate)
      ->orderBy('fecha')
      ->first();

    //completando con ano y/o mes la fecha

    if (isset($requestBody['mes'])) {
      $mes = $requestBody['mes'];
      $data['dateBegin'] = $mes . "-01";
      $data['dateEnd'] = ($mes == '02') ? $mes . "-28" : (((int) $mes % 2 == 0) ? $mes . "-31" : $mes . "-30");
    } elseif (isset($requestBody['ano'])) {
      $ano = $requestBody['ano'];
      if ($ano >= substr($inventarioRegistro->fecha, 0, 4)) {
        $data['dateBegin'] = $inventarioRegistro->fecha;
      } else {
        $data['dateBegin'] = NULL;
      }
      $data['dateEnd'] = $ano . "-12-31";
    } elseif (isset($requestBody['dateFrom']) && isset($requestBody['dateTo'])) {
      $data['dateBegin'] = $requestBody['dateFrom'];
      $data['dateEnd'] = $requestBody['dateTo'];
    } elseif (isset($requestBody['dia'])) {
      $dia = $requestBody['dia'];
      if ($dia >= $inventarioRegistro->fecha) {
        $data['dateBegin'] = $requestBody['dia'];
        $data['dateEnd'] = $requestBody['dia'];
      } else {
        $data['dateBegin'] = NULL;
      }
    }

    //para AÑO o mes y
    if (!$data['dateBegin'] || $data['dateBegin'] < $inventarioRegistro->fecha) {
      $data['destroy'] = "Error con la fecha debe ser mayor a mes de " .
        date('F', strtotime($inventarioRegistro->fecha));
    }

    $dateBegin = $data['dateBegin'];
    $dateEnd = $data['dateEnd'];

    $data['inventarios']->each(function (Inventario $inventario) use ($dateBegin, $dateEnd) {
      $inventario->inventarioInicialRegistro($dateBegin);
      $inventario->inventarioInicialCompras($dateBegin, $dateEnd);
      $inventario->inventarioInicialVentas($dateBegin, $dateEnd);
      $inventario->inventarioInicialRetiros($dateBegin, $dateEnd);
      $inventario->inventarioFinalRegistro($dateEnd);
    });

    $inventarios = Inventario::query()
      ->where([
        ['fk_usuarios', $userId]
      ])
      ->orderBy('codigo')
      ->get();

    $inventarios->each(function (Inventario $inventario) use ($dateBegin, $dateEnd) {
      $inventario->inventarioInicialRegistro($dateBegin);
      $inventario->inventarioInicialCompras($dateBegin, $dateEnd);
      $inventario->inventarioInicialVentas($dateBegin, $dateEnd);
      $inventario->inventarioInicialRetiros($dateBegin, $dateEnd);
      $inventario->inventarioFinalRegistro($dateEnd);
    });

    //totalizcion
    $data['inventarioInicialAcum'] = [
      "inventario_inicial_registro_costo_reg_inv" => $inventarios->sum("inventario_inicial_registro_costo_reg_inv"),
      "inventario_inicial_registro_cantidad_reg_inv" => $inventarios->sum("inventario_inicial_registro_cantidad_reg_inv"),
      "inventario_inicial_registro_monto" => $inventarios->sum("inventario_inicial_registro_monto"),
      "inventario_inicial_compra_cantidadCompras" => $inventarios->sum("inventario_inicial_compra_cantidadCompras"),
      "inventario_inicial_compra_montoActual" => $inventarios->sum("inventario_inicial_compra_montoActual"),
      "inventario_inicial_venta_cantidadVentas" => $inventarios->sum("inventario_inicial_venta_cantidadVentas"),
      "inventario_inicial_venta_montoActual" => $inventarios->sum("inventario_inicial_venta_montoActual"),
      "inventario_inicial_compra_devo_cantidadCompras" => $inventarios->sum("inventario_inicial_compra_devo_cantidadCompras"),
      "inventario_inicial_compra_devo_montoActual" => $inventarios->sum("inventario_inicial_compra_devo_montoActual"),
      "inventario_inicial_retiro_cantidadRetiros" => $inventarios->sum("inventario_inicial_retiro_cantidadRetiros"),
      "inventario_inicial_retiro_montoActual" => $inventarios->sum("inventario_inicial_retiro_montoActual"),
      "inventario_final_registro_costo_reg_inv" => $inventarios->sum("inventario_final_registro_costo_reg_inv"),
      "inventario_final_registro_cantidad_reg_inv" => $inventarios->sum("inventario_final_registro_cantidad_reg_inv"),
      "inventario_final_registro_monto" => $inventarios->sum("inventario_final_registro_monto")
    ];
    return $data;
  }

  /**
   * para validar si la fecha de registro de inventario esta incorrecta
   */
  public function validDate($vfecha)
  {
    $dateValid = null;

    $regInv = RegInventario::query();

    //retorno condicion 2 para javascript decir que debe ingresar almenos un inventario inicial
    $regInvExists = RegInventario::query()->doesntExist();
    if ($regInvExists) {
      //echo 2
      $dateValid = null;
    } else {
      $regInvAvailables = RegInventario::where('fecha_reg_inv', '>', $vfecha);

      if ($regInvAvailables->exists()) {
        //echo 1; //esta bien
        $dateValid = true;
      } else {
        $dateValid = $regInv->first()->fecha_reg_inv;
      }
    }

    $data['registriInv'] = $regInv->get();
    $data['dateValid'] = $dateValid;

    return response()->json([
      'status' => true,
      'data' => $data,
    ], 201);
  }

  /**
   * obtener data para fecha de inventario inicial
   */
  public function config()
  {
    $reginventario = RegInventario::query()
      ->orderBy('fecha_reg_inv', 'asc')
      ->where('tipo', 'inv_ini')
      ->first();

    $mesInventario = sprintf("%d-%02d", date('Y'), date('m') - 1);

    if ($reginventario) {
      $mesInventario = substr($reginventario->fecha_reg_inv, 0, 7);
      $dateInventario = optional($reginventario)->fecha_reg_inv;
    }

    $data['mesInventario'] = $mesInventario;

    $data['dateInventario'] = $dateInventario;

    return response()->json([
      'status' => true,
      'data' => $data,
    ], 201);
  }

  public function create()
  {
    return view('inventario-add');
  }

  public function store(Request $request)
  {

    $request = $request->all();

    $userId = auth()->user()->id;

    try {
      $fecha = Carbon::create($request['fecha']);
      $fecha = $fecha->endOfMonth()->toDateString();

      $request['tipo'] = $request['tipo'] ?? '';

      //CODIGO DE INSERCION
      $inventario = Inventario::create([

        "codigo" => $request['codigo'],
        "nombre_i" => $request['nombre_i'],
        "stock" => $request['stock'],
        "valor_unitario" => $request['valor_unitario'],
        "pmpvj_actual" => $request['pmpvj'],
        "fecha" => $fecha,
        "cant_min" => $request['cant_min'],
        "cant_max" => $request['cant_max'],
        "descripcion" => $request['descripcion'],
        "tipo" => $request['tipo'],
        "fk_usuarios" => $userId,
      ]);


      //PARA INSERTAR EN REGISTRO PARA INV INICIAL
      if ($inventario && isset($request['tipo']) && $request['tipo'] == "inv_ini") {
        //INSERTAR PARA EL  REGISTRO DE INVENTARIO LO ACTUAL SEGUN LA FECHA PARA KARDEX
        $insertRegInv = RegInventario::create([
          "fecha_reg_inv" => $fecha,
          //costo actual para esta fecha
          "costo_reg_inv" => $request['valor_unitario'],
          "pmpvj" => $request['pmpvj'],
          //cantidad actual para esta fecha
          "cantidad_reg_inv" => $request['stock'],
          "tipo" => $request['tipo'],
          "fk_inventario" => $inventario->id,
          "fecha_registro" => Carbon::now(),
          "hora_registro" => Carbon::now()->toDateTimeString()
        ]);

        $data['insertRegInv'] = $insertRegInv;
      }

      $data['inventario'] = $inventario;

      return response()->json([
        'status' => true,
        'data' => $data,
      ], 201);
    } catch (\Exception $e) {

      if (isset($inventario) && $inventario->id) {
        Inventario::destroy($inventario->id);
      }

      $data['message'] = 'Error para PRODUCTO: ' . $e->getMessage();

      return response()->json([
        'status' => false,
        'data' => $data,
      ], 503);
    }
  }

  /**
   * update inventario
   */
  public function update(Request $request)
  {
    try {
      $updateInventario = Inventario::query()
        ->where("id", $request['id'])
        ->update([
          'codigo' => $request['codigo'],
          'nombre_i' => $request['nombre_i'],
          'descripcion' => $request['descripcion'],
          'cant_min' => $request['cant_min'],
          'cant_max' => $request['cant_max'],
          'valor_unitario' => $request['valor_unitario'],
          'pmpvj_actual' => $request['pmpvj'][0],
          'fecha' => Carbon::create($request['fecha'])->toDateString(),
        ]);
      $data["updateInventario"] = $updateInventario;
      return response()->json(['status' => false, 'data' => $data], 200);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
    }
  }

  public function storeRetiro(Request $request)
  {
    $request = $request->all();

    $userId = auth()->user()->id;

    try {

      $inventario = Inventario::query()->where([
        ["stock", ">=", $request['cant_inv_retiros']],
        ["id", $request['fk_inventario']]
      ])->first();

      if (!$inventario) {
        $data['message'] = 'Retiro NO realizado producto inexistente o no posee existencias: ';
        return response()->json([
          'status' => false,
          'data' => $data,
        ], 404);
      }

      //CODIGO DE INSERCION
      $inventarioRetiro = InventarioRetiro::create([

        "cant_a" => $request['stock'],
        "costo_a" => $request['costo'],
        "fecha_inv_retiros" => $request['fecha_inv_retiros'],
        "cant_inv_retiros" => $request['cant_inv_retiros'],
        "orden_inv_retiros" => $request['orden_inv_retiros'],
        "obs_inv_retiros" => $request['obs_inv_retiros'],
        "fk_inventario" => $request['fk_inventario'],
        "fk_usuariosRI" => $userId

      ]);

      $data['inventarioRetiro'] = $inventarioRetiro;

      //para el precio o costo este es el promediado de precios
      $stockCantidad = $inventario->stock - $request['cant_inv_retiros'];

      $updateInven = Inventario::query()
        ->where('id', $request["fk_inventario"])
        ->update([
          'stock' => $stockCantidad,
        ]);

      $data['updateInven'] = $updateInven;

      //INSERTAR PARA EL  REGISTRO DE INVENTARIO LO ACTUAL SEGUN LA FECHA PARA KARDEX
      $insertRegInv = RegInventario::create([

        "tipo" => 'retiro',
        "fecha_reg_inv" => $request['fecha_inv_retiros'],
        "costo_reg_inv" => $inventario->valor_unitario, //costo actual para esta fecha
        "cantidad_reg_inv" => $stockCantidad, //cantidad actual para esta fecha
        "fk_inventario" => $request['fk_inventario'],
        "fecha_registro" => Carbon::now(),
        "hora_registro" => Carbon::now()->toDateTimeString(),
        'pmpvj', $inventario->pmpvj_actual,

      ]);

      $data['insertRegInv'] = $insertRegInv;

      return response()->json([
        'status' => true,
        'data' => $data,
      ], 201);
    } catch (\Exception $e) {

      /* if ($inventarioRetiro->id) {
        InventarioRetiro::destroy($inventarioRetiro->id);
      } */

      $data['message'] = 'Retiro NO realizado : ' . $e->getMessage();

      return response()->json([
        'status' => false,
        'data' => $data,
      ], 503);
    }
  }

  public function reportInventario(Request $request)
  {
    //get css by default
    $parser = new \Sabberworm\CSS\Parser(file_get_contents('./assets/css/report.css'));
    $cssDocument = '<style>' . $parser->parse() . '</style>';
    $data = $this->find($request);

    $data['css'] = $cssDocument;

    $html = view('components.prod.prods-table', $data);

    /**
     * reference the Dompdf namespace
     * */
    $options = new Options();
    $options->set('defaultFont', 'Courier');
    $dompdf = new Dompdf($options);

    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('legal', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    $options = $dompdf->getOptions();
    $options->setIsRemoteEnabled(true);
    $dompdf->setOptions($options);

    $dateCurrent = date("Y-m-d");
    // Output the generated PDF to Browser
    $dompdf->stream('reporte_inventario_' . $dateCurrent . '.pdf');
  }
}
