<?php 
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

//inicializar variable del campo actual ya que no se recibe en todos lados
if(isset($_POST['urlActual']))
{
	$urlActual = $_POST['urlActual'];
	//echo $urlActual;
		if( stristr($urlActual, "cargarRetirosInvent") == false){
			$numCampoActual = "document.form1.numCampoActual.value";
		}else
			$numCampoActual = "''";
			
		if(stristr($urlActual, "venta") == true){
			$tipo = "venta";
		}else
			$tipo = "compra";
}else
	$numCampoActual = "document.form1.numCampoActual.value";


	if(isset($_POST['prod'])){
		
		if($_POST['prod'] == " "){
			
			//si el sql cambio por que se envio lleno desde m_b_prod con el campo tipo lleno en NC
			//echo $consulta;
			if(isset($_POST['sqlN']) && $_POST['sqlN']!== '' && isset($_POST['tipoDoc']) && $_POST['tipoDoc']=="NC-DESC" || $_POST['tipoDoc']=="NC-DEVO" ){
				//echo $_POST['sqlN'];
				$consulta = pg_query($conexion,sprintf($_POST['sqlN']));
				
			}else//realizo el sql
				$consulta=pg_query($conexion,sprintf("SELECT * FROM inventario"));
				
			
		}else{
			//recibo la variable post
			$prod = "%".$_POST['prod']."%";	
			//realizo el sql
			//if(stristr($urlActual, "venta") == true){
			if(isset($_POST['sqlN']) && $_POST['sqlN']!== '' && isset($_POST['tipoDoc']) && $_POST['tipoDoc']=="NC-DESC" || $_POST['tipoDoc'] == "NC-DEVO" || $_POST['tipoDoc'] == "ND"){//DE MANERA INDIRECTA
				//ASIGNANDO EL SQL DE LA CONNSULTA
				$consulta=pg_query($conexion,sprintf($_POST['sqlN']."
																AND
																inventario.nombre_i LIKE '%s'",
																$prod));
			}else{
				$consulta=pg_query($conexion,sprintf("SELECT * FROM inventario WHERE
																inventario.nombre_i LIKE '%s' OR 
																inventario.descripcion LIKE '%s' OR 
																inventario.codigo LIKE '%s'",
																$prod, $prod, $prod));
			}
			
		}
		$filas=pg_fetch_assoc($consulta);
		$total_consulta = pg_num_rows($consulta);
		
	}
		
?>
<div class="table-responsive">
<br>
<h4>Resultados Item &oacute; Producto</h4>
<table class="table table-bordered">
  <thead>
	<tr>
    	<td><b>Nombre</b></td>
        <td><b>Codigo</b></td>
        <td><b>Descripcion</b></td>
        <td><b><?php if(isset($_POST['tipoDoc']) && $_POST['tipoDoc']=="NC-DESC" || $_POST['tipoDoc'] == "NC-DEVO" || $_POST['tipoDoc'] == "ND") echo "Cantidad"; else echo "Stock";?></b></td></b></td>
        <td><b><?php if(isset($_POST['tipoDoc']) && $_POST['tipoDoc']=="NC-DESC" || $_POST['tipoDoc'] == "NC-DEVO" || $_POST['tipoDoc'] == "ND") echo "Costo"; else echo "Precio de Venta / Costo Promediado";?></b></td>
        <td><b>Fecha de Insercion</b></td>
        <td><b>Accion</b></td>
    </tr>
  </thead>
  <tbody>
<?php
		//para saber si hay resultados y mostrar
		if($total_consulta >= 1){
				
			do{
				if($tipo == "venta"){
					//consulta de los precios de venta
					/// 		consulta de precio de venta mas actual pva
					$consulta_pva=pg_query($conexion,sprintf("SELECT * FROM inventario WHERE
										inventario.codigo = '%s' ",
										$filas['codigo']));//para obtener elmas actual
					// $filas_pva=$consulta_pva->fetch_assoc();
					$filas_pva=pg_fetch_assoc($consulta_pva);

					$total_consulta_pva = pg_num_rows($consulta_pva);
					
					$td_costo = $filas_pva['pmpvj_actual'];
					$cantidadstock = $filas['stock'];
					////////////////////////////////////
					if(isset($_POST['sqlN']) && $_POST['sqlN']!== '' && isset($_POST['tipoDoc'])  && $_POST['tipoDoc']=="NC-DESC" || $_POST['tipoDoc']=="NC-DEVO" || $_POST['tipoDoc']=="ND"){
						$td_costo = $filas['valor_unitario'];
						$cantidadstock = $filas['stock'];

						if($_POST['tipoDoc']=="NC-DESC"){//solo necesitos los precios la cantidad puede ser 
							$td_costo = $filas['costo'];
							$cantidadstock = $filas['cantidad'];
						}elseif($_POST['tipoDoc']=="NC-DEVO"){//uso solo el numero de productos que voy a devolver y a cuanto
							$td_costo = $filas['costo'];
							$cantidadstock = $filas['cantidad'];
						}
						
					}
				}elseif($tipo == "compra"){
					//COMMPRA
					$consulta_costo_actual=pg_query($conexion,sprintf("SELECT * FROM inventario WHERE 
									inventario.codigo = '%s'",
									$filas['codigo']));//para obtener elmas actual
					$filas_costo_actual=pg_fetch_assoc($consulta_costo_actual);
					// $filas_costo_actual=$consulta_costo_actual->fetch_assoc();
					$total_consulta_costo_actual = pg_num_rows($consulta_costo_actual);
					
					
					$td_costo = $filas_costo_actual['valor_unitario'];
					$cantidadstock = $filas['stock'];
					
					if(isset($_POST['sqlN']) && $_POST['sqlN']!== '' && isset($_POST['tipoDoc'])  && $_POST['tipoDoc']=="NC-DESC" || $_POST['tipoDoc']=="NC-DEVO" || $_POST['tipoDoc']=="ND"){
						if($_POST['tipoDoc']=="NC-DESC"){//solo necesitos los precios la cantidad puede ser 
							$td_costo = $filas['valor_unitario'];
							$cantidadstock = $filas['cantidad'];
						}elseif($_POST['tipoDoc']=="NC-DEVO"){//uso solo el numero de productos que voy a devolver y a cuanto
							$td_costo = $filas['valor_unitario'];
							$cantidadstock = $filas['cantidad'];
						}
						
					}
				}
			?>
            <tr>
              <td><?php echo $filas['nombre_i']?></td>
              <td><?php echo $filas['codigo']?></td>
              <td><?php echo $filas['descripcion']?></td>
              <td><?php echo $cantidadstock;?></td>
              <td><?php echo round($td_costo,2); ?></td>
              <td><?php echo $filas['fecha']?></td>
              <td>
              	<span class="input-group">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-info" onClick="selecProd('<?php echo $filas["codigo"]?>','<?php echo $filas["nombre_i"]?>','<?php echo $td_costo;?>','<?php echo $cantidadstock?>',<?php echo $numCampoActual?>);" data-dismiss="modal">Seleccionar</button>
                  
                    <button type="button" class="btn btn-warning" onClick="mmProd('<?php echo $filas["codigo"]?>');">Modificar</button>
                  </span>
                </span>
              </td>
            </tr>
            <?php
            }while($filas=pg_fetch_assoc($consulta));
		}else{
			?>
            <tr>
                <td colspan="6"><div>No hay resultados</div></td>
                <!--data-bs-toggle="modal" data-target="#nueProv" para agregar y con dismis cierra el actual-->
                <td>
                <?php if($tipo == "venta"){?>
                	Lo sentimos pero Debe <br>
					AGREGAR el PRODUCTO por <br>
					COMPRAS o como INVENTARIO INICIAL
                <?php }elseif($tipo == "compra"){?>
                <input type="button" class="btn btn-success" value="Agregar y Seleccionar Producto" data-dismiss="modal" data-bs-toggle="modal" data-target="#nueProd">
                <?php }?>
                </td>
            </tr>
            <?php    
		}
?>		
		</tbody>
</table>
</div>