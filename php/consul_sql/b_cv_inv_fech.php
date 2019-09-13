<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

$vfecha = $_GET['vfecha'];

$pre_consulta=pg_query($conexion,sprintf("SELECT * FROM reg_inventario"));
$filas_pre=$pre_consulta);
$total_pre_consulta = mysqli_num_rows($pre_consulta);
////////////////////////////////////////////////////////////////////////
$consulta=pg_query($conexion,sprintf("SELECT * FROM reg_inventario, inventario WHERE 
												reg_inventario.fk_inventario = inventario.codigo AND
												'%s' > reg_inventario.fecha_reg_inv", $vfecha));
$filas=$consulta->fetch_assoc();
$total_consulta = mysqli_num_rows($consulta);
////////////////////////////////////////////////////////////////////////7
$c_inv_menor=pg_query($conexion,sprintf("SELECT * FROM reg_inventario, inventario WHERE 
												reg_inventario.fk_inventario = inventario.codigo 
												ORDER BY fecha_reg_inv ASC"));
$filas_c_inv_menor = $c_inv_menor->fetch_assoc();
$total_c_inv_menor = mysqli_num_rows($c_inv_menor);

if($filas_pre){//si existen registros al menos
	if($filas)
		echo 1;//esta bien
	else 
		echo $filas_c_inv_menor['fecha_reg_inv'];
}else
	echo 2;//retorno condicion 2 para javascript decir que debe ingresar almenos un inventario inicial
	
?>