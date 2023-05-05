<link rel="stylesheet" href="https://yimsystem.onrender.com/css/estilos_reportes.css" type="text/css" />
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
{{date('d/m/Y')}}
<header>
  <table style="width: 100%;">
    <tr>
      <td style="text-align: left;	width: 33%">
        Sistema {{env('APP_NAME')}} - {{env('APP_VERSION')}}
      </td>
      <td style="text-align: center;	width: 34%">Reporte de Comprobante de Retencion</td>
      <td style="text-align: right;	width: 33%">Fecha de Generaci&oacute;n<?php echo date('d/m/Y'); ?></td>
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
        <div>&nbsp;</div>
      </th>
    </tr><!--NO QUITE EL DIV ES EL QUE HACE PONER LA TABLA AL 100-->
    <tr>
      <th colspan="12" class="tabla_header">
        Direcci&oacute;n: &nbsp; {{$empre->dir_empre}}
      </th>
      <th colspan="2" class="tabla_bordes">PERIODO FISCAL</th>
    </tr>
    <tr>
      <th colspan="12" class="tabla_header">
        Telf. {{$empre->tel_empre}}
      </th>
      <th class="tabla_bordes">A&ntilde;o</th>
      <th class="tabla_bordes">Mes</th>
    </tr>
    <tr>
      <th colspan="12" class="tabla_header">
        Rif: {{$empre->rif_empre}}
      </th>
      <th colspan="2" class="tabla_bordes">
        Rif: {{$empre->mes_apli_reten}}
      </th>
    </tr>
    <!--
    <tr>
    	<th colspan="12" class="tabla_header">Contribuyente <?php //echo $filas['contri_empre'];
                                                          ?></th>
    </tr>
    <tr><th colspan="4" class="tabla_header">Comprobantes de Retencion: <?php //echo $_POST['num_compro_reten'];
                                                                        ?></th></tr>
    -->
    <tr>
      <th>&nbsp;</th>
    </tr>
    <tr>
      <th>&nbsp;</th>
    </tr>
    <tr>
      <th class="tabla_bordes">Dia</th>
      <th class="tabla_bordes">Mes</th>
      <th class="tabla_bordes">A&ntilde;o</th>
      <th>&nbsp;</th>
      <th colspan="6">COMPROBANTE DE RETENCI&Oacute;N del I.V.A.</th>
      <th colspan="2"><b>Nro. de Comprobante:</b></th>
      <th colspan="2"> {{$fact_compras[0]->num_compro_reten}} </th>
    </tr>
    <tr>
      <th class="tabla_bordes">{{ date('d', strtotime($fact_compras[0]->fecha_compro_reten)) }}</th>
      <th class="tabla_bordes">{{ date('m', strtotime($fact_compras[0]->fecha_compro_reten)) }}</th>
      <th class="tabla_bordes">{{ date('Y', strtotime($fact_compras[0]->fecha_compro_reten)) }}</th>
      <th>&nbsp;</th>
      <th colspan="10" rowspan="3">
        <p>&#40;
          Ley IVA - Art. 11: &quot; Seran responsables del pago del impuesto en calidad de agente de retenci&oacute;n los compradores<br />
          o adquirientes de determinados bienes muebles y los receptores de ciertos servicios&#44; a quienes la administraci&oacute;n<br />
          tributaria designe como tal
          &quot;&#41;</p>
      </th>
    </tr>
    <tr>
      <th>&nbsp;</th>
    </tr>
    <tr>
      <th>&nbsp;</th>
    </tr>
    <tr>
      <th>&nbsp;</th>
    </tr>
    <?php //funcion para convertir la fechaa mes en letras y ano
    ?>
    <tr>
      <td class="titulo" colspan="3"><b>Nombre &oacute; Raz&oacute;n Social:</b></td>
      <td class="titulo tabla_bordes" colspan="4">{{$fact_compras[0]->nombre}} </td>
      <td class="titulo tabla_bordes" colspan="7"></td>
    </tr>
    <tr>
      <td class="titulo" colspan="3"><b>Nro. de R.I.F. :</b></td>
      <td class="titulo tabla_bordes" colspan="4">{{$fact_compras[0]->rif}} </td>
      <td class="titulo tabla_bordes" colspan="7"></td>
    </tr>
    <tr>
      <td class="titulo" colspan="3"><b>Direcci&oacute;n Fiscal:</b></td>
      <td class="titulo tabla_bordes" colspan="4">{{$fact_compras[0]->direccion}} </td>
      <td class="titulo tabla_bordes" colspan="7"></td>
    </tr>
    <tr class="titulo">
      <td class="h"><b>Op Nro.</b></td>
      <td class="h"><b>Fecha de <br>Factura</b></td>
      <td class="h"><b>Numero de<br> Factura</b></td>
      <td class="h"><b>Numero <br>Control de<br> Factura</b></td>
      <td class="h"><b>Numero <br>Nota de <br>Credito</b></td>
      <td class="h"><b>Numero <br>Nota de <br>Debito</b></td>
      <td class="h"><b>Tipo de <br>Transacci&oacute;n</b></td>
      <td class="h"><b>Numero de <br>Factura <br>Afectada</b></td>
      <td class="h"><b>Total <br>Compras <br>Incluyendo <br>I.V.A.</b></td>
      <td class="h"><b>Compras <br>Sin <br>Derecho a <br>Credito <br>I.V.A.</b></td>
      <td class="h"><b>Base <br>Imponible</b></td>
      <td class="h"><b>&#37; Alicuotas</b></td>
      <td class="h"><b>Impuesto <br>I.V.A.</b></td>
      <td class="h"><b>Monto I.V.A. <br>Retenido</b></td>
    </tr>
  </thead>
  <tbody>

    @for ($nop=0; $nop < $fact_compras->count(); $nop++)
      <tr>
        <td><span>{{ $nop+1 }}</span></td>
        <td><span>{{ $fact_compras[$nop]->fecha_fact_compra }} </span></td>
        <td><span>{{ $fact_compras[$nop]->num_fact_compra }} </span></td>
        <td><span>{{ $fact_compras[$nop]->num_ctrl_factcompra }} </span></td>
        <td class="conter_table_nadatd">
          <table class="table_nada">
            @foreach ($fact_compras[$nop]->notascds as $notascd)
              @if($notascd->tipo_notas_cd == 'NC')
                <tr><td>
                  $notascd->num_notas_cd
                </td></tr>
              @endif
            @endforeach
          </table>
        </td>
        <td>
          <table class="table_nada">
            @foreach ($fact_compras[$nop]->notascds as $notascd)
              @if($notascd->tipo_notas_cd == 'ND')
                <tr><td>
                  $notascd->num_notas_cd
                </td></tr>
              @endif
            @endforeach
          </table>
        </td>
        <td><span>{{ $fact_compras[$nop]->tipo_trans }}</span></td>
        <td><span>{{ $fact_compras[$nop]->nfact_afectada }}</span></td>
        <td><span>
          {{ number_format((float)$fact_compras[$nop]->mtot_iva_compra, 2) }}
        </span></td>
        <td><span>
          {{ number_format((float)$fact_compras[$nop]->msubt_exento_compra, 2) }}
        </span></td>
        <td><span>
          {{ number_format((float)$fact_compras[$nop]->msubt_tot_bi_compra, 2) }}
        </span></td>
        <td><span>
          
          @if ($fact_compras[$nop]->msubt_bi_iva_12 > 0)
            12
          @elseif ($fact_compras[$nop]->msubt_bi_iva_8 > 0)
            , 8
          @elseif ($fact_compras[$nop]->msubt_bi_iva_27 > 0)
            27
          @endif

        </span></td>
        <td><span>
          {{ number_format((float)$fact_compras[$nop]->tot_iva, 2) }}
        </span></td>
        <td><span>
          {{ number_format((float)$fact_compras[$nop]->m_iva_reten, 2) }}
        </span></td>
      </tr>
    @endfor

  </tbody>
</table>

<footer>
  <table style="width: 100%;">
    <tr>
      <td style="text-align: center;	width: 35%">________________________________</td>
      <td style="text-align: center;	width: 30%">________________________________</td>
      <td style="text-align: center;	width: 35%">________________________________</td>
    </tr>
    <tr>
      <td style="text-align: center;	width: 35%">FIRMA AGENTE DE RETENCI&Oacute;N</td>
      <td style="text-align: center;	width: 30%">FIRMA BENEFICIARIO</td>
      <td style="text-align: center;	width: 35%">FECHA DE RECEPCI&Oacute;N</td>
    </tr>
    <tr>
      <td style="text-align: left;	width: 50%">
      </td>
      <td style="text-align: right;	width: 50%">page [[page_cu]]/[[page_nb]]</td>
    </tr>
  </table>
</footer>
Sistema {{env('APP_NAME')}} - {{env('APP_VERSION')}}