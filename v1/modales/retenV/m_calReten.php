<!--BOOSTRAP-->
<link rel="stylesheet" type="text/css" href="bootstrap-3.3.6/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="bootstrap-3.3.6/css/estilo.css"/>
<script type="text/javascript" src="bootstrap-3.3.6/js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="bootstrap-3.3.6/js/bootstrap.min.js"></script>
<script>
<?php
/*
//inicializar variable del campo actual ya que no se recibe en todos lados
$urlActual = $_SERVER['REQUEST_URI'];
//echo $urlActual;
if( stristr($urlActual, "inventario") == true){
	$numCampoActual = "''";
}else
	$numCampoActual = "document.form1.numCampoActual.value";
*/
?>
//para desactivar el enter envie y cierre el modal
$(document).ready(function() {
	$(window.document).on('shown.bs.modal', '#calReten', function() {
		window.setTimeout(function() {
			<?php
			if($_SESSION['privilegio']!=1 && $_SESSION['privilegio']!=2)
			{
				header("Location: ../../index.php?acceso=1 ");
				exit;
			}
			?>
			$('#tot_iva', this).focus();
			url = '<?php echo $_SERVER['REQUEST_URI'];?>';
			patron1 = 'cargarRetenVenta';
			
			if(url.search(patron1) >= 0){
				calReten();
			}else{
				//document.forms['formcalReten'].elements['tot_iva'].value = document.form1.elements['costo'+numCampoActual].value;
				calReten();
			}
		}.bind(this), 100);
	});	
	$('#calReten').on('show.bs.modal', function (e) {
		document.onkeypress = stopRKey;
		
	});
	$('#calReten').on('hidden.bs.modal', function (e) {
		document.onkeypress = !stopRKey;
		
	});
});

//funcion calcular PMPVJ
function calReten(){
	tot_iva = parseFloat(document.forms['formcalReten'].elements['tot_iva'].value);
	porcentaje = parseFloat(document.forms['formcalReten'].elements['porcentaje'].value);
																	////////////	BI		/////////////////
	document.forms['formcalReten'].elements['m_iva_reten'].value = Math.round10( (tot_iva * porcentaje),-2 );
}

</script>
<!-- Modal nueCargo-->
<div id="calReten" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <form name="formcalReten" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Calculo de Retencion de Venta</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    Total I.V.A.:<br>
                    <input class="form-control" type="number" min="0" step="0.0000001" name="tot_iva" id="tot_iva" onKeyUp="calReten();"  value="" required readonly="readonly">
                </div>
                <div class="col-md-4 col-lg-4">
                    Porcentaje:<br>
                    <input class="form-control" type="number" min="0" step="0.0000001" name="porcentaje" id="porcentaje" onKeyUp="calReten();" value="0.75" required>
                </div>
                <div class="col-md-4 col-lg-4">
                    I.V.A. Retenido:<br>
                    <input class="form-control" type="number" min="0" step="0.0000001" name="m_iva_reten" id="m_iva_reten" onKeyUp="calReten();"  readonly="readonly">
                </div>
            </div><!--row-->
            <br />
          </div><!--form-group-->
      </div><!--modal-bosy-->
    </form><!--mbprov-->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="calReten();">Calcular</button>
      	<button type="button" class="btn btn-success" onclick="SeleccalReten(document.forms['formcalReten'].elements['m_iva_reten'].value)" data-dismiss="modal">Seleccionar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>