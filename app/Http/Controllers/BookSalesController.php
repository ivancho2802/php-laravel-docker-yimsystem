<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FactVenta;
use App\Models\Inventario;
use App\Models\RegInventario;
use App\Models\Venta;
use Illuminate\Support\Carbon;
use App\Models\Empre;
use Dompdf\Dompdf;
use Dompdf\Options;

class BookSalesController extends Controller
{
  //
  public function index(Request $request)
  {
    //consulta de los datos de la empreas PARA SABE LA ACTIVA
    $requestBody = $request->all();

    $user = auth()->user();

    //consulta de los datos de la empreas PARA SABE LA ACTIVA
    $data['empre'] = Empre::query()
      ->where([
        ['est_empre', '1'],
        ['fk_usuarios', auth()->user()->id]
      ])
      ->first();

    //find data company for see information in relation
    $data['date_to'] = date("Y-m-d");
    $time = strtotime($data['date_to']);
    $data['date_from'] = date("Y-m-d", strtotime("-1 month", $time));

    $factVentas = FactVenta::query()
      ->where([
        ['fecha_fact_venta', '>=', $data['date_from']],
        ['fecha_fact_venta', '<=', $data['date_to']],
        ['fk_usuariosV', auth()->user()->id]
      ]);

    $factVentasAcum = FactVenta::query()
      ->where([
        ['fecha_fact_venta', '>=', $data['date_from']],
        ['fecha_fact_venta', '<=', $data['date_to']],
        ['fk_usuariosV', auth()->user()->id]
      ]);

    $data['mes'] = date("m", strtotime($data['date_from']));

    //acumulador

    $acum_IN_SDCF_venta_n  =  0;
    $acum_IN_EX_venta_n =     0;
    $acum_IN_EXO_venta_n  =  0;
    $acum_IN_NS_venta_n  =   0;

    //calculo de acum without_iva
    $factVentasAcum
      ->each(
        function ($factVentaAcum) use (
          $acum_IN_SDCF_venta_n,
          $acum_IN_EX_venta_n,
          $acum_IN_EXO_venta_n,
          $acum_IN_NS_venta_n
        ) {

          $factVentaAcum->append("without_iva");

          $acum_IN_SDCF_venta_n += $factVentaAcum->without_iva['SDCF'];
          $acum_IN_EX_venta_n += $factVentaAcum->without_iva['EX'];
          $acum_IN_EXO_venta_n += $factVentaAcum->without_iva['EXO'];
          $acum_IN_NS_venta_n += $factVentaAcum->without_iva['NS'];
        }
      );


    $data['fact_ventas_acum'] = [
      "acum_msubt_exento_venta" => $factVentasAcum->sum('msubt_exento_venta'),

      "acum_msubt_bi_iva_12_n" => $factVentasAcum->orWhere([
        ['nplanilla_export', ''],
        ['nplanilla_export', NULL],
      ])
        ->sum('msubt_bi_iva_12'),

      "acum_msubt_bi_iva_8_n" => $factVentasAcum->orWhere([
        ['nplanilla_export', ''],
        ['nplanilla_export', NULL],
      ])
        ->sum('msubt_bi_iva_8'),

      "acum_msubt_bi_iva_27_n" => $factVentasAcum->orWhere([
        ['nplanilla_export', ''],
        ['nplanilla_export', NULL],
      ])
        ->sum('msubt_bi_iva_27'),

      "acum_msubt_bi_iva_12_n_CONTRI" => $factVentasAcum->where([['tipo_contri', '!=', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_12'),

      "acum_msubt_bi_iva_8_n_CONTRI" => $factVentasAcum->where([['tipo_contri', '!=', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_8'),

      "acum_msubt_bi_iva_27_n_CONTRI" => $factVentasAcum->where([['tipo_contri', '!=', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_27'),

      "acum_msubt_bi_iva_12_n_NO_CONTRI" => $factVentasAcum->where([['tipo_contri', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_12'),

      "acum_msubt_bi_iva_8_n_NO_CONTRI" => $factVentasAcum->where([['tipo_contri', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_8'),

      "acum_msubt_bi_iva_27_n_NO_CONTRI" => $factVentasAcum->where([['tipo_contri', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_27'),

      "acum_mtot_iva_venta_n" => $factVentasAcum->sum('mtot_iva_venta'),

      //TOTAL BI 8 IMPORT
      'acum_IN_SDCF_venta_n' => $acum_IN_SDCF_venta_n,
      'acum_IN_EX_venta_n' => $acum_IN_EX_venta_n,
      'acum_IN_EXO_venta_n' => $acum_IN_EXO_venta_n,
      'acum_IN_NS_venta_n' => $acum_IN_NS_venta_n,

      "acum_msubt_exento_venta_export" => $factVentasAcum->whereNotNull('nplanilla_export')
        ->sum('msubt_exento_venta'),

      "acum_m_iva_reten" => $factVentasAcum->sum('m_iva_reten'),
      "acum_tot_iva" => $factVentasAcum->sum('tot_iva'),
    ];

    //query retencion
    if (isset($requestBody['query'])) {
      $factVentas->where($requestBody['query']);
    } else {
      if (isset($requestBody['queryBetween'])) {
        $factVentas->whereBetween($requestBody['queryBetween']['key'], $requestBody['queryBetween']['data']);
      } else {
        $factVentas->whereBetween('fecha_fact_venta', [$data['date_from'], $data['date_to']]);
      }
    }

    //order
    if (isset($requestBody['orderBy'])) {
      foreach ($requestBody['orderBy'] as $orderBy) {
        $factVentas->orderBy($orderBy);
      }
    } else {
      $factVentas->orderBy('fecha_fact_venta');
    }

    $data['fact_ventas'] = $factVentas
      ->orderBy('fecha_fact_venta')
      ->with('notascdventas')
      ->with('cliente')
      ->paginate(10);

    return view('book-sales-list', $data);
  }

  /**
   * filter fact_venta
   * @request
   * {
   *		mes_fact_venta,
   *		tipo_fact_venta,
   *		num_fact_venta,
   *		fk_proveedor,
   *		fecha_fact_venta,
   *		serie_fact_venta,
   *		ord
   *	}
   */
  public static function search(Request $request)
  {

    //find data company for see information in relation
    $userId = auth()->user()->id;
    $requestBody = $request->all();

    //valid dates if send dates or not set for default
    if (!isset($data['date_to'])) {
      $data['date_to'] = date("Y-m-d");
    }

    //find data company for see information in relation
    if (!isset($data['date_from'])) {
      $time = strtotime($data['date_to']);
      $data['date_from'] = date("Y-m-d", strtotime("-1 month", $time));
    }

    $factVentas = FactVenta::query()
      ->where([
        ['fk_usuariosV', $userId]
      ]);

    $factVentasAcum = FactVenta::query()
      ->where([
        ['fk_usuariosV', $userId]
      ]);

    //query retencion
    if (isset($requestBody['query'])) {
      $factVentas->where($requestBody['query']);
    } else {
      if (isset($requestBody['queryBetween'])) {
        $factVentas->whereBetween($requestBody['queryBetween']['key'], $requestBody['queryBetween']['data']);
      } else {
        $factVentas->whereBetween('fecha_fact_venta', [$data['date_from'], $data['date_to']]);
      }
    }

    //order
    if (isset($requestBody['orderBy'])) {
      foreach ($requestBody['orderBy'] as $orderBy) {
        $factVentas->orderBy($orderBy);
      }
    } else {
      $factVentas->orderBy('fecha_fact_venta');
    }

    //origin
    if (isset($requestBody['origin'])) {
      $data['origin'] = $requestBody['origin'];
    }

    //consulta de los datos de la empreas PARA SABE LA ACTIVA
    $data['empre'] = Empre::query()
      ->where([
        ['est_empre', '1'],
        ['fk_usuarios', auth()->user()->id]
      ])
      ->first();

    $data['fact_ventas_acum'] = [
      "acum_msubt_exento_venta" => $factVentasAcum->sum('msubt_exento_venta'),

      "acum_msubt_bi_iva_12_n" => $factVentasAcum->orWhere([
        ['nplanilla_export', ''],
        ['nplanilla_export', NULL],
      ])
        ->sum('msubt_bi_iva_12'),

      "acum_msubt_bi_iva_8_n" => $factVentasAcum->orWhere([
        ['nplanilla_export', ''],
        ['nplanilla_export', NULL],
      ])
        ->sum('msubt_bi_iva_8'),

      "acum_msubt_bi_iva_27_n" => $factVentasAcum->orWhere([
        ['nplanilla_export', ''],
        ['nplanilla_export', NULL],
      ])
        ->sum('msubt_bi_iva_27'),

      "acum_msubt_bi_iva_12_n_CONTRI" => $factVentasAcum->where([['tipo_contri', '!=', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_12'),

      "acum_msubt_bi_iva_8_n_CONTRI" => $factVentasAcum->where([['tipo_contri', '!=', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_8'),

      "acum_msubt_bi_iva_27_n_CONTRI" => $factVentasAcum->where([['tipo_contri', '!=', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_27'),

      "acum_msubt_bi_iva_12_n_NO_CONTRI" => $factVentasAcum->where([['tipo_contri', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_12'),

      "acum_msubt_bi_iva_8_n_NO_CONTRI" => $factVentasAcum->where([['tipo_contri', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_8'),

      "acum_msubt_bi_iva_27_n_NO_CONTRI" => $factVentasAcum->where([['tipo_contri', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_27'),

      "acum_msubt_exento_venta_export" => $factVentasAcum->whereNull('nplanilla_export')
        ->sum('msubt_exento_venta'),

      "acum_mtot_iva_venta_n" => $factVentasAcum->orWhere([
        ['nplanilla_export', ''],
        ['nplanilla_export', NULL],
      ])
        ->sum('mtot_iva_venta'),

      "acum_m_iva_reten" => $factVentasAcum->sum('m_iva_reten'),
      "acum_tot_iva" => $factVentasAcum->sum('tot_iva'),
    ];

    $factVentas = $factVentas
      ->with('empre')
      ->with('user.empre')
      ->with('notascdventas')
      ->with('cliente')
      ->with(['user' => function ($query) {
        $query
          ->with(['empre' => function ($query) {
            $query->where('est_empre', '1');
          }]);
      }])
      ->get()
      //calculo de acum without_iva
      ->append("without_iva");

    $data['fact_ventas'] = $factVentas;
    $factVentasAcum = $factVentas;

    //TOTAL BI 8 IMPORT
    $data['fact_ventas_acum']['acum_IN_SDCF_venta_n'] = $factVentasAcum->sum('without_iva.SDCF');
    $data['fact_ventas_acum']['acum_IN_EX_venta_n'] = $factVentasAcum->sum('without_iva.EX');
    $data['fact_ventas_acum']['acum_IN_EXO_venta_n'] = $factVentasAcum->sum('without_iva.EXO');
    $data['fact_ventas_acum']['acum_IN_NS_venta_n'] = $factVentasAcum->sum('without_iva.NS');

    if (isset($request['destination'])) {

      if ($request['limit'] == 1) {
        $data['fact_ventas'] = $factVentas->first();
      }

      if ($request['destination'] == 'json') {
        return response()->json(['status' => true, 'data' => $data], 200);
      }

      if ($request['destination'] == 'components.report.sales' || $request['destination'] == 'book-sales') {
        if (isset($requestBody['css'])) {
          $data['css'] = $requestBody['css'];
        }
      }

      if (isset($request['success'])) {
        return redirect($request['destination'])->with([
          'success' => $request['success']
        ]);
      }

      return view($request['destination'])->with($data);
    }

    return view('book-sales-simple', $data);
  }

  public function valid(Request $request)
  {
    try {
      $userId = auth()->user()->id;
      //numero
      //control
      $exist = FactVenta::query()
        ->where([
          ["fk_usuariosV", $userId],
          ["num_fact_venta", $request['numero']],
          ["num_ctrl_factventa", $request['control']]
        ])
        ->exists();

      return response()->json(['status' => true, 'data' => $exist], 200);
    } catch (\Exception $e) {
      return response()->json(['status' => false, 'data' => $e->getMessage()], 500);
    }
  }

  public static function condRif($rif)
  {

    $letraRif = substr($rif, 0, 1);

    if ($letraRif == 'J' || $letraRif == 'G') {
      $condRif = 'PJ';
    } else {
      $condRif = 'PN';
    }

    return $condRif;
  }

  public function report(Request $request)
  {
    $dateCurrent = date("Y-m-d");

    $request['destination'] = 'components.report.sales';
    //$request['query'] = ["num_compro_reten" => $request['num_compro_reten']];

    //get css by default
    $parser = new \Sabberworm\CSS\Parser(file_get_contents('./assets/css/report.css'));
    $cssDocument = '<style>' . $parser->parse() . '</style>';

    $request['css'] = $cssDocument;

    //gethtml table and invoice
    $html = $this->search($request);

    // reference the Dompdf namespace

    // instantiate and use the dompdf class
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

    // Output the generated PDF to Browser
    $dompdf->stream('reporte_book_sales_' . $dateCurrent . '.pdf');
  }

  public function reportFact(Request $request)
  {

    $userId = auth()->user()->id;

    if (!isset($request->id_fact_venta)) {
      return response()->json(['status' => false], 409);
    }

    //consulta de los datos de la empreas PARA SABE LA ACTIVA
    $data['empre'] = Empre::query()
      ->where([
        ['est_empre', '1'],
        ['fk_usuarios', auth()->user()->id]
      ])
      ->first();

    $data['fact_venta'] = FactVenta::query()
      ->where([
        ['id', $request->id_fact_venta],
        ['fk_usuariosV', $userId]
      ])
      ->with('empre')
      ->with('user.empre')
      ->with(['user' => function ($query) {
        $query
          ->with(['empre' => function ($query) {
            $query->where('est_empre', '1');
          }]);
      }])
      ->with('cliente')
      ->with('ventas')
      ->with('ventas.inventario');

    $data['fact_ventas_acum'] = [
      "acum_msubt_exento_venta" => $data['fact_venta']->sum('msubt_exento_venta'),

      "acum_msubt_bi_iva_12_n" => $data['fact_venta']->orWhere([
        ['nplanilla_export', ''],
        ['nplanilla_export', NULL],
      ])
        ->sum('msubt_bi_iva_12'),

      "acum_msubt_bi_iva_8_n" => $data['fact_venta']->orWhere([
        ['nplanilla_export', ''],
        ['nplanilla_export', NULL],
      ])
        ->sum('msubt_bi_iva_8'),

      "acum_msubt_bi_iva_27_n" => $data['fact_venta']->orWhere([
        ['nplanilla_export', ''],
        ['nplanilla_export', NULL],
      ])
        ->sum('msubt_bi_iva_27'),

      "acum_msubt_bi_iva_12_n_CONTRI" => $data['fact_venta']->where([['tipo_contri', '!=', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_12'),

      "acum_msubt_bi_iva_8_n_CONTRI" => $data['fact_venta']->where([['tipo_contri', '!=', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_8'),

      "acum_msubt_bi_iva_27_n_CONTRI" => $data['fact_venta']->where([['tipo_contri', '!=', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_27'),

      "acum_msubt_bi_iva_12_n_NO_CONTRI" => $data['fact_venta']->where([['tipo_contri', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_12'),

      "acum_msubt_bi_iva_8_n_NO_CONTRI" => $data['fact_venta']->where([['tipo_contri', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_8'),

      "acum_msubt_bi_iva_27_n_NO_CONTRI" => $data['fact_venta']->where([['tipo_contri', 'NO_CONTRI']])
        ->orWhere([
          ['nplanilla_export', ''],
          ['nplanilla_export', NULL],
        ])
        ->sum('msubt_bi_iva_27'),

      "acum_msubt_exento_venta_export" => $data['fact_venta']->whereNull('nplanilla_export')
        ->sum('msubt_exento_venta'),

      "acum_mtot_iva_venta_n" => $data['fact_venta']->orWhere([
        ['nplanilla_export', ''],
        ['nplanilla_export', NULL],
      ])
        ->sum('mtot_iva_venta'),

      "acum_m_iva_reten" => $data['fact_venta']->sum('m_iva_reten'),
      "acum_tot_iva" => $data['fact_venta']->sum('tot_iva'),
    ];

    $data['fact_venta'] = $data['fact_venta']->first();

    $date = Carbon::parse($data['fact_venta']->fecha_fact_venta);
    $daysToAdd =  $data['fact_venta']['dias_venc'];
    $date = $date->addDays($daysToAdd);

    $data['fact_venta']['fecha_fact_venta_expired'] = $date;

    if (isset($request->returnData)) {
      return $data;
    }

    //get css by default
    $parser = new \Sabberworm\CSS\Parser(file_get_contents('./assets/css/report.css'));
    $cssDocument = '<style>' . $parser->parse() . '</style>';

    $data['css'] = $cssDocument;

    $html = view('components.report.fact_sales', $data);

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
    $dompdf->stream('reporte_book_fact_sales_' . $dateCurrent . '.pdf');
  }

  public function create(Request $request)
  {
    return view('book-sales-add');
  }

  public function store(Request $request)
  {

    $request = $request->all();

    $user = auth()->user();

    //consulta de los datos de la empreas PARA SABE LA ACTIVA
    $data['empre'] = Empre::query()
      ->where([
        ['est_empre', '1'],
        ['fk_usuarios', auth()->user()->id]
      ])
      ->first();

    //return ['params' => $request];

    try {

      $mtotIvaVenta = $request['mtot_iva_venta'];
      $totIva = $request['tot_iva'];
      $msubtExentoVenta = $request['msubt_exento_venta'];
      $msubtTotBiVenta = $request['msubt_tot_bi_venta'];
      $msubtBiIva12 = $request['msubt_bi_iva_12'];
      $msubtBiIva8 = $request['msubt_bi_iva_8'];
      $msubtBiIva27 = $request['msubt_bi_iva_27'];

      //asignacion de NEGATIVOS O NO
      if ($request['tipo_fact_venta'] == "NC-DEVO" || $request['tipo_fact_venta'] == "NC-DESC") {
        $negativo = -1;
        $mtotIvaVenta = $mtotIvaVenta * $negativo;
        $totIva = $totIva * $negativo;
        $msubtExentoVenta = $msubtExentoVenta * $negativo;
        $msubtTotBiVenta = $msubtTotBiVenta * $negativo;
        $msubtBiIva12 = $msubtBiIva12 * $negativo;
        $msubtBiIva8 = $msubtBiIva8 * $negativo;
        $msubtBiIva27 = $msubtBiIva27 * $negativo;
      }

      //insertar en FACT_COMPRA
      $factVenta = FactVenta::create([
        "serie_fact_venta" => $request['serie_fact_venta'],
        "num_fact_venta" => $request['num_fact_venta'],
        "num_ctrl_factventa" => $request['num_ctrl_factventa'],
        "fecha_fact_venta" => $request['fecha_fact_venta'],
        "tipo_trans" => $request['tipo_trans'],
        "nfact_afectada" => $request['nfact_afectada'],
        "tipo_fact_venta" => $request['tipo_fact_venta'],
        "tipo_pago" => $request['tipo_pago'],
        "dias_venc" => $request['dias_venc'],
        "tipo_contri" => $request['tipo_contri'],
        "nplanilla_export" => $request['nplanilla_export'],
        "nexpe_export" => $request['nexpe_export'],
        "naduana_export" => $request['naduana_export'],
        "fechaduana_export" => $request['fechaduana_export'],
        "monto_paga" => $request['monto_paga'],
        "mtot_iva_venta" => $mtotIvaVenta,
        "tot_iva" => $totIva,
        "msubt_exento_venta" => $msubtExentoVenta,
        "msubt_tot_bi_venta" => $msubtTotBiVenta,
        "msubt_bi_iva_12" => $msubtBiIva12,
        "msubt_bi_iva_8" => $msubtBiIva8,
        "msubt_bi_iva_27" => $msubtBiIva27,
        "reg_maq_fis" => $request['reg_maq_fis'],
        "num_repo_z" => $request['num_repo_z'],
        "hora_fact_venta" => Carbon::now()->toDateTimeString(),
        "fecha_fact_venta_reg" => Carbon::now(),

        "fk_cliente" => $request['fk_cliente'],
        "fk_usuariosV" => $user->id,
        "empre_cod_empre" => $empre->id
      ]);

      $data['factVenta'] = $factVenta;

      //get data of inventary of product for check
      $inventarios = Inventario::query()
        ->whereIn('id', $request["fk_inventario"])
        ->get();

      //funcion modificar inventario basado en la cantidad para promediar de precios
      //OJO EL valor_unitario ES IGUAL A COSTO PROMEDIADO ACTUAL
      //EL VALOR PROMEDIADO ES ESTIMULADO MEDIANTE CADA COMPRA
      $i = 0;
      $inventarios->each(function ($inventario) use ($request, $i, $factVenta) {

        $costo = $request["costo"][$i];

        //ACTUALIZACION inventario DE COSTO
        /* if ($inventario["valor_unitario"] !== $request["costo"][$i]) {
          //clculo de precio promediado
          $costo_promediado = $inventario->calculatePrecioProm($request["costo"][$i], $request["cantidad"][$i]);
        } */

        //ACTUALIZA SUMA AL INVENTARIO
        $stock_cantidad = $inventario->calculateCantidad(
          $request['tipo_fact_venta'],
          $inventario['stock'],
          $request["cantidad"][$i],
          'venta'
        );

        $updateInven = Inventario::query()
          ->where('id', $request["fk_inventario"][$i])
          ->update([
            'stock' => $stock_cantidad,
            'pmpvj_actual' => $costo,
          ]);

        $data['updateInven'] = $updateInven;
        $resInsertRegInv = null;

        if ($updateInven) {
          //INSERTAR PARA EL  REGISTRO DE INVENTARIO LO ACTUAL SEGUN LA FECHA PARA KARDEX
          $insertRegInv = new RegInventario;
          $insertRegInv->fecha_reg_inv = $request['fecha_fact_venta'];
          $insertRegInv->costo_reg_inv = $inventario['valor_unitario'];
          $insertRegInv->cantidad_reg_inv = $stock_cantidad;
          $insertRegInv->pmpvj = $costo;
          $insertRegInv->tipo = "venta";
          $insertRegInv->fk_inventario = $request["fk_inventario"][$i];
          $insertRegInv->fk_fact_cv = $factVenta->id;
          $insertRegInv->hora_registro = Carbon::now()->toDateTimeString();
          $insertRegInv->fecha_registro = Carbon::now();

          $resInsertRegInv = $insertRegInv->save();
          $data['resInsertRegInv'] = $resInsertRegInv;
        }

        if ($resInsertRegInv) {
          //insertando venta
          $insertVenta = new Venta;
          $insertVenta->tipoVenta = $request["tipoVenta"][$i];
          $insertVenta->fk_inventario = $request["fk_inventario"][$i];
          $insertVenta->costo = $inventario['valor_unitario'];
          $insertVenta->precio_venta = $costo;
          $insertVenta->cantidad = $request["cantidad"][$i];
          $insertVenta->fk_fact_venta = $factVenta->id;

          $resInsertVenta = $insertRegInv->save();
          $data['resInsertVenta'] = $resInsertVenta;
        }
        $i++;
      });

      return redirect('book-sales')->with([
        'success' => 'Factura de Venta creada con exito.'
      ]);
    } catch (\Exception $e) {
      $valid = "Duck";
      if (isset($factVenta) && optional($factVenta)->id) {
        FactVenta::destroy($factVenta->id);
        $valid = " yes" . $factVenta->id;
      }

      return $e->getMessage() . $valid;
    }
  }

  public function indexDetail(Request $request)
  {
    $request['returnData'] = true;
    $request['id_fact_venta'] = $request->id_fact_venta;

    $data = $this->reportFact($request);

    return view('modales.fact_v.m_b_fact_v_detail', $data);
  }
}
