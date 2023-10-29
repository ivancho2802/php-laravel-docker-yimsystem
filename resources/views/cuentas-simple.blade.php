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

  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <div class="d-flex flex-row justify-content-between">
            <div>
              <h5 class="mb-0">Todas las Cuentas </h5>
            </div>
          </div>

        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">

            @if($cuentas->count()==0)
            <div class="m-3  alert alert-warning alert-dismissible fade show" id="alert-warning" role="alert">
              <span class="alert-text text-white">
                No hay resultados 
              </span>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="fa fa-close" aria-hidden="true"></i>
              </button>
            </div>
            @else
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th><b>ID de la Cuenta</b></th>
                  <th><b>Nombre de la Cuenta</b></th>
                  <th><b>TSC</b></th>
                  <th><b>Naturaleza</b></th>
                </tr>
              </thead>

              <tbody>
                @foreach ($cuentas as $cuenta)

                <tr>
                  <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">{{ $cuenta->id_plancuenta }}</p>
                  </td>

                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $cuenta->nom_plancuenta }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $cuenta->tsc }}
                    </span>
                  </td>
                  <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">
                      {{ $cuenta->natu }}
                    </p>
                  </td>
                </tr>
                @endforeach

              </tbody>
            </table>
            
            {{  $cuentas->links() }}
            
            @endif


          </div>
        </div>
      </div>
    </div>
  </div>
</div>