<!-- Modal mostrarFact-->
<div id="mostrarFact" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="busFactLabel">Detalles de la Factura</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post">
        <div class="modal-body">

          <h4>Resultados</h4>

          <table class="table table-bordered">
            <thead>
              <tr>
                <td><b>ID de la Factura:</b>{{ $fact_compra->id }} </td>
              </tr>
              <tr>
                <td><b>Numero de la Factura:</b>{{ $fact_compra->num_fact_compra }}</td>
              </tr>
              <tr>
                <td><b>Serie de la Factura:</b>{{ $fact_compra->serie_fact_compra }}</td>
              </tr>
              <tr>
                <td><b>Fecha de la Compra:</b>{{ $fact_compra->fecha_fact_compra }}</td>
              </tr>
              <tr>
                <td><b>Monto Total con IVA:</b>{{ $fact_compra->mtot_iva_compra }}</td>
              </tr>
              <tr>
                <td><b>Codigo</b></td>
                <td><b>Nombre</b></td>
                <td><b>Descripci&oacute;n</b></td>
                <td><b>Costo</b></td>
                <td><b>Cantidad</b></td>
              </tr>
            </thead>
            <tbody>
              @foreach($fact_compra->compras as $compra)
              <tr>
                <td>{{ $compra->inventario->codigo }}</td>
                <td>{{ $compra->inventario->nombre_i }}</td>
                <td>{{ $compra->inventario->descripcion }}</td>
                <td>{{ $compra->costo }}</td>
                <td>{{ $compra->cantidad }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>

        </div><!--modal-bosy-->
      </form><!--mbprov-->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>