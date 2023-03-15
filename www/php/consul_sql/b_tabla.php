<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

$tabla = $_GET['tabla'];
$columna = $_GET['columna'];
$valor = $_GET['valor'];


$consulta=pg_query($conexion,sprintf("SELECT * FROM %s WHERE %s = '%s'",$tabla, $columna, $valor));
$filas=pg_fetch_assoc($consulta);
$total_consulta = pg_num_rows($consulta);

if($filas)echo 1;
else echo 0;
?>