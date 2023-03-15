<?php
include_once("../conexion.php");
	$tabla = $_POST['tabla'];
	$campo = $_POST['campo'];
	$valor = $_POST['valor'];
	
	$sql = sprintf("SELECT * FROM %s WHERE %s = '%s'", $tabla, $campo, $valor);
	$consulta=pg_query($conexion,$sql);
	$filas=pg_fetch_assoc($consulta);
	$total_consulta = pg_num_rows($consulta);
	
	echo $filas['stock'];
?>