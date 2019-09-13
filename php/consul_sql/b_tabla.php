<?php
include_once('../../includes_SISTEM/include_head.php');
include_once($extra.'includes_SISTEM/include_login.php');

$tabla = $_GET['tabla'];
$columna = $_GET['columna'];
$valor = $_GET['valor'];


$consulta=pg_query($conexion,sprintf("SELECT * FROM %s WHERE %s = '%s'",$tabla, $columna, $valor));
$filas=$consulta->fetch_assoc();
$total_consulta = mysqli_num_rows($consulta);

if($filas)echo 1;
else echo 0;
?>