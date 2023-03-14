<?php include_once('../../includes_SISTEM/include_head.php');?>
<script>
<?php
//inicializar variable del campo actual ya que no se recibe en todos lados
$urlActual = $_SERVER['REQUEST_URI'];
//echo $urlActual;
if( stristr($urlActual, "cargarInvent") == true){
	$numCampoActual = "''";
}else
	$numCampoActual = "document.form1.numCampoActual.value";
?>
//para desactivar el enter envie y cierre el modal
$(document).ready(function() {
	$(window.document).on('shown.bs.modal', '#calPMPVJ', function() {
		window.setTimeout(function() {
			/*
			$.ajax({
				type: "POST",
				url: "../../includes_SISTEM/include_login.php",
				//data: dataString,
				success: function(data) {
					
					document.write(data);
					//alert(data);
				}
			});
			*/
			//if(acceso == 0)
				//window.locationf="<?php //echo "http://$host$urlPrev";?>";
			
			$('#utilidad', this).focus();
			url = '<?php echo $_SERVER['REQUEST_URI'];?>';
			patron1 = 'cargarInvent';
			
			if(url.search(patron1) >= 0){
				calPMPVJ();
			}else{
				document.forms['formPMPVJ'].elements['costoActual'].value = document.form1.elements['costo'+numCampoActual].value;
				calPMPVJ();
			}
		}.bind(this), 100);
	});	
	$('#calPMPVJ').on('show.bs.modal', function (e) {
		document.onkeypress = stopRKey;
		
	});
	$('#calPMPVJ').on('hidden.bs.modal', function (e) {
		document.onkeypress = !stopRKey;
		
	});
});

//funcion calcular PMPVJ
function calPMPVJ(){
	costoActual = parseFloat(document.forms['formPMPVJ'].elements['costoActual'].value);
	utilidad = parseFloat(document.forms['formPMPVJ'].elements['utilidad'].value);
																	////////////	BI		/////////////////
	document.forms['formPMPVJ'].elements['precio_venta'].value = Math.round10( ((costoActual * utilidad) + costoActual),-2 );
}

</script>
<!-- Modal nueCargo-->
<div id="calPMPVJ" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <form name="formPMPVJ" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Calculo de Precio de Venta</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    Costo Actual:<br>
                    <input class="form-control" type="number" min="0" step="0.0000001" name="costoActual" id="costoActual" onKeyUp="calPMPVJ();"  value="" required readonly="readonly">
                </div>
                <div class="col-md-4 col-lg-4">
                    Utilidad:<br>
                    <input class="form-control" type="number" min="0" step="0.0000001" name="utilidad" id="utilidad" onKeyUp="calPMPVJ();" value="0.33" required>
                </div>
                <div class="col-md-4 col-lg-4">
                    Precio de Venta:<br>
                    <input class="form-control" type="number" min="0" step="0.0000001" name="precio_venta" id="precio_venta" onKeyUp="calPMPVJ();"  readonly="readonly">
                </div>
            </div><!--row-->
            <br />
          </div><!--form-group-->
      </div><!--modal-bosy-->
    </form><!--mbprov-->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="calPMPVJ();">Calcular</button>
      	<button type="button" class="btn btn-success" onclick="SelecPMPVJ(document.forms['formPMPVJ'].elements['precio_venta'].value ,<?php echo $numCampoActual;?>)" data-dismiss="modal">Seleccionar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>