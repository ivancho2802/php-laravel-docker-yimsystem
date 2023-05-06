<?php include_once('../../includes_SISTEM/include_head.php');?>
<script>
	$(window.document).on('shown.bs.modal', '#addCuenta', function() {
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
					agreCuenta('formModal');
					codFactProvee('form1', 'serie_fact_venta', 'num_fact_venta', 'fk_cliente', 'id_fact_venta');
				}
			}
			*/
		}.bind(this), 100);
	});
	
	function agreCuenta(formulario) {
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
		  var fk_cate = $("input#categoria").val();
		  
		  xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
			  document.getElementById("txtHintA").innerHTML = xhttp.responseText;
			}
		  };
		  //xhttp.open("GET", "c.php?q="+str, true);
		  //xhttp.send();
		  
			xhttp.open("POST", "<?php echo $extra?>modales/cuentas/a_cuenta.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("id="+ id +"&nombre="+ nombre +"&descripcion="+ descripcion +"&fk_cate="+ fk_cate );
			
			//si esto compila se puede insertar y seleccionar
			// selecCliente(ced_cliente,nom_cliente,contri_cliente);
		}
	}
</script>
<!-- Modal nueProv-->
    <div id="addCuenta" class="modal fade" role="dialog">
      <div class="modal-dialog  modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Cuenta</h4>
          </div>
          
          <form name="formModal"><!--QUE AL PRECIONAR ENTER ENVIE EL FORTMULARIUO-->
          <div class="modal-body">
              <div class="form-group">
                <div class="grid">
                	<div class="row">
                        <!--para mostrar resultado de acciones de insercion y demas-->
                        <label class="col-md-12 col-lg-12" id="txtHintA" data-bs-dismiss="modal"></label>
                    </div>
                	<div class="row">
                    	<!--con el rif se manda a validar si existe con la funcino buscar_dato, y con cURLrif obtener el nombre-->
                        <label class="col-md-4 col-lg-4" id="res_ced_cliente">
                        <label>N° Cuenta:</label><br />
                            <span id="cont_ced_cliente">
                                <input type="text" class="form-control" name="id" id="id" lang="si-general" required>
                            </span>
                        </label>
                        <label class="col-md-4 col-lg-4">
                        	Nombre:<br />
                            <span class="">
                                <span id="resRifC"></span>
                                <input type="text" class="form-control" name="nombre" id="nombre" lang="si-general" required>
                            </span>
                        </label>
                        <label class="col-md-4 col-lg-4">
                            Descripcion
                            <input class="form-control" name="descripcion" id="descripcion" lang="si-general" required>
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-lg-12">
                            <label>Categoria:</label><br />
                            <div class="list-group">
                                <?php 
                                $consulta2 = pg_query($conexion, sprintf("SELECT * FROM categoria 
                                                        WHERE 
                                                        fk_empre = '%s';", $_SESSION["id_usu"] ));
                                $filas2=pg_fetch_assoc($consulta2);
                                $total_consulta2 = pg_num_rows($consulta2);
                                if($total_consulta2>0){?>
                                    <select name="categoria"  id="categoria" class="form-control" required="required"  >
                                        <?php do{ ?>
                                        <option value="<?php echo $filas2['id']?>"><?php echo $filas2['nombre'];?></option>
                                        <?php }while($filas2 = pg_fetch_assoc($consulta2)); ?>
                                    </select>    
                                <?php }else{?>
                                    <div class="alert alert-warning">
                                      <strong>Warning!</strong> no hay categorias..
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                    </div> 
                </div>
              </div><!--form-group-->
          </div><!--modal-bosy-->
          
          <div class="modal-footer">      									<!--dejelo asi la funcion lo hace beine solo es el nombre-->
            <button type="button" class="btn btn-success" onclick="agreCuenta(this.form);" >Agregar</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          </div>
          </form>
        </div>
    
      </div>
    </div>