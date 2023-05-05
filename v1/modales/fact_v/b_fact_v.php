<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

	if(isset($_POST['fact']))
	{
		if(isset($_POST['tipo_docu']))
			$tipo_docu = $_POST['tipo_docu'];
		else
			$tipo_docu = 'F';

		if($_POST['fact'] == " "){
		//realizo el sql
			
			$consulta=pg_query($conexion,sprintf("SELECT * FROM fact_venta, cliente WHERE
									fact_venta.tipo_fact_venta = '%s'		AND
									fact_venta.fk_cliente = cliente.ced_cliente",
									$tipo_docu));
			$filas=pg_fetch_assoc($consulta);
			$total_consulta = pg_num_rows($consulta);
		}else{
			//recibo la variable post
			$fact = "%".$_POST['fact']."%";	
			//realizo el sql
			$consulta=pg_query($conexion,sprintf("SELECT * FROM fact_venta, cliente WHERE
																	fact_venta.id_fact_venta LIKE '%s' 		AND
																	fact_venta.tipo_fact_venta = '%s'		AND
																	fact_venta.fk_cliente = cliente.ced_cliente",
																	$fact,$tipo_docu));
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
    	<td><b>ID de la Factura</b></td>
    	<td><b>Numero de la Factura</b></td>
        <td><b>Serie de la Factura</b></td>
        <td><b>Fecha de la Compra</b></td>
        <td><b>Monto Total con IVA</b></td>
        <td><b>IVA Retenido</b></td>
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
              <td><?php echo $filas['id_fact_venta']?></td>
              <td><?php echo $filas['num_fact_venta']?></td>
              <td><?php echo $filas['serie_fact_venta']?></td>
              <td><?php echo $filas['fecha_fact_venta']?></td>
              <td><?php echo $filas['mtot_iva_venta']?></td>
              <td><?php echo $filas['tot_iva']?></td>
              <td>
              <?php if(isset($_POST['selecMFact']) ){?>
                <button type="button" class="btn btn-warning" onClick="selecFactVM('<?php echo $filas["id_fact_venta"]?>','<?php echo $filas['num_fact_venta']?>','<?php echo $filas['serie_fact_venta']?>','<?php echo $filas['nom_cliente']?>','<?php echo $filas['tot_iva']?>','<?php echo $filas['m_iva_reten']?>','<?php echo $filas['mes_apli_reten']?>','<?php echo $filas['num_compro_reten']?>','<?php echo $filas['fecha_compro_reten']?>');" data-dismiss="modal">Seleccionar</button>
                
                <?php }if(isset($_POST['fact_venta']) && isset($_POST['tipo_docu']) ){?>
                <button type="button" class="btn btn-primary" onClick="mConsulFact('<?php echo $filas["id_fact_venta"]?>')">Detalles Fact.</button>
                
                <?php }else{?>
                
                <button type="button" class="btn btn-warning" onClick="selecFactV('<?php echo $filas["id_fact_venta"]?>');" data-dismiss="modal">Seleccionar</button>
                <?php }?>
              </td>
            </tr>
            <?php
            }while($filas=pg_fetch_assoc($consulta));
		}else{
			?>
            <tr>
                <td colspan="7"><div>No hay resultados La Factura Debe Existir en el Sistema</div></td>
                <!--data-bs-toggle="modal" data-target="#nueProv" para agregar y con dismis cierra el actua
                <td><input type="button" class="btn btn-success" value="Cancelar" data-dismiss="modal"></td>l-->
            </tr>
            <?php    
		}
?>		
		</tbody>
</table>
</div>
<div class="col-md-12 col-lg-12" id="resFact2">
	
</div>
<?php		
	}
?>
<body>

</body>
</html>
