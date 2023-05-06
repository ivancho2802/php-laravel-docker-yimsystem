<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

//CODIGO DE INSERCION
if(isset($_POST['codigo']) && isset($_POST['nombre_i']) && isset($_POST['cant_min']) && isset($_POST['cant_max']) && isset($_POST['stock']) && isset($_POST['valor_unitario']) && isset($_POST['fecha']) ){

$insertSQL = sprintf("INSERT INTO inventario (codigo, nombre_i, cant_min, cant_max, descripcion, stock ,valor_unitario, fecha) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                       $_POST['codigo'],
                       $_POST['nombre_i'],
                       $_POST['cant_min'],
                       $_POST['cant_max'],
					   $_POST['descripcion'],
					   $_POST['stock'],
					   $_POST['valor_unitario'],
					   $_POST['fecha']."-28");

  //mysql_select_db($database_conexion);
  //SI NO SE REGISTR RETORNA DIE O MUERE EL PROCESO Y MUESTRA
  $Result1 = pg_query($conexion,$insertSQL) or die('
	<div class="alert alert-danger in" role="alert">
			<strong>Opps!</strong> Codigo Existente.
			Error para PRODUCTO: '.pg_last_error().'
			<button type="button" class="close" data-dismiss="alert" aria-label="close">&times;</button>
	</div>');
//HASTA AQUI CODIGO DE INSERCION

//PARA INSERTAR EN REGISTRO PARA INV INICIAL
if($Result1 && isset($_POST['tipo']) && $_POST['tipo']=="inv_ini"){
		//INSERTAR PARA EL  REGISTRO DE INVENTARIO LO ACTUAL SEGUN LA FECHA PARA KARDEX
		$InsertRegInv = sprintf("INSERT INTO reg_inventario( fecha_reg_inv, costo_reg_inv, pmpvj, cantidad_reg_inv,tipo , fk_inventario, fecha_registro, hora_registro) VALUES
											('%s','%s','%s','%s','%s','%s','%s','%s')",
											$_POST['fecha']."-28",
											$_POST['valor_unitario'],//costo actual para esta fecha
											$_POST['pmpvj'],
											$_POST['stock'],//cantidad actual para esta fecha
											$_POST['tipo'],
											$_POST['codigo'],
											date('Y/m/d'),
											date('H:i:s'));
		$resInsertRegInv = pg_query($conexion,$InsertRegInv)or die('registro inventario NO realizada con éxito'.pg_last_error());
	}
  //si llega ha esta linea quiere decir que no ha arrojado error RIGISTRO EXITOSO
  //echo $_POST['fecha'];
  ?>
  <div class="alert alert-success" role="alert">
    <strong>Excelente&grave;</strong> Registro y seleccion exitosa <strong>Click para Volver</strong>.
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  
  <?php
}else{
	echo "Error no se enviaron algunos parametros que se esperaban";
	}