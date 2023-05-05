<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');
	


	$mes_fact_compra = $_POST['mes_fact_compra'];
	$tipo_fact_compra = $_POST['tipo_fact_compra'];
	
	$num_fact_compra = "%".$_POST['num_fact_compra']."%";
	$serie_fact_compra = "%".$_POST['serie_fact_compra']."%";
	$fk_proveedor = "%".$_POST['fk_proveedor']."%";
	
	$fecha_fact_compra = $_POST['fecha_fact_compra'];
	$ord = $_POST['ord'];
	$origen = $_POST['origen'];
	
	$mesi = $mes_fact_compra."-01";
	$mesf = $mes_fact_compra."-31";
	
	if($ord !== "")
		$ord = "fact_compra.".$_POST['ord'];
	else
		$ord = "fact_compra.num_fact_compra";
	
	
if(isset($_POST['num_fact_compra']))
{	
	if($_POST['num_fact_compra'] == " " || $_POST['serie_fact_compra'] == " "){
		//realizo el sql
		$consulta=pg_query($conexion,sprintf("SELECT * FROM fact_compra, proveedor, empre WHERE
										fact_compra.tipo_fact_compra = 'F'		AND
										fact_compra.fk_proveedor = proveedor.rif
										ORDER BY %s DESC", $ord))or die(pg_last_error());
		$filas=pg_fetch_assoc($consulta);
		$total_consulta = pg_num_rows($consulta);
		
	}else{	
		//realizo el sql
		$sql_cont = "";
		
		if(str_replace('\x20', '', $num_fact_compra) !== "%%")
			$sql_cont = " AND fact_compra.num_fact_compra LIKE '".$num_fact_compra."'";
				
		if($serie_fact_compra !== "%%")
			$sql_cont .= " AND fact_compra.serie_fact_compra LIKE '".$serie_fact_compra."'";
		
		if($fk_proveedor !== "%Clic aqui%")
			$sql_cont .= " AND fact_compra.fk_proveedor LIKE '".$fk_proveedor."'";
		
		if($tipo_fact_compra !== "")
			$sql_cont .= " AND fact_compra.tipo_fact_compra = '".$tipo_fact_compra."'";
		
		if($mes_fact_compra !== "")
			$sql_cont .= " AND fact_compra.fecha_fact_compra BETWEEN '".$mesi."' AND '".$mesf."'";							
		
		if($fecha_fact_compra !== "")
			$sql_cont .= " AND fact_compra.fecha_fact_compra = '".$fecha_fact_compra."'";
			
		//echo $sql_cont;
		
			
									
		$consulta=pg_query($conexion,sprintf("SELECT * FROM fact_compra, proveedor ,empre WHERE
									fact_compra.empre_cod_empre = empre.cod_empre AND
									empre.est_empre = '1' AND
									fact_compra.fk_proveedor = proveedor.rif AND
									fact_compra.tipo_fact_compra != 'II'
									%s
									
									ORDER BY %s DESC", 
									$sql_cont, $ord))or die(pg_last_error());
																
																
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
        <td><b>Nombre del Proveedor</b></td>
        <td><b>Accion</b></td>
    </tr>
  </thead>
  <tbody>
<?php
		//para saber si hay resultados y mostrar
		//echo $total_consulta;
		if($total_consulta >= 1){
			do{
			?>
            <tr>
              <td><?php echo $filas['id_fact_compra']?></td>
              <td><?php echo $filas['num_fact_compra']?></td>
              <td><?php echo $filas['serie_fact_compra']?></td>
              <td><?php echo $filas['fecha_fact_compra']?></td>
              <td><?php echo $filas['nombre']?></td>
              <td>
              <?php if($origen == "cargarRetenCompra" ){?>
              
                <button type="button" class="btn btn-warning" onClick="selecFactCM('<?php echo $filas["id_fact_compra"]?>','<?php echo $filas['num_fact_compra']?>','<?php echo $filas['serie_fact_compra']?>','<?php echo $filas['nombre']?>','<?php echo $filas['tot_iva']?>','<?php echo $filas['m_iva_reten']?>','<?php echo $filas['mes_apli_reten']?>','<?php echo $filas['num_compro_reten']?>','<?php echo $filas['fecha_compro_reten']?>');" data-dismiss="modal" required="required">Seleccionar</button>
                
              <?php }elseif($origen == "modificarCompra" ){?>
              
                <button type="button" class="btn btn-warning" onClick="selecFactMF('<?php echo $filas["id_fact_compra"]?>','<?php echo $filas['num_fact_compra']?>','<?php echo $filas['serie_fact_compra']?>','<?php echo $filas['nombre']?>','<?php echo $filas['fk_proveedor']?>','<?php echo $filas['mtot_iva_compra']?>','<?php echo $filas['tipo_fact_compra']?>','<?php echo $filas['num_ctrl_factcompra']?>','<?php echo $filas['fecha_fact_compra']?>','<?php echo $filas['tipo_trans']?>');" data-dismiss="modal" required="required">Seleccionar</button>
                
              <?php }else{?>
                <button type="button" class="btn btn-warning" onClick="selecFactC('<?php echo $filas["id_fact_compra"]?>');" data-dismiss="modal" required="required">Seleccionar</button>
              <?php }?>
              </td>
            </tr>
            <?php
            }while($filas=pg_fetch_assoc($consulta));
		}else{
			?>
            <tr>
                <td colspan="5"><div>No hay resultados La Factura Debe Existir en el Sistema</div></td>
                <!--data-bs-toggle="modal" data-target="#nueProv" para agregar y con dismis cierra el actual-->
                <td><input type="button" class="btn btn-danger" value="Cancelar" data-dismiss="modal"></td>
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