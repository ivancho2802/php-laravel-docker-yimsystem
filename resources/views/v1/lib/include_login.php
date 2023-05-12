<?php
session_start();
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$urlPrev = str_replace("//","/",$_SERVER['REQUEST_URI']);

if(strpos($uri, 'modulos') || strpos($uri, 'res_reporte')|| strpos($uri, 'modales')){
	$extraLogin = '../../index.php';
}else{
	$extraLogin = 'index.php';
}

if($_SESSION["acceso"] == 0){
	$_SESSION['msm']="Tu Sesi&oacute;n a sido cerrada";
	$_SESSION['urlPrev']="http://$host$urlPrev";
	header("Location: http://$host$uri/$extraLogin");
	exit;
	
}elseif($_SESSION["acceso"] == 1){
	
	$arrayUrlsPriv2 = array("cargarRetenCompra.php",
							"cargarInvent.php",
							"modificarCompra.php");
	//echo $arrayUrlsPriv2[1];
	for($i=0;$i< count($arrayUrlsPriv2);$i++){
		if($_SESSION['privilegio']==2 && strpos($urlPrev, $arrayUrlsPriv2[$i])){
			$_SESSION["msm"]="Lo Sentimos No Posee Privilegios. Su Sesi&oacute;n ha Sido Cerrada";
			$_SESSION['urlPrev']="http://$host$urlPrev";
			header("Location: http://$host$uri/$extraLogin");
			exit;
		}elseif($_SESSION['privilegio']==1 ){
			
		}
	}
	//$_SESSION["msm"]
	//echo "http://$host$urlPrev";
	//$_SESSION["acceso"];
}
?>