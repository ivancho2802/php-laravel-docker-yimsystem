<?php include_once('../../includes_SISTEM/include_head.php');

if(isset($_POST['nfact_afectada']))
{		
		//recibo la variable post
		$fact = $_POST['nfact_afectada'];	
		//realizo el sql
		$consulta=pg_query($conexion,sprintf("SELECT * FROM fact_compra, compra, inventario WHERE
									fact_compra.id_fact_compra = '%s' AND
									compra.fk_fact_compra = fact_compra.id_fact_compra AND
									compra.fk_inventario = inventario.codigo",
									$fact));
		$filas=pg_fetch_assoc($consulta);
		$total_consulta = pg_num_rows($consulta);
}		
?>
<script>
//para desactivar el enter envie y cierre el modal
$(document).ready(function() {
	$(window.document).on('shown.bs.modal', '#mostrarFact', function() {
		window.setTimeout(function() {
			<?php include_once('../../includes_SISTEM/include_login.php'); ?>
			document.onkeypress = stopRKey;
			//$('#b_fact', this).focus();
		}.bind(this), 100);
	});
	/*
	$('#busFact').on('hidden.bs.modal', function (e) {
		document.onkeypress = !stopRKey;
		//loseFocus('b_fact');
		
	});
	*/
});
</script>
<!-- Modal mostrarFact-->
<div id="mostrarFact" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <form method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detalles de la Factura</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <div class="row">
                <div class="col-md-12 col-lg-12" align="center">
                    <!--
                    Numero de Factura:<br />
                    <input type="text" name="b_fact" id="b_fact" onKeyUp="consulFact(this.value);" required>
                    <br /><span>Presione Espacio para mostrar todos</span>
                    -->
                </div>
                <div class="col-md-12 col-lg-12">
                	<?php
                    if($_POST['nfact_afectada'] == ""){
                    //no hay nfact_afectada
                       echo "Numero de factura faltante"; 
                    }else{
					?>
					<div class="">
                    <br>
                    <h4>Resultados</h4>
                    <table class="table table-bordered">
                      <thead>
                      	<tr>
                            <td><b>ID de la Factura:</b><?php echo $filas['id_fact_compra']?></td>
                            <td><b>Numero de la Factura:</b><?php echo $filas['num_fact_compra']?></td>
                            <td><b>Serie de la Factura:</b><?php echo $filas['serie_fact_compra']?></td>
                            <td><b>Fecha de la Compra:</b><?php echo $filas['fecha_fact_compra']?></td>
                            <td><b>Monto Total con IVA:</b><?php echo $filas['mtot_iva_compra']?></td>
                        </tr>
                        <tr>
                            <td><b>Codigo</b></td>
                            <td><b>Nombre</b></td>
                            <td><b>Descripci&oacute;n</b></td>
                            <td><b>Costo</b></td>
                            <td><b>Cantidad</b></td>
                        </tr>
                      </thead>
                      <tbody>
						<?php
						//para saber si hay resultados y mostrar
						if($total_consulta >= 1){
							do{
							?>
							<tr>
							  <td><?php echo $filas['codigo']?></td>
							  <td><?php echo $filas['nombre_i']?></td>
							  <td><?php echo $filas['descripcion']?></td>
							  <td><?php echo $filas['costo']?></td>
                              <td><?php echo $filas['cantidad']?></td>
							</tr>
							<?php
							}while($filas=pg_fetch_assoc($consulta));
						}else{
						?>
                            <tr>
                                <td colspan="5"><div>No hay resultados La Factura Debe Existir en el Sistema??</div></td>
                                <!--data-bs-toggle="modal" data-target="#nueProv" para agregar y con dismis cierra el actual-->
                            </tr>
            			<?php    
						}
						?>		
					  	</tbody>
					  </table>
				    </div>
					<?php
                    }
                    ?>
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