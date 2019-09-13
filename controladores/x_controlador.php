<?php
include_once("../clases/utilidades.class.php");
$objUtilidades=new utilidades;
$conexion=$objUtilidades->conectar();
$accion=@$_REQUEST["accion"];
$error=0;

switch($accion)
{
///////////////////////////////////////////////////////////////////////////////////////////////////////////
 case 'buscar_dato':
 $objUtilidades->buscar_datos($conexion,trim($_GET["valor"]),trim(@$_GET["tabla"]),trim(@$_GET["campo"]),trim(@$_GET["campo_retorno"]));
 break;
////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 'validar_repetido':
$objUtilidades->validar_repetido($conexion,$_GET["valor"],$_GET["tabla"],$_GET["columna"]);
break;

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>