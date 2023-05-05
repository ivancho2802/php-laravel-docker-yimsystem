@extends('layouts.user_type.auth')

@section('content')

<div class="bs-example" id="cargarVenta">

  <div class="alert alert-secondary mx-4" role="alert">
    <span class="text-white">
      <strong>Agrega, Edita, Elimina caracteristicas</strong>
    </span>
  </div>


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

  <div class="container-fluid py-4 card">

    <div class="card-header pb-0 px-3">
      <h6 class="mb-0">{{ __('Informacion de Factura de Venta') }}</h6>
    </div>

    <form id="form1" name="form1" method="POST" action="{{ isset($factVenta->id) ? '/book-sales-edit/'. $factVenta->id : '/book-sales-add'}}">

      @csrf
      <!--campos ocultos-->
      <input name="fk_cliente" required="required" type="hidden" value="{{ $factVenta['fk_cliente'] ?? '' }}" />
      @if(isset($factVenta['id']))
      <input type="hidden" name="id_fact_venta" value="{{ $factVenta['id'] ?? '' }}" />
      @endif
      @if(isset($factVenta['id']))
      @method('PUT')
      @endif

      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>Tipo de Documento:</label>
          <select id="tipoDoc" class="form-select" name="tipo_fact_venta" id="tipo_fact_venta" onchange="tipoDocuV(this.value)" value="{{ $factVenta->tipo_fact_venta ?? '' }}" required>
            <option value="">Seleccione</option>
            <option value="F" {!! !empty($factVenta) && $factVenta->tipo_fact_venta=='F' ? 'selected' : '' !!}>Factura</option>
            <option value="RDV" {!! !empty($factVenta) && $factVenta->tipo_fact_venta=='RDV' ? 'selected' : '' !!}>Resumen Diario de Ventas</option>
            <option value="FNULL" {!! !empty($factVenta) && $factVenta->tipo_fact_venta=='FNULL' ? 'selected' : '' !!}>Factura Anulada</option>
            <option value="ND" {!! !empty($factVenta) && $factVenta->tipo_fact_venta=='ND' ? 'selected' : '' !!}>Nota de D&eacute;bito</option>
            <option value="NC-DEVO" {!! !empty($factVenta) && $factVenta->tipo_fact_venta=='NC-DEVO' ? 'selected' : '' !!}>Nota de Cr&eacute;dito - Devoluciones</option>
            <option value="NC-DESC" {!! !empty($factVenta) && $factVenta->tipo_fact_venta=='NC-DESC' ? 'selected' : '' !!}>Nota de Cr&eacute;dito - Descuentos</option>
            <option value="NE" {!! !empty($factVenta) && $factVenta->tipo_fact_venta=='NE' ? 'selected' : '' !!}>Nota de Entrega</option>
          </select>
        </div>
        <!--AQUI SE MOSTRARA EL RESULTADO DE LA CONSUKLTA Y SU SELECCION-->
        <div class="col-xs-4 col-md-4 col-lg-4" id="resTipoDoc">
          <span id="span_resTipoDoc"></span><br>
          <span class="input-group">
            <input type="hidden" name="nfact_afectada" class="form-control" id="nfact_afectada" value="{{$factVenta->nfact_afectada ?? '' }}" />
            <input type="hidden" name="reg_maq_fis" class="form-control" value="{{$factVenta->reg_maq_fis ?? '' }}" onblur="javascript:this.value=this.value.toUpperCase();">
            <button type="button" style="display:none" class="btn btn-primary m-0" name="btn_nfact_afectada" id="btn_nfact_afectada" onclick="mConsulFact(document.form1.nfact_afectada.value)">
              Detalles Fact.
            </button>
            <!--style="display:none" no visible-->
          </span>
          <span id="res_nfact_afectada"></span>
        </div><!--este define por ajax el numero de documento o factura afectada-->

        <div class="col-xs-4 col-md-4 col-lg-4">
          <span id="span_resnum_repo_z"></span><br>
          <input name="num_repo_z" value="{{ $factVenta['num_repo_z'] ?? '' }}" class="form-control" type="hidden">
        </div>
      </div><!--ROW-->
      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4" id="ResselecCliente">
          <label>Documento del Cliente:</label>
          <!--en onclocl queda la funcion que desactiva la tecla enter del teclado-->
          <input name="ced_cliente" required="required" onblur="javascript:this.value=this.value.toUpperCase();" data-bs-toggle="modal" data-bs-target="#busCliente" readonly="readonly" placeholder="Clic aqui" class="form-control btn-primary active" value="{{ $factVenta['ced_cliente'] ?? '' }}" />
        </div>

        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>Nombre o Raz&oacute;n Social:</label>
          <input name="nom_cliente_ajax" class="form-control btn-primary active" id="nom_cliente_ajax" required="required" data-bs-toggle="modal" data-bs-target="#busCliente" onblur="javascript:this.value=this.value.toUpperCase();" readonly="readonly" placeholder="Clic aqui" value="{{ $factVenta['nom_cliente'] ?? '' }}" />
        </div>

        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>Tipo de Contribuyente:</label>
          <input name="tipo_contri" class="form-control btn-primary active" id="tipo_contri" required="required" data-bs-toggle="modal" data-bs-target="#busCliente" onblur="javascript:this.value=this.value.toUpperCase();" readonly="readonly" placeholder="Clic aqui" value="{{ $factVenta['tipo_contri'] ?? '' }}" />
        </div>
      </div><!--rOW-->

      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4" id="res_serie_fact_venta">
          <span id="cont_serie_fact_venta">
            <label>Serie de Documento</label>
            <div class="input-group">
              <input type="text" name="serie_fact_venta" class="form-control" id="serie_fact_venta" value="" size="20" onKeyUp="javascript:this.value=this.value.toUpperCase();" value="{{ $factVenta['serie_fact_venta'] ?? '' }}">
              <button id="generateNFact" type="button" class="btn btn-primary  m-0">Generar</button>
            </div>
          </span>
          <!--no es requerido por que a veces las facturas no tienen numero de serie-->
        </div>

        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>N° Documento:</label>
          <input type="number" min="0" name="num_fact_venta" id="num_fact_venta" class="form-control" value="" size="20" required="required" value="{{ $factVenta['num_fact_venta'] ?? '' }}" />
        </div>

        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>N° Control:</label><br>
          <input type="text" class="form-control" name="num_ctrl_factventa" id="num_ctrl_factventa" value="{{ $factVenta['num_ctrl_factventa'] ?? '' }}" size="20" />
        </div>

      </div>
      <!--row-->

      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>Tipo de Transacci&oacute;n:</label>
          <select id="tipoTrans" name="tipo_transv" class="form-control" required disabled="disabled" value="{{ $factVenta['tipoTrans'] ?? '' }}">
            <option value="01-reg" {!! !empty($factVenta) && $factVenta->tipo_trans=='01-reg' ? 'selected' : '' !!}>
              01-reg -> Registro
            </option>
            <option value="02-reg" {!! !empty($factVenta) && $factVenta->tipo_trans=='02-reg' ? 'selected' : '' !!}>
              02-reg -> Nota de Debito
            </option>
            <option value="03-reg" {!! !empty($factVenta) && $factVenta->tipo_trans=='03-reg' ? 'selected' : '' !!}>
              03-reg -> Nota de Credito
            </option>
            <option value="01-anul" {!! !empty($factVenta) && $factVenta->tipo_trans=='01-anul' ? 'selected' : '' !!}>
              01-anul -> Anulada
            </option>
          </select>
          <input id="tipoTrans" type="hidden" class="form-control" name="tipo_trans" value="{{ $factVenta['tipo_trans'] ?? '' }}" required>
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4" id="res_fecha_fact_venta">
          <span id="cont_fecha_fact_venta">
            <label>Fecha de Emisi&oacute;n:</label><!--de la Venta-->
            <input type="date" name="fecha_fact_venta" class="form-control" id="fecha_fact_venta" size="20" lang="si-general" value="{{date('Y-m-d')}}" required value="{{ $factVenta['fecha_fact_venta'] ?? '' }}" />
            <span id="nota_venta"></span>
          </span>
        </div>
      </div><!--row-->
      <div class="row"><!--DE AQUI EN ADELANDE CONSICIONADOS PARA SERR OCULTOS O NO POR JAVBASCRIPT-->
        <div class="col-xs-4 col-md-4 col-lg-4">
          N° Planilla de Exportaci&oacute;n:<br>
          <input type="text" name="nplanilla_export" class="form-control" value="" size="20" required readonly="readonly" />
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>N° Exp de Exportaci&oacute;n:</label>
          <input type="text" name="nexpe_export" class="form-control" value="" size="20" required readonly="readonly" />
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
      </div><!--ROW-->
      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4">
          N° Declaraci&oacute;n Aduana:<br>
          <input type="text" name="naduana_export" class="form-control" value="" size="20" required readonly="readonly" />
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          Fecha Aduana Exportaci&oacute;n:<br>
          <input type="date" name="fechaduana_export" class="form-control" value="" size="20" required readonly="readonly" />
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
      </div><!--ROW-->
      <!--///////////////////////////////////////PARA LA INSERCION DE PRODUCTOS-->
      <hr id="res_cargarVenta" class="featurette-divider">
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
              <p>Precio de Venta (BsF.)</p>
            </div>
            <div class="col">
              <p>Cantidad</p>
            </div>
            <div class="col">
              <p>Tipo de Venta</p>
            </div>
            <div class="col">
              <p>Accion</p>
            </div>
          </div>

          <div id="res_consulTablaProd">
            @if(!isset($factVenta->id))
            <x-prod.form-prod codigo="" fkInventario="" nomFkInventario="" costo="" pmpvj="" cantidad="" stock="" tipoCompra="" type="venta" />
            @else
            @if(isset($factVenta->ventas))
            @foreach ($factVenta->ventas as $venta)
            <x-prod.form-prod codigo="{{$venta->inventario->codigo}}" fkInventario="{{$venta->fk_inventario}}" nomFkInventario="{{$venta->inventario->nombre_i}}" costo="{{$venta->costo}}" pmpvj="{{$venta->inventario->pmpvj_actual}}" cantidad="{{$venta->cantidad}}" stock="{{$venta->inventario->stock}}" tipoCompra="{{$venta->tipoVenta}}" type="venta" />
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
      </div>
      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>Monto Exento (BsF.):</label>
          <input type="text" class="form-control" name="msubt_exento_venta" value="0" size="20" readonly="readonly" />
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
      </div><!--ROW-->

      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>Base Imponible (BsF.):</label>
          <input type="text" class="form-control" name="msubt_bi_iva_12" value="0" size="20" readonly="readonly" />
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>IVA al 12 &#37;:</label>
          <input type="number" class="form-control" min="0" step="0.01" value="0.00" placeholder="0.00" name="iva_12" readonly="readonly" />
        </div>
      </div><!--ROW-->
      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>Base Imponible (BsF.):</label>
          <input type="text" class="form-control" name="msubt_bi_iva_8" value="0" size="20" readonly="readonly" />
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>IVA al 8 &#37;:</label>
          <input type="number" class="form-control" min="0" step="0.01" value="0.00" placeholder="0.00" name="iva_8" readonly="readonly" />
        </div>
      </div><!--ROW-->
      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>Base Imponible (BsF.):</label>
          <input type="number" class="form-control" min="0" step="0.01" value="0.00" placeholder="0.00" name="msubt_bi_iva_27" readonly="readonly" />
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>IVA al 27 &#37;:</label>
          <input type="number" class="form-control" min="0" step="0.01" value="0.00" placeholder="0.00" name="iva_27" readonly="readonly" />
        </div>
      </div><!--ROW-->
      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          Total Base Imponible (BsF.):<br />
          <input type="text" class="form-control" name="msubt_tot_bi_venta" value="0" size="20" readonly="readonly" />
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          Total Impuesto IVA:<br />
          <input type="text" class="form-control" name="tot_iva" value="0" size="20" readonly="readonly" />
        </div>
      </div><!--ROW-->
      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          Total de la Venta Incluyendo IVA (BsF.):<br />
          <input type="text" class="form-control" name="mtot_iva_venta" value="0" size="20" readonly="readonly" />
        </div>
      </div><!--ROW-->
      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
      </div><!--ROW-->

      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>Tipo de Pago:</label>
          <select name="tipo_pago" class="form-control" onChange="tipoPago(this.value)" required="required">
            <option value="">Seleccione</option>
            <option value="D">Debito</option>
            <option value="C">Credito</option>
            <option value="E">Efectivo</option>
            <option value="T">Transferencia</option>
          </select>
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>Dias a pagar:</label>
          <input type="number" class="form-control" min="0" name="dias_venc" value="" size="20" readonly="readonly" required="required" />
        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
      </div><!--ROW-->
      <div class="row">
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>Monto a Pagar:</label>
          <input name="monto_paga" type="number" class="form-control" onkeyup="vueltosPago(this.value)" min="0" step="0.01" value="" placeholder="0.00" required="required" />

        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">

        </div>
        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>Vueltos:</label>
          <div id="dvueltos" class="">
            <input type="number" class="form-control" min="0" value="0.00" placeholder="0.00" name="vueltos" readonly="readonly" required="required" />
            <span id="svueltos" class=""></span>
          </div>
          <div class="col-sm-10">

          </div>
        </div>
      </div><!--ROW-->
      <hr id="res_cargarVenta" class="featurette-divider">
      <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
          <button type="submit" id="btnCargarVent" class="btn btn-lg btn-success col-xs-12 col-md-12 col-lg-12">Agregar Venta</button>
        </div>
      </div><!--row-->

    </form>
  </div><!--bs-marco- -->
</div><!--cargarVenta-->

<div id="zoneModalExtra"></div>

<script>
  $(document).ready(function() {
    let dateInventario = ''

    $('#generateNFact').on("click", generateNfact);

    validarFormularioAddSales()
    getDateInventarioInicial();

  });

  /**
   * validar si existe inventario inicial con input id fecha_fact_venta
   */
  function validarFormularioAddSales() {

    //cuando carge la fecha validar si si las fecha es valida
    document.getElementById("fecha_fact_venta").addEventListener("load", (event) => {
      let currentDate = document.getElementById("fecha_fact_venta").value;
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

        document.getElementById('nota_venta').innerHTML += iconCheck;
      }

    })

    /**
     * cuando carge el numero y control de documento
     */
    document.getElementById("num_fact_venta").addEventListener("change", (event) => {
      checkFactSalesExist()
    })

    document.getElementById("num_ctrl_factventa").addEventListener("change", (event) => {
      checkFactSalesExist()
    })

  }

  function getDateInventarioInicial() {

    $.ajax({
      type: 'GET',
      url: '/inventario-config',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {

        dateInventario = data.data.dateInventario
        document.getElementById("nota_venta").innerHTML = "Fecha Inv. Inicial: " + dateInventario;
      }

    });

  }

  //tipoDocuV
  function tipoDocuV(str) {
    var infact_afectada = document.getElementById("nfact_afectada");
    var btnfact_afectada = document.getElementById("btn_nfact_afectada");
    if (str == "FNULL") {
      //anulo los demas datos
      document.forms['form1'].elements['fk_cliente'].value = "Anulado";
      document.forms['form1'].elements['nom_cliente_ajax'].value = "Anulado";
      document.forms['form1'].elements['tipo_contri'].value = "";

      document.forms['form1'].elements['tipo_trans'].value = "01-anul";
      document.forms['form1'].elements['tipo_transv'].value = "01-anul";

      document.forms['form1'].elements['num_fact_venta'].type = "number";

      document.forms['form1'].elements['nfact_afectada'].type = "hidden";
      document.forms['form1'].elements['nfact_afectada'].required = null;

      document.forms['form1'].elements['reg_maq_fis'].type = "hidden";
      document.forms['form1'].elements['reg_maq_fis'].value = "";
      document.getElementById("span_resTipoDoc").innerHTML = "";
      document.forms['form1'].elements['reg_maq_fis'].required = null;
      ///////////////////////////////////////////////////////////////
      document.getElementById("span_resnum_repo_z").innerHTML = "";
      document.forms['form1'].elements['num_repo_z'].type = "hidden";
      document.forms['form1'].elements['num_repo_z'].required = null;
      ///////////////////////////////////////////////////////////////
      document.forms['form1'].elements['num_ctrl_factventa'].value = "00-";
      document.forms['form1'].elements['num_ctrl_factventa'].type = "text";
      //document.forms['form1'].elements['num_ctrl_factventa'].min = 0;
      /////////////////////////////////////////////////////////// 			RDV
      document.forms['form1'].elements['num_ctrl_factventa'].readOnly = null;

      //LA INVERSA DE LO QUE HACEN LAS NOTAS DE CREDITO
      infact_afectada.value = '';
      infact_afectada.type = 'hidden';
      btnfact_afectada.style = "display:none"; //no visible

    } else if (str == "RDV") {
      //resumen diario de ventas pone automatico los campos de resumen y demas
      //randoly serie_fact_venta y vacio

      document.forms['form1'].elements['fk_cliente'].value = "RESUMEN";
      document.forms['form1'].elements['nom_cliente_ajax'].value = "Resumen Diario De Ventas";
      document.forms['form1'].elements['tipo_contri'].value = "";

      document.forms['form1'].elements['tipo_trans'].value = "01-reg";
      document.forms['form1'].elements['tipo_transv'].value = "01-reg";

      document.forms['form1'].elements['num_fact_venta'].type = "text";

      document.forms['form1'].elements['nfact_afectada'].type = "hidden";
      document.forms['form1'].elements['nfact_afectada'].required = null;

      document.getElementById("span_resTipoDoc").innerHTML = "Registro Maquina Fiscal";
      document.forms['form1'].elements['reg_maq_fis'].type = "text";
      document.forms['form1'].elements['reg_maq_fis'].required = "required";
      ///////////////////////////////////////////////////////////////
      document.getElementById("span_resnum_repo_z").innerHTML = "Numero de Reporte Z";
      document.forms['form1'].elements['num_repo_z'].type = "number";
      document.forms['form1'].elements['num_repo_z'].min = 0;
      document.forms['form1'].elements['num_repo_z'].required = "required";
      ///////////////////////////////////////////////////////////////
      document.forms['form1'].elements['num_ctrl_factventa'].type = "text";
      document.forms['form1'].elements['num_ctrl_factventa'].value = "";
      document.forms['form1'].elements['num_ctrl_factventa'].readOnly = true;
      //document.forms['form1'].elements['num_ctrl_factventa'].min = null;

      //LA INVERSA DE LO QUE HACEN LAS NOTAS DE CREDITO
      infact_afectada.value = '';
      infact_afectada.type = 'hidden';
      btnfact_afectada.style = "display:none"; //no visible

    } else if (str == 'F' || str == 'NE') {
      document.forms['form1'].elements['fk_cliente'].value = "";
      document.forms['form1'].elements['nom_cliente_ajax'].value = "";
      document.forms['form1'].elements['tipo_contri'].value = "";

      document.forms['form1'].elements['tipo_trans'].value = "01-reg";
      document.forms['form1'].elements['tipo_transv'].value = "01-reg";

      document.forms['form1'].elements['num_fact_venta'].type = "number";

      document.forms['form1'].elements['nfact_afectada'].type = "hidden";
      document.forms['form1'].elements['nfact_afectada'].required = null;

      document.forms['form1'].elements['reg_maq_fis'].type = "hidden";
      document.forms['form1'].elements['reg_maq_fis'].value = "";
      document.getElementById("span_resTipoDoc").innerHTML = "";
      document.forms['form1'].elements['reg_maq_fis'].required = null;
      ///////////////////////////////////////////////////////////////
      document.getElementById("span_resnum_repo_z").innerHTML = "";
      document.forms['form1'].elements['num_repo_z'].type = "hidden";
      document.forms['form1'].elements['num_repo_z'].required = null;
      ///////////////////////////////////////////////////////////////
      document.forms['form1'].elements['num_ctrl_factventa'].value = "00-";
      document.forms['form1'].elements['num_ctrl_factventa'].type = "text";
      //document.forms['form1'].elements['num_ctrl_factventa'].min = 0;
      /////////////////////////////////////////////////////////// 			RDV
      document.forms['form1'].elements['num_ctrl_factventa'].readOnly = null;

      //LA INVERSA DE LO QUE HACEN LAS NOTAS DE CREDITO
      infact_afectada.value = '';
      infact_afectada.type = 'hidden';
      btnfact_afectada.style = "display:none"; //no visible

    } else if (str == 'ND' || str == 'NC-DEVO' || str == 'NC-DESC') {

      document.forms['form1'].elements['fk_cliente'].value = "";
      document.forms['form1'].elements['nom_cliente_ajax'].value = "";
      document.forms['form1'].elements['tipo_contri'].value = "";

      document.forms['form1'].elements['num_fact_venta'].type = "number";

      document.forms['form1'].elements['reg_maq_fis'].type = "hidden";
      document.forms['form1'].elements['reg_maq_fis'].value = "";
      document.getElementById("span_resTipoDoc").innerHTML = "N. Factura Afectada";
      document.forms['form1'].elements['reg_maq_fis'].required = null;
      ///////////////////////////////////////////////////////////////
      document.getElementById("span_resnum_repo_z").innerHTML = "";
      document.forms['form1'].elements['num_repo_z'].type = "hidden";
      document.forms['form1'].elements['num_repo_z'].required = null;
      ///////////////////////////////////////////////////////////////
      document.forms['form1'].elements['num_ctrl_factventa'].value = "00-";
      document.forms['form1'].elements['num_ctrl_factventa'].type = "text";
      //document.forms['form1'].elements['num_ctrl_factventa'].min = 0;
      /////////////////////////////////////////////////////////// 			RDV
      document.forms['form1'].elements['num_ctrl_factventa'].readOnly = null;
      //ACTIVACION O PONER VISIBLE LOS CAMPOS DE SELÑECCINAR LA FACTURA
      //esta arriba document.getElementById("span_resTipoDoc").innerHTML = "N. Factura Afectada";

      infact_afectada.type = 'text';
      infact_afectada.setAttribute("data-bs-toggle", "modal");
      infact_afectada.setAttribute("data-target", "#busFact");
      infact_afectada.setAttribute("onfocus", "$('#busFact').modal('show')");
      infact_afectada.setAttribute("readonly", "readonly");

      btnfact_afectada.style = "display:compact"; // visible
      if (str == "ND") {
        document.forms['form1'].elements['tipo_trans'].value = "02-reg";
        document.forms['form1'].elements['tipo_transv'].value = "02-reg";
      } else {
        document.forms['form1'].elements['tipo_trans'].value = "03-reg";
        document.forms['form1'].elements['tipo_transv'].value = "03-reg";
      }
    }
  }

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
        $('#btn_nfact_afectada').prop('disabled', true)
      },
      complete: function() {
        $('#btn_nfact_afectada').prop('disabled', false)
      },

    });

  }
  /**
   * funcion para seleccionar mas inputs
   */
  function agreInput() {
    consulTablaProd()
  }
  /**
   * para agregar componente de prods
   */
  function consulTablaProd(str) {
    //console.log("consulTablaProd str", str)

    const checkEdit = '<?php echo isset($factVenta->id); ?>';

    if (!str && !checkEdit) {
      $("#res_consulTablaProd").append(`<x-prod.form-prod codigo="" fkInventario="" nomFkInventario="" costo="" pmpvj="" cantidad="" stock="" tipoCompra="" type="venta"/>`);
      fcalculo();
    } else if (str) {

      $.ajax({
        type: 'GET',
        url: '/ventas/' + str,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          let formProds = ""
          data.ventas.forEach(element => {
            formProds += `<x-prod.form-prod codigo=""  fkInventario="" nomFkInventario="" costo="" pmpvj="" cantidad="" stock="" tipoCompra="" type="venta"/>`
          });
          $("#res_consulTablaProd").append(formProds);

          fcalculo();
        },

      });
    }
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
      document.form1.nplanilla_export.readOnly = action;
      document.form1.nexpe_export.readOnly = action;
      document.form1.naduana_export.readOnly = action;
      document.form1.fechaduana_export.readOnly = action;
    }

    var n = 0
    if ($(".formProdContent"))
      n = $(".formProdContent").length

    //totales
    var acum_msubt_exento_venta = 0;
    var acum_msubt_bi_iva_12 = 0;
    var acum_msubt_bi_iva_8 = 0;
    var acum_msubt_bi_iva_27 = 0;
    var acum_iva_12 = 0;
    var acum_iva_8 = 0;
    var acum_iva_27 = 0;
    var acum_msubt_tot_bi_venta = 0;
    var acum_mtot_iva_venta = 0;

    var tipoDoc = document.getElementById('tipoDoc').value

    for (i = 0; i < n; i++) {

      if ($("input[name='fk_inventario[" + i + "]']") != null) {
        var tipoVentaA = $("select[name='tipoVenta[" + i + "]']").val();
        var fk_inventarioA = $("input[name='fk_inventario[" + i + "]']").val();
        var costoA = parseFloat($("input[name='costo[" + i + "]']").val());
        var cantidadA = parseInt($("input[name='cantidad[" + i + "]']").val());
        var stockA = parseInt($("input[name='stock[" + i + "]']").val());

        if (cantidadA > stockA) {
          $("input[name='cantidad[" + i + "]']").val("");
          alert("la cantidad supera la existencia");
          return 0;
        }
        console.log("fcalculo", fk_inventarioA)
        console.log("fcalculo", costoA)
        console.log("fcalculo", cantidadA)
        console.log("fcalculo", cantidadA)

        //validar que los campos anteriores esten llenos
        if (fk_inventarioA === "" || costoA == 0 || cantidadA == 0) {

          if (valido == 1) {
            alert("Debe llenar los demas campos");
            //tipoVentaA = "";
          }
          $("select[name='tipoVenta[" + i + "]']").val("")
        } else { //por lo tanto los campos estan llenos
          bi = costoA * cantidadA; //base imponible
          if (tipoVentaA == "NA_EX" || tipoVentaA == "NA_EXO" || tipoVentaA == "NA_NS" || tipoVentaA == "NA_SDCF") {
            disabledInputs(true)
            acum_msubt_exento_venta += bi;

          } else if (tipoVentaA == "NA_BI_12") {
            disabledInputs(true)
            acum_msubt_bi_iva_12 += bi;
            acum_iva_12 += bi * 0.12;

          } else if (tipoVentaA == "NA_BI_27") {
            disabledInputs(true)
            acum_msubt_bi_iva_27 += bi;
            acum_iva_27 += bi * 0.27;

          } else if (tipoVentaA == "NA_BI_8") {
            disabledInputs(true)
            acum_msubt_bi_iva_8 += bi;
            acum_iva_8 += bi * 0.08;

          } else if (
            tipoVentaA == "EX_EX" || tipoVentaA == "EX_EXO" || tipoVentaA == "EX_NS" ||
            tipoVentaA == "EX_SDCF") {

            disabledInputs(false)
            acum_msubt_exento_venta += bi;
          }

        }
      }
    }
    //END FOR
    document.form1.msubt_exento_venta.value = Math.round10(acum_msubt_exento_venta, -2);

    document.form1.msubt_bi_iva_12.value = Math.round10(acum_msubt_bi_iva_12, -2);
    document.form1.msubt_bi_iva_8.value = Math.round10(acum_msubt_bi_iva_8, -2);
    document.form1.msubt_bi_iva_27.value = Math.round10(acum_msubt_bi_iva_27, -2);

    msubt_tot_bi_venta = acum_msubt_bi_iva_12 + acum_msubt_bi_iva_27 + acum_msubt_bi_iva_8
    document.form1.msubt_tot_bi_venta.value = Math.round10(msubt_tot_bi_venta, -2);

    document.form1.iva_12.value = Math.round10(acum_iva_12, -2);
    document.form1.iva_8.value = Math.round10(acum_iva_8, -2);
    document.form1.iva_27.value = Math.round10(acum_iva_27, -2);

    tot_iva = acum_iva_12 + acum_iva_27 + acum_iva_8;
    document.form1.tot_iva.value = Math.round10(tot_iva, -2);

    document.form1.mtot_iva_venta.value = Math.round10(
      acum_msubt_exento_venta + msubt_tot_bi_venta + tot_iva, -2
    );
  }

  function tipoPago(str) {
    if (str == "C") {
      document.forms['form1'].elements['dias_venc'].required = true;
      document.forms['form1'].elements['dias_venc'].readOnly = null;
    } else { // if(str == "E"){
      document.forms['form1'].elements['dias_venc'].required = null;
      document.forms['form1'].elements['dias_venc'].readOnly = true;
    }
  }

  function vueltosPago(monto) {
    var mtot_iva_venta = parseFloat(document.forms['form1'].elements['mtot_iva_venta'].value);
    var monto_paga = parseFloat(monto);

    if (mtot_iva_venta > monto_paga) {
      document.getElementById('dvueltos').setAttribute("class", "form-group has-warning has-feedback");
      document.getElementById('svueltos').setAttribute("class", "glyphicon glyphicon-remove form-control-feedback");
    } else {
      document.getElementById('dvueltos').setAttribute("class", "form-group has-success has-feedback");
      document.getElementById('svueltos').setAttribute("class", "glyphicon glyphicon-ok form-control-feedback");
    }

    document.forms['form1'].elements['vueltos'].value = Math.round10(mtot_iva_venta - monto_paga, -2);
  }

  function generateNfact() {

    let body = {}

    body.destination = 'json';
    body.orderBy = ['serie_fact_venta', 'num_ctrl_factventa']
    body.limit = 1;

    $.ajax({
      type: 'POST',
      url: '/book-sales',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: body,
      success: function(data) {

        $("#serie_fact_venta").val(parseInt(data.data.fact_ventas.serie_fact_venta) + 1);
        $("#num_ctrl_factventa").val(parseInt(data.data.fact_ventas.num_ctrl_factventa) + 1);
      },
      beforeSend: function() {
        document.getElementById("generateNFact").disabled = true
      },
      complete: function() {
        document.getElementById("generateNFact").disabled = false
      },

    });
  }

  /**
   * vaidar factira repetido
   */
  function checkFactSalesExist() {

    $num_fact_venta = document.getElementById("num_fact_venta").value
    $num_ctrl_factventa = document.getElementById("num_ctrl_factventa").value

    if ($num_fact_venta && $num_ctrl_factventa) {

      $.ajax({
        type: 'GET',
        url: `/book-sales/${$num_fact_venta}/${$num_ctrl_factventa}`,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          if (data.data) {
            let className = document.getElementById("num_fact_venta").className;

            document.getElementById("num_fact_venta").setAttribute("class", "is-invalid " + className);
            document.getElementById("num_ctrl_factventa").setAttribute("class", "is-invalid " + className);

            $('#num_fact_venta').parent().append(`
            <div id="validationNumFactVentaFeedback" class="invalid-feedback">
              Los datos para FACTURA de VENTA ya existen en el sistema
            </div>
            `)
            $('#num_ctrl_factventa').parent().append(`
            <div id="validationNumCtrlFactventaFeedback" class="invalid-feedback">
              Los datos para FACTURA de VENTA ya existen en el sistema
            </div>
            `)

            alert("Los datos para FACTURA de VENTA ya existen en el sistema");
          } else {
            document.getElementById("num_fact_venta").classList.remove("is-invalid")
            document.getElementById("num_ctrl_factventa").classList.remove("is-invalid")

            document.getElementById("validationNumCtrlFactventaFeedback").remove();
            document.getElementById("validationNumFactVentaFeedback").remove();
          }
        },
        beforeSend: function() {
          document.getElementById("btnCargarVent").disabled = true
        },
        complete: function() {
          document.getElementById("btnCargarVent").disabled = false
        },

      });

    }
  }
</script>

<!-- modales -->
@include('modales.fact_v.m_b_fact_v')
@include('modales.cliente.m_b_cliente')
@include('modales.cliente.form_cliente')
@include('modales.prod.m_b_prod')
@include('modales.prod.m_PMPVJ')

<!-- //llamando de modales el id es "nueCliente"
include_once($extra . "modales/cliente/m_a_cliente.php");
//llamando de modales el id es "mmCliente"
include_once($extra . "modales/cliente/m_m_cliente.php");
//llamando de modales el id es "nueProd"
include_once($extra . "modales/prod/m_a_prod.php");
//llamando de modales el id es "mmProd"
include_once($extra . "modales/prod/m_m_prod.php"); -->

@endsection