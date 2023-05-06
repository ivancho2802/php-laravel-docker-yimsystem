<?php include_once('../../includes_SISTEM/include_head.php');?>
<script>
//para desactivar el enter envie y cierre el modal
$(document).ready(function() {
	
	$(window.document).on('shown.bs.modal', '#busCliente', function() {
		window.setTimeout(function() {
			<?php include_once('../../includes_SISTEM/include_login.php'); ?>
			document.onkeypress = stopRKey;
			$('#b_Cliente', this).focus();
			
		}.bind(this), 100);
	});
	$('#busCliente').on('hidden.bs.modal', function (e) {
		document.onkeypress = !stopRKey;
		//loseFocus('b_prov');
		
	});
});
//para ver si existe el rif en el sistema
	function consulCliente(str){
	  var xhttp;
	  if (str.length == 0) {
		document.getElementById("resCliente").innerHTML = "Introduzca algo en el campo";
		return;
	  }
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  document.getElementById("resCliente").innerHTML = xhttp.responseText;
		}
	  };
		
		xhttp.open("POST", "<?php echo $extra?>modales/cliente/b_cliente.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("cliente="+ str);
	}

</script>
<!-- Modal nueCargo-->
                            <div id="busCliente" class="modal fade" role="dialog">
                              <div class="modal-dialog modal-lg">
                                <!-- Modal content-->
                                <div class="modal-content">
                                <form method="post">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Consulta del Cliente</h4>
                                  </div>
                                  <div class="modal-body">
                                      <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12" align="center">
                                                Nombre &oacute; Documento:<br />
                                                <input type="text" class="form-control" name="b_cliente" id="b_cliente" onKeyUp="consulCliente(this.value);" autocomplete="off" required>
                                                <br /><span>Presione Espacio para mostrar todos</span>
                                            </div>
                                            <div class="col-md-12 col-lg-12" id="resCliente">
                                            	
                                            </div>
                                        </div><!--row-->
                                      </div><!--form-group-->
                                  </div><!--modal-bosy-->
                                </form><!--mbprov-->
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                  </div>
                                </div>
                            
                              </div>
                            </div>