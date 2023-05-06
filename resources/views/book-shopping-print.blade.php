@extends('layouts.user_type.auth')

@section('content')

<div>
  <div class="alert alert-secondary mx-4" role="alert">
    <span class="text-white">
      <strong>Reimprimir Comprobante de Retenci&oacute;n [{{ $date_from }} - {{ $date_to }}] </strong>
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

  <div class="row">
    <div class="col-12">
      <div class="card mb-4 mx-4">

        <div class="card-header pb-0">
          <!--header-->
          <div class="d-flex flex-row justify-content-between">
            <div class="row">
              <div class="col">

                <div>{{ $empre->titular_rif_empre }} - {{ $empre->nom_empre }}</div>
                <div>{{ $empre->rif_empre }}</div>
                <div>Direcci&oacute;n: &nbsp;{{ $empre->dir_empre }}</div>
                <div>Contribuyente {{ $empre->contri_empre }}</div>
                <!-- funcion para convertir la fechaa mes en letras y ano -->
                <div>
                  Comprobantes de Retencion Correspondiente Al Mes De {{ date('F', strtotime($date_from)) }}
                </div>

              </div>
            </div>
          </div>
          <!--header-->
        </div>

        <div class="card-body px-0 pt-0 pb-2">
          <div class="row">

            <div class="col-xs-6 col-md-6 col-lg-6">
              <form id="form1" name="form1" method="POST" action="/book-shopping-print">
                @csrf

                <div class="m-3">
                  <label for="exampleFormControlInput1" class="form-label">Consulta Por Mes:</label>

                  <span class="input-group">
                    <input type="month" name="mes" class="form-control" value="<?php if (isset($_POST['mes'])) echo $_POST['mes']; ?>" required="required" />
                    <input class="form-control btn btn-primary m-0" type="submit" value="Buscar Comprobante">
                  </span>

                </div>

              </form>
            </div>

            <div class="col-xs-6 col-md-6 col-lg-6">
              <form id="form2" name="form2" method="POST" action="/book-shopping-print">
                @csrf

                <div class="m-3">
                  <label for="exampleFormControlInput1" class="form-label">Consulta por Numero de Comprabante:</label>

                  <span class="input-group">
                    <input type="text" name="query[num_compro_reten]" id="query[num_compro_reten]" class="form-control" value="<?php if (isset($_POST['query[num_compro_reten]'])) echo $_POST['query[num_compro_reten]']; ?>" lang="si-num_compro_reten" required="required" />
                    <input class="form-control btn btn-primary m-0" type="submit" value="Buscar Comprobante" onClick="consulReten(this.form)" value="Buscar Comprobante">
                  </span>

                </div>
              </form>
            </div>

          </div>

          <div class="row m-3">

            <div class="table-responsive p-0">
              <table class="table table-bordered align-items-center mb-0">
                <thead>

                  <tr class="titulo">
                    <td rowspan="2"><b>ACCIONES</b></td>
                    <td colspan="4"><b>Comprobante de Retencion</b></td>
                    <td colspan="2"><b>Datos Proveedor</b></td>
                    <!--ACCIONES-->
                  </tr>
                  <tr class="titulo">
                    <td><b>Numero</b></td>
                    <td><b>Fecha</b></td>
                    <td><b>Monto I.V.A. Retenido</b></td>
                    <td><b>Mes de Aplicacion</b></td>
                    <!--proveedor-->
                    <td><b>R.I.F.</b></td>
                    <td><b>Razon Social</b></td>
                    <!--ACCIONES-->
                  </tr>

                </thead>

                <tbody>

                  @if ($fact_compras->count()==0)
                  <tr>
                    <td class="text-center " colspan="9">Lo sentimos pero no hay resultados</td>
                  </tr>
                  @endif

                  @foreach ($fact_compras as $fact_compra)

                  <tr>
                    <!--ACCIONES-->
                    <td>
                      <form target="_blank" id="form1" name="form1" action="/book-shopping-print-report" method="POST">
                        @csrf

                        <input name="num_compro_reten" type="hidden" value="{{$fact_compra->num_compro_reten}}" />
                        <label class="m-0" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $fact_compra->num_compro_reten ?? 'Este documento no tiene numero' }}">
                          <button class="btn btn-danger" type="submit" {{ $fact_compra->num_compro_reten ?? 'disabled' }}>
                            <i class="fa fa-file-pdf-o fa-lg" title="PDF" description="PDF"></i>
                          </button>
                        </label>
                      </form>
                    </td>
                    <!--Numero de Operqciones-->
                    <td>{{ $fact_compra->num_compro_reten }} </td>
                    <td>{{ date('j F, Y', strtotime($fact_compra->fecha_compro_reten)) }} </td>
                    <td>{{ number_format((float)$fact_compra->m_iva_reten, 2) }} </td>
                    <td>{{ $fact_compra->mes_apli_reten }} </td>
                    <!--PROVEEDOR-->
                    <td>{{ $fact_compra->proveedor->rif }} </td>
                    <td>{{ $fact_compra->proveedor->nombre }} </td>
                  </tr>

                  @endforeach

                </tbody>

              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL FOR CONFIRMATION DELETE -->

<!-- FIN MODAL FOR CONFIRMATION DELETE -->

@endsection