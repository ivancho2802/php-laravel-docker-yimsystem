<?php include_once('../../includes_SISTEM/include_head.php');?>
<script>
	$(window.document).on('shown.bs.modal', '#addCate', function() {
		window.setTimeout(function() {
			<?php include_once('../../includes_SISTEM/include_login.php'); ?>
			// if (/[JVEGPjvepg][0-9]{8}$/.test(document.getElementById('b_cliente').value) || /[JVEGPjvepg][0-9]{9}$/.test(document.getElementById('b_cliente').value) || /[0-9]{8}$/.test(document.getElementById('b_cliente').value)) 
				// document.getElementById('ced_cliente').value = document.getElementById('b_cliente').value;
			$('#id', this).focus();
			/*	
			document.onkeypress = function()
			{
				var tecla;
				tecla = (document.all) ? event.keyCode : event.which;
				if(tecla == 13)
				{
					agreCate('formModal');
					codFactProvee('form1', 'serie_fact_venta', 'num_fact_venta', 'fk_cliente', 'id_fact_venta');
				}
			}
			*/
		}.bind(this), 100);
	});
	
	function agreCate(formulario) {
		//funcion de validacion
		var valido = validarFormulario(formulario);
		
		if(valido==1)
		{
		  //paramentros y funciones de registro AJAX	
		  var xhttp;
		  //variables contenidas en el formulariuo
		  var id = $("input#id").val();
		  var nombre = $("input#nombre").val();
		  var descripcion = $("input#descripcion").val();
		  
		  xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
			  document.getElementById("txtHintA").innerHTML = xhttp.responseText;
			}
		  };
		  //xhttp.open("GET", "c.php?q="+str, true);
		  //xhttp.send();
		  
			xhttp.open("POST", "<?php echo $extra?>modales/cuentas/a_cate.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("id="+ id +"&nombre="+ nombre +"&descripcion="+ descripcion );
			
			//si esto compila se puede insertar y seleccionar
			// selecCliente(ced_cliente,nom_cliente,contri_cliente);
		}
	}
</script>
<!-- Modal nueProv-->
    <div id="addCate" class="modal fade" role="dialog">
      <div class="modal-dialog  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Categoria</h4>
          </div>
          
          <form name="formModal"><!--QUE AL PRECIONAR ENTER ENVIE EL FORTMULARIUO-->
          <div class="modal-body">
              <div class="form-group">
                <div class="grid">
                	<div class="row">
                        <!--para mostrar resultado de acciones de insercion y demas-->
                        <label class="col-md-12 col-lg-12" id="txtHintA" data-dismiss="modal"></label>
                    </div>
                	<div class="row">
                    	<!--con el rif se manda a validar si existe con la funcino buscar_dato, y con cURLrif obtener el nombre-->
                        <label class="col-md-4 col-lg-4" id="res_ced_cliente">
                            N° de catagoria:<br>
                            <span id="cont_ced_cliente">
                                <input type="text" class="form-control" name="id" id="id" lang="si-general" required>
                            </span>
                        </label>
                        <label class="col-md-8 col-lg-8">
                        	Nombre:<br />
                            <span class="">
                                <span id="resRifC"></span>
                                <input type="text" class="form-control" name="nombre" id="nombre" lang="si-general" required>
                            </span>
                        </label>
                    </div>
                    <div class="row">
                    	<label class="col-md-4 col-lg-4">
                        	Descripcion
                            <input class="form-control" name="descripcion" id="descripcion" lang="si-general" required>
                        </label>
                	</div><!--row-->
                </div>
              </div><!--form-group-->
          </div><!--modal-bosy-->
          
          <div class="modal-footer">      									<!--dejelo asi la funcion lo hace beine solo es el nombre-->
            <button type="button" class="btn btn-success" onclick="agreCate(this.form);" >Agregar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
          </form>
        </div>
    
      </div>
    </div>