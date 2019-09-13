<?php include_once('../../includes_SISTEM/include_head.php');?>
<script>
//para desactivar el enter envie y cierre el modal

$(document).ready(function() {
	$(window.document).on('shown.bs.modal', '#busProd', function() {
		window.setTimeout(function() {
			<?php include_once('../../includes_SISTEM/include_login.php'); ?>
			$('#b_prod', this).focus();
			document.getElementById("b_prod").value = "";
			document.getElementById("resProd").innerHTML = "";
			//alert("aqui"+document.form1.nfact_afectada.value);
		}.bind(this), 100);
	});	
	$('#busProd').on('show.bs.modal', function (e) {
		document.onkeypress = stopRKey;
		
	});
	$('#busProd').on('hidden.bs.modal', function (e) {
		document.onkeypress = !stopRKey;
		
	});
});
//para ver si existe el rif en el sistema
	function consulProd(str){
	  
	  var urlActual = '<?php echo $_SERVER['REQUEST_URI']?>';
	  var sqlN = ''; 
	  //si vengo de cargar compra y el tipo de documento es nota de credito el sql va a cambiar
	  if(urlActual.search('cargarCompra') >= 0){//solo para compra  if(url.search(patron1) >= 0){
		var tipoDoc = document.form1.tipo_fact_compra.value;
	    nfact_afectada = document.form1.nfact_afectada.value;
		
		if(tipoDoc == 'NC-DESC' || tipoDoc == 'NC-DEVO'){
			if(nfact_afectada == "" || nfact_afectada == "Clic Aqui"){
				alert("Debe seleccionar un Documento para afectar Debido a la NOTA DE CREDITO");
				//$('#busProd').modal('hidden');
				//document.form1.nfact_afectada.onfocus;
				
				return 0;
			}else{
				sqlN = "SELECT * FROM compra, inventario WHERE compra.fk_fact_compra = \'"+nfact_afectada+"\' AND compra.fk_inventario = inventario.codigo";
			//alert(sqlN);
			}
		}
	  }else if(urlActual.search('cargarVenta') >= 0){//solo para compra  if(url.search(patron1) >= 0){
		var tipoDoc = document.form1.tipo_fact_venta.value;
	    nfact_afectada = document.form1.nfact_afectada.value;
		if(tipoDoc == 'NC-DESC' || tipoDoc == 'NC-DEVO'){
			if(nfact_afectada == "" || nfact_afectada == "Clic Aqui"){
				alert("Debe seleccionar un Documento para afectar Debido a la NOTA DE CREDITO");
				//$('#busProd').modal('hidden');
				//document.form1.nfact_afectada.onfocus;
				
				return 0;
			}else{
				sqlN = "SELECT * FROM venta, inventario WHERE venta.fk_fact_venta = \'"+nfact_afectada+"\' AND venta.fk_inventario = inventario.codigo";
			//alert(sqlN);
			}
		}
	  }
	  
	  var xhttp;
	  if (str.length == 0) {
		document.getElementById("resProd").innerHTML = "Introduzca algo en el campo";
		return;
	  }
	  xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			  //, document.form1.nfact_afectada.value, document.form1.tipo_fact_compra.value
		  	document.getElementById("resProd").innerHTML = xhttp.responseText;
		  
		}
	  };
	  //xhttp.open("GET", "c.php?q="+str, true);
	  //xhttp.send();
		//var pre=$('#pre_rif_empre').val();
		//alert(sqlN+' '+urlActual)
		xhttp.open("POST", "<?php echo $extra?>modales/prod/b_prod.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("prod="+ str +"&urlActual="+ urlActual +"&sqlN="+ sqlN+"&tipoDoc="+ tipoDoc);
	}

</script>
<!-- Modal nueCargo-->
                            <div id="busProd" class="modal fade" role="dialog">
                              <div class="modal-dialog modal-lg">
                                <!-- Modal content-->
                                <div class="modal-content">
                                <form method="post">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Consulta del Producto</h4>
                                  </div>
                                  <div class="modal-body">
                                      <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12" align="center">
                                                Nombre &oacute; Codigo:<br />
                                                <input type="text" class="form-control" name="b_prod" id="b_prod" onKeyUp="consulProd(this.value);" autocomplete="off" required>
                                                <br /><span>Presione Espacio para mostrar todos</span>
                                            </div>
                                            <div class="col-md-12 col-lg-12" id="resProd">
                                            	
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