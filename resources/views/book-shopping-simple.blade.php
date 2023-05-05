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

  @if(isset($tipo_trans))
  <div class="m-3  alert alert-warning alert-dismissible fade show" id="alert-warning" role="alert">
    <span class="alert-text text-white">
      Esta factura YA POSEE RETENCION Si continua se MODIFICARAN LOS DATOS {{$tipo_trans}}</span>
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
              <h5 class="mb-0">Todas las Compras [{{ $date_from }} - {{ $date_to }}] </h5>
            </div>
          </div>

        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">

            @if($fact_compras->count()==0)
            <div class="m-3  alert alert-warning alert-dismissible fade show" id="alert-warning" role="alert">
              <span class="alert-text text-white">
                No hay resultados La Factura Debe Existir en el Sistema
              </span>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="fa fa-close" aria-hidden="true"></i>
              </button>
            </div>
            @else
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th><b>Accion</b></th>
                  <th><b>ID de la Factura</b></th>
                  <th><b>Numero de la Factura</b></th>
                  <th><b>Serie de la Factura</b></th>
                  <th><b>Fecha de la Compra</b></th>
                  <th><b>Rif del Proveedor</b></th>
                  <th><b>Nombre del Proveedor</b></th>
                </tr>
              </thead>

              <tbody>
                @foreach ($fact_compras as $fact_compra)

                <tr>

                  <td class="text-center">
                    @if ($origin == "book-shopping-reten-add")
                    <button type="button" class="btn btn-warning" onClick="
                      selecFactCM('{{$fact_compra->id}}',
                      '{{$fact_compra->num_fact_compra}}',
                      '{{$fact_compra->serie_fact_compra}}',
                      '{{$fact_compra->nombre}}',
                      '{{$fact_compra->tot_iva}}',
                      '{{$fact_compra->m_iva_reten}}',
                      '{{$fact_compra->mes_apli_reten}}',
                      '{{$fact_compra->num_compro_reten}}',
                      '{{$fact_compra->fecha_compro_reten}}');" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#busFact">
                      Seleccionar
                    </button>
                    @elseif ($origin == "book-shopping-edit")
                    <button type="button" class="btn btn-warning" onClick="
                      selecFactMF('{{$fact_compra->id}}',
                      '{{$fact_compra->num_fact_compra}}',
                      '{{$fact_compra->serie_fact_compra}}',
                      '{{$fact_compra->nombre}}',
                      '{{$fact_compra->fk_proveedor}}',
                      '{{$fact_compra->mtot_iva_compra}}',
                      '{{$fact_compra->tipo_fact_compra}}',
                      '{{$fact_compra->num_ctrl_factcompra}}',
                      '{{$fact_compra->fecha_fact_compra}}',
                      '{{$fact_compra->tipo_trans}}');" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#busFact">
                      Seleccionar
                    </button>
                    @else
                    <button type="button" class="btn btn-warning" onClick="
                      selecFactC('{{$fact_compra->id}}');" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#busFact">
                      Seleccionar
                    </button>
                    @endif

                  </td>
                  <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">{{ $fact_compra->id }}</p>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->num_fact_compra }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->serie_fact_compra }}
                    </span>
                  </td>
                  <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">
                      {{ date('j F, Y', strtotime($fact_compra->fecha_fact_compra)) }}
                    </p>
                  </td>
                  <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">{{ $fact_compra->rif }}</p>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ $fact_compra->nombre }}</span>
                  </td>
                </tr>
                @endforeach

              </tbody>
            </table>
            @endif
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>