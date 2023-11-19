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
            <a onClick="showModalEditCuenta(this)" data-id="" class="btn bg-gradient-primary btn-sm mb-0" type="button">
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
                      <th>Acci&oacute;n</th>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>T.S.C.</th>
                      <th>Naturaleza</th>
                      <th>Auxiliar</th>
                    </tr>
                  </thead>
                  <tbody class="text-center text-sm">
                    @forelse ($cuentas as $cuenta)
                    @if(!$cuenta->empreplancuenta || (isset($cuenta->empreplancuenta) ? $cuenta->empreplancuenta->status : true) === true)
                    <tr>

                      <td class="text-center">

                        <button type="button" class="btn  btn-warning btn-sm" onClick="showModalEditCuenta(this)" data-id="{{$cuenta}}">
                          <i alt="Modificar Cuenta" class="fas fa fa-edit  text-sm" description="Editar compra"></i>
                        </button>

                        <!-- Eliminar Factura de Compras -->
                        <!--  data-bs-target="#confirmDeleteModal" data-bs-id="{{$cuenta->id}}" -->
                        <button class="btn btn-danger btn-sm" onClick="showModalDeleteCuenta(this)" data-id="{{$cuenta}}">
                          <i alt="Eliminar Cuenta" class="cursor-pointer fas fa fa-trash text-sm"></i>
                        </button>

                      </td>
                      <td>{{$cuenta->id_plancuenta}} </td>
                      <td>{{$cuenta->nom_plancuenta}} </td>
                      <td>{{$cuenta->tsc}} </td>
                      <td>{{$cuenta->natu}}</td>
                      <td>{{$cuenta->aux}} </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                      <td class="text-center " colspan="9">Lo sentimos pero no hay resultados</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>

                {{ $cuentas->links() }}
              </div>
            </label>

          </div>
        </div>

      </div>


    </div>
  </div>
</div>

<script>
  var cuentaToUpdate

  function showModalEditCuenta(btn) {

    console.log("btn", btn)
    cuentaToUpdate = $(btn).data('id');
    console.log("cuentaToUpdate", cuentaToUpdate)

    var modalEditcuenta = new bootstrap.Modal(document.getElementById('addCuenta'), {
      keyboard: false
    })
    modalEditcuenta.show()

  }

  function showModalDeleteCuenta(btn) {


    console.log("btn", btn)
    let cuentaToDeleted = $(btn).data('id');
    console.log("cuentaToDeleted", cuentaToDeleted);
    console.log("cuentaToDeleted", cuentaToDeleted.id);

    delete cuentaToDeleted.created_at;
    delete cuentaToDeleted.updated_at;
    delete cuentaToDeleted.empreplancuenta;

    let values = Object.values(cuentaToDeleted);
    let keys = Object.keys(cuentaToDeleted);

    let contentResponse = "";

    for (let index = 0; index < values.length; index++) {
      const value = values[index];
      const key = keys[index];

      contentResponse += " " + key + ": " + value + "\n";

    }

    let msgConfirm = "Estas Seguro que quieres eliminar " + contentResponse;

    if (confirm(msgConfirm) == true) {
      loading(true);
      deleleCuenta(cuentaToDeleted);
    }

    /* var modalEditcuenta = new bootstrap.Modal(document.getElementById('addCuenta'), {
      keyboard: false
    });

    modalEditcuenta.show() */

  }

  function deleleCuenta(cuentaToDeleted) {

    let id = cuentaToDeleted.id;

    $.ajax({
      type: 'DELETE',
      url: '/cuentas-delete/' + id,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        loading(false);

        let html = `
            <div class="alert alert-success">
              Operacion hecha con exito
            </div>
            `;
        alertYim(true, html);

        console.log("data", data)

      },
      beforeSend: function(data) {
        $('#btnaddCuenta').prop('disabled', true)
      },
      complete: function() {
        $('#btnaddCuenta').prop('disabled', false)
        loading(false);
        let origin = window.location.origin
        window.location.replace(origin + '/cuentas-list');
      },
      error: function(data) {

        let html = `
          <div class="alert alert-danger">
            Lo sentimos No fue posible realizar la operacion Cliente
            ${data.responseJSON.message}
          </div>
          `;
        $("#txtEdomodaddCuenta").append(html)
        $('#btnaddCuenta').prop('disabled', false)
      },

    });
  }
</script>

<!-- modales -->
<div id="zoneModalExtra"></div>

@include('modales.m_loading')
@include('modales.m_alert')
<!-- modal para agregar cuena -->
<!-- modal para modificar cuena -->
@include('modales.cuentas.m_a_cuenta')

@endsection