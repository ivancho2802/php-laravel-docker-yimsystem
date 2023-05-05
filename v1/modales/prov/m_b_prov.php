<?php include_once('../../includes_SISTEM/include_head.php');?>
<script>
//para desactivar el enter envie y cierre el modal
$(document).ready(function() {
	
	$(window.document).on('shown.bs.modal', '#busProv', function() {
		window.setTimeout(function() {
			//alert(<?php //echo $_SERVER['REQUEST_URI']?>);
			<?php include_once('../../includes_SISTEM/include_login.php'); ?>
			document.onkeypress = stopRKey;
			$('#b_Prov', this).focus();
			
		}.bind(this), 100);
	});
	$('#busProv').on('hidden.bs.modal', function (e) {
		document.onkeypress = !stopRKey;
		//loseFocus('b_prov');
		
	});
});
//para ver si existe el rif en el sistema
	function consulProv(str){
	  var xhttp;
	  var url = '<?php echo $_SERVER['REQUEST_URI'];?>';
	  var otroModal = document.getElementById('otroModal').value;
	  
	  if (str.length == 0) {
		document.getElementById("resProv").innerHTML = "Introduzca algo en el campo";
		return;
	  }
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  document.getElementById("resProv").innerHTML = xhttp.responseText;
		}
	  };
	  //xhttp.open("GET", "c.php?q="+str, true);
	  //xhttp.send();
		//var pre=$('#pre_rif_empre').val();
		
		xhttp.open("POST", "<?php echo $extra?>modales/prov/b_prov.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("prov="+ str +"&url="+url +"&otroModal"+ otroModal);
	}

</script>
<!-- Modal nueCargo-->
                            <div id="busProv" class="modal fade" role="dialog">
                              <div class="modal-dialog modal-lg">
                                <!-- Modal content-->
                                <div class="modal-content">
                                <form method="post" name="formProv" id="formProv">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Consulta del Proveedor</h4>
                                  </div>
                                  <div class="modal-body">
                                      <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12" align="center">
                                            
                                            	
                                            	<input type="hidden" id="otroModal" value=""/>
                                                
                                                Nombre &oacute; R.I.F.:<br />
                                                <input type="text" class="form-control" name="b_prov" id="b_prov" onKeyUp="consulProv(this.value);" autocomplete="off" required>
                                                <br /><span>Presione Espacio para mostrar todos</span>
                                            </div>
                                            <div class="col-md-12 col-lg-12" id="resProv">
                                            	
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