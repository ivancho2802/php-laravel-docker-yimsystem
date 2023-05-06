@extends('layouts.user_type.auth')

@section('content')


<div class="container-fluid py-4">
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h6 class="mb-0">{{ __('Informacion de Factura de Compra') }}</h6>
    </div>
    <div class="card-body pt-4 p-3">
      <form id="form1" name="form1" method="POST" action="{{ isset($factCompra->id) ? '/book-shopping-edit/'. $factCompra->id : '/book-shopping-add'}}">

        @csrf
        <input name="fk_proveedor" required="required"  value="{{ $factCompra->fk_proveedor ?? '' }}" type="hidden"  />

        @if(isset($factCompra['id']))
        @method('PUT')
        @endif

        <!--campos ocultos-->
        @if(isset($factCompra['id']))
        <input type="hidden" name="id_fact_compra" value="{{ $factCompra['id'] ?? '' }}" />
        @endif
        <!--fin campos ocultos-->

        @if($errors->any())
        <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
          <span class="alert-text text-white">
            {{$errors->first()}}</span>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <i class="fa fa-close" aria-hidden="true"></i>
          </button>
        </div>
        @endif
        @if(session('success'))
        <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
          <span class="alert-text text-white">
            {{ session('success') }}</span>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <i class="fa fa-close" aria-hidden="true"></i>
          </button>
        </div>
        @endif
        <div class="row">
          <div class="col-xs-4 col-md-4 col-lg-4">

            <label for="tipodocumnto">Tipo de Documento:</label><br />
            <select id="tipoDoc" name="tipo_fact_compra" value="{{ $factCompra->tipo_fact_compra ?? '' }}" class="form-select" onchange="tipoDocuC(this.value)" required>
              <option value="">Seleccione</option>
              <option value="F" {!! !empty($factCompra) && $factCompra->tipo_fact_compra=='F' ? 'selected' : '' !!}>
                Factura
              </option>
              <option value="ND" {!! !empty($factCompra) && $factCompra->tipo_fact_compra=='ND' ? 'selected' : '' !!}>
                Nota de D&eacute;bito
              </option>
              <option value="NC-DESC" {!! !empty($factCompra) && $factCompra->tipo_fact_compra=='NC-DESC' ? 'selected' : '' !!}>
                Nota de Cr&eacute;dito - Descuento
              </option>
              <option value="NC-DEVO" {!! !empty($factCompra) && $factCompra->tipo_fact_compra=='NC-DEVO' ? 'selected' : '' !!}>
                Nota de Cr&eacute;dito - Devoluciones
              </option>
              <option value="C" {!! !empty($factCompra) && $factCompra->tipo_fact_compra=='C' ? 'selected' : '' !!}>
                Certificaci&oacute;n
              </option>
              <option value="NE" {!! !empty($factCompra) && $factCompra->tipo_fact_compra=='NE' ? 'selected' : '' !!}>
                Nota de Entrega
              </option>
              <!--
                <optgroup label="Existencia Inicial">
                    <option value="II">Inventario Inicial</option>
                </optgroup>
                -->
            </select>
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4" id="resTipoDoc">
            <span id="tit_nfact_afectada"></span>
            <br />
            <span class="input-group">
              <input class="form-control btn-default" name="nfact_afectada" id="nfact_afectada" type="hidden" placeholder="Clic Aqui" value="{{$factCompra->nfact_afectada ?? '' }}" />
              <button type="button" style="display:none" class="btn btn-primary m-0" name="btn_b_nfact_afectada" id="btn_b_nfact_afectada" title="Buscar Factura" data-bs-toggle="modal" data-bs-target="#busFact">
                B <i class="fa fa-search"></i>
              </button>

              <button type="button" style="display:none" class="btn btn-info m-0" name="btn_nfact_afectada" id="btn_nfact_afectada" onclick="modalConsulFact(document.form1.nfact_afectada.value)">
                D <i class="fa fa-th-list"></i>
              </button>
            </span>
          </div><!-- cierre del col este define por ajax el numero de documento o factura afectada-->
          <div class="col-xs-4 col-md-4 col-lg-4" id="res_serie_fact_compra">
            <span id="cont_serie_fact_compra">
              Serie de Documento<br />
              <input type="text" class="form-control" name="serie_fact_compra" id="serie_fact_compra" value="{{ $factCompra->serie_fact_compra ?? '' }}" size="20" onKeyUp="toInputUpperCase(event)">
              <!--no es requerido por que a veces las facturas no tienen numero de serie-->
            </span>
          </div>
        </div><!--ROW-->
        <div class="row">
          <div class="col-xs-4 col-md-4 col-lg-4">
            <label>N° Documento:</label><br />
            <input type="number" class="form-control" min="0" name="num_fact_compra" value="{{ $factCompra->num_fact_compra ?? '' }}" size="20" required="required" />
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4">
            <label>N° Control:</label><br>
            <input type="text" class="form-control" name="num_ctrl_factcompra" id="num_ctrl_factcompra" value="{{ $factCompra->num_ctrl_factcompra ?? '00-' }}" size="20" />
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4">

          </div>
        </div><!--row-->
        <div class="row" id="ResselecProv">
          <div class="col-xs-6 col-md-6 col-lg-6">
            <label>R.I.F. del Proveedor:</label><br />
            <div class="input-group" role="group" aria-label="Vertical button group">
              <input name="rif" class="open-busProv form-control list-group-item" required="required" onblur="toInputUpperCase(event)" onclick="modalbusProv('N')" onfocus="modalbusProv('N')" value="{{ $factCompra->proveedor->rif ?? '' }}" type="text" placeholder="Clic aqui" />
              <button type="button" class="btn btn-primary  m-0" onclick="modalbusProv('N')">
                Seleccionar Proveedor
              </button>
            </div>
          </div>
          <div class="col-xs-6 col-md-6 col-lg-6">
            <label>Nombre o Raz&oacute;n Social:</label><br />
            <div class="input-group" role="group" aria-label="Vertical button group">
              <input id="nom_prov_ajax" name="nombre" class="form-control" required="required" onclick="modalbusProv('N')" onfocus="modalbusProv('N')" value="{{ $factCompra->proveedor->nombre ?? '' }}" type="text" placeholder="Clic aqui" />
              <button type="button" class="btn btn-primary  m-0" onclick="modalbusProv('N')">
                Seleccionar Proveedor
              </button>
            </div>
          </div>
        </div><!--row-->
        <div class="row">
          <div class="col-xs-4 col-md-4 col-lg-4" id="res_fecha_fact_compra">
            <span id="cont_fecha_fact_compra">
              <label>Fecha de Emisi&oacute;n:</label>
              <br />
              <!--de la Compra-->
              <input type="date" class="form-control" name="fecha_fact_compra" id="fecha_fact_compra" size="20" lang="si-general" required />
              <br />
              <span id="nota_compra"></span>
            </span>
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4">
            <label>Tipo de Transacci&oacute;n:</label><br />
            <select id="tipoTrans" class="form-select" name="tipo_transc" required disabled="disabled" value="{{ $factCompra->tipo_trans ?? '' }}">
              <option value="01-reg" {!! !empty($factCompra) && $factCompra->tipo_trans=='01-reg' ? 'selected' : '' !!}>
                01-reg -> Factura
              </option>
              <option value="02-reg" {!! !empty($factCompra) && $factCompra->tipo_trans=='02-reg' ? 'selected' : '' !!}>
                02-reg -> Nota de Debito
              </option>
              <option value="03-reg" {!! !empty($factCompra) && $factCompra->tipo_trans=='03-reg' ? 'selected' : '' !!}>
                03-reg -> Nota de Credito
              </option>
              <option value="01-anul" {!! !empty($factCompra) && $factCompra->tipo_trans=='01-anul' ? 'selected' : '' !!}>
                01-anul -> Anulada
              </option>
            </select>
            <input id="tipoTrans" type="hidden" name="tipo_trans" value="{{ $factCompra->tipo_trans ?? '' }}" required>
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4">

          </div>
        </div><!--row-->
        <div class="row">
          <div class="col-xs-4 col-md-4 col-lg-4">
            <label>N° Planilla de Importaci&oacute;n:</label><br>
            <input type="text" class="form-control" name="nplanilla_import" value="{{ $factCompra->nplanilla_import ?? '' }}" size="20" required readonly="readonly" />
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4">
            <label>N° Exp de Importaci&oacute;n:</label><br>
            <input type="text" class="form-control" name="nexpe_import" value="{{ $factCompra->nexpe_import ?? '' }}" size="20" required readonly="readonly" />
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4">
            <label>N° Declaraci&oacute;n Aduana:</label><br>
            <input type="text" class="form-control" name="naduana_import" value="{{ $factCompra->naduana_import ?? '' }}" size="20" required readonly="readonly" />
          </div>
        </div><!--row-->
        <div class="row">
          <div class="col-xs-4 col-md-4 col-lg-4">
            <label>Fecha Aduana Importacion:</label><br>
            <input type="date" class="form-control" name="fechaduana_import" value="{{ $factCompra->fechaduana_import ?? '' }}" size="20" required readonly="readonly" />
          </div>
          <div class="col-xs-4 col-md-4 col-lg-4">

          </div>
          <div class="col-xs-4 col-md-4 col-lg-4">

          </div>
        </div><!--row-->
        <hr id="res_cargarCompra" class="featurette-divider">
        <div class="row">
          <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="row">
              <div class="col" width="16.5%">
                <p>Codigo Producto</p>
              </div>
              <div class="col">
                <p>Nombre Producto</p>
              </div>
              <div class="col">
                <p>Costo (BsF.) &frasl; Precio de Venta</p>
              </div>
              <div class="col">
                <p>Cantidad</p>
              </div>
              <div class="col">
                <p>Tipo de Compra</p>
              </div>
              <div class="col">
                <p class = "text-center">Accion</p>
              </div>
            </div>

            <div id="res_consulTablaProd">
              @if(!isset($factCompra->id))
              <x-prod.form-prod codigo="" fkInventario="" nomFkInventario="" costo="" pmpvj="" cantidad="" stock="" tipoCompra="" type="" />
              @else
              @if(isset($factCompra->compras))
              @foreach ($factCompra->compras as $compra)
              <x-prod.form-prod codigo="{{$compra->inventario->codigo}}" fkInventario="{{$compra->fk_inventario}}" nomFkInventario="{{$compra->inventario->nombre_i}}" costo="{{$compra->costo}}" pmpvj="{{$compra->inventario->pmpvj_actual}}" cantidad="{{$compra->cantidad}}" stock="{{$compra->inventario->stock}}" tipoCompra="{{$compra->tipoCompra}}" type="{{$compra->type}}" />
              @endforeach
              @endif
              @endif
            </div>

            <div class="row">
              <div class="col-4">&nbsp;</td>
                <div class="col">
                  <button class="btn btn-sm btn-primary" type="button" onClick="agreInput()">
                    <span class="fa fa-plus"></span>
                  </button>
                </div>
              </div>
            </div>
          </div><!--row-->
          <div class="row">
            <div class="col-xs-4 col-md-4 col-lg-4">

            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
              <label>Monto Exento (BsF.):</label><br />
              <input type="text" class="form-control" name="msubt_exento_compra" value="{{ $factCompra->msubt_exento_compra ?? '0' }}" size="20" readonly="readonly" />
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">

            </div>
          </div><!--row-->
          <div class="row">
            <div class="col-xs-4 col-md-4 col-lg-4">

            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
              <label>Base Imponible (BsF.):</label><br />
              <input type="text" class="form-control" name="msubt_bi_iva_12" value="{{ $factCompra->msubt_bi_iva_12 ?? '0' }}" size="20" readonly="readonly" />
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
              <label>IVA al 12 &#37;:</label><br />
              <input type="number" class="form-control" min="0" step="0.01" value="{{ $factCompra->iva_12 ?? '0.00' }}" placeholder="0.00" name="iva_12" required="required" onkeyup="fcalculoTotC(this.value, document.form1.iva_8.value, document.form1.iva_27.value)" />
            </div>
          </div><!--row-->
          <div class="row">
            <div class="col-xs-4 col-md-4 col-lg-4">

            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
              <label>Base Imponible (BsF.):</label><br />
              <input type="text" class="form-control" name="msubt_bi_iva_8" value="{{ $factCompra->msubt_bi_iva_8 ?? '0' }}" size="20" readonly="readonly" />
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
              <label>IVA al 8 &#37;:</label><br />
              <input type="number" class="form-control" min="0" step="0.01" value="{{ $factCompra->iva_8 ?? '0.00' }}" placeholder="0.00" name="iva_8" required="required" onkeyup="fcalculoTotC(document.form1.iva_12.value, this.value,  document.form1.iva_27.value)" />
            </div>
          </div><!--row-->
          <div class="row">
            <div class="col-xs-4 col-md-4 col-lg-4">

            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
              <label>Base Imponible (BsF.):</label><br />
              <input type="text" class="form-control" name="msubt_bi_iva_27" value="{{ $factCompra->msubt_bi_iva_27 ?? '0' }}" size="20" readonly="readonly" />
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
              <label>IVA al 27 &#37;:</label><br />
              <input type="number" class="form-control" min="0" step="0.01" value="{{ $factCompra->iva_27 ?? '0.00' }}" placeholder="0.00" name="iva_27" required="required" onkeyup="fcalculoTotC(document.form1.iva_12.value, document.form1.iva_8.value, this.value)" />
            </div>
          </div><!--row-->
          <div class="row">
            <div class="col-xs-4 col-md-4 col-lg-4">

            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
              <label>Total Base Imponible (BsF.):</label><br />
              <input type="text" class="form-control" name="msubt_tot_bi_compra" value="{{ $factCompra->msubt_tot_bi_compra ?? '0' }}" size="20" readonly="readonly" />
            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">
              <label>Total Impuesto IVA:</label><br />
              <input type="text" class="form-control" name="tot_iva" value="{{ $factCompra->tot_iva ?? '0' }}" size="20" readonly="readonly" />
            </div>
          </div><!--row-->

          <div class="row">
            <div class="col-xs-4 col-md-4 col-lg-4">

            </div>
            <div class="col-xs-4 col-md-6 col-lg-6">
              <label>Total de la Compra Incluyendo IVA (BsF.):</label><br />
              <input type="text" class="form-control" name="mtot_iva_compra" value="{{ $factCompra->mtot_iva_compra ?? '0' }}" readonly="readonly" />
            </div>
          </div><!--row-->
          <hr id="res_cargarCompra" class="featurette-divider">
          <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
              <button type="submit" class="btn btn-lg btn-success col-xs-12 col-md-12 col-lg-12">
                {{ isset($factCompra->id) ? 'Modificar Compra' : 'Agregar Compra'}}
              </button>
            </div>
          </div><!--row-->
          <div class="row">
            <div class="col-xs-4 col-md-4 col-lg-4">

            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">

            </div>
            <div class="col-xs-4 col-md-4 col-lg-4">

            </div>
          </div>
          <!--row-->
          <!--   PARA DESPUES no existe en la bd
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Num_compro_reten:</td>
              <td><input type="text" name="num_compro_reten" value="" size="20" /></td>
              </tr>
              <tr valign="baseline">
              <td nowrap="nowrap" align="right">Fecha_compro_reten:</td>
              <td><input type="text" name="fecha_compro_reten" value="" size="20" /></td>
            </tr>
          -->
          <!-- PARA DESPUES no existe en la bd
              <tr valign="baseline">
              <td nowrap="nowrap" align="right">Iva_retenido_vendedor_inter:</td>
              <td><input type="text" name="iva_retenido_vendedor_inter" value="" size="20" /></td>
              </tr>
              <tr valign="baseline">
              <td nowrap="nowrap" align="right">Iva_anticipo_import:</td>
              <td><input type="text" name="iva_anticipo_import" value="" size="20" required="required"/></td>
              </tr>
          -->
      </form>
    </div>
  </div>
</div>

<div id="zoneModalExtra"></div>


<!--PARA LLAMAR A EL cRUL RIF-->
<script>
  var formProdCurrent = 0,
    dateInventario = '';

  $(document).ready(function() {
    validarFormularioAddShopping()

    getDateInventarioInicial();
  });

  function getDateInventarioInicial() {

    $.ajax({
      type: 'GET',
      url: '/inventario-config',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {

        dateInventario = data.data.dateInventario
        document.getElementById("nota_compra").innerHTML = dateInventario;
      }

    });

  }

  /**
   * validar si existe inventario inicial con input id fecha_fact_compra
   */
  function validarFormularioAddShopping() {

    //cuando carge la fecha validar si si las fecha es valida
    document.getElementById("fecha_fact_compra").addEventListener("load", (event) => {
      let currentDate = document.getElementById("fecha_fact_compra").value;
      let inputFecha = event.target

      //la fecha esta incorrecta
      if (!dateInventario) {
        var opcion = confirm(
          "Disculpe las molestias INVENTARIO INICIAL vacio " +
          " \nSera redireccionado en cuanto pulce Aceptar"
        );
        if (opcion == true) {
          const path = '<?php echo \App\Models\Inventario::INVENTARYLIST; ?>';
          setTimeout(function() {
            window.location = path
          }, 2000);
        }

      } else if (currentDate < dateInventario) {
        var opcion = confirm(
          "Disculpe las molestias" +
          "La Fecha que ingreso debe ser mayor a la FECHA de INVENTARIO INICIAL: " +
          dateInventario
        );
        if (opcion == true) {
          const path = '<?php echo \App\Models\Inventario::INVENTARYLIST; ?>';
          setTimeout(function() {
            window.location = path
          }, 2000);
        }
      } else {
        let iconCheck = '<i class="fa fa-check text-success" ></i>';

        document.getElementById('nota_compra').innerHTML += iconCheck;
      }

    })
  }


  function tipoDocuC(str) {

    var tit_nfact_afectada = document.getElementById("tit_nfact_afectada");
    var infact_afectada = document.getElementById("nfact_afectada");
    var btnfact_afectada = document.getElementById("btn_nfact_afectada");
    var btnfact_b_afectada = document.getElementById("btn_b_nfact_afectada");


    if (str == 'NC-DESC' || str == 'NC-DEVO' || str == "ND") {
      if (str == "ND") {
        document.forms['form1'].elements['tipo_trans'].value = "02-reg";
        document.forms['form1'].elements['tipo_transc'].value = "02-reg";
      } else {
        document.forms['form1'].elements['tipo_trans'].value = "03-reg";
        document.forms['form1'].elements['tipo_transc'].value = "03-reg";
      }
      //ACTIVACION O PONER VISIBLE LOS CAMPOS DE SELÑECCINAR LA FACTURA
      tit_nfact_afectada.innerHTML = "N. Factura Afectada";

      infact_afectada.type = 'text';

      infact_afectada.setAttribute("data-bs-toggle", "modal");
      infact_afectada.setAttribute("data-bs-target", "#busFact");
      infact_afectada.setAttribute("onfocus", "new bootstrap.Modal(document.getElementById('busFact')).show()");
      //infact_afectada.setAttribute("readonly", "readonly");
      //infact_afectada.setAttribute("readonly", "readonly");


      btnfact_afectada.style = "display:compact"; // visible
      btnfact_b_afectada.style = "display:compact"; // visible

    } else if (str == 'F' || str == 'C' || str == 'NE') {
      document.forms['form1'].elements['tipo_trans'].value = "01-reg";
      document.forms['form1'].elements['tipo_transc'].value = "01-reg";
      //LA INVERSA DE LO QUE HACEN LAS NOTAS DE CREDITO
      infact_afectada.value = '';
      infact_afectada.type = 'hidden';
      btnfact_afectada.style = "display:none"; //no visible
      btnfact_b_afectada.style = "display:none"; //no visible
      tit_nfact_afectada.innerHTML = "";

    } else {
      document.forms['form1'].elements['tipo_trans'].value = "";
      document.forms['form1'].elements['tipo_transc'].value = "";
      //LA INVERSA DE LO QUE HACEN LAS NOTAS DE CREDITO
      infact_afectada.value = '';
      infact_afectada.type = 'hidden';
      btnfact_afectada.style = "display:none"; //no visible
      btnfact_b_afectada.style = "display:none"; //no visible
      tit_nfact_afectada.innerHTML = "";
    }
    //vaciado de los productos
    consulTablaProd();
  }

  //
  function modalbusProv(otroModal) {

    if (otroModal == "N") {

      document.getElementById('otroModal').value = '';
      $('#busProv').modal('show');
      return
    } else if (otroModal == 'formMbf') {

      document.getElementById('otroModal').value = 'formMbf'; //formulario de el modal bFactC
      $('#busProv').modal('show');
      return
    }

  }
  /**
   * para agregar componente de prods
   */
  function consulTablaProd(str) {
    //console.log("consulTablaProd str", str)

    const checkEdit = '<?php echo isset($factCompra->id); ?>';

    if (!str && !checkEdit) {
      $("#res_consulTablaProd").append(`<x-prod.form-prod codigo="" fkInventario="" nomFkInventario="" costo="" pmpvj="" cantidad="" stock="" tipoCompra="" type=""/>`);
      fcalculo();
    } else if (str) {

      $.ajax({
        type: 'GET',
        url: '/compras/' + str,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          let formProds = ""
          data.compras.forEach(element => {
            formProds += `<x-prod.form-prod codigo=""  fkInventario="" nomFkInventario="" costo="" pmpvj="" cantidad="" stock="" tipoCompra="" type=""/>`
          });
          $("#res_consulTablaProd").append(formProds);

          fcalculo();
        },

      });
    }
  }

  /**
   * funcion para seleccionar mas inputs
   */
  function agreInput() {
    consulTablaProd()
  }

  //funcion para restar campos
  function elimInput() {
    fcalculo();
  }
  /**
   * control del seleccionador del PMPVJ
   */
  function ctrlSelecPMPVJ(inputOrigin) {
    formProdCurrent = $('div.formProdContent').index(inputOrigin.parents('.formProdContent'))
    $('#calPMPVJ').modal('show');
  }

  /**
   * funcion para condicionar el llenado o suma de los totales
   */
  function fcalculo(valido) {

    function disabledInputs(action) {
      document.form1.nplanilla_import.readOnly = action;
      document.form1.nexpe_import.readOnly = action;
      document.form1.naduana_import.readOnly = action;
      document.form1.fechaduana_import.readOnly = action;
    }

    var n = 0
    if ($(".formProdContent"))
      n = $(".formProdContent").length

    //totales
    var acum_msubt_exento_compra = 0;
    var acum_msubt_bi_iva_12 = 0;
    var acum_msubt_bi_iva_8 = 0;
    var acum_msubt_bi_iva_27 = 0;
    var acum_iva_12 = 0;
    var acum_iva_8 = 0;
    var acum_iva_27 = 0;
    var acum_msubt_tot_bi_compra = 0;
    var acum_mtot_iva_compra = 0;
    var tipoDoc = document.getElementById('tipoDoc').value

    for (i = 0; i < n; i++) {

      if ($("input[name='fk_inventario[" + i + "]']") != null) {
        var tipoCompraA = $("select[name='tipoCompra[" + i + "]']").val();
        var fk_inventarioA = $("input[name='fk_inventario[" + i + "]']").val();
        var costoA = parseFloat($("input[name='costo[" + i + "]']").val());
        var cantidadA = parseInt($("input[name='cantidad[" + i + "]']").val());

        if (tipoDoc == "NC-DEVO") {
          var stockA = parseInt($("input[name='stock[" + i + "]']").val());

          if (cantidadA > stockA) {
            $("input[name='cantidad[" + i + "]']").val("");
            alert("la cantidad supera la existencia");
            //return 0;
          }
        }

        //validar que los campos anteriores esten llenos
        if (fk_inventarioA === "" || costoA == 0 || cantidadA == 0) {
          if (valido == 1) {
            alert("Debe llenar los demas campos");
            //tipoCompraA = "";
          }
          $("select[name='tipoCompra[" + i + "]']").val("")
        } else { //por lo tanto los campos estan llenos
          bi = costoA * cantidadA; //base imponible
          if (tipoCompraA == "IN_EX" || tipoCompraA == "IN_EXO" || tipoCompraA == "IN_NS" || tipoCompraA == "IN_SDCF") {
            disabledInputs(true)
            acum_msubt_exento_compra += bi;

          } else if (tipoCompraA == "IN_BI_12") {
            disabledInputs(true)
            acum_msubt_bi_iva_12 += bi;
            acum_iva_12 += bi * 0.12;

          } else if (tipoCompraA == "IN_BI_27") {
            disabledInputs(true)
            acum_msubt_bi_iva_27 += bi;
            acum_iva_27 += bi * 0.27;

          } else if (tipoCompraA == "IN_BI_8") {
            disabledInputs(true)
            acum_msubt_bi_iva_8 += bi;
            acum_iva_8 += bi * 0.08;

          } else if (tipoCompraA == "IM_EX" || tipoCompraA == "IM_EXO" ||
            tipoCompraA == "IM_NS" || tipoCompraA == "IM_SDCF") {

            disabledInputs(false)
            acum_msubt_exento_compra += bi;
          } else if (tipoCompraA == "IM_BI_12") {

            disabledInputs(false)
            acum_msubt_bi_iva_12 += bi;
            acum_iva_12 += bi * 0.12;

          } else if (tipoCompraA == "IM_BI_27") {

            disabledInputs(false)
            acum_msubt_bi_iva_27 += bi;
            acum_iva_27 += bi * 0.27;

          } else if (tipoCompraA == "IM_BI_8") {

            disabledInputs(false)
            acum_msubt_bi_iva_8 += bi;
            acum_iva_8 += bi * 0.08;
          }

        }
      }
    }
    //END FOR

    document.form1.msubt_exento_compra.value = acum_msubt_exento_compra;

    document.form1.msubt_bi_iva_12.value = acum_msubt_bi_iva_12;
    document.form1.msubt_bi_iva_8.value = acum_msubt_bi_iva_8;
    document.form1.msubt_bi_iva_27.value = acum_msubt_bi_iva_27;

    msubt_tot_bi_compra = acum_msubt_bi_iva_12 + acum_msubt_bi_iva_27 + acum_msubt_bi_iva_8
    document.form1.msubt_tot_bi_compra.value = Math.round10(msubt_tot_bi_compra, -2);

    document.form1.iva_12.value = Math.round10(acum_iva_12, -2);
    document.form1.iva_8.value = Math.round10(acum_iva_8, -2);
    document.form1.iva_27.value = Math.round10(acum_iva_27, -2);

    tot_iva = acum_iva_12 + acum_iva_27 + acum_iva_8;
    document.form1.tot_iva.value = Math.round10(tot_iva, -2);

    document.form1.mtot_iva_compra.value = Math.round10(
      acum_msubt_exento_compra + msubt_tot_bi_compra + tot_iva, -2
    );
  }

  /** ver los detalle de una factura de compra */
  function modalConsulFact(factCompra) {

    $.ajax({
      type: 'GET',
      url: '/book-shopping-detail/' + factCompra,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        document.getElementById("zoneModalExtra").innerHTML = data;
        $('#mostrarFact').modal('show');

      },
      beforeSend: function() {
        $('#btn_nfact_afectada').prop('disabled', true)
      },
      complete: function() {
        $('#btn_nfact_afectada').prop('disabled', false)
      },

    });

  }
</script>

<!-- modales -->
@include('modales.fact_c.m_b_fact_c')
@include('modales.prov.m_b_prov')
@include('modales.prov.form_prov')
@include('modales.prod.m_b_prod')
@include('modales.prod.m_a_prod')
@include('modales.prod.m_PMPVJ')


@endsection