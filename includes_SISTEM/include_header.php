<?php
ob_start();

//setlocale(LC_ALL,"es_ES");
setlocale(LC_ALL, 'es_VE'); 
date_default_timezone_set('America/Caracas');

require_once("librerias/conexion.php"); 
require_once("php/funciones.php");
/** SISTEM_ROOT DIRECTORIO */
if (!defined('SISTEM_ROOT')) {
	define('SISTEM_ROOT', dirname(__FILE__) . '/');
	// EJEMPLO require(PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
}
?>