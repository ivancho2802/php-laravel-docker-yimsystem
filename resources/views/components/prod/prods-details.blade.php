@if(isset($type) && $type=="pdf")
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endif

@if(isset($css))
{!! $css !!}
@endif

<div class="row">
  <div class="col-12">
    <div class="card mb-4 mx-4">
      <div class="card-header pb-0">
        <div class="d-flex flex-row justify-content-between">
          <div>
            <h5 class="mb-0">Movimiento de Unidades [{{ isset($dateFrom) }} - {{ isset($dateTo) }}] </h5>
            <h5 class="mb-0">Limite existente [{{ $dateBegin }} - {{ $dateEnd }}] </h5>
          </div>
        </div>

        <div class="d-flex flex-row justify-content-between">
          <div class="row">
            <div class="col">

              <div>{{ $empre->titular_rif_empre }} - {{ $empre->nom_empre }}</div>
              <div>N.I.T./R.I.F.:{{ $empre->rif_empre }}</div>
              <div>Direcci&oacute;n: &nbsp;{{ $empre->dir_empre }}</div>
              <div>Contribuyente {{ $empre->contri_empre }}</div>
              <div>Telefono {{ $empre->tel_empre }}</div>
              <div>Clasificaci&oacute;n: .... &amp; Activo: Todos</div>
              <div>
                Fecha Desde: {{ date('j F, Y', strtotime(isset($dateFrom))) }} &amp; Fecha Hasta: {{ date('j F, Y', strtotime(isset($dateTo))) }}
              </div>
              <div>MOVIMIENTO DE UNIDADES </div>
              <div><i>Seg&uacute;n el art&iacute;culo N&deg; 177 Ley de Impuesto Sobre la Renta</i></div>
            </div>
          </div>
        </div>

        <div class="d-flex flex-row justify-content-between">
          <div class="row">
            <div class="col">
              <h5 class="mb-0">Detalles del Producto</h5>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div>Codigo de Producto:</div>
              <div>Nombre de Producto:</div>
              <div>Descripcion: </div>
              <div>Stock ó Existencia</div>
              <div>Valor Unitario</div>
              <div>Precio de Venta</div>
              <div>Fecha de Inventario Inicial:</div>
            </div>

            <div class="col-12">
              <div>{{ $prod->codigo }}</div>
              <div>{{ $prod->nombre_i }}</div>
              <div>{{ $prod->descripcion }}</div>
              <div>{{ $prod->stock }}</div>
              <div>{{ $prod->valor_unitario }}</div>
              <div>{{ $prod->pmpvj_actual }}</div>
              <div>{{ $prod->fecha }}</div>
            </div>
          </div>
        </div>

      </div>

      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">

          <div class="row">
            <div class="col">
              <h5 class="mb-0">Movimientos de la Unidad</h5>
            </div>
          </div>

          <table class="table table-bordered align-items-center mb-0">

            <thead>

              <tr class="titulo">
                <th>ID</th>
                <th>Fecha de Registro Inventario</th>
                <th>Fecha Registro</th>
                <th>hora Registro</th>
                <th>Costo de Registro Inventario</th>
                <th>Cantidad de Registro Inventario</th>
                <th>Precio Venta</th>
                <th>Tipo</th>
                <th>Referencia de Documento</th>
                <th>Total de Operacion</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($operations as $operation)
              <tr>
                <td> {{ $operation->id }} </td>
                <td> {{ $operation->fecha_reg_inv }}</td>
                <td> {{ $operation->fecha_registro }} </td>
                <td> {{ $operation->hora_registro }} </td>
                <td> {{ $operation->costo_reg_inv }} </td>
                <td> {{ $operation->cantidad_reg_inv }} </td>
                <td> {{ $operation->pmpvj }} </td>
                <td class="text-light {{ $operation->tipo == 'compra' ? 'bg-success' : 'bg-danger'}}"> {{ $operation->tipo }} </td>
                <td> {{ $operation->fk_fact_cv ? $operation->fk_fact_cv : $operation->fk_fact_venta }} </td>
                <td> {{ $operation->cantidad_reg_inv * $operation->pmpvj }} </td>

              </tr>
              @endforeach
              <th>
                <td colspan="5">Totales</td>
                <td>{{ $inventarioInicialAcum['cantidad_reg_inv_tot'] }} </td>
                <td>{{ $inventarioInicialAcum['pmpvj_tot'] }} </td>
              </th>
              <tr>
                <td colspan="8"><i>Total de operaciones</i></td>
                <td><i>
                    {{ $inventarioInicialAcum['cantidad_reg_inv_tot'] * $inventarioInicialAcum['pmpvj_tot'] }}
                  </i></td>

              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>