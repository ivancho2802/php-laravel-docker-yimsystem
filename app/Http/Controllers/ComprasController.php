<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;

class ComprasController extends Controller
{
	/**
	 * filter compra
	 * @request
	 * {
	*		id, de la factura
	*	}
	 */
	public function search(Request $request)
	{
		$data['compras'] = Compra::query()
		->where([
			['fk_fact_compra', $request->id]
		])
        ->get();

        return response()->json([ 'status' => true,  'compras' => $data['compras']], 201);
    }
}
