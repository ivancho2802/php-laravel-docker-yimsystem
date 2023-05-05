<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
{!! $css !!}
<header>
  <table style="width: 100%;">
    <tr>
      <td style="text-align: left;	width: 33%">
        Sistema {{env('APP_NAME')}} - {{env('APP_VERSION')}}
      </td>
      <td style="text-align: center;	width: 34%">Factura de Ventas</td>
      <td style="text-align: right;	width: 33%">Fecha de Generaci&oacute;n {{date('d/m/Y')}}</td>
    </tr>
  </table>
</header>
<table cellpadding="0" cellspacing="0" style=" width:100%">
  <tr>
    <td style=" width:100%" colspan="8">

    </td>
  </tr>
  <tr>
    <td colspan="6"></td>
    <th>Factura N&deg;: </th>
    <td>{{$fact_venta->num_fact_venta}} </td>
  </tr>
  <tr>
    <td colspan="6"></td>
    <th>N&deg; Control:</th>
    <td>{{$fact_venta->num_ctrl_factventa}} </td>
  </tr>
  <tr>
    <td colspan="6"></td>
    <th>Emision: </th>
    <td>{{ date('j F, Y', strtotime($fact_venta->fecha_fact_venta)) }} </td>
  </tr>
  <tr>
    <td colspan="6"></td>
    <th>Vencimiento: </th>
    <td>
      {{ $fact_venta->fecha_fact_venta_expired }}
      <?php
      /* $fecha_venc = new DateTime($filas['fecha_fact_venta']);
      $fecha_venc->add(new DateInterval('P' . $filas['dias_venc'] . 'D'));
      echo $fecha_venc->format('d-m-Y'); */
      ?>
    </td>
  </tr>
  <tr>
    <td><br /><br /><br /></td>
  </tr>
  <tr>
    <th>Nombre del Cliente: </th>
    <td>{{$fact_venta->cliente->nom_cliente}} </td>
  </tr>
  <tr>
    <th>R.I.F.: </th>
    <td>{{$fact_venta->cliente->ced_cliente}} </td>
  </tr>
  <tr>
    <th>Telefono: </th>
    <td>{{$fact_venta->cliente->tel_cliente}} </td>
  </tr>
  <tr>
    <th>C / Pago: </th>
    <td>
      @if ($fact_venta->tipo_pago == "C")
      REDITO A {{$fact_venta->dias_venc}} Dias
      @elseif ($fact_venta->tipo_pago == "E")
      EFECTIVO
      @endif
    </td>
  </tr>
  <tr>
    <th>Direcci&oacute;n: </th>
    <td>{{$fact_venta->cliente->dir_cliente}} </td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
    <th>Nombre del Vendedor:</th>
    <td>{{$fact_venta->user->usuario}} </td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
    <th>Cedula del Vendedor:</th>
    <td>{{$fact_venta->user->cedula}} </td>
  </tr>
</table>
<!---->
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table cellpadding="0" cellspacing="0" style=" width:100%">
  <tr>
    <th style="width: 20%;border:1px solid;">REFERENCIA</th>
    <th style="width: 20%;border:1px solid;">DESCRIPCION</th>
    <th style="width: 20%;border:1px solid;">CANTIDAD</th>
    <th style="width: 20%;border:1px solid;">PRECIO</th>
    <th style="width: 20%;border:1px solid;">TOTAL</th>
  </tr>

  @foreach($fact_venta->ventas as $sale)
  <tr>
    <td>{{ $sale->inventario->codigo }} </td>
    <td>{{ $sale->inventario->nombre_i }} </td>
    <td>{{ $sale->cantidad }} </td>
    <td>{{ number_format((float)$sale->precio_venta, 2)}}</td>
    <td>{{ number_format((float)$sale->precio_venta * $sale->cantidad, 2)}}</td>
  </tr>
  @endforeach

</table>
<footer style="font: arial; font-size:9px">
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <table cellpadding="0" cellspacing="0" style=" width:100%">
    <tr>
      <td style="width: 60%;">&nbsp;</td>
      <th style="width: 20%;">Base Imponible 12 &#37;:</th>
      <td style="width: 20%;">{{ $fact_venta->msubt_bi_iva_12 }} </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <th>Base Imponible 8 &#37;:</th>
      <td>{{ $fact_venta->msubt_bi_iva_8 }} </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <th>Base Imponible 27 &#37;:</th>
      <td>{{ $fact_venta->msubt_bi_iva_27 }} </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <th>I.V.A. Al 12 &#37;:</th>
      <td>{{ $fact_ventas_acum['acum_msubt_bi_iva_12_n'] * 0.12 }} </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <th>I.V.A. Al 8 &#37;:</th>
      <td>{{ $fact_ventas_acum['acum_msubt_bi_iva_8_n'] * 0.08 }} </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <th>I.V.A. Al 27 &#37;:</th>
      <td>{{ $fact_ventas_acum['acum_msubt_bi_iva_27_n'] * 0.27 }} </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <th>Monto Exento:</th>
      <td>{{ $fact_ventas_acum['acum_msubt_exento_venta'] }} </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <th>Total de la Operaci&oacute;n:</th>
      <td>{{ $fact_ventas_acum['acum_mtot_iva_venta_n'] }} </td>
    </tr>
    <tr>
      <td><br /><br /><br /></td>
    </tr>
  </table>
  <br />

  <table style="width: 100%;">
    <tr>
      <td style="text-align: left;	width: 50%">
      </td>
      <td style="text-align: right;	width: 50%">page [[page_cu]]/[[page_nb]]</td>
    </tr>
  </table>
</footer>
Sistema {{env('APP_NAME')}} - {{env('APP_VERSION')}}