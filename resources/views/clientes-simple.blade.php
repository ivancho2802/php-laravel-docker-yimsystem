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
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex flex-row justify-content-between">
          <div>
            <h5 class="mb-0">Todas los Clientes </h5>
          </div>
        </div>

      </div>
      <div class="card-body px-0 pt-0 pb-2">
        @if($clientes->count()==0)
        <div class="m-3  alert alert-warning alert-dismissible fade show" id="alert-warning" role="alert">
          <span class="alert-text text-white">
            No hay resultados
          </span>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <i class="fa fa-close" aria-hidden="true"></i>
          </button>
        </div>
        @else
        <div class="table-responsive p-0">
          <table class="table table-bordered">

            <thead>
              <tr>
                <td><b>Nombre del Cliente</b></td>
                <td><b>Cedula del Cliente</b></td>
                <td><b>Tipo de Contribuyente</b></td>
                <td><b>Accion</b></td>
              </tr>
            </thead>
            <tbody>
              @foreach ($clientes as $cliente)


              <tr>
                <td>{{$cliente->nom_cliente}}</td>
                <td>{{$cliente->ced_cliente}}</td>
                <td>{{$cliente->contri_cliente}}</td>

                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-info" onClick="
                      selecCliente('{{$cliente->id}}',
                      '{{$cliente->ced_cliente}}',
                      '{{$cliente->nom_cliente}}',
                      '{{$cliente->contri_cliente}}');" data-bs-dismiss="modal" required="required">
                      Seleccionar
                    </button>

                    <button type="button" class="btn btn-warning"
                    onClick="showModalEditCliente(this)"
                    data-id="{{$cliente}}"
                    >
                      Modificar
                    </button>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif

      </div>
    </div>
  </div>
</div>
