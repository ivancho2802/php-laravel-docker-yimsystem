<?php
$uri   = "";//rtrim(dirname($_SERVER['REQUEST_URI']), '/\\');
$extra = "";
$url = str_replace("//","/",$_SERVER['REQUEST_URI']);
error_reporting(E_ALL);
ini_set('display_errors', '1');
//$url = rtrim(dirname($_SERVER['REQUEST_URI']), '/\\');
//	echo "aqui".$url;

if(strpos($url, '/modulos') || strpos($url, '/modales') || strpos($url, '/php')){
	
	if( $_SERVER["SERVER_NAME"] == 'localhost'){
		$extra1 = '../';
		$extra = '../../';
	}
	else{
		$extra = '../../';
		$extra1 = $extra;
	}
	//echo "$extra";
	if(strpos($url, '/modulos/reporte'))
		$extra = '../';
}else{
	if( $_SERVER["SERVER_NAME"] == 'localhost')
	$extra1 = './';
	else{
		$extra = '/';
		$extra1 = $extra;
	}
}
//echo $_SERVER["SERVER_NAME"];
//echo $extra;
///////////////////////////////////////////////////////////////////////////////////
//			FUNCIONES
////////////////////////////////////////////////////////////////////////////////////
include_once(dirname(__DIR__).$extra1."Controllers/Conexion.php");
include_once(dirname(__DIR__).$extra1."php/funciones.php");
if(!(strpos($url, '/php') || strpos($url, '/modulos/reporte'))){
?>

<script type="text/javascript" src="<?php echo $uri.$extra?>js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo $uri.$extra?>js/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo $uri.$extra?>js/bootstrap.min.js"></script>

<?php }?>
