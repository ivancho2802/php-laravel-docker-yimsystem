<?php
ob_start();
session_start();
//////////////////////////////////			CONSULTA DE LA INFO DEL SISTEMA
include_once("../librerias/conexion.php");
$sql="select * from data_system where edo_ds='1'";
$ok=pg_query($conexion, $sql);
//$resultado=mysql_fetch_assoc($ok);
//////////////////////////////////////////
include_once("../clases/usuario.class.php");
//include_once("../clases/utilidades.class.php");
//$objUtilidades=new utilidades;
//$conexion=$objUtilidades->conectar();

$objUsuario=new usuario;
$usu_aprobado=$objUsuario->iniciar_sesion($conexion,$_POST["usuario"],$_POST["clave"]);
$_SESSION["acceso"] = $usu_aprobado['acceso'];

$_SESSION["msm"] = $usu_aprobado["mensaje"];

if($_SESSION["acceso"] == 1)
 {
	//INICIALIZO LA VARIABLE urlPrev
	$_SESSION['urlPrev']="";
	$_SESSION["usuario"]=$usu_aprobado["usuario"];
	$_SESSION["id_usu"]=$usu_aprobado["idusuario"]; 
	$_SESSION["privilegio"]=$usu_aprobado["nivel"];
	/////////////////////////////////////////////			DATOS DEL SISTEMAS SON GLOBALES AHORA 
	$_SESSION["alias"]=$usu_aprobado["alias_ds"];
	$_SESSION["version"]=$usu_aprobado["version_ds"];
	$url ="...";
	if($_POST["urlPrev"] !== ""){
		$url = $_POST["urlPrev"];
		echo "aqui".$url;
	}else
		$url = "../admin.php";
	header("Location:$url");
	exit;	  
 }else{
	// echo $_POST['urlPrev'];
	$_SESSION['urlPrev'] = $_POST['urlPrev'];
	header("Location:../index.php");
	exit;
 }
ob_end_flush();
?>