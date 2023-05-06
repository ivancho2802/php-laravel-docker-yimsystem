<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
  use HasFactory;

  const INVENTARYADD = 'inventario-add';
  const INVENTARYLIST = 'inventario-list';

  protected $fillable = [
    'id',
    'codigo',
    'nombre_i',
    'descripcion',
    'cant_min',
    'cant_max',
    'stock',
    'valor_unitario',
    'pmpvj_actual',
    'fecha',
    'updated_at',
    'fk_usuarios',
    'created_at'

  ];

  public function registros()
  {
    return $this->hasMany(RegInventario::class, 'fk_inventario', 'id');
  }

  public function retiros()
  {
    return $this->hasMany(InventarioRetiro::class, 'fk_inventario', 'id');
  }

  public function compras()
  {
    return $this->hasMany(Compra::class, 'fk_inventario', 'id');
  }

  public function ventas()
  {
    return $this->hasMany(Venta::class, 'fk_inventario', 'id');
  }

  /**
   * atributo inventario_inicial_registro [costo_reg_inv, ]
   */
  public function inventarioInicialRegistro($dateBegin)
  {

    $inventarioInicial = $this->load(['registros' => function ($query) use ($dateBegin) {
      $query->where('fecha_reg_inv', '<', $dateBegin)
        ->orderBy('fecha_reg_inv', 'desc')
        ->first();
    }]);

    $costo_reg_inv = optional($inventarioInicial->registros->first())->costo_reg_inv;
    $cantidad_reg_inv = optional($inventarioInicial->registros->first())->cantidad_reg_inv;
    $monto = $cantidad_reg_inv * $costo_reg_inv;
    /* miicu */
    $this->attributes['inventario_inicial_registro_costo_reg_inv'] = round($costo_reg_inv, 2);
    /* miic */
    $this->attributes['inventario_inicial_registro_cantidad_reg_inv'] = round($cantidad_reg_inv, 2);
    /* miim */
    $this->attributes['inventario_inicial_registro_monto'] = round($monto, 2);
  }

  /**
   * atributo inventario_final_registro [costo_reg_inv, ]
   */
  public function inventarioFinalRegistro($dateEnd)
  {

    $inventarioFinal = $this->load(['registros' => function ($query) use ($dateEnd) {
      $query->where('fecha_reg_inv', '<=', $dateEnd)
        ->orderBy('fecha_reg_inv', 'desc')
        ->orderBy('hora_registro', 'desc')
        ->first();
    }]);

    $costo_reg_inv = optional($inventarioFinal->registros->first())->costo_reg_inv;
    $cantidad_reg_inv = optional($inventarioFinal->registros->first())->cantidad_reg_inv;
    $monto = $cantidad_reg_inv * $costo_reg_inv;

    $this->attributes['inventario_final_registro_costo_reg_inv'] = round($costo_reg_inv, 2);
    $this->attributes['inventario_final_registro_cantidad_reg_inv'] = round($cantidad_reg_inv, 2);
    $this->attributes['inventario_final_registro_monto'] = round($monto, 2);
  }


  /**
   * atributo inventario_inicial_retiro [costo_reg_inv, ]
   */
  public function inventarioInicialRetiros($dateBegin, $dateEnd)
  {

    $retiros = $this->load(['retiros' => function ($query) use ($dateBegin, $dateEnd) {
      $query
        ->whereBetween('fecha_inv_retiros', [$dateBegin, $dateEnd])
        ->selectRaw('costo_a * cant_inv_retiros as costo_cantidad, *');
    }])->retiros;

    //$acum_irm += $filas4["cant_inv_retiros"] * $filas4["costo_a"];
    //mostrar retiros monto $accion == "mirm")
    $montoActual = $retiros
      ->sum('costo_cantidad');

    //mostrar retiros cantidad ($accion == "mirc")
    $cantidadRetiros = $retiros
      ->sum('cant_inv_retiros');

    $this->attributes['inventario_inicial_retiro_cantidadRetiros'] = round($cantidadRetiros, 2);
    $this->attributes['inventario_inicial_retiro_montoActual'] = round($montoActual, 2);
  }

  /**
   * atributo inventario_inicial_compra []
   */
  public function inventarioInicialCompras($dateBegin, $dateEnd)
  {

    $compras = $this->load(['compras' => function ($query) use ($dateBegin, $dateEnd) {
      $query
        ->selectRaw('costo * cantidad as costo_cantidad, *')
        ->withExists(['factCompra' => function ($query) use ($dateBegin, $dateEnd) {
          $query->where('tipo_fact_compra', 'F')
            ->whereBetween('fecha_fact_compra', [$dateBegin, $dateEnd]);
        }]);
    }])->compras;

    //$acum_cm += $filas["cantidad"] * $filas["costo"]; //este costo es unitario se pide el monto total
    //mostrar compra cantidad "mcc"
    $montoActual = $compras->where('fact_compra_exists', true)
      ->sum('costo_cantidad');

    //mostrar compras monto (o costo) "mcm"
    $cantidadCompras = $compras->where('fact_compra_exists', true)
      ->sum('cantidad');

    $this->attributes['inventario_inicial_compra_cantidadCompras'] = round($cantidadCompras, 2);
    $this->attributes['inventario_inicial_compra_montoActual'] = round($montoActual, 2);
  }


  /**
   * atributo inventario_inicial_venta []
   */
  public function inventarioInicialVentas($dateBegin, $dateEnd)
  {
    $ventas = $this->load(['ventas' => function ($query) use ($dateBegin, $dateEnd) {
      $query->selectRaw('costo * cantidad as costo_cantidad, *')
        ->withExists(['factVenta' => function ($query) use ($dateBegin, $dateEnd) {
          $query->where('tipo_fact_venta', 'F')
            ->whereBetween('fecha_fact_venta', [$dateBegin, $dateEnd]);
        }]);
    }])->ventas;

    $montoActual = $ventas->where('fact_venta_exists', true)
      ->sum('costo_cantidad');

    //mostrar Ventas monto (o costo) "mcm"
    $cantidadVentas = $ventas->where('fact_venta_exists', true)
      ->sum('cantidad');

    $this->attributes['inventario_inicial_venta_cantidadVentas'] = round($cantidadVentas, 2);
    $this->attributes['inventario_inicial_venta_montoActual'] = round($montoActual, 2);
  }

  /**
   * DEVOLUCIONES			NC-DEVO		mcdc
   * atributo inventario_inicial_compra_devo []
   */
  public function inventarioInicialComprasDevo($dateBegin, $dateEnd)
  {
    $compras = $this->load(['compras' => function ($query) use ($dateBegin, $dateEnd) {
      $query
        ->selectRaw('costo * cantidad as costo_cantidad, *')
        ->withExists(['factCompra' => function ($query) use ($dateBegin, $dateEnd) {
          $query->where('tipo_fact_compra', 'NC-DEVO')
            ->whereBetween('fecha_fact_compra', [$dateBegin, $dateEnd]);
        }]);
    }])->compras;

    //mostrar compras devoluciones cantidad
    $montoActual = $compras->where('fact_compra_exists', true)
      ->sum('costo_cantidad');

    //mostrar compras devoluciones monto
    $cantidadCompras = $compras->where('fact_compra_exists', true)
      ->sum('cantidad');

    $this->attributes['inventario_inicial_compra_devo_cantidadCompras'] = round($cantidadCompras, 2);
    $this->attributes['inventario_inicial_compra_devo_montoActual'] = round($montoActual, 2);
  }

  //scopes

  //methods

  /**
   * el COSTO AL QUE FUE COMPRADA de reg_inventario
   * la CANTIDAD QUE COMPRE de compas
   * acumular costos * cantidades para promediar
   */
  public function calculatePrecioProm($costoCompra, $cantidadCompra)
  {
    $montoCompra = $costoCompra * $cantidadCompra;
    $registros = RegInventario::query()
      ->where([
        ['fk_inventario', $this->id],
        ['tipo', 'compra']
      ])
      ->selectRaw('costo_reg_inv * cantidad_reg_inv as costo_cantidad')
      ->get();

    $montoActual = collect($registros)
      ->sum('costo_cantidad');

    $montoActual += $montoCompra;
    $totCant = $this->stock + $cantidadCompra;

    return $montoActual / $totCant;
  }

  /**
   * ACTUALIZACION inventario DE cantidad
   * para la cantidad actual resultado de la compra
   * SI ES ND SUMO al inventario
   * SI ES NC RESTO al inventario
   */
  public function calculateCantidad($tipoFactCompra, $inventarioStock, $cantidadCompra, $type)
  {
    $stockCantidad = 0;

    if ($type == 'compra') {
      //SUMO NORMAL parap tipo_fact_compra == "ND"
      $stockCantidad = $inventarioStock + $cantidadCompra;

      //RESTO
      if ($tipoFactCompra == "NC-DEVO") {
        $stockCantidad = $inventarioStock - $cantidadCompra;
      } elseif ($tipoFactCompra == "NC-DESC" || $tipoFactCompra == "ND") {
        $stockCantidad = $inventarioStock;
        //NO RESTO
      }
    } elseif ($type == 'venta') {
      $stockCantidad = $inventarioStock - $cantidadCompra;

      if ($tipoFactCompra == "NC-DEVO") {
        $stockCantidad = $inventarioStock + $cantidadCompra;
      } elseif ($tipoFactCompra == "NC-DESC" || $tipoFactCompra == "ND") {
        $stockCantidad = $inventarioStock;
      }
    }

    return $stockCantidad;
  }
}
