<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

$tabla = $_GET['tabla'];
$columna = $_GET['columna'];

$consulta = pg_query($conexion,sprintf("SELECT %s AS columna FROM %s ORDER BY columna DESC",$columna, $tabla));
$filas = pg_fetch_assoc($consulta);

if($filas['columna'] == "")
	echo "0";
else 
	echo $filas['columna'];
?>