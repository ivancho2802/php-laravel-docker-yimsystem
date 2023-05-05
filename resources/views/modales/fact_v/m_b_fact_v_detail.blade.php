<!-- Modal mostrarFact-->
<div id="mostrarFact" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="busFactLabel">Detalles de la Factura</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post">
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-md-12 col-lg-12 text-center">
                <!--
                Numero de Factura:<br />
                <input type="text" name="b_fact" id="b_fact" onKeyUp="consulFact(this.value);" required>
                <br /><span>Presione Espacio para mostrar todos</span>
                -->
              </div>
              <div class="col-md-12 col-lg-12" id="resFact">
                <div class="">
                  <br>
                  <h4>Resultados</h4>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <td><b>ID de la Factura:</b>{{ $fact_venta->id }} </td>
                        <td><b>Numero de la Factura:</b>{{ $fact_venta->num_fact_venta }}</td>
                        <td><b>Serie de la Factura:</b>{{ $fact_venta->serie_fact_venta }} </td>
                        <td><b>Fecha de la venta:</b>{{ $fact_venta->fecha_fact_venta }} </td>
                        <td><b>Monto Total con IVA:</b>{{ $fact_venta->mtot_iva_venta }} </td>
                      </tr>
                      <tr>
                        <td colspan="5">&nbsp;</td>
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
                      @foreach($fact_venta->ventas as $venta)
                      <tr>
                        <td>{{ $venta->inventario->codigo }}</td>
                        <td>{{ $venta->inventario->nombre_i }}</td>
                        <td>{{ $venta->inventario->descripcion }}</td>
                        <td>{{ $venta->costo }}</td>
                        <td>{{ $venta->cantidad }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!--row-->
          </div><!--form-group-->
        </div><!--modal-bosy-->
      </form><!--mbprov-->
      <div class="modal-footer">

        <form target="_blank" id="form2" name="form2" action="/book-fact-sales-print-report" method="POST">
          @csrf
          <input name="id_fact_venta" type="hidden" value="{{$fact_venta->id}}" />

          <div class="input-group">
            <button class="btn btn-danger  col-6" type="submit" name="type" value="pdf">
              <i class="fa fa-file-pdf-o fa-lg text-light" title="PDF" description="PDF"></i>
            </button>
          </div>
        </form>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>