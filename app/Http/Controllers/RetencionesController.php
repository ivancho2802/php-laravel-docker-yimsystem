<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FactCompra;

class RetencionesController extends Controller
{
  /**
   * filter factura compra
   * @request
   * {
   *		id, de la factura
   *	}book-shopping-detail/{factCompra}
   */
  public function indexDetail(Request $request)
  {
    $data['fact_compra'] = FactCompra::query()
      ->find($request->factCompra)
      ->where([
        ['fk_usuariosc', auth()->user()->id]
      ])
      ->load(['compras', 'compras.inventario']);
    return view('modales.fact_c.m_b_fact_c_detail', $data);
  }


  public function retenadd(Request $request)
  {
    $empre = auth()->user()->empre()->active();

    if ($empre->reteniva == 'SI' && $empre->contri_empre == 'Especial') {
      return redirect('book-shopping')->with([
        'warning' => 'Lo sentimos ud debe cumplir ciertas condiciones para retener en compras Debe Ser
				- Contribuyente Especial
				- Debe Retener IVA segun pagina del SENIAT.'
      ]);
    }

    $data['asd'] = "";

    return view('book-shopping-reten-add', $data);
  }

  /**
   * generar numero comprobante de retencion
   */
  public function generate(Request $request)
  {
    $factCompra = FactCompra::query()
      ->select(['num_compro_reten'])
      ->where([
        ['fk_usuariosc', auth()->user()->id]
      ])
      ->first();

    $ultimoNumero = 0;

    if (isset($factCompra->num_compro_reten)) {
      //extraigo los 8 numeros finales del numero actual
      $ultimoNumero = substr($factCompra->num_compro_reten, 10, 16);
    }

    $siguienteNumero = $ultimoNumero + 1;

    return response()->json(['status' => true,  'siguienteNumero' => $siguienteNumero], 201);
  }

  /**
   * crear retencio a factura
   */
  public function update(Request $request)
  {
    try {
      $data['fact_compra'] = FactCompra::query()
        ->where([
          ['id', $request->id_fact_compra],
          ['fk_usuariosc', auth()->user()->id]
        ])
        ->update([
          'num_compro_reten' => $request->num_compro_reten,
          'fecha_compro_reten' => $request->fecha_compro_reten,
          'm_iva_reten' => $request->m_iva_reten,
          'mes_apli_reten' => $request->mes_apli_reten,
        ]);

      $request['destination'] = 'book-shopping-print';
      $request['success'] = "<strong>Excelente!</strong> Registro exitoso <strong>Click para Volver</strong>.";
      return \App\Http\Controllers\BookShoppingController::search($request);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }
}
