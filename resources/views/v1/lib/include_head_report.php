<?php
$uri   = "";//rtrim(dirname($_SERVER['REQUEST_URI']), '/\\');
$extra = "";
$url = str_replace("//","/",$_SERVER['REQUEST_URI']);
error_reporting(E_ALL);
ini_set('display_errors', '1');
//$url = rtrim(dirname($_SERVER['REQUEST_URI']), '/\\');
//  echo "aqui".$url;

if(strpos($url, '/modulos') || strpos($url, '/modales') || strpos($url, '/php')){
    $extra = '../../';
    echo "$extra";
    echo $extra;
    if(strpos($url, '/modulos/reporte'))
        $extra = '../';
}else
    $extra = '/';
///////////////////////////////////////////////////////////////////////////////////
//          FUNCIONES
////////////////////////////////////////////////////////////////////////////////////
include_once(dirname(__DIR__).$extra."Controllers/Conexion.php");
include_once(dirname(__DIR__).$extra."php/funciones.php");
if(!(strpos($url, '/php') || strpos($url, '/modulos/reporte'))){
?>
<!-- <title>Sist. YIM</title> -->
<!--ESTILOS BOOSTRAP-->
<link rel="stylesheet" type="text/css" href="<?php echo $uri.$extra?>css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $uri.$extra?>css/navbar-fixed-top.css">
<link rel="stylesheet" type="text/css" href="<?php echo $uri.$extra?>css/signin.css">
<link rel="stylesheet" type="text/css" href="<?php echo $uri.$extra?>css/loading.css">
<link rel="stylesheet" type="text/css" href="<?php echo $uri.$extra?>css/font-awesome-4.6.3/css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $uri.$extra?>css/otros-stylos.css">

<link rel="icon" href="<?php echo $uri.$extra?>logo.ico">
<?php }?>