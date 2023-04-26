<?php
$uri   = "";//rtrim(dirname($_SERVER['REQUEST_URI']), '/\\');
$extra = "";
$url = str_replace("//","/",$_SERVER['REQUEST_URI']);
error_reporting(E_ALL);
ini_set('display_errors', '1');
//$url = rtrim(dirname($_SERVER['REQUEST_URI']), '/\\');

if(strpos($url, 'modulos/') > 0 || strpos($url, 'modales/') > 0  || strpos($url, 'php/') > 0 ){
	
	if( $_SERVER["SERVER_NAME"] === 'localhost'){
		$extra1 = '../';
		$extra = '../../';
	}
	else{
		$extra = '../../';
		$extra1 = $extra;
	}
	//echo "$extra";
	if(strpos($url, 'modulos/reporte') > 0)
		$extra = '../';

} else {
	if ($_SERVER["SERVER_NAME"] === 'localhost')
	{
		$extra1 = '/';
	} else {
		$extra = '/';
		$extra1 = $extra;
	}
}
//echo $_SERVER["SERVER_NAME"];
//echo $extra;
///////////////////////////////////////////////////////////////////////////////////
//			FUNCIONES
////////////////////////////////////////////////////////////////////////////////////
require_once(dirname(__DIR__).$extra1."librerias/conexion.php");
require_once(dirname(__DIR__).$extra1."php/funciones.php");
if(!(strpos($url, '/php') || strpos($url, '/modulos/reporte'))){
?>
<title>Sist. YIM</title>
<!--ESTILOS BOOSTRAP-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo $uri.$extra?>css/bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="<?php echo $uri.$extra?>css/navbar-fixed-top.css">
<link rel="stylesheet" type="text/css" href="<?php echo $uri.$extra?>css/signin.css">
<link rel="stylesheet" type="text/css" href="<?php echo $uri.$extra?>css/loading.css">
<link rel="stylesheet" type="text/css" href="<?php echo $uri.$extra?>css/font-awesome-4.6.3/css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $uri.$extra?>css/otros-stylos.css">

<link rel="icon" href="<?php echo $uri.$extra?>logo.ico">
<script type="text/javascript" src="<?php echo $uri.$extra?>js/jquery-3.6.0.min.js"></script>
<!--<script type="text/javascript" src="<?php //echo $uri.$extra?>js/jquery-ui.min.js"></script>-->
<script type="text/javascript" src="<?php echo $uri.$extra?>js/funciones.js"></script>
  
</body>

<?php }?>