@extends('layouts.user_type.auth')

@section('content')

<div>
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

  <div class="row">
    <div class="col-12">
      <div class="card mb-4 mx-4">
        <div class="card-header pb-0">

          <!-- BOTONES ACCIONES -->
          <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-4">
            <button class="btn bg-gradient-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              <i class="fa fa-chevron-down" aria-hidden="true"></i>
              Busqueda
              <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </button>
            <form class="">
              @csrf
              <button class="btn bg-gradient-danger btn-sm" type="submit">
                Reiniciar y Actualizar datos
              </button>
            </form>

            <button class="btn bg-gradient-primary btn-sm" type="button" data-bs-toggle="modal" href="#nueProd">
              +&nbsp; Cargar Inventario
            </button>

            <button class="btn bg-gradient-primary btn-sm" type="button" data-bs-toggle="modal" href="#retriveProd">
              -&nbsp; Cargar Retiros del Inventario
            </button>

          </div>
          <!-- END BOTONES ACCIONES -->

          <!-- FORMULARIO CONSULTA -->
          <div class="collapse" id="collapseExample">
            <div class="card mb-4">

              <form class=" card-body">
                @csrf
                <div class="row">
                  <div class="col-xs-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label class="control-label">Consulta Por Dia</label>
                      <div class="input-group">
                        <input type="date" class="form-control" name="dia" value="{{ $dia ?? ''}}" />
                      </div>
                    </div>
                  </div><!--col-->
                  <div class="col-xs-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label class="control-label">Consulta Por Mes</label>
                      <div class="input-group">
                        <input type="month" class="form-control" name="mes" value="{{ $mes ?? ''}}" />
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-4 col-lg-4">
                    <div class="form-group">
                      <label class="control-label">Consulta Por A&ntilde;o</label>
                      <div class="input-group">
                        <input type="number" class="form-control" min="1500" max="9999" name="ano" value="{{ $ano ?? ''}}" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12 col-md-12 col-lg-12">

                    <div class="form-group">
                      <label class="control-label">Consulta Por Rango</label>
                      <div class="input-group">
                        <span class="input-group-text bg-secondary">Fecha Inicio:</span>
                        <input type="date" class="form-control" name="date_from" onblur=" validarFecha(this.value,document.forms['form_rang'].elements['fechaf'].value)" value="{{$dateFrom ?? ''}}" />
                        <span class="input-group-text bg-secondary">Fecha Final:</span>
                        <input type="date" class="form-control" name="date_to" onblur="validarFecha(document.forms['form_rang'].elements['fechai'].value, this.value)" value="{{$dateTo ?? ''}}" />
                      </div>
                    </div>
                  </div>


                  <div class="col-xs-12 col-md-12 col-lg-12">

                    <div class="form-group">
                      <label class="control-label">Consulta Por Nombre o Codigo</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="prod" value="{{$prod ?? ''}}" />
                      </div>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col">
                    <button type="submit" class="btn btn-primary">
                      Buscar Movimiento!
                    </button>
                  </div>
                  <div class="col">
                    <button type="button" class="btn btn-danger" data-bs-toggle="collapse" data-bs-target="#collapseExample">Cancelar</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- END FORMULARIO CONSULTA -->

        </div>

      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-12">

      <div class="card mb-4 mx-4">
        <div class="row">
          <div class="col-xs-12 col-lg-12 btn-group d-grid gap-2 p-4">
            <!-- reporte_inventario.php?id= $inv_cod -->
            <!-- ../res_reporte/reporte_excel_mov_unidad.php -->

            <!-- reporte_pdf_mov_unidad.php  -->

            <div class="btn-group">
              <form class="form-control btn btn-sm btn-danger" target="_blank" name="formreport" method="post" action="/inventario-report" class="d-grid gap-2">

                <button class="btn btn-clear m-0 " type="submit" name="report_pdf" value="pdf">
                  <span class="fa fa-file-pdf-o fs-5  text-light" title="pdf"></span>
                </button>

                @csrf
                @if(isset($mes))
                <input type="hidden" name="mes" value="{{$mes}}" />
                @elseif(isset($ano))
                <input type="hidden" name="ano" value="{{$ano}}" />
                @elseif(isset($date_from) && isset($date_to))
                <input type="hidden" name="date_from" value="{{$date_from}}" />
                <input type="hidden" name="date_to" value="{{$date_to}}" />
                @elseif(isset($dia))
                <input type="hidden" name="dia" value="{{$dia}}" />
                @endif

                @if(isset($prod))
                <input type="hidden" name="prod" value="{{$prod}}" />
                @endif

              </form>
              <form class="form-control btn btn-sm btn-success" target="_blank" name="formreport" method="post" action="/inventario-report" class="d-grid gap-2">

                @csrf
                @if(isset($mes))
                <input type="hidden" name="mes" value="{{$mes}}" />
                @elseif(isset($ano))
                <input type="hidden" name="ano" value="{{$ano}}" />
                @elseif(isset($date_from) && isset($date_to))
                <input type="hidden" name="date_from" value="{{$date_from}}" />
                <input type="hidden" name="date_to" value="{{$date_to}}" />
                @elseif(isset($dia))
                <input type="hidden" name="dia" value="{{$dia}}" />
                @endif

                @if(isset($prod))
                <input type="hidden" name="prod" value="{{$prod}}" />
                @endif
                <button class="btn btn-clear m-0" type="submit" name="report_excel" value="excel">
                  <span class="fa fa-file-excel-o fs-5 text-light" title="EXCEL"></span>
                </button>

              </form>
            </div><!--input-group-->

          </div>
        </div>

      </div>
    </div>

  </div>

  <x-prod.prods-table dateFrom="{{$date_from ?? ''}}" dateTo="{{$date_to ?? ''}}" dateBegin="{{$dateBegin}}" dateEnd="{{$dateEnd}}" :empre="$empre" :inventarios="$inventarios" :inventarioInicialAcum="$inventarioInicialAcum" mes="{{$mes ?? ''}}" dia="{{$dia ?? ''}}" ano="{{$ano ?? ''}}" type="{{$type ?? ''}}" prod="{{$prod ?? ''}}" />

</div>

<script>
  $(document).ready(function() {
    //alert()
    hoverScrool('#btn-res_movUnidades');
  });

  /**
   * validaciones
   */
  function validarFecha(fechai, fechaf) {

    if (fechai !== "" && fechaf !== "") {
      if (fechai > fechaf) {
        alert('Atencion la Fecha Inicial debe ser Menor a la Fecha Final');
        document.forms['form_rang'].elements['fechai'].value = "";
        document.forms['form_rang'].elements['fechaf'].value = "";
        return 0;
      } else if (fechaf < fechai) {
        alert('Atencion la Fecha Final debe ser Mayor a la Fecha Final');
        document.forms['form_rang'].elements['fechai'].value = "";
        document.forms['form_rang'].elements['fechaf'].value = "";
        return 0;
      }
    }
  }
</script>
<!-- MODALALES -->

@include('modales.prod.inventario_retiro')
@include('modales.prod.m_a_prod')
@include('modales.prod.m_b_prod')
@include('modales.prod.m_PMPVJ')

@endsection