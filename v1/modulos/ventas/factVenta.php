<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

date_default_timezone_set('America/Caracas');
setlocale(LC_ALL, "es_ES");
//llamado de modales el id es "busFact"
$extra = "../../";
include_once($extra . "modales/fact_v/m_b_fact_v.php");

?>
<script>
	$(document).ready(function() {
		window.setTimeout(function() {
			$('#busFact').modal({
				backdrop: 'static',
				keyboard: false
			})
			document.getElementById('close_m').setAttribute('data-dismiss', '');
			document.getElementById('close_m_x').setAttribute('data-dismiss', '');
			$('#busFact').modal('show');

		}.bind(this), 1000);



		$(window.document).on('shown.bs.modal', '#busFact', function() {
			window.setTimeout(function() {

			}.bind(this), 100);
		});
		$(window.document).on('hidden.bs.modal', '#busFact', function() {
			window.setTimeout(function() {

			}.bind(this), 100);
		});
	});

	function mConsulFact(str) {
		//alert(str);
		var xhttp;
		xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				document.getElementById("resFact2").innerHTML = xhttp.responseText;
				$('#mostrarFact').modal('show');
			}
		};
		url = '<?php echo $extra ?>modales/fact_v/m_b_fact_v_det.php';
		xhttp.open("POST", url, true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("nfact_afectada=" + str);
	}
</script>