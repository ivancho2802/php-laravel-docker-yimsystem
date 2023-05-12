<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\FactCompra;
use App\Models\Inventario;
use App\Models\RegInventario;
use App\Models\Empre;

use Illuminate\Support\Carbon;
use Dompdf\Dompdf;


class BookShoppingController extends Controller
{
  //
  public function index()
  {
    //find data company for see information in relation
    $data['date_to'] = date("Y-m-d");
    $time = strtotime($data['date_to']);
    $data['date_from'] = date("Y-m-d", strtotime("-3 month", $time));

    $factCompras = FactCompra::query()
      ->where([
        ['fecha_fact_compra', '>=', $data['date_from']],
        ['fecha_fact_compra', '<=', $data['date_to']],
        ['fk_usuariosc', auth()->user()->id]
      ]);

    /* $compras = Compra::query()
		->where([
			['fk_fact_compra->fecha_fact_compra', '>=', $data['date_from']],
			['fk_fact_compra->fecha_fact_compra', '<=', $data['date_to']],
			['fk_usuariosc', auth()->user()->id]
		]); */

    //$factCompras->setAppends(['importations_without_iva']);
    /*  $factComprasAll = $factCompras->get()->all();
		$factComprasAll->each->append("importations_without_iva"); */

    $data['fact_compras'] = $factCompras
      ->orderBy('fecha_fact_compra')
      ->with('notacd')
      ->with('proveedor')
      ->paginate(10);

    //consulta de los datos de la empreas PARA SABE LA ACTIVA
    $data['empre'] = Empre::query()
      ->where([
        ['est_empre', '1'],
        ['fk_usuarios', auth()->user()->id]
      ])
      ->first();

    $acumInSdcfCompraInter = 0;
    $acumInExCompraInter = 0;
    $acumInExoCompraInter = 0;
    $acumInNsCompraInter = 0;
    //calculo de acum importations
    $factCompras
      ->each(
        function ($factCompra) use (
          $acumInSdcfCompraInter,
          $acumInExCompraInter,
          $acumInExoCompraInter,
          $acumInNsCompraInter
        ) {

          $acumInSdcfCompraInter += $factCompra->importations_without_iva['SDCF'];
          $acumInExCompraInter += $factCompra->importations_without_iva['EX'];
          $acumInExoCompraInter += $factCompra->importations_without_iva['EXO'];
          $acumInNsCompraInter += $factCompra->importations_without_iva['NS'];
        }
      );

    //totalizcion
    $data['fact_compras_acum'] = [
      //IMPORTACIONES
      //TOTAL DE IMPORTACIONEES INCLUYENDO EL IVA
      "acum_mtot_iva_compra_import" => $factCompras->sum('mtot_iva_compra'),
      //TOTAL DE IMPORTACIONES EXENTAS O EXONERADAS
      "acum_msubt_exento_compra_import" => $factCompras->sum('msubt_exento_compra'),
      //TOTALES DE LAS BASES IMPONIBLES
      "acum_msubt_tot_bi_compra_import" => $factCompras->sum('msubt_tot_bi_compra'),
      //TOTAL BI 12 IMPORT
      "acum_msubt_bi_iva_12_import" => $factCompras->sum('msubt_bi_iva_12'),
      //TOTAL BI 8 IMPORT
      "acum_msubt_bi_iva_8_import" => $factCompras->sum('msubt_bi_iva_8'),
      //TOTAL BI 27 IMPORT
      "acum_msubt_bi_iva_27_import" => $factCompras->sum('msubt_bi_iva_27'),

      //INTERNAS
      //total compras incluyendo el iva
      "acum_mtot_iva_compra_inter" => $factCompras->sum('mtot_iva_compra'),
      //TOTAL DE IMPORTACIONES EXENTAS O EXONERADAS
      "acum_IN_SDCF_compra_inter" => $acumInSdcfCompraInter,
      //TOTALES DE LAS BASES IMPONIBLES
      "acum_IN_EX_compra_inter" => $acumInExCompraInter,
      //TOTAL BI 12 IMPORT
      "acum_IN_EXO_compra_inter" =>  $acumInExoCompraInter,
      //TOTAL BI 8 IMPORT
      "acum_IN_NS_compra_inter" =>  $acumInNsCompraInter,

      "acum_msubt_tot_bi_compra_inter" => $factCompras->sum('msubt_tot_bi_compra'),
      "acum_msubt_bi_iva_12_inter" => $factCompras->sum('msubt_bi_iva_12'),
      "acum_msubt_bi_iva_8_inter" => $factCompras->sum('msubt_bi_iva_8'),
      "acum_msubt_bi_iva_27_inter" => $factCompras->sum('msubt_bi_iva_27'),

      "acum_tot_iva" => $factCompras->sum('tot_iva'),
      "acum_m_iva_reten" => $factCompras->sum('m_iva_reten'),

    ];

    //return $data['fact_compras_acum'];
    return view('book-shopping-list', $data);
  }

  /**
   * filter fact_compra
   * @request
   * {
   *		mes_fact_compra,
   *		tipo_fact_compra,
   *		num_fact_compra,
   *		fk_proveedor,
   *		fecha_fact_compra,
   *		serie_fact_compra,
   *		ord
   *	}
   */
  public static function search(Request $request)
  {
    //find data company for see information in relation
    $userId = auth()->user()->id;
    $requestBody = $request->all();

    //valid dates if send dates or not set for default
    $data['date_to'] = date("Y-m-d");
    $time = strtotime($data['date_to']);
    $data['date_from'] = date("Y-m-d", strtotime("-3 month", $time));

    if (isset($requestBody['mes'])) {
      $requestBody['queryBetween'] = [
        'key' => 'fecha_compro_reten',
        'data' => [
          Carbon::create($requestBody['mes'])->toDateString(),
          Carbon::create($requestBody['mes'])->endOfMonth()->toDateString()
        ]
      ];
    }

    $factCompras = FactCompra::query()
      ->where([
        ['fk_usuariosc', $userId]
      ]);

    //query retencion
    if (isset($requestBody['query'])) {
      $factCompras->where($requestBody['query']);
    } else {
      if (isset($requestBody['queryBetween'])) {
        $factCompras->whereBetween($requestBody['queryBetween']['key'], $requestBody['queryBetween']['data']);
      } else {
        $factCompras->whereBetween('fecha_fact_compra', [$data['date_from'], $data['date_to']]);
      }
    }

    //order
    if (isset($requestBody['orderBy'])) {
      $factCompras->orderBy($requestBody['orderBy']);
    } else {
      $factCompras->orderBy('fecha_fact_compra');
    }

    //origin
    if (isset($requestBody['origin'])) {
      $data['origin'] = $requestBody['origin'];
    }

    $data['fact_compras'] = $factCompras
      ->with('empre')
      ->with('user.empre')
      ->with('notacd')
      ->with('proveedor')
      ->with(['user' => function ($query) {
        $query
          ->with(['empre' => function ($query) {
            $query->where('est_empre', '1');
          }]);
      }])
      ->get();

    //consulta de los datos de la empreas PARA SABE LA ACTIVA
    $data['empre'] = Empre::query()
      ->where([
        ['est_empre', '1'],
        ['fk_usuarios', auth()->user()->id]
      ])
      ->first();

    if (isset($request['destination'])) {
      if ($request['destination'] == 'components.report.shopping-reten' || $request['destination'] == 'book-shopping-print') {
        $data['fact_compras'] = $data['fact_compras']
          ->where('num_compro_reten', '!=', '');
      }

      if (isset($request['success'])) {
        return redirect($request['destination'])->with([
          'success' => $request['success']
        ]);
      }
      return view($request['destination'], $data);
    }

    return view('book-shopping-simple', $data);
  }

  public function create()
  {
    return view('book-shopping-add');
  }

  public function store(Request $request)
  {

    $request = $request->all();

    $user = auth()->user();

    //consulta de los datos de la empreas PARA SABE LA ACTIVA
    $empre = Empre::query()
      ->where([
        ['est_empre', '1'],
        ['fk_usuarios', auth()->user()->id]
      ])
      ->first();

    //return ['params' => $request];

    try {

      $mtotIvaCompra = $request['mtot_iva_compra'];
      $totIva = $request['tot_iva'];
      $msubtExentoCompra = $request['msubt_exento_compra'];
      $msubtTotBiCompra = $request['msubt_tot_bi_compra'];
      $msubtBiIva12 = $request['msubt_bi_iva_12'];
      $msubtBiIva8 = $request['msubt_bi_iva_8'];
      $msubtBiIva27 = $request['msubt_bi_iva_27'];

      //asignacion de NEGATIVOS O NO
      if ($request['tipo_fact_compra'] == "NC-DEVO" || $request['tipo_fact_compra'] == "NC-DESC") {
        $negativo = -1;
        $mtotIvaCompra = $mtotIvaCompra * $negativo;
        $totIva = $totIva * $negativo;
        $msubtExentoCompra = $msubtExentoCompra * $negativo;
        $msubtTotBiCompra = $msubtTotBiCompra * $negativo;
        $msubtBiIva12 = $msubtBiIva12 * $negativo;
        $msubtBiIva8 = $msubtBiIva8 * $negativo;
        $msubtBiIva27 = $msubtBiIva27 * $negativo;
      }

      //insertar en FACT_COMPRA
      $factCompra = FactCompra::create([
        "serie_fact_compra" => $request['serie_fact_compra'],
        "num_fact_compra" => $request['num_fact_compra'],
        "num_ctrl_factcompra" => $request['num_ctrl_factcompra'],
        "fecha_fact_compra" => $request['fecha_fact_compra'],
        "tipo_trans" => $request['tipo_trans'],
        "nfact_afectada" => $request['nfact_afectada'],
        "tipo_fact_compra" => $request['tipo_fact_compra'],
        "fk_proveedor" => $request['fk_proveedor'],
        "fk_usuariosc" => $user->id,
        "empre_cod_empre" => $empre->id,
        "nplanilla_import" => $request['nplanilla_import'],
        "nexpe_import" => $request['nexpe_import'],
        "naduana_import" => $request['naduana_import'],
        "fechaduana_import" => $request['fechaduana_import'],

        "mtot_iva_compra" => $mtotIvaCompra,
        "tot_iva" => $totIva,
        "msubt_exento_compra" => $msubtExentoCompra,
        "msubt_tot_bi_compra" => $msubtTotBiCompra,
        "msubt_bi_iva_12" => $msubtBiIva12,
        "msubt_bi_iva_8" => $msubtBiIva8,
        "msubt_bi_iva_27" => $msubtBiIva27,

        "hora_fact_compra" => Carbon::now()->toDateTimeString(),
        "fecha_fact_compra_reg" => Carbon::now()

      ]);

      $data['factCompra'] = $factCompra;

      //get data of inventary of product for check
      $inventarios = Inventario::query()
        ->whereIn('id', $request["fk_inventario"])
        ->get();

      //funcion modificar inventario basado en la cantidad para promediar de precios
      //OJO EL valor_unitario ES IGUAL A COSTO PROMEDIADO ACTUAL
      //EL VALOR PROMEDIADO ES ESTIMULADO MEDIANTE CADA COMPRA
      $i = 0;
      $inventarios->each(function ($inventario) use ($request, $i, $factCompra) {

        $costo_promediado = $request["costo"][$i];

        //ACTUALIZACION inventario DE COSTO
        if ($inventario["valor_unitario"] !== $request["costo"][$i]) {
          //clculo de precio promediado
          $costo_promediado = $inventario->calculatePrecioProm($request["costo"][$i], $request["cantidad"][$i]);
        }

        //ACTUALIZA SUMA AL INVENTARIO
        $stock_cantidad = $inventario->calculateCantidad(
          $request['tipo_fact_compra'],
          $inventario['stock'],
          $request["cantidad"][$i],
          'compra'
        );

        $updateInven = Inventario::query()
          ->where('id', $request["fk_inventario"][$i])
          ->update([
            'stock' => $stock_cantidad,
            'valor_unitario' => $costo_promediado,
            'pmpvj_actual' => $request["pmpvj"][$i],

          ]);

        $data['updateInven'] = $updateInven;
        $resInsertRegInv = null;

        if ($updateInven) {
          //INSERTAR PARA EL  REGISTRO DE INVENTARIO LO ACTUAL SEGUN LA FECHA PARA KARDEX
          $insertRegInv = new RegInventario;
          $insertRegInv->fecha_reg_inv = $request['fecha_fact_compra'];
          $insertRegInv->costo_reg_inv = $costo_promediado;
          $insertRegInv->cantidad_reg_inv = $stock_cantidad;
          $insertRegInv->pmpvj = $request["pmpvj"][$i];
          $insertRegInv->tipo = "compra";
          $insertRegInv->fk_inventario = $request["fk_inventario"][$i];
          $insertRegInv->fk_fact_cv = $factCompra->id;
          $insertRegInv->hora_registro = Carbon::now()->toDateTimeString();
          $insertRegInv->fecha_registro = Carbon::now();

          $resInsertRegInv = $insertRegInv->save();
          $data['resInsertRegInv'] = $resInsertRegInv;
        }

        if ($resInsertRegInv) {
          //insertando compra
          $insertCompra = new Compra;

          $insertCompra->tipoCompra = $request["tipoCompra"][$i];
          $insertCompra->fk_inventario = $request["fk_inventario"][$i];
          $insertCompra->costo = $request["costo"][$i];
          $insertCompra->cantidad = $request["cantidad"][$i];
          $insertCompra->fk_fact_compra = $factCompra->id;

          $resInsertCompra = $insertRegInv->save();
          $data['resInsertCompra'] = $resInsertCompra;
        }
        $i++;
      });

      return redirect('book-shopping')->with([
        'success' => 'Factura de Compra creada con exito.'
      ]);
    } catch (\Exception $e) {
      $valid = "Fuck";
      if ($factCompra->id) {
        FactCompra::destroy($factCompra->id);
        $valid = " yes" . $factCompra->id;
      }

      return $e->getMessage() . $valid;
    }
  }

  public function edit(FactCompra $factCompra)
  {
    $factCompra->load(['proveedor', 'compras', 'compras.inventario']);
    //2023-02-04 00:00:00
    $factCompra->fechaduana_import = Carbon::create($factCompra->fechaduana_import)->format('Y-m-d');
    $factCompra->fecha_fact_compra = Carbon::create($factCompra->fecha_fact_compra)->format('Y-m-d');
    $data['factCompra'] = $factCompra;
    return view('book-shopping-add', $data);
  }

  public function update(Request $request)
  {

    $request = $request->all();

    $user = auth()->user();

    //consulta de los datos de la empreas PARA SABE LA ACTIVA
    $empre = Empre::query()
      ->where([
        ['est_empre', '1'],
        ['fk_usuarios', auth()->user()->id]
      ])
      ->first();

    return ['params' => $request];

    try {

      $mtotIvaCompra = $request['mtot_iva_compra'];
      $totIva = $request['tot_iva'];
      $msubtExentoCompra = $request['msubt_exento_compra'];
      $msubtTotBiCompra = $request['msubt_tot_bi_compra'];
      $msubtBiIva12 = $request['msubt_bi_iva_12'];
      $msubtBiIva8 = $request['msubt_bi_iva_8'];
      $msubtBiIva27 = $request['msubt_bi_iva_27'];

      //asignacion de NEGATIVOS O NO
      if ($request['tipo_fact_compra'] == "NC-DEVO" || $request['tipo_fact_compra'] == "NC-DESC") {
        $negativo = -1;
        $mtotIvaCompra = $mtotIvaCompra * $negativo;
        $totIva = $totIva * $negativo;
        $msubtExentoCompra = $msubtExentoCompra * $negativo;
        $msubtTotBiCompra = $msubtTotBiCompra * $negativo;
        $msubtBiIva12 = $msubtBiIva12 * $negativo;
        $msubtBiIva8 = $msubtBiIva8 * $negativo;
        $msubtBiIva27 = $msubtBiIva27 * $negativo;
      }

      //actualizo en FACT_COMPRA
      $factCompra = FactCompra::find($request['id_fact_compra'])
        ->load(['compras']);

      $factCompraUpdate = $factCompra
        ->update([
          "serie_fact_compra" => $request['serie_fact_compra'],
          "num_fact_compra" => $request['num_fact_compra'],
          "num_ctrl_factcompra" => $request['num_ctrl_factcompra'],
          "fecha_fact_compra" => $request['fecha_fact_compra'],
          "tipo_trans" => $request['tipo_trans'],
          "nfact_afectada" => $request['nfact_afectada'],
          "tipo_fact_compra" => $request['tipo_fact_compra'],
          "fk_proveedor" => $request['fk_proveedor'],
          "fk_usuariosc" => $user->id,
          "empre_cod_empre" => $empre->id,
          "nplanilla_import" => $request['nplanilla_import'],
          "nexpe_import" => $request['nexpe_import'],
          "naduana_import" => $request['naduana_import'],
          "fechaduana_import" => $request['fechaduana_import'],

          "mtot_iva_compra" => $mtotIvaCompra,
          "tot_iva" => $totIva,
          "msubt_exento_compra" => $msubtExentoCompra,
          "msubt_tot_bi_compra" => $msubtTotBiCompra,
          "msubt_bi_iva_12" => $msubtBiIva12,
          "msubt_bi_iva_8" => $msubtBiIva8,
          "msubt_bi_iva_27" => $msubtBiIva27,

          "hora_fact_compra" => Carbon::now()->toDateTimeString(),
          "fecha_fact_compra_reg" => Carbon::now()

        ]);

      $data['factCompraUpdate'] = $factCompraUpdate;

      $data['factCompraOld'] = $factCompra->get();

      //get data of inventary of product for check
      $inventarios = Inventario::query()
        ->whereIn('id', $request["fk_inventario"])
        ->get();

      $comprasOld = $factCompra->compras;

      //funcion modificar inventario basado en la cantidad para promediar de precios
      //OJO EL valor_unitario ES IGUAL A COSTO PROMEDIADO ACTUAL
      //EL VALOR PROMEDIADO ES ESTIMULADO MEDIANTE CADA COMPRA
      $i = 0;
      $j = 0;
      $comprasOld->each(function ($compraOld) use ($request, $i, $j, $factCompra, $inventarios) {
        $inventarios->each(function ($inventario) use ($request, $i, $j, $factCompra, $compraOld) {

          //check if have update
          if ($compraOld !== $inventario) {

            //si hay diferencia en precio que hay con el inventario prmedio

          }

          $costo_promediado = $request["costo"][$i];

          //ACTUALIZACION inventario DE COSTO
          if ($inventario["valor_unitario"] !== $request["costo"][$i]) {
            //clculo de precio promediado
            $costo_promediado = $inventario->calculatePrecioProm($request["costo"][$i], $request["cantidad"][$i]);
          }

          //ACTUALIZA SUMA AL INVENTARIO
          $stock_cantidad = $inventario->calculateCantidad(
            $request['tipo_fact_compra'],
            $inventario['stock'],
            $request["cantidad"][$i],
            'compra'
          );

          $updateInven = Inventario::query()
            ->where('id', $request["fk_inventario"][$i])
            ->update([
              'stock' => $stock_cantidad,
              'valor_unitario' => $costo_promediado,
              'pmpvj_actual' => $request["pmpvj"][$i],

            ]);

          $data['updateInven'] = $updateInven;
          $resInsertRegInv = null;

          if ($updateInven) {
            //INSERTAR PARA EL  REGISTRO DE INVENTARIO LO ACTUAL SEGUN LA FECHA PARA KARDEX
            $insertRegInv = new RegInventario;
            $insertRegInv->fecha_reg_inv = $request['fecha_fact_compra'];
            $insertRegInv->costo_reg_inv = $costo_promediado;
            $insertRegInv->cantidad_reg_inv = $stock_cantidad;
            $insertRegInv->pmpvj = $request["pmpvj"][$i];
            $insertRegInv->tipo = "compra";
            $insertRegInv->fk_inventario = $request["fk_inventario"][$i];
            $insertRegInv->fk_fact_cv = $factCompra->id;
            $insertRegInv->hora_registro = Carbon::now()->toDateTimeString();
            $insertRegInv->fecha_registro = Carbon::now();

            $resInsertRegInv = $insertRegInv->save();
            $data['resInsertRegInv'] = $resInsertRegInv;
          }

          if ($resInsertRegInv) {
            //insertando compra
            $insertCompra = new Compra;

            $insertCompra->tipoCompra = $request["tipoCompra"][$i];
            $insertCompra->fk_inventario = $request["fk_inventario"][$i];
            $insertCompra->costo = $request["costo"][$i];
            $insertCompra->cantidad = $request["cantidad"][$i];
            $insertCompra->fk_fact_compra = $factCompra->id;

            $resInsertCompra = $insertRegInv->save();
            $data['resInsertCompra'] = $resInsertCompra;
          }
          $j++;
        });
        $i++;
      });

      return redirect('book-shopping')->with([
        'success' => 'Factura de Compra actualizada con exito.'
      ]);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function destroy(Request $request)
  {
    //FactCompra::destroy($request->id);
    return redirect('book-shopping')->with(['destroy' => 'Factura de Compra eliminada con exito.']);
  }

  public function indexPrint(Request $request)
  {

    $empre = auth()->user()->empre()->active();

    if ($empre->reteniva == 'SI' && $empre->contri_empre == 'Especial') {
      return redirect('book-shopping')->with([
        'warning' => 'Lo sentimos ud debe cumplir ciertas condiciones para retener en compras Debe Ser
				- Contribuyente Especial
				- Debe Retener IVA segun pagina del SENIAT.'
      ]);
    }

    $request['destination'] = 'book-shopping-print';
    return $this->search($request);
  }

  public function print(Request $request)
  {

    $empre = auth()->user()->empre()->active();

    if ($empre->reteniva == 'SI' && $empre->contri_empre == 'Especial') {
      return redirect('book-shopping')->with([
        'warning' => 'Lo sentimos ud debe cumplir ciertas condiciones para retener en compras Debe Ser
				- Contribuyente Especial
				- Debe Retener IVA segun pagina del SENIAT.'
      ]);
    }

    $request['destination'] = 'book-shopping-print';

    return $this->search($request);
  }

  public function report(Request $request)
  {
    $dateCurrent = date("Y-m-d");

    $request['destination'] = 'components.report.shopping-reten';
    $request['query'] = ["num_compro_reten" => $request['num_compro_reten']];

    //get css by default
    $parser = new \Sabberworm\CSS\Parser(file_get_contents('./assets/css/report.css'));
    $cssDocument = '<style>' . $parser->parse() . '</style>';


    //gethtml table and invoice
    $html = $this->search($request);

    //return $html;

    // reference the Dompdf namespace

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();

    $dompdf->loadHtml($cssDocument.$html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('legal', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    $options = $dompdf->getOptions();
    $options->setIsRemoteEnabled(true);
    $dompdf->setOptions($options);

    // Output the generated PDF to Browser
    $dompdf->stream('reporte_compro_reten_' . $dateCurrent . '.pdf');
  }

}
