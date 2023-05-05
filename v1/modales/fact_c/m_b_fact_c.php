<?php include_once('../../includes_SISTEM/include_head.php');?>
<script>
//para desactivar el enter envie y cierre el modal
$(document).ready(function() {
	$(window.document).on('shown.bs.modal', '#busFact', function() {
		window.setTimeout(function() {
			<?php include_once('../../includes_SISTEM/include_login.php'); ?>
			document.onkeypress = stopRKey;
			$('#num_fact_compra', this).focus();
			
		}.bind(this), 100);
	});
	$('#busFact').on('hidden.bs.modal', function (e) {
		document.onkeypress = !stopRKey;
		//loseFocus('b_fact');
		
	});
});
//para ver si existe el rif en el sistema
	function consulFact(){
	  var xhttp;
	  
	  var mes_fact_compra = document.formMbf.mes_fact_compra.value;
	  var tipo_fact_compra =  document.formMbf.tipo_fact_compra.value;
	  var num_fact_compra = document.formMbf.num_fact_compra.value;
	  var fk_proveedor = document.formMbf.fk_proveedor.value;
	  var fecha_fact_compra = document.formMbf.fecha_fact_compra.value;
	  var serie_fact_compra = document.formMbf.serie_fact_compra.value;
	  var ord = document.formMbf.ord.value;
	  //alert("-"+num_fact_compra+"-");
	  
	  //if (1==0 ) {//num_fact_compra.length == 0
		//document.getElementById("resFact").innerHTML = "Introduzca algo en el campo";
		
	  //}else{
	  
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
		  		document.getElementById("resFact").innerHTML = xhttp.responseText;
			}
		};
		url = '<?php echo $_SERVER['REQUEST_URI'];?>';
		patron1 = 'cargarRetenCompra';
		patron2 = 'cargarCompra';
		patron3 = 'modificarCompra';
		
		xhttp.open("POST", "<?php echo $extra?>modales/fact_c/b_fact_c.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		if(url.search(patron1) > 0){
			xhttp.send("mes_fact_compra="+ mes_fact_compra +"&tipo_fact_compra="+ tipo_fact_compra+"&num_fact_compra="+ num_fact_compra +"&fk_proveedor="+ fk_proveedor + "&fecha_fact_compra="+  fecha_fact_compra +"&serie_fact_compra="+ serie_fact_compra +"&ord="+ ord +"&origen="+ patron1);
			
			
		}else if(url.search(patron2) > 0){
			
			xhttp.send("mes_fact_compra="+ mes_fact_compra +"&tipo_fact_compra="+ tipo_fact_compra+"&num_fact_compra="+ num_fact_compra +"&fk_proveedor="+ fk_proveedor + "&fecha_fact_compra="+  fecha_fact_compra +"&serie_fact_compra="+ serie_fact_compra +"&ord="+ ord +"&origen="+ patron2);
			
			
		}else if(url.search(patron3) > 0){
			xhttp.send("mes_fact_compra="+ mes_fact_compra +"&tipo_fact_compra="+ tipo_fact_compra+"&num_fact_compra="+ num_fact_compra +"&fk_proveedor="+ fk_proveedor + "&fecha_fact_compra="+  fecha_fact_compra +"&serie_fact_compra="+ serie_fact_compra +"&ord="+ ord +"&origen="+ patron3);
		}
	  //}
	}

</script>
<!-- Modal nueCargo-->
<div id="busFact" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" name="formMbf">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Consulta del Documento a Afectar</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <div class="row">
                <div class="col-xs-12 col-md-4 col-lg-4" align="center">
                    N° Documento:<br />
                    <input type="text" class="form-control" name="num_fact_compra" id="num_fact_compra" onKeyUp="consulFact();" autocomplete="off">
                </div>
                <div class="col-xs-12 col-md-4 col-lg-4">
                    Serie de Documento<br>
                	<input type="text" class="form-control" name="serie_fact_compra" id="serie_fact_compra" onKeyUp="consulFact();" autocomplete="off">
                    
                </div>
                  
                <div class="col-xs-12 col-md-4 col-lg-4">
                	<label for="tipodocumnto">Tipo de Documento:</label><br />
                    <select id="tipo_fact_compra" class="form-control" name="tipo_fact_compra" onchange="consulFact();" autocomplete="off">
                        <option value="">Seleccione</option>
                        <option value="F">Factura</option>
                        <option value="ND">Nota de D&eacute;bito</option>
                        <option value="NC-DESC">Nota de Cr&eacute;dito - Descuento</option>
                        <option value="NC-DEVO">Nota de Cr&eacute;dito - Devoluciones</option>
                        <option value="C">Certificaci&oacute;n</option>
                        <option value="NE">Nota de Entrega</option>
                        <!--
                        <optgroup label="Existencia Inicial">
                            <option value="II">Inventario Inicial</option>
                        </optgroup>
                        -->
                    </select>
                </div>
			</div>
            <div class="row">
                <div class="col-xs-12 col-md-4 col-lg-4">
                    <label>Rif Proveedor:</label><br />
                    <div class="input-group">
                    	<input name="fk_proveedor" id="fk_proveedor" class="form-control btn-primary" onBlur="consulFact();" onclick="modalbusProv('formMbf')" onfocus="modalbusProv('formMbf')" value="Clic aqui" type="text"/>
                        <span class="input-group-btn">
                        	<button class="btn btn-primary" type="button" onclick="vaciar('fk_proveedor'); consulFact();"> 
                            &times;
                            </button>
                        </span>
                    </div>
                </div>
                
                  
              	<div class="col-xs-12 col-md-4 col-lg-4"> 
                	<label>Nombre Proveedor:</label><br />
                	<div class="input-group">
                         <input type="button" name="nom_prov_ajax" id="nom_prov_ajax" class="form-control btn-primary" onclick="modalbusProv('formMbf')" onfocus="modalbusProv('formMbf')" onBlur="consulFact();" value="Clic aqui">
                         <span class="input-group-btn">
                        	<button class="btn btn-primary" type="button" onclick="vaciar('nom_prov_ajax'); consulFact();"> 
                            &times;
                            </button>
                        </span>
                       
                    </div>
              	</div>
                
                
                <div class="col-xs-12 col-md-4 col-lg-4">
                	<label>Fecha de Emisi&oacute;n:</label><br><!--de la Compra-->
                	<input type="date" class="form-control" name="fecha_fact_compra" id="fecha_fact_compra" onchange="consulFact();"/>
                </div>
                  
            </div><!--row-->
            <div class="row">
            	<div class="col-xs-12 col-md-4 col-lg-4">
                    <label>Mes y A&ntilde;o de Emisi&oacute;n:</label><br><!--de la Compra-->
                    <input type="month" class="form-control" name="mes_fact_compra" id="mes_fact_compra" onchange="consulFact();"/>
                 </div>
                 
            	<div class="col-xs-12 col-md-4 col-lg-4">
                    Ordenado Por:
                    <select class="form-control" name="ord"  id="ord" onchange="consulFact();">
                        <option value="">Seleccione</option>
                        <option value="tipo_fact_compra">Tipo de Documento</option>
                        <option value="num_fact_compra">Numero de Documento</option>
                        <option value="fk_proveedor">Nombre de Proveedor</option>
                        <option value="fecha_fact_compra">Fecha</option>
                        <!--
                        <optgroup label="Existencia Inicial">
                            
                        <option value="">Nota de Cr&eacute;dito - Devoluciones</option>
                        <option value="C">Certificaci&oacute;n</option>
                        <option value="NE">Nota de Entrega</option>
                        
                        <option value="II">Inventario Inicial</option>
                        </optgroup>
                        -->
                    </select>
            	</div>
			</div><!--row-->
            <hr id="" class="featurette-divider"/>    
            <div class="row">
                <div class="col-md-12 col-lg-12" align="center">
                    <br /><span>Presione Espacio para mostrar todos</span>
                </div>
                <div class="col-md-12 col-lg-12" id="resFact">
                    
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