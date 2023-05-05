@extends('layouts.user_type.auth')

@section('content')

<div class="bs-example" id="cargarVenta">

  <div class="alert alert-secondary mx-4" role="alert">
    <span class="text-white">
      <strong>Agrega caracteristicas</strong>
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
      <h6 class="mb-0">{{ __('Informacion de Inventario') }}</h6>
    </div>

    <form id="form1" name="form1" method="POST" action="/inventario-add">

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
          <input type="number" min="0" name="num_fact_venta" class="form-control" value="" size="20" required="required" value="{{ $factVenta['num_fact_venta'] ?? '' }}" />
        </div>

        <div class="col-xs-4 col-md-4 col-lg-4">
          <label>N° Control:</label><br>
          <input type="text" class="form-control" name="num_ctrl_factventa" id="num_ctrl_factventa" value="{{ $factVenta['num_ctrl_factventa'] ?? '' }}" size="20" />
        </div>

      </div><!--row-->

      <hr id="res_cargarVenta" class="featurette-divider">
      <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
          <button type="submit" class="btn btn-lg btn-success col-xs-12 col-md-12 col-lg-12">Agregar Inventario</button>
        </div>
      </div><!--row-->

    </form>
  </div><!--bs-marco- -->
</div><!--cargarVenta-->

<div id="zoneModalExtra"></div>

<script>
  
</script>

<!-- modales -->
<!-- @include('modales.fact_v.m_b_fact_v')
@include('modales.cliente.m_b_cliente')
@include('modales.prod.m_b_prod')
@include('modales.prod.m_PMPVJ') -->

@endsection