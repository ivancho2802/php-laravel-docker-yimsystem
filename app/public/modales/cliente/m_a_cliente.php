<?php include_once('../../includes_SISTEM/include_head.php');?>
<script>
	$(window.document).on('shown.bs.modal', '#nueCliente', function() {
		window.setTimeout(function() {
			<?php include_once('../../includes_SISTEM/include_login.php'); ?>
			if (/[JVEGPjvepg][0-9]{8}$/.test(document.getElementById('b_cliente').value) || /[JVEGPjvepg][0-9]{9}$/.test(document.getElementById('b_cliente').value) || /[0-9]{8}$/.test(document.getElementById('b_cliente').value)) 
				document.getElementById('ced_cliente').value = document.getElementById('b_cliente').value;
			$('#ced_cliente', this).focus();
			
			
			/*	
			document.onkeypress = function()
			{
				var tecla;
				tecla = (document.all) ? event.keyCode : event.which;
				if(tecla == 13)
				{
					agreRCliente('formModal');
					codFactProvee('form1', 'serie_fact_venta', 'num_fact_venta', 'fk_cliente', 'id_fact_venta');
				}
			}
			*/
		}.bind(this), 100);
	});
	
	
	function agreRCliente(formulario) {
		//funcion de validacion
		var valido = validarFormulario(formulario);
		
		if(valido==1)
		{
		  //paramentros y funciones de registro AJAX	
		  var xhttp;
		  //variables contenidas en el formulariuo
		  var ced_cliente = $("input#ced_cliente").val();
		  var nom_cliente = $("input#nom_cliente").val();
		  var ape_cliente = $("input#ape_cliente").val();
		  var contri_cliente = $("select#contri_cliente").val();
		  var email_cliente = $("input#email_cliente").val();
		  var tel_cliente = $("input#tel_cliente").val();
		  var dir_cliente = $("input#dir_cliente").val();
		  var fech_i_cliente = $("input#fech_i_cliente").val();
		  
		  
		  xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
			  document.getElementById("txtHintA").innerHTML = xhttp.responseText;
			}
		  };
		  //xhttp.open("GET", "c.php?q="+str, true);
		  //xhttp.send();
		  
			xhttp.open("POST", "<?php echo $extra?>modales/cliente/a_cliente.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("ced_cliente="+ ced_cliente +"&nom_cliente="+ nom_cliente +"&ape_cliente="+ ape_cliente +"&email_cliente="+ email_cliente+"&contri_cliente="+contri_cliente+"&tel_cliente="+ tel_cliente+"&dir_cliente="+ dir_cliente+"&fech_i_cliente="+ fech_i_cliente);
			
			
			//si esto compila se puede insertar y seleccionar
			selecCliente(ced_cliente,nom_cliente,contri_cliente);
		}
			
	}
		
</script>
<!-- Modal nueProv-->
    <div id="nueCliente" class="modal fade" role="dialog">
      <div class="modal-dialog  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Nuevo Cliente (Raz&oacute;n Social)</h4>
          </div>
          
          <form name="formModal"><!--QUE AL PRECIONAR ENTER ENVIE EL FORTMULARIUO-->
          <div class="modal-body">
              <div class="form-group">
                <label align="left">
                	<div class="row">
                        <!--para mostrar resultado de acciones de insercion y demas-->
                        <label class="col-md-12 col-lg-12" id="txtHintA" data-dismiss="modal"></label>
                    </div>
                	<div class="row">
                    	<!--con el rif se manda a validar si existe con la funcino buscar_dato, y con cURLrif obtener el nombre-->
                        <label class="col-md-4 col-lg-4" id="res_ced_cliente">
                            Documento del Cliente<br>
                            <span id="cont_ced_cliente">
                            <input type="text" class="form-control" name="ced_cliente" id="ced_cliente" pattern="[JVEGP][0-9]{9}" onBlur="javascript:this.value=this.value.toUpperCase();validar_repetidoM('cliente', 'ced_cliente', this.value, 'ced_cliente');" onKeyUp="autos_tipo_contri(this.value,'contri_cliente');" lang="si-general" required>
                            <span class="help-block">Formato: V012223334</span>
                            </span>
                        </label>
                        <label class="col-md-8 col-lg-8">
                        	Nombre o Raz&oacute;n Social:<br />
                            <span class="input-group">
                                <span id="resRifC"></span>
                                    <input type="text" class="form-control" name="nom_cliente" id="nom_cliente" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();" lang="si-general" required>
                                
                                <span class="input-group-btn">
                                    <button id="btn" type="button" onclick="cURLrifC('nombre','ced_cliente','formModal','nom_cliente','resRifC',this.id);" class="form-control btn btn-primary">
                                    Buscar(INTERNET)
                                    </button>
                                </span>
                            </span>
                        </label>
                        
                    </div>
                    <div class="row">
                    	<label class="col-md-4 col-lg-4">
                        	Tipo de Contribuyente
                            <select class="form-control" name="contri_cliente" id="contri_cliente" lang="si-general" required>
                            	<option>Seleccione</option>
                                <option value="CONTRI_ORD">Contribuyente Ordinario</option>
                                <option value="CONTRI_ESP">Contribuyente Especial</option>
                                <option value="NO_CONTRI">No Contribuyente</option>
                            </select>
                        </label>
                        <label class="col-md-4 col-lg-4">
                            Fecha de Registro:<br>
                            <input type="date" class="form-control" name="fech_i_cliente" id="fech_i_cliente" value="<?php echo date('Y-m-d'); ?>"/>
                        </label>
                        
                        <label class="col-md-4 col-lg-4">
                            Telefono:<br>
                            <input type="text" class="form-control" name="tel_cliente" id="tel_cliente" min="999999999" max="999999999999" pattern="[0][42][127][246][0-9]{7}" lang="no-telf">
                            <span class="help-block">Formato: 04161234567</span>
                        </label>
                        
                	</div><!--row-->
                    <div class="row">
                    	<label class="col-md-4 col-lg-4">
                            E-mail:<br>
                            <input type="text" class="form-control" name="email_cliente" id="email_cliente"  lang="no-email" >
                        </label>
                        <label class="col-md-4 col-lg-4">
                            Direcci&oacute;n:<br />
                            <input class="form-control" type="text" name="dir_cliente" id="dir_cliente" required>
                        </label>
                	</div><!--row-->
                </label>
              </div><!--form-group-->
          </div><!--modal-bosy-->
          
          <div class="modal-footer">      									<!--dejelo asi la funcion lo hace beine solo es el nombre-->
            <button type="button" class="btn btn-success" onclick="agreRCliente(this.form);" onblur="codFactProvee('form1', 'serie_fact_venta', 'num_fact_venta', 'fk_cliente', 'id_fact_venta');">Agregar y Seleccionar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
          </form>
        </div>
    
      </div>
    </div>