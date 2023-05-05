<!-- Modal nueCargo-->
<div id="calReten" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="busFactLabel">Calculo de Retencion de Venta</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form name="formcalReten" method="post">
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col">
                Total I.V.A.:<br>
                <input class="form-control" type="number" min="0" step="0.0000001" name="tot_iva" id="tot_iva" onKeyUp="calReten();" value="" required readonly="readonly">
              </div>
              <div class="col">
                Porcentaje:<br>
                <input class="form-control" type="number" min="0" step="0.0000001" name="porcentaje" id="porcentaje" onKeyUp="calReten();" value="0.75" required>
              </div>
              <div class="col">
                I.V.A. Retenido:<br>
                <input class="form-control" type="number" min="0" step="0.0000001" name="m_iva_reten" id="m_iva_reten" onKeyUp="calReten();" readonly="readonly">
              </div>
            </div><!--row-->
            <br />
          </div><!--form-group-->
        </div><!--modal-bosy-->
      </form><!--mbprov-->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="calReten();">Calcular</button>
        <button type="button" class="btn btn-success" onclick="SeleccalReten(document.forms['formcalReten'].elements['m_iva_reten'].value)" data-bs-dismiss="modal">Seleccionar</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<script>
  //para desactivar el enter envie y cierre el modal
  $(document).ready(function() {
    $(window.document).on('shown.bs.modal', '#calReten', function() {
      window.setTimeout(function() {
        $('#tot_iva', this).focus();
        calReten();
        document.onkeypress = stopRKey;
      }.bind(this), 100);
    });

    $('#calReten').on('hidden.bs.modal', function(e) {
      document.onkeypress = !stopRKey;
    });
  });

  //funcion calcular PMPVJ
  function calReten() {
    tot_iva = parseFloat(document.forms['formcalReten'].elements['tot_iva'].value);
    porcentaje = parseFloat(document.forms['formcalReten'].elements['porcentaje'].value);
    ////////////	BI		/////////////////
    document.forms['formcalReten'].elements['m_iva_reten'].value = Math.round10((tot_iva * porcentaje), -2);
  }

  function SeleccalReten(str) {
    document.getElementById("m_iva_reten").value = str;
  }
</script>