<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');



//llamado de modales el id es "busFact"
$extra = "../../";
include_once($extra . "modales/retenC/m_a_retenC.php");


//llamado de modales el id es "busFact"
$extra = "../../";
include_once($extra . "modales/fact_c/m_b_fact_c.php");
//llamando de modales el id es "calReten"
include_once($extra . "modales/retenC/m_calReten.php");

//llamando de modales el id es "nueProv"
include_once($extra . "modales/prov/m_a_prov.php");
//llamado de modales el id es "busProv"
include_once($extra . "modales/prov/m_b_prov.php");

$mensaje = '<strong><span class="glyphicon glyphicon-warning-sign" style="font-size:60;float:left"></span></strong> 
				Lo sentimos ud debe cumplir ciertas condiciones para retener en compras Debe Ser<br />
				- Contribuyente Especial<br />
				- Debe Retener IVA segun pagina del SENIAT'; //EL MENSAJE DEL ALERT
//llamando de modales "alert"
include_once($extra . "modales/alert/m_alert.php");

//consultade los datos de la empresa ACTIVA
$consulta = pg_query($conexion, "SELECT * FROM empre WHERE empre.est_empre = '1'");
// $filasEmpre = pg_fetch_assoc($consultaEmpre);
$filas = pg_fetch_assoc($consulta);
$total_consultaEmpre = pg_num_rows($consulta);
//$filas cod_empre
?>
<!--PARA LLAMAR A EL cRUL RIF-->
<script>
	$(document).ready(function() {
		//VALIDACION DE LA RETENCION DE COMPRAS SI EN CONTRIBUYENTE ESPECIAL PUEDE HACER ESTO
		/*
	//FUNCION CURL QUE ENVIA LA CEDULA PARA SABER SI ES RETENEDOR
	var xhttp;
	var str = <?php //echo $filas['cod_empre']
				?>;
  	xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
	if (xhttp.readyState == 4 && xhttp.status == 200) {
	  document.getElementById("txtHint").innerHTML = xhttp.responseText;
	}
  };
	xhttp.open("POST", "funciones_ivan/cURL/ajax_rif_empre_contri.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("rif="+ str);
	*/
	setTimeout(() => {
		
		var retenC = '<?php echo $filas['reteniva'] ?>';
		var contriC = '<?php echo $filas['contri_empre'] ?>';
		if (retenC == 'SI' && contriC == 'Especial') {
			if($('#nueRetenC'))
			$('#nueRetenC').modal({
				backdrop: 'static',
				keyboard: false
			})
			if($('#nueRetenC'))
			$('#nueRetenC').modal('show');
			alert('asd')
		} else{
			if($('#alert'))
			$('#alert').modal('show');

		}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////

		$(window.document).on('shown.bs.modal', '#nueRetenC', function() {
			window.setTimeout(function() {

			}.bind(this), 100);
		});
		$(window.document).on('hidden.bs.modal', '#nueRetenC', function() {
			window.setTimeout(function() {

			}.bind(this), 100);
		});
	}, 2000);
	});
</script>
<!--LUGAR DONDE SE CARGA EL MODAL DE DETALLES DE LA FACTURA
    	m_b_fact_c_det.php
    -->
<span id="res_nfact_afectada"></span>

<div class="container">
	<div class="row">
		<h1>Aplicar Rentencion - Compra</h1>
	</div>
</div>

<button class="btn btn-primary m-0" data-toggle="modal" data-target="#nueRetenC">asd</button>
  <script src="../../js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
