<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

$vfecha = $_GET['vfecha'];

$pre_consulta=pg_query($conexion,sprintf("SELECT * FROM reg_inventario"));
$filas_pre=$pre_consulta;
$total_pre_consulta = pg_num_rows($pre_consulta);
////////////////////////////////////////////////////////////////////////
$consulta=pg_query($conexion,sprintf("SELECT * FROM reg_inventario, inventario WHERE 
												reg_inventario.fk_inventario = inventario.codigo AND
												'%s' > reg_inventario.fecha_reg_inv", $vfecha));
$filas=pg_fetch_assoc($consulta);
$total_consulta = pg_num_rows($consulta);
////////////////////////////////////////////////////////////////////////7
$consulta2=pg_query($conexion,sprintf("SELECT * FROM reg_inventario, inventario WHERE 
												reg_inventario.fk_inventario = inventario.codigo 
												ORDER BY fecha_reg_inv ASC"));
// $filas2 = $c_inv_menor->fetch_assoc();
$filas2=pg_fetch_assoc($consulta2);
$total_c_inv_menor = pg_num_rows($c_inv_menor);

if($filas_pre){//si existen registros al menos
	if($filas)
		echo 1;//esta bien
	else 
		echo $filas2['fecha_reg_inv'];
}else
	echo 2;//retorno condicion 2 para javascript decir que debe ingresar almenos un inventario inicial
	
?>