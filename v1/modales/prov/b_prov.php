<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');
	
	
	$url = $_POST['url'];
	
	if(isset($_POST['prov']))
	{
		
		
		if($_POST['prov'] == " "){
			//realizo el sql
			$consulta=pg_query($conexion,sprintf("SELECT * FROM proveedor"));
			$filas=pg_fetch_assoc($consulta);
			$total_consulta = pg_num_rows($consulta);
		}else{
			//recibo la variable post
			$prov = "%".$_POST['prov']."%";	
			//realizo el sql
			$consulta=pg_query($conexion,sprintf("SELECT * FROM proveedor WHERE
														proveedor.nombre LIKE '%s' OR
														proveedor.rif LIKE '%s'",
																	$prov, $prov));
			$filas=pg_fetch_assoc($consulta);
			$total_consulta = pg_num_rows($consulta);
		}
		
//echo date('H:i:s')?>
<div class="table-responsive">
<br>
<h4>Resultados</h4>
<table class="table table-bordered">
  <thead>
	<tr>
    	<td><b>Nombre del Proveedor</b></td>
        <td><b>R.I.F. del Proveedor</b></td>
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
              <td><?php echo $filas['nombre']?></td>
              <td><?php echo $filas['rif']?></td>
              <td>
                <span class="input-group">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-info" onClick="selecProv('<?php echo $filas["rif"]?>','<?php echo $filas["nombre"]?>','<?php echo $url;?>');" data-dismiss="modal" required="required">Seleccionar</button>
                  
                    <button type="button" class="btn btn-warning" onClick="mmProv('<?php echo $filas["rif"]?>')" required="required">Modificar</button>
                  </span>
                </span>
              </td>
            </tr>
            <?php
            }while($filas=pg_fetch_assoc($consulta));
		}else{
			?>
            <tr>
                <td colspan="2"><div>No hay resultados</div></td>
                <!--data-bs-toggle="modal" data-target="#nueProv" para agregar y con dismis cierra el actual-->
                <td><input type="button" class="btn btn-success" value="Agregar y Seleccionar Proveedor" data-dismiss="modal" data-bs-toggle="modal" data-target="#nueProv"></td>
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
