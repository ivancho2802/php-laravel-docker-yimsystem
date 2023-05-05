<!-- Modal nueCargo-->
<div id="calPMPVJ" class="modal fade" role="dialog" aria-hidden="true" aria-labelledby="calPMPVJLabel2" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="busProdLabel">Calculo de Precio de Venta</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form name="formPMPVJ" method="post">
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-md-4 col-lg-4">
                Costo Actual:<br>
                <input class="form-control" type="number" min="0" step="0.0000001" name="costoActual" id="costoActual" onKeyUp="calPMPVJ();" value="" required readonly="readonly">
              </div>
              <div class="col-md-4 col-lg-4">
                Utilidad:<br>
                <input class="form-control" type="number" min="0" step="0.0000001" name="utilidad" id="utilidad" onKeyUp="calPMPVJ();" value="0.33" required>
              </div>
              <div class="col-md-4 col-lg-4">
                Precio de Venta:<br>
                <input class="form-control" type="number" min="0" step="0.0000001" name="precio_venta" id="precio_venta" onKeyUp="calPMPVJ();" readonly="readonly">
              </div>
            </div><!--row-->
            <br />
          </div><!--form-group-->
        </div><!--modal-bosy-->
      </form><!--mbprov-->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="calPMPVJ();">Calcular</button>
        <button type="button" id="btnSelectPrice" class="btn btn-success" onclick="SelecPMPVJ(document.forms['formPMPVJ'].elements['precio_venta'].value)" data-bs-dismiss="modal">Seleccionar</button>
        <button type="button" id="btnCancelPrice" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>
<script>
  //para desactivar el enter envie y cierre el modal
  document.getElementById('calPMPVJ').addEventListener('hidden.bs.modal', function(e) {
    document.onkeypress = !stopRKey;
  });

  document.getElementById('calPMPVJ').addEventListener('show.bs.modal', function() {
    document.onkeypress = stopRKey;
    document.getElementById('utilidad').focus();
    //origen
    let urlCurrent = window.location.href
    let origin = urlCurrent.split('/')
    const urlActual = origin[origin.length - 1]

    const inventaryalist = '<?php echo \App\Models\Inventario::INVENTARYLIST; ?>'

    if (!urlActual.includes(inventaryalist)) {
      $("form[name='formPMPVJ']").find("#costoActual").val(
        $("#form1").find("[name='costo[" + formProdCurrent + "]']").val() ||
        $("#formProds").find("[name='costo[" + formProdCurrent + "]']").val()
      )
    } else {
      formProdCurrent = 0;
    }

    calPMPVJ();
  });

  /**
   * funcion calcular PMPVJ
   */
  function calPMPVJ() {
    costoActual = parseFloat(document.forms['formPMPVJ'].elements['costoActual'].value);
    utilidad = parseFloat(document.forms['formPMPVJ'].elements['utilidad'].value);
    ////////////	BI		/////////////////
    document.forms['formPMPVJ'].elements['precio_venta'].value =
      Math.round10(((costoActual * utilidad) + costoActual), -2);
  }
  //calculo del pmvpj vs utilidd
  function SelecPMPVJ(strI) {
    //extraer formProdCurrent de la forma en que lo he usado
    $("#form1 input[name='pmpvj[" + formProdCurrent + "]'").val(strI)
    $("#formProds input[name='pmpvj[" + formProdCurrent + "]'").val(strI)
    
  }
</script>