<?php
include_once("../conexion.php");
	$tabla = $_POST['tabla'];
	$campo = $_POST['campo'];
	$valor = $_POST['valor'];
	
	$sql = sprintf("SELECT * FROM %s WHERE %s = '%s'", $tabla, $campo, $valor);
	$consulta=mysqli_query($conexion,$sql);
	$filas=$consulta->fetch_assoc();
	$total_consulta = mysqli_num_rows($consulta);
	
	echo $filas['stock'];
?>