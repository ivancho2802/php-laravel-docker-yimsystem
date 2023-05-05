 <?php
	include_once('../../includes_SISTEM/include_head.php');
	include_once('../../includes_SISTEM/include_login.php');
	//MODALES
	include_once("../../modales/prod/m_a_prod.php");
	//llamando de modales el id es "calPMPVJ"
	include_once("../../modales/prod/m_PMPVJ.php")
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
	$('#nueProd').modal({backdrop: 'static', keyboard: false})
	document.getElementById('close_m').setAttribute('data-dismiss','');
	document.getElementById('close_m_x').setAttribute('data-dismiss','');
	$('#nueProd').modal('show');
	
	$(window.document).on('shown.bs.modal', '#nueProd', function() {
		window.setTimeout(function() {
			
		}.bind(this), 100);
	});
	$(window.document).on('hidden.bs.modal', '#nueProd', function() {
		window.setTimeout(function() {
	  		
		}.bind(this), 100);
	});
});
</script>