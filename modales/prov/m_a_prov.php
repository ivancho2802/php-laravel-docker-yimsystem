<?php include_once('../../includes_SISTEM/include_head.php');?>

<script>
	$(window.document).on('shown.bs.modal', '#nueProv', function() {
		window.setTimeout(function() {
			<?php
			include_once('../../includes_SISTEM/include_login.php');
			?>
			$('#rif', this).focus();
			//esta variable contirnr rn realidad un rif paselo si no no
			if (/[JVEGPjvepg][0-9]{8}$/.test(document.getElementById('b_prov').value) || /[JVEGPjvepg][0-9]{9}$/.test(document.getElementById('b_prov').value) || /[0-9]{8}$/.test(document.getElementById('b_prov').value)) 
				document.getElementById('rif').value = document.getElementById('b_prov').value;
		}.bind(this), 100);
	});

	function agreRProv(formulario) {
		//funcion de validacion
		var valido = validarFormulario(formulario);
		
		if(valido==1)
		{
		  //paramentros y funciones de registro AJAX	
		  var xhttp;
		  //variables contenidas en el formulariuo
		  var rif = $("input#rif").val();
		  var nombre = $("input#nombre").val();
		  var telefono = $("input#telefono").val();
		  var direccion = $("input#direccion").val();
		  
		  
		  xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
			  document.getElementById("txtHintA").innerHTML = xhttp.responseText;
			}
		  };
		  //xhttp.open("GET", "c.php?q="+str, true);
		  //xhttp.send();
		  
			xhttp.open("POST", "<?php echo $extra?>modales/prov/a_prov.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("rif="+ rif +"&nombre="+ nombre +"&telefono="+ telefono +"&direccion="+ direccion);
			
			
			//si esto compila se puede insertar y seleccionar
			selecProv(rif,nombre,'<?php echo $_SERVER['REQUEST_URI'];?>');
		}
			
	}
		
</script>
<!-- Modal nueProv-->
    <div id="nueProv" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Nuevo Proveedor (Raz&oacute;n Social)</h4>
          </div>
          <form name="formModal">
          <div class="modal-body">
              <div class="form-group">
                <label align="left">
                	<div class="row">
                        <!--para mostrar resultado de acciones de insercion y demas-->
                        <label class="col-md-12 col-lg-12" id="txtHintA" data-dismiss="modal"></label>
                    </div>
                	<div class="row">
                    	<!--con el rif se manda a validar si existe con la funcino buscar_dato, y con cURLrif obtener el nombre-->
                        <label class="col-md-6 col-lg-6" id="res_rif">
                        	<span id="cont_rif">
                            R.I.F. / Cedula<br>
                            <input type="text" class="form-control" name="rif" id="rif" pattern="[JVEGP][0-9]{8}" onBlur="javascript:this.value=this.value.toUpperCase();validar_repetidoM('proveedor', 'rif', this.value, 'rif');"   lang="si-rif" required/>
                            <span class="help-block">Formato: V012223334</span>
                            </span>
                        </label>
                        <label class="col-md-6 col-lg-6">
                        	Nombre o Raz&oacute;n Social:<br />
                        	<span class="input-group">
                                <span id="resRifC"> </span>
                                    <input type="text" class="form-control" name="nombre" id="nombre" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();" lang="si-general" required>
                               
                                <span class="input-group-btn">
                                <button id="btn" type="button" onclick="cURLrifC('nombre','rif','formModal','nombre','resRifC',this.id);" class="btn btn-primary">Buscar (INTERNET)</button>
                                </span>
                            </span>
                        </label>
                        
                        
                    </div>
                    <div class="row">
                        <label class="col-md-6 col-lg-6">
                            Telefono:<br>
                            <input type="text" class="form-control" name="telefono" id="telefono" min="999999999" max="999999999999" pattern="[0][42][127][246][0-9]{7}" lang="no-telf" required>
                            <span class="help-block">Formato: 04161234567</span>
                        </label>
                        <label class="col-md-6 col-lg-6">
                            Direcci&oacute;n:<br />
                            <input class="form-control" type="text" name="direccion" id="direccion" required>
                        </label>
                	</div><!--row-->
                </label>
              </div><!--form-group-->
          </div><!--modal-bosy-->
          
          <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="agreRProv(this.form);" onblur="codFactProvee('form1', 'serie_fact_compra', 'num_fact_compra', 'fk_proveedor', 'id_fact_compra');">Agregar y Seleccionar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
          </form><!--maprov-->
        </div>
    
      </div>
    </div>
<script></script>