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

      </div>

      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table table-bordered align-items-center mb-0">

            <thead>
              <tr class="titulo">
                <!--ACCIONES-->
                <th rowspan="2">
                  <div class="verticalText">Acciones</div>
                </th>
                <td colspan="2"></td>
                <td colspan="3" class="titulo">Existencia Inicial</td>
                <td colspan="2" class="titulo">Entradas</td>
                <td colspan="2" class="titulo">Salidas</td>
                <td colspan="2" class="titulo">Autoconsumos</td>
                <td colspan="2" class="titulo">Devoluciones</td>
                <td colspan="2" class="titulo">Retiros</td>
                <td colspan="2" class="titulo">Existencia Actual</td>
              </tr>

              <tr class="titulo">
                <th>Codigo</th>
                <th>Nombre &oacute; Descripci&oacute;n</th>

                <th>Costo Unitario</th>
                <th>Cantidad</th>
                <th>Monto</th>
                <!--ETRADAS-->
                <th>Cantidad</th>
                <th>Monto</th>
                <!--SALIDAS-->
                <th>Cantidad</th>
                <th>Monto</th>
                <!--AUTOCUNSUMOS-->
                <th>Cantidad</th>
                <th>Monto</th>
                <!--DEVOLUCIONES-->
                <th>Cantidad</th>
                <th>Monto</th>
                <!--RETIROS-->
                <th>Cantidad</th>
                <th>Monto</th>
                <!--INVENTARIUO ACTUAL-->
                <th>Cantidad</th>
                <th>Monto</th>

              </tr>
            </thead>
            <tbody>
              @foreach ($inventarios as $inventario)
              <tr>
                <td class="text-center">

                  <form target="_blank" id="formreport" name="formreport" action="/inventario-report" method="POST">
                    @csrf

                    <input name="id" type="hidden" value="{{$inventario->id}}" />
                    <label class="m-0" data-bs-toggle="tooltip" data-bs-placement="top">
                      <button class="btn btn-danger" type="submit">
                        <i class="fa fa-file-pdf-o fa-lg" title="PDF" description="PDF"></i>
                      </button>
                      detalles
                    </label>
                  </form>

                </td>

                <td> {{$inventario->codigo}} </td>
                <td> {{$inventario->nombre_i}}</td>
                <!--EXISTENCIA INICIAL-->
                <!-- miicu inventario inicial costo unitario costo_reg_inv -->
                <!--  c_cv_inventario($inv_cod, $fechai, $fechaf, "miicu") -->
                <td> {{ $inventario->inventario_inicial_registro_costo_reg_inv }} </td>
                <!-- c_cv_inventario($inv_cod, $fechai, $fechaf, "miic") -->
                <td> {{ $inventario->inventario_inicial_registro_cantidad_reg_inv }} </td>
                <!-- c_cv_inventario($inv_cod, $fechai, $fechaf, "miim") -->
                <td> {{ $inventario->inventario_inicial_registro_monto }} </td>
                <!-- c_cv_inventario($inv_cod, $fechai, $fechaf, "mcc") -->
                <td> {{ $inventario->inventario_inicial_compra_cantidadCompras }} </td>
                <!-- c_cv_inventario($inv_cod, $fechai, $fechaf, "mcm") -->
                <td> {{ $inventario->inventario_inicial_compra_montoActual }} </td>
                <!-- c_cv_inventario($inv_cod, $fechai, $fechaf, "mvc") //mostrar ventas cantidad -->
                <td> {{ $inventario->inventario_inicial_venta_cantidadVentas }} </td>
                <!-- c_cv_inventario($inv_cod, $fechai, $fechaf, "mvm") //mostrar ventas monto -->
                <td> {{ $inventario->inventario_inicial_venta_montoActual }} </td>

                <td> 0</td>
                <td> 0</td>

                <!-- c_cv_inventario($inv_cod, $fechai, $fechaf, "mcdc") //mostrar compras devoluciones cantidad-->
                <td> {{ $inventario->inventario_inicial_compra_devo_cantidadCompras }} </td>
                <!-- c_cv_inventario($inv_cod, $fechai, $fechaf, "mcdm") //mostrar compras devoluciones monto-->
                <td> {{ $inventario->inventario_inicial_compra_devo_montoActual }} </td>
                <!-- c_cv_inventario($inv_cod, $fechai, $fechaf, "mirc") mostrar retiros cantidad-->
                <td> {{ $inventario->inventario_inicial_retiro_cantidadRetiros }} </td>
                <!-- c_cv_inventario($inv_cod, $fechai, $fechaf, "mirm") mostrar retiros monto-->
                <td> {{ $inventario->inventario_inicial_retiro_montoActual }} </td>
                <!-- c_cv_inventario($inv_cod, $fechai, $fechaf, "mifc") -->
                <td> {{ $inventario->inventario_final_registro_cantidad_reg_inv }} </td>
                <!-- c_cv_inventario($inv_cod, $fechai, $fechaf, "mifm") -->
                <td> {{ $inventario->inventario_final_registro_monto }} </td>

              </tr>
              @endforeach
              <tr>
                <td colspan="3">Totales</td>
                <!-- $acum_miicu; -->
                <td><b>{{ $inventarioInicialAcum['inventario_inicial_registro_costo_reg_inv'] }} </b></td>
                <!-- $acum_miic -->
                <td><b>{{ $inventarioInicialAcum['inventario_inicial_registro_cantidad_reg_inv'] }} </b></td>
                <!-- $acum_miim -->
                <td><b>{{ $inventarioInicialAcum['inventario_inicial_registro_monto'] }} </b></td>


                <!-- $acum_mcc -->
                <td><b>{{ $inventarioInicialAcum['inventario_inicial_compra_cantidadCompras'] }} </b></td>
                <!-- $acum_mcm; -->
                <td><b>{{ $inventarioInicialAcum['inventario_inicial_compra_montoActual'] }} </b></td>

                <!-- $acum_mvc -->
                <td><b>{{ $inventarioInicialAcum['inventario_inicial_venta_cantidadVentas'] }} </b></td>
                <!-- $acum_mvm -->
                <td><b>{{ $inventarioInicialAcum['inventario_inicial_venta_montoActual'] }} </b></td>

                <td>0</td>
                <td>0</td>
                <!-- $acum_mcdc; -->
                <td><b>{{ $inventarioInicialAcum['inventario_inicial_compra_devo_cantidadCompras'] }} </b></td>
                <!-- $acum_mcdm -->
                <td><b>{{ $inventarioInicialAcum['inventario_inicial_compra_devo_montoActual'] }} </b></td>

                <!-- $acum_mirc -->
                <td><b>{{ $inventarioInicialAcum['inventario_inicial_retiro_cantidadRetiros'] }} </b></td>
                <!-- $acum_mirm -->
                <td><b>{{ $inventarioInicialAcum['inventario_inicial_retiro_montoActual'] }} </b></td>
                <!-- $acum_mifc; -->
                <td><b>{{ $inventarioInicialAcum['inventario_final_registro_cantidad_reg_inv'] }} </b></td>
                <!--  $acum_mifm; -->
                <td><b>{{ $inventarioInicialAcum['inventario_final_registro_monto'] }} </b></td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>