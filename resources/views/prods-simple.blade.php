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
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex flex-row justify-content-between">
          <div>
            <h5 class="mb-0">Todas los Productos </h5>
          </div>
        </div>

      </div>
      <div class="card-body px-0 pt-0 pb-2">
        @if($inventarios->count()==0)
        <div class="m-3  alert alert-warning alert-dismissible fade show" id="alert-warning" role="alert">
          <span class="alert-text text-white">
            No hay resultados
          </span>

          @if (stripos($origin, "sale"))
          Lo sentimos pero Debe <br>
          AGREGAR el PRODUCTO por <br>
          COMPRAS o como INVENTARIO INICIAL
          @elseif (stripos($origin, "shopping"))
          <input type="button" class="btn btn-success" value="Agregar y Seleccionar Producto" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#nueProd">
          @endif

          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <i class="fa fa-close" aria-hidden="true"></i>
          </button>
        </div>
        @else
        <div class="table-responsive p-0">
          <table class="table table-bordered">
            <thead>
              <tr>
                <td><b>Nombre</b></td>
                <td><b>Codigo</b></td>
                <td><b>Descripcion</b></td>
                <td><b>
                    @if (isset($tipoDoc) && ($tipoDoc == "NC-DESC" || $tipoDoc == "NC-DEVO" || $tipoDoc == "ND"))
                    Cantidad
                    @else
                    Stock
                    @endif
                  </b>
                </td>
                <td><b>
                    @if (isset($tipoDoc) && ($tipoDoc == "NC-DESC" || $tipoDoc == "NC-DEVO" || $tipoDoc == "ND"))
                    Costo
                    @else
                    Precio de Venta /<br> Costo Promediado
                    @endif
                  </b></td>
                <td><b>Fecha de Insercion</b></td>
                <td><b>Accion</b></td>
              </tr>
            </thead>

            <tbody>
              @foreach ($inventarios as $prod)
              <tr>
                <td>{{$prod->nombre_i}}</td>
                <td>{{$prod->id}}</td>
                <td>{{$prod->descripcion}}</td>
                <td>{{$prod->stock}}</td>
                <!-- <td> $cantidadstock </td> -->
                <td>{{$prod->valor_unitario}}</td>
                <!-- <td>round($td_costo, 2)</td> -->
                <td>{{$prod->fecha}}</td>
                <td>
                  <span class="btn-group">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal" id="selectbusProd" data-bs-asd="{{$prod->id}}" data-asd="{{$prod->id}}" onClick="selecProd(
                    '{{$prod->id}}',
                    '{{$prod->codigo}}',
                    '{{$prod->nombre_i}}',
                    '{{$prod->valor_unitario}}',
                    '{{$prod->stock}}');">
                      Seleccionar
                    </button>

                    <button type="button" class="btn btn-warning" onClick="showModalEditProd(this)" data-id="{{$prod}}">
                      Modificar</button>
                  </span>
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