<style>
  .tabla_bordes {
    font-size: 12px;
    border: 1px solid;
    text-align: center;
  }

  .tabla_header {
    font-size: 12px;
    text-align: left;
  }

  b {
    font-size: 12px;
  }

  span {
    font-size: 12px;
  }
</style>
{!! $css !!}

{{date('d/m/Y')}}

<header>
  <table style="width: 100%;">
    <tr>
      <td style="text-align: left;	width: 33%">
        Sistema {{env('APP_NAME')}} - {{env('APP_VERSION')}}
      </td>
      <td style="text-align: center;	width: 34%">Reporte de Ventas</td>
      <td style="text-align: right;	width: 33%">Fecha de Generaci&oacute;n {{date('d/m/Y')}}</td>
    </tr>
  </table>
</header>

<table cellpadding="0" cellspacing="0" class="tabla1 table tabla_bordes" style="width: 100%;">
  <thead>
    <tr>
      <th colspan="14" class="tabla_header">
        <span style="font-size:18px;">
          {{$empre->titular_rif_empre}} - {{$empre->nom_empre}}
        </span>
      </th>
    </tr>
    <tr>
      <th colspan="14" class="tabla_header">
        <div>{{$empre->rif_empre}}</div>
      </th>
    </tr>
    <tr>
      <th colspan="12" class="tabla_header">
        Direcci&oacute;n: &nbsp; {{$empre->dir_empre}}
      </th>
      <th colspan="2" class="tabla_bordes">PERIODO FISCAL</th>
    </tr>
    <tr>
      <th colspan="34">
        <div>Contribuyente {{$empre->contri_empre}} </div>
      </th>
    </tr>
    <tr>
      <th colspan="34">
        <div>LIBRO DE VENTAS CORRESPONDIENTE AL MES DE {{ date('F', strtotime($date_from)) }} </div>
      </th>
    </tr>

    <tr>
      <td colspan="20" rowspan="2"><b></b></td>
      <td class="titulo" colspan="1" rowspan="2">
        <div class="subTitulo">EXPORTACIONES</div>
      </td>
      <td class="titulo" colspan="11">
        <div class="subTitulo">NACIONALES</div>
      </td>
      <td colspan="2" rowspan="2"><b></b></td>
    </tr>

    <tr>
      <td colspan="5" class="titulo">&nbsp;</td>
      <td colspan="3" class="titulo">Contribuyente</td>
      <td colspan="3" class="titulo">No Contribuyente</td>
    </tr>

    <tr class="titulo">
      <td class="cont_v">
        <div>Nro. Operaciones</div>
      </td>
      <td class="w-30">
        <div class="h">Fecha <br>del <br>Documento</div>
      </td>
      <td class="w-30">
        <div class="h">N&deg; R.I.F. &oacute;<br />Cedula de <br />Identidad</div>
      </td>
      <td class="w-30">
        <div class="h">Nombre &oacute; <br />Raz&oacute;n Social</div>
      </td>
      <td class="w-30">
        <div class="h">Tipo <br />de <br />Cliente</div>
      </td>

      <td class="cont_v">
        <div>Nro. de Planilla de Exportaci&oacute;n</div>
      </td>
      <td class="cont_v">
        <div>Nro. del Expediente de Exportaci&oacute;n</div>
      </td>
      <td class="cont_v">
        <div>Nro. de Declaraci&oacute;n de Aduana</div>
      </td>
      <td class="cont_v">
        <div>Fecha de Declaraci&oacute;n de Aduana</div>
      </td>

      <td class="cont_v">
        <div>Serie del Documento</div>
      </td>
      <td class="cont_v">
        <div>Nro. del Documento</div>
      </td>
      <td class="cont_v">
        <div>Nro. de Control</div>
      </td>
      <td class="cont_v">
        <div>Registro de Maquina Fiscal</div>
      </td>
      <td class="cont_v">
        <div>Nro. de Reporte Z</div>
      </td>
      <td class="cont_v">
        <div>Nro. de Nota de Debito</div>
      </td>
      <td class="cont_v">
        <div>Nro. de Nota de Credito</div>
      </td>
      <td class="cont_v">
        <div>Tipo de Transacci&oacute;n</div>
      </td><!--tipo Venta-->

      <td class="cont_v">
        <div>Nro. de Documento afectado</div>
      </td>

      <td class="cont_v">
        <div>Nro. de  Comprob  de  Retenci&oacute;n</div>
      </td>
      <td class="cont_v">
        <div>Fecha de  Aplicaci&oacute;n  de  Retenci&oacute;n</div>
      </td>

      <!--EXPORTACIONES-->
      <td class="cont_v">
        <div>Ventas Exportacion Exentas /Exoneradas</div>
      </td>
      <!--nacional-->
      <td class="cont_v">
        <div>Total de Venta Nacional incluyendo el IVA</div>
      </td>
      <td class="cont_v">
        <div>Ventas sin derecho a credito IVA</div>
      </td>
      <td class="cont_v">
        <div>Ventas Exentas</div>
      </td>
      <td class="cont_v">
        <div>Ventas Exoneradas</div>
      </td>
      <td class="cont_v">
        <div>Ventas no Sujetas</div>
      </td>
      <td class="cont_v">
        <div>Subtotal B.I. al 12%</div>
      </td>
      <td class="cont_v">
        <div>Subtotal B.I. al 8%</div>
      </td>
      <td class="cont_v">
        <div>Subtotal B.I. al 27%</div>
      </td>

      <td class="cont_v">
        <div>Subtotal B.I. al 12%</div>
      </td>
      <td class="cont_v">
        <div>Subtotal B.I. al 8%</div>
      </td>
      <td class="cont_v">
        <div>Subtotal B.I. al 27%</div>
      </td>
      <td class="cont_v">
        <div>Impuesto I.V.A.</div>
      </td>
      <td class="cont_v">
        <div>I.V.A. Retenido</div>
      </td>
      <!--ACCIONES-->
    </tr>

  </thead>

  <tbody>

    @foreach ($fact_ventas as $fact_venta)
    <tr>
      <!--Numero de Operqciones-->
      <td>{{$fact_venta->id}}</td>
      <!--FACTURA-->
      <td>
        {{ date('j F, Y', strtotime($fact_venta->fecha_fact_venta)) }}
      </td>
      <!--cliente-->
      <td>{{$fact_venta->clientes->ced_cliente}}</td>
      <td>{{$fact_venta->clientes->nom_cliente}}</td>
      <!--TIPO DE cliente-->
      <td>
        {{ \App\Http\Controllers\BookSalesController::condRif($fact_venta->clientes->ced_cliente)}}
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
      <!---->
      <td> {{$fact_venta->tipo_trans}} </td>
      <td>
        {{ $fact_venta->nfact_afectada ?? '-' }}
      </td>
      <!--FACTURA RETENCION-->
      <td>
        {{ $fact_venta->num_compro_reten ?? '-' }}
      </td>
      <td>{{ date('j F, Y', strtotime($fact_venta->fecha_compro_reten)) }}</td>
      <!--FACTURA TOTALES Exportacion-->
      <td>
        @if (isset($fact_venta->nplanilla_export))
        {{ number_format((float)$fact_venta->mtot_iva_venta, 2)}}
        @else
        0
        @endif
      </td>
      <!--FACTURA TOTALES nacional-->
      <td>
        @if (isset($fact_venta->nplanilla_export))
        0
        @else
        {{ number_format((float)$fact_venta->mtot_iva_venta, 2)}}
        @endif
      </td>

      <td class="text-center">
        <span class="text-secondary text-xs font-weight-bold">
          {{ $fact_venta->without_iva['SDCF'] }}
        </span>
      </td>
      <td class="text-center">
        <span class="text-secondary text-xs font-weight-bold">
          {{ $fact_venta->without_iva['EX'] }}
        </span>
      </td>
      <td class="text-center">
        <span class="text-secondary text-xs font-weight-bold">
          {{ $fact_venta->without_iva['EXO'] }}
        </span>
      </td>
      <td class="text-center">
        <span class="text-secondary text-xs font-weight-bold">
          {{ $fact_venta->without_iva['NS'] }}
        </span>
      </td>

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

    </tr>

    @endforeach


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


<!--RESUMEN DE LA VENTA-->
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

<footer>
  <table style="width: 100%;">
    <tr>
      <td style="text-align: left;	width: 50%">
      </td>
      <td style="text-align: right;	width: 50%">page [[page_cu]]/[[page_nb]]</td>
    </tr>
  </table>
</footer>
Sistema {{env('APP_NAME')}} - {{env('APP_VERSION')}}