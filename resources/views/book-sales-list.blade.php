@extends('layouts.user_type.auth')

@section('content')

<div>

  @if(session('success'))
  <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
    <span class="alert-text text-white">
      {{ session('success') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      <i class="fa fa-close" aria-hidden="true"></i>
    </button>
  </div>
  @endif

  @if(session('destroy'))
  <div class="m-3  alert alert-danger alert-dismissible fade show" id="alert-danger" role="alert">
    <span class="alert-text text-white">
      {{ session('destroy') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      <i class="fa fa-close" aria-hidden="true"></i>
    </button>
  </div>
  @endif


  @if(session('update'))
  <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
    <span class="alert-text text-white">
      {{ session('update') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      <i class="fa fa-close" aria-hidden="true"></i>
    </button>
  </div>
  @endif

  @if(session('warning'))
  <div class="m-3  alert alert-warning alert-dismissible fade show" id="alert-warning" role="alert">
    <span class="alert-text text-white">
      {{ session('warning') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      <i class="fa fa-close" aria-hidden="true"></i>
    </button>
  </div>
  @endif

  <div class="alert alert-secondary mx-4" role="alert">
    <span class="text-white">
      <strong>Agrega, Edita, Elimina caracteristicas</strong>
    </span>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card mb-4 mx-4">
        <div class="card-header pb-0">
          <div class="d-flex flex-row justify-content-between">
            <div>
              <h5 class="mb-0">Todas las Ventas [{{ $date_from }} - {{ $date_to }}] </h5>
            </div>
            <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button">
              +&nbsp; Agregar Venta
            </a>
          </div>

          <div class="d-flex flex-row justify-content-between">
            <div class="row">
              <div class="col">

                <div>{{ $empre->titular_rif_empre }} - {{ $empre->nom_empre }}</div>
                <div>{{ $empre->rif_empre }}</div>
                <div>Direcci&oacute;n: &nbsp;{{ $empre->dir_empre }}</div>
                <div>Contribuyente {{ $empre->contri_empre }}</div>
                <?php //funcion para convertir la fechaa mes en letras y ano
                ?>
                <div>
                  Libro de Ventas CORRESPONDIENTE AL MES DE {{ date('F', strtotime($date_from)) }}
                </div>

              </div>
            </div>
          </div>

          <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-4">
            <button class="btn bg-gradient-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              <i class="fa fa-chevron-down" aria-hidden="true"></i>
              Busqueda
              <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </button>
            <form class="">
              @csrf
              <button class="btn bg-gradient-danger btn-sm" type="submit">
                Reiniciar
              </button>
            </form>
          </div>

          <div class="collapse" id="collapseExample">
            <div class="card mb-4">

              <form class=" card-body">
                @csrf

                <div class="form-group">
                  <div id="row1" class="row">
                    <div id="colum1" class="col-md-6 col-lg-6">
                      Numero de Factura:<br />
                      <input type="text" class="form-control" name="query[num_fact_venta]" autocomplete="off" required>
                    </div>

                    <div class="col-md-6 col-lg-6">
                      Tipo de Documento
                      <br>
                      <select class="form-control" name="query[tipo_fact_venta]" required="required">
                        <option value="">Todas</option>
                        <option value="F">Factura</option>
                        <option value="RDV">Resumen Diario de Ventas</option>
                        <option value="FNULL">Factura Anulada</option>
                        <option value="ND">Nota de Débito</option>
                        <option value="NC-DEVO">Nota de Crédito - Devoluciones</option>
                        <option value="NC-DESC">Nota de Crédito - Descuentos</option>
                        <option value="NE">Nota de Entrega</option>
                      </select>
                    </div>

                  </div><!--row-->
                  <div class="row">
                    <div class="col-md-12 col-lg-12" id="resFact">

                    </div>
                  </div>
                </div><!--form-group-->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">
                    Buscar
                  </button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="collapse" data-bs-target="#collapseExample">Cancelar</button>
                </div>
              </form>
            </div>
          </div>

          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table table-bordered align-items-center mb-0">

                <thead class="text-center">
                  <tr>
                    <th rowspan="2">ACCIONES</th>
                    <td colspan="20" rowspan="2"></td>
                    <th colspan="1" rowspan="2">EXPORTACIONES</th>
                    <th colspan="11">NACIONALES</th>
                    <td colspan="2" rowspan="2"><b></b></td>

                  </tr>
                  <tr class="titulo">
                    <th colspan="5">&nbsp;</th>
                    <th colspan="3">Contribuyente</th>
                    <th colspan="3">No Contribuyente</th>
                  </tr>
                  <tr class="titulo">
                    <!--ACCIONES-->
                    <th>
                      <div>Ver Factura</div>
                    </th>
                    <th class="content-verticalText">
                      <div class="verticalText">Nro. Operaci&oacute;n</div>
                    </th>
                    <td><b>Fecha del Documento</b></td>

                    <td><b>N&deg; R.I.F. &oacute; de Identidad</b></td>
                    <td><b>Nombre &oacute; Raz&oacute;n Social</b></td>
                    <th>
                      <div class="verticalText">Tipo de Cliente</div>
                    </th>

                    <th>
                      <div class="verticalText">Nro. de Planilla<br> de Exportaci&oacute;n</div>
                    </th>
                    <th>
                      <div class="verticalText">Nro. del Expediente<br> de Exportaci&oacute;n</div>
                    </th>
                    <th>
                      <div class="verticalText">Nro. de Declaraci&oacute;n<br> de Aduana</div>
                    </th>
                    <td><b>Fecha de Declaraci&oacute;n de Aduana</b></td>

                    <th>
                      <div class="verticalText">Serie del Documento</div>
                    </th>
                    <td><b>Nro. del Documento</b></td>
                    <td><b>Nro. de Control</b></td>
                    <td><b>Registro de Maquina Fiscal</b></td>
                    <td><b>Nro. de Reporte Z</b></td>
                    <td><b>Nro. de Nota de Debito</b></td>
                    <td><b>Nro. de Nota de Credito</b></td>
                    <th>
                      <div class="verticalText">Tipo de<br /> Transacci&oacute;n</div>
                    </th><!--tipo Venta-->

                    <th>
                      <div class="verticalText">Nro. de Comprobante <br>de Retenci&oacute;n</div>
                    </th>
                    <td><b>Fecha de Aplicaci&oacute;n de Retenci&oacute;n</b></td>

                    <td><b>Nro. de Documento <br>afectado</b></td>
                    <!--EXPORTACIONES-->
                    <th>
                      <div class="verticalText">Ventas Exportacion<br> Exentas /Exoneradas</div>
                    </th>
                    <!--nacional-->
                    <th>
                      <div class="verticalText">Total de Venta <br> Nacional incluyendo<br> el IVA</div>
                    </th>
                    <th>
                      <div class="verticalText">Ventas sin derecho <br>a credito IVA</div>
                    </th>
                    <th>
                      <div class="verticalText">Ventas Exentas</div>
                    </th>
                    <th>
                      <div class="verticalText">Ventas Exoneradas</div>
                    </th>
                    <th>
                      <div class="verticalText">Ventas no Sujetas</div>
                    </th>
                    <th>
                      <div class="verticalText">Subtotal B.I. al 12%</div>
                    </th>
                    <th>
                      <div class="verticalText">Subtotal B.I. al 8%</div>
                    </th>
                    <th>
                      <div class="verticalText">Subtotal B.I. al 27%</div>
                    </th>

                    <th>
                      <div class="verticalText">Subtotal B.I. al 12%</div>
                    </th>
                    <th>
                      <div class="verticalText">Subtotal B.I. al 8%</div>
                    </th>
                    <th>
                      <div class="verticalText">Subtotal B.I. al 27%</div>
                    </th>
                    <th>
                      <div class="verticalText">Impuesto IVA</div>
                    </th>
                    <th>
                      <div class="verticalText">IVA Retenido</div>
                    </th>

                  </tr>
                </thead>
                <tbody class="text-center">
                  @forelse ($fact_ventas as $fact_venta)
                  <tr>
                    <td class="text-center">

                      <form target="_blank" id="form2" name="form2" action="/book-fact-sales-print-report" method="POST">
                        @csrf
                        <input name="id_fact_venta" type="hidden" value="{{$fact_venta->id}}" />

                        <div class="btn-group">
                          <button class="btn btn-danger" type="submit" name="type" value="pdf">
                            <i class="fa fa-file-pdf-o fa-lg text-light" title="PDF" description="PDF"></i>
                          </button>

                          <button value="{{$fact_venta->id}}" type="button" class="btn btn-success" name="nfact_afectada" id="nfact_afectada" onclick="mConsulFact($(this).val())">
                            <i class="fas fa-list-ul ps-2 pe-2 text-center text-dark text-white " title="Detalles Fact." description="Detalles Fact."></i>
                          </button>

                        </div>
                      </form>
                    </td>
                    <!--Numero de Operqciones-->
                    <td>{{$fact_venta->id}}</td>
                    <!--FACTURA-->
                    <td>
                      {{ date('j F, Y', strtotime($fact_venta->fecha_fact_venta)) }}
                    </td>
                    <!--cliente-->
                    <td>{{$fact_venta->cliente->ced_cliente}}</td>
                    <td>{{$fact_venta->cliente->nom_cliente}}</td>
                    <!--TIPO DE cliente-->
                    <td>
                      {{ \App\Http\Controllers\BookSalesController::condRif($fact_venta->cliente->ced_cliente)}}
                    </td>
                    <!--FACTURA EXPORTACIPONES-->
                    <td>{{$fact_venta->nplanilla_export}}</td>
                    <td>{{$fact_venta->nexpe_export}}</td>
                    <td>{{$fact_venta->naduana_export}}</td>
                    <td>{{ date('j F, Y', strtotime($fact_venta->fechaduana_export)) }}</td>
                    <!--FACTURA-->
                    <td>{{$fact_venta->serie_fact_venta}}</td>
                    <td>{{$fact_venta->num_fact_venta}}</td>
                    <td>{{$fact_venta->num_ctrl_factventa}}</td>
                    <!--registro z-->
                    <td>{{$fact_venta->reg_maq_fis}}</td>
                    <td>{{$fact_venta->num_repo_z}}</td>
                    <!--FACTURA NOTA-->
                    <td class="conter_table_nadatd">
                      <table class="table_nada">
                        @foreach ($fact_venta->notascdventas as $notascdventa)
                        @if ($notascdventa->tipo_notas_cd_venta == 'NC')
                        <tr>
                          <td>{{ $notascdventa->num_notas_cd_venta }}</td>
                        </tr>
                        @endif
                        @endforeach
                      </table>
                    </td>
                    <td>
                      <table class="table_nada">
                        @foreach ($fact_venta->notascdventas as $notascdventa)
                        @if ($notascdventa->tipo_notas_cd_venta == 'ND')
                        <tr>
                          <td>{{ $notascdventa->num_notas_cd_venta }}</td>
                        </tr>
                        @endif
                        @endforeach
                      </table>
                    </td>
                    <!---->
                    <td> {{$fact_venta->tipo_trans}} </td>
                    <!--FACTURA RETENCION-->
                    <td>
                      {{ $fact_venta->num_compro_reten ?? '-' }}
                      {{ $fact_venta->num_compro_reten }}
                    </td>
                    <td>{{ date('j F, Y', strtotime($fact_venta->fecha_compro_reten)) }}</td>
                    <!--NOTAS DEBEITO CREDITO-->
                    <td>{{ $fact_venta->nfact_afectada }}</td>
                    <!--FACTURA TOTALES Exportacion-->
                    <td>{{ number_format((float)$fact_venta->msubt_exento_venta_export, 2)}}</td>
                    <!--FACTURA TOTALES nacional-->
                    <td>{{ number_format((float)$fact_venta->mtot_iva_venta_n, 2)}}</td>

                    <td>{{ number_format((float)$fact_venta->without_iva['SDCF'], 2)}}</td>
                    <td>{{ number_format((float)$fact_venta->without_iva['EX'], 2)}}</td>
                    <td>{{ number_format((float)$fact_venta->without_iva['EXO'], 2)}}</td>
                    <td>{{ number_format((float)$fact_venta->without_iva['NS'], 2)}}</td>

                    <td>
                      @if (isset($fact_venta->tipo_contri) !== "NO_CONTRI")
                      {{ number_format((float)$fact_venta->msubt_bi_iva_12, 2)}}
                      @else
                      0
                      @endif
                    </td>
                    <td>
                      @if (isset($fact_venta->tipo_contri) !== "NO_CONTRI")
                      {{ number_format((float)$fact_venta->msubt_bi_iva_8, 2)}}
                      @else
                      0
                      @endif
                    </td>
                    <td>
                      @if (isset($fact_venta->tipo_contri) !== "NO_CONTRI")
                      {{ number_format((float)$fact_venta->msubt_bi_iva_27, 2)}}
                      @else
                      0
                      @endif
                    </td>
                    <td>
                      @if (isset($fact_venta->tipo_contri) == "NO_CONTRI")
                      {{ number_format((float)$fact_venta->msubt_bi_iva_12, 2)}}
                      @else
                      0
                      @endif
                    </td>
                    <td>
                      @if (isset($fact_venta->tipo_contri) == "NO_CONTRI")
                      {{ number_format((float)$fact_venta->msubt_bi_iva_8, 2)}}
                      @else
                      0
                      @endif
                    </td>
                    <td>
                      @if (isset($fact_venta->tipo_contri) == "NO_CONTRI")
                      {{ number_format((float)$fact_venta->msubt_bi_iva_27, 2)}}
                      @else
                      0
                      @endif
                    </td>

                    <!--monto total de impuesto IVA-->
                    <td>{{ number_format((float)$fact_venta['tot_iva'], 2)}}</td>
                    <!--FACTURA TOTALES DE RETENCIONES-->
                    <td>{{ number_format((float)$fact_venta['m_iva_reten'], 2)}}</td>

                    <td width="32">
                      <?php
                      /*
                        $id = $filas['id_fact_venta'];
                        echo "<a href='modificarVenta.php?id=$id' target='principal'>Actualizar</a>";
                        */
                      ?>
                    </td>
                    <td width="34">
                      <?php
                      /*
                        echo "<a onclick='confirmDel();' href='borrarVenta.php?id=$id' target='principal'>  
                        Eliminar</a>";
                        */
                      ?>
                    </td>
                    <td width="34">
                      <?php
                      /*
                        echo "<a href='hacerDevolucion.php?id=$id' target='principal'>  
                        Devolver</a>";
                        */
                      ?>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td class="text-center " colspan="9">Lo sentimos pero no hay resultados</td>
                  </tr>
                  @endforelse
                  <tr>
                    <td colspan="20">Totales</td>
                    <!-- IMPORTACIONES -->
                    <!-- TOTAL DE IMPORTACIONEES INCLUYENDO EL IVA-->
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_msubt_exento_venta_export'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_msubt_exento_venta_export'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_mtot_iva_venta_n'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_IN_SDCF_venta_n'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_IN_EX_venta_n'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_IN_EXO_venta_n'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_IN_NS_venta_n'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_msubt_bi_iva_12_n_NO_CONTRI'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_msubt_bi_iva_8_n_NO_CONTRI'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_msubt_bi_iva_27_n_NO_CONTRI'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_msubt_bi_iva_12_n_CONTRI'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_msubt_bi_iva_8_n_CONTRI'], 2)}}
                      </span>
                    </td>

                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_msubt_bi_iva_27_n_CONTRI'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_tot_iva'], 2)}}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="text-secondary text-xs font-weight-bold">
                        {{ number_format((float)$fact_ventas_acum['acum_m_iva_reten'], 2)}}
                      </span>
                    </td>

                  </tr>
                </tbody>
              </table>

              {{$fact_ventas->links() }}

              <!--RESUMEN DE LA venta-->
              <table class="table table-bordered table-hover">
                <thead class="text-center">
                  <tr class="titulo">
                    <td colspan="5">RESUMEN DE VENTAS DEl MES DE {{ date('F', strtotime($date_from)) }}</td>
                  </tr>
                  <tr class="titulo">
                    <td rowspan="2">Descripci&oacute;n</td>
                    <td colspan="2">Base Imponible</td>
                    <td colspan="2">Debito Fiscal</td>
                  </tr>
                  <tr>
                    <td>Item</td>
                    <td>Monto</td>
                    <td>Item</td>
                    <td>Monto</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Ventas Internas No Gravadas</td>
                    <td>40</td>
                    <td>{{ number_format((float)$fact_ventas_acum['acum_msubt_exento_venta'], 2)}} </td>
                    <td>-</td>
                    <td>-</td>
                  </tr>
                  <tr>
                    <td>Ventas de Exportaci&oacute;n</td>
                    <td>41</td>
                    <td>{{ number_format((float)$fact_ventas_acum['acum_msubt_exento_venta_export'], 2)}} </td>
                    <td>-</td>
                    <td>-</td>
                  </tr>
                  <tr>
                    <td>Ventas Internas o Nacionales Gravadas por Alicuota General 12%</td>
                    <td>42</td>
                    <td>{{ number_format((float)$fact_ventas_acum['acum_msubt_bi_iva_12_n'], 2)}} </td>
                    <td>43</td>
                    <td>{{ number_format((float)$fact_ventas_acum['acum_msubt_bi_iva_12_n']* 0.12, 2)}} </td>
                  </tr>
                  <tr>
                    <td>Ventas Internas o Nacionales Gravadas por Alicuota General mas Alicuota Adicional 27%</td>
                    <td>442</td>
                    <td>{{ number_format((float)$fact_ventas_acum['acum_msubt_bi_iva_27_n'], 2)}} </td>
                    </td>
                    <td>452</td>
                    <td>{{ number_format((float)$fact_ventas_acum['acum_msubt_bi_iva_27_n']* 0.27, 2)}} </td>
                  </tr>
                  <tr>
                    <td>Ventas Internas o Nacionales Gravadas por Alicuota Reducida 8%</td>
                    <td>333</td>
                    <td>{{ number_format((float)$fact_ventas_acum['acum_msubt_bi_iva_8_n'], 2)}} </td>
                    </td>
                    <td>343</td>
                    <td>{{ number_format((float)$fact_ventas_acum['acum_msubt_bi_iva_8_n']* 0.08, 2)}} </td>
                  </tr>
                  <tr>
                    <td><b>Total Ventas y Debitos Fiscales para Efectos de Determinacion:</b></td>
                    <td>46</td>
                    <td>
                      {{ number_format(
                        (float)
                        $fact_ventas_acum['acum_msubt_exento_venta'] +
                        $fact_ventas_acum['acum_msubt_bi_iva_12_n'] +
                        $fact_ventas_acum['acum_msubt_bi_iva_27_n'] +
                        $fact_ventas_acum['acum_msubt_bi_iva_8_n']
                      , 2)
                    }}
                    <td>47</td>
                    <td>
                      {{ number_format(
                          (float)
                          ($fact_ventas_acum['acum_msubt_bi_iva_12_n']* 0.12)+
                          ($fact_ventas_acum['acum_msubt_bi_iva_27_n']* 0.27)+
                          ($fact_ventas_acum['acum_msubt_bi_iva_8_n']* 0.08)
                        , 2)
                      }}
                    </td>
                  </tr>
                </tbody>
              </table>

              <div>
                <br />
                <br /><br />
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td width="70px" class="titulo"><b style="text-align:center">
                          I.V.A. Retenido por el Comprador
                        </b></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ number_format((float)$fact_ventas_acum['acum_m_iva_reten'], 2)}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!--responsive-->
              <div class="row">
                <div class="col-xs-12 col-lg-12">

                  <form target="_blank" id="form1" name="form1" action="/book-sales-print-report" method="POST">
                    @csrf

                    <div class="input-group">
                      <button class="btn btn-danger  col-6" type="submit" name="type" value="pdf">
                        <i class="fa fa-file-pdf-o fa-lg text-light" title="PDF" description="PDF"></i>
                      </button>
                      <input type="hidden" name="date_from" value="{{$date_from}}" />
                      <input type="hidden" name="date_to" value="{{$date_from}}" />
                      <button class="btn btn-success  col-6" type="submit" name="type" value="excel">
                        <span class="fa fa-file-excel-o text-light" title="EXCEL"></span>
                      </button>

                    </div>
                  </form>

                </div><!--col-->
              </div><!--row-->

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    hoverScrool('btn-res_libroVenta');
  });
  
  /** ver los detalle de una factura de venta */
  function mConsulFact(factVenta) {

    $.ajax({
      type: 'GET',
      url: '/book-sales-detail/' + factVenta,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        document.getElementById("zoneModalExtra").innerHTML = data;
        $('#mostrarFact').modal('show');

      },
      beforeSend: function() {
        $('#nfact_afectada').prop('disabled', true)
      },
      complete: function() {
        $('#nfact_afectada').prop('disabled', false)
      },

    });

  }
</script>

<!-- modales -->
<div id="zoneModalExtra"></div>

@include('modales.fact_v.m_b_fact_v')

@endsection