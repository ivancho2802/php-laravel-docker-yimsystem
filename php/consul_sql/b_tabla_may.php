<?php
include_once('../../includes_SISTEM/include_head.php');
require_once($extra.'includes_SISTEM/include_login.php');

$tabla = $_GET['tabla'];
$columna = $_GET['columna'];

$consulta = $conexion->query(sprintf("SELECT %s AS columna FROM %s ORDER BY columna DESC",$columna, $tabla));
$filas = $consulta->fetch_assoc();

if($filas['columna'] == "")
	echo "0";
else 
	echo $filas['columna'];
?>