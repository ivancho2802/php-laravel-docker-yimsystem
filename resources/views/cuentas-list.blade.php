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
              <h5 class="mb-0">Todas las Cuentas </h5>
            </div>
            <a data-bs-target="#addCuenta" data-bs-toggle="modal" class="btn bg-gradient-primary btn-sm mb-0" type="button">
              +&nbsp; Agregar Plan de Cuentas
            </a>
          </div>

        </div>

        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">

            <label for="campo" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="table-responsive">
                <table class="table table-bordered align-items-center mb-0">
                  <thead class="titulo text-sm">
                    <tr>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>T.S.C.</th>
                      <th>Naturaleza</th>
                      <th>Auxiliar</th>
                      <th>Acci&oacute;n</th>
                    </tr>
                  </thead>
                  <tbody class="text-center text-sm">
                    @forelse ($cuentas as $cuenta)
                    <tr>
                      <td>{{$cuenta->id_plancuenta}}  </td>
                      <td>{{$cuenta->nom_plancuenta}} </td>
                      <td>{{$cuenta->tsc}} </td>
                      <td>{{$cuenta->natu}}</td>
                      <td>{{$cuenta->aux}} </td>
                      <td>
                        <input type="button" class="btn btn-warning" onClick="location.href='g_plan_cuentas.php?id_plancuenta={{$cuenta->id_plancuenta}}&accion=m'" value="Modificar" />
                        <input type="button" class="btn btn-danger" onClick="location.href='g_plan_cuentas.php?id_plancuenta={{$cuenta->id_plancuenta}}&accion=e'" value="Eliminar" />
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td class="text-center " colspan="9">Lo sentimos pero no hay resultados</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>

                {{  $cuentas->links() }}
              </div>
            </label>

          </div>
        </div>

      </div>


    </div>
  </div>
</div>

<script>
</script>

<!-- modales -->
<div id="zoneModalExtra"></div>

@include('modales.m_loading')
@include('modales.cuentas.m_a_cuenta')


@endsection