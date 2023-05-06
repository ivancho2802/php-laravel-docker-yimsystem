<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

	if(isset($_POST['cliente']))
	{
		if($_POST['cliente'] == " "){
		//realizo el sql
		$consulta=pg_query($conexion,sprintf("SELECT * FROM cliente"));
		// $filas=pg_fetch_assoc($consulta);
    $filas=pg_fetch_assoc($consulta);

		$total_consulta = pg_num_rows($consulta);
		}else{
		//recibo la variable post
		$cliente = "%".$_POST['cliente']."%";	
		//realizo el sql
		$consulta=pg_query($conexion,sprintf("SELECT * FROM cliente WHERE
																cliente.nom_cliente LIKE '%s' OR cliente.ced_cliente LIKE '%s'",
																$cliente, $cliente));
		$filas=pg_fetch_assoc($consulta);
		$total_consulta = pg_num_rows($consulta);
		}
		
?>
<div class="table-responsive">
<br>
<h4>Resultados</h4>
<table class="table table-bordered">
  <thead>
	<tr>
    	<td><b>Nombre del Cliente</b></td>
        <td><b>Cedula del Cliente</b></td>
        <td><b>Tipo de Contribuyente</b></td>
        <td><b>Accion</b></td>
    </tr>
  </thead>
  <tbody>
<?php
		//para saber si hay resultados y mostrar
		if($total_consulta >= 1){
			do{
			?>
            <tr>
              <td><?php echo $filas['nom_cliente']?></td>
              <td><?php echo $filas['ced_cliente']?></td>
              <td><?php echo $filas['contri_cliente']?></td>
              <td>
                <span class="input-group">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-info" onClick="selecCliente('<?php echo $filas["ced_cliente"]?>','<?php echo $filas["nom_cliente"]?>','<?php echo $filas['contri_cliente']?>');" data-dismiss="modal" required="required" onBlur="codFactProvee('form1', 'serie_fact_venta', 'num_fact_venta', 'fk_cliente', 'id_fact_venta');">Seleccionar</button>
                    
                    <button type="button" class="btn btn-warning" onClick="mmCliente('<?php echo $filas["ced_cliente"]?>');">Modificar</button>
                  </span>
                </span>
                								<!--este selector de fac proveedor funciona dejelo asi-->
                                                
              </td>
            </tr>
            <?php
            }while($filas=pg_fetch_assoc($consulta));
		}else{
			?>
            <tr>
                <td colspan="3"><div>No hay resultados</div></td>
                <!--data-bs-toggle="modal" data-target="#nueProv" para agregar y con dismis cierra el actual-->
                <td><input type="button" class="btn btn-success" value="Agregar y Seleccionar Cliente" data-dismiss="modal" data-bs-toggle="modal" data-target="#nueCliente"></td>
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
</html>
