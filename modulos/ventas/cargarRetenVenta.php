<?php
session_start(); 
if($_SESSION['privilegio']!=1 && $_SESSION['privilegio']!=2)
{
	header("location: index.php?acceso=1 ");
	exit;
} 
if (! empty($_SESSION["usuario"])) 
  echo "usuario vacio";
else//este es igual login osea si alguien se ha logeado
  //echo "id_usu:".$_SESSION["id_usu"];
?>
<?php
	include_once("conexion.php");
	//llamado de modales el id es "busFact"
	include_once("modales/retenV/m_a_retenV.php");
	//llamado de modales el id es "busFact"
	include_once("modales/fact_v/m_b_fact_v.php");
	//llamando de modales el id es "calReten"
	include_once("modales/retenV/m_calReten.php");
	
?>
<script language="javascript" type="text/javascript" src="javascript/js/jquery-1.6.4.min.js"></script>
<!--BOOSTRAP-->
<script language="javascript" type="text/javascript" src="bootstrap-3.3.6/js/jquery-1.12.0.min.js"></script>
<script language="javascript" type="text/javascript" src="bootstrap-3.3.6/js/bootstrap.min.js"></script>

<script language="javascript" type="text/javascript" src="javascript/funciones.js"></script>
<!--PARA LLAMAR A EL cRUL RIF-->
<script>
$(document).ready(function() {
	$('#nueRetenV').modal('show');
	
	$(window.document).on('shown.bs.modal', '#nueRetenV', function() {
		window.setTimeout(function() {
			
		}.bind(this), 100);
	});
	$(window.document).on('hidden.bs.modal', '#nueRetenV', function() {
		window.setTimeout(function() {
	  		
		}.bind(this), 100);
	});
});
</script>
<link rel="stylesheet" href="css/estilos_entrada.css" type="text/css"/>
<h2>Aplicar Rentencion - Venta</h2>