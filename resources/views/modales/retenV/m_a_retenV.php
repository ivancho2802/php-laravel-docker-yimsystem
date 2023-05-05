<!--BOOSTRAP-->
<link rel="stylesheet" type="text/css" href="bootstrap-3.3.6/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="bootstrap-3.3.6/css/estilo.css"/>
<script type="text/javascript" src="bootstrap-3.3.6/js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="bootstrap-3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="javascript/funciones.js"></script>
<!--<script type="text/javascript" src="js/jquery.min.js"></script>-->
<script>

$(document).ready(function() {
	$(window.document).on('shown.bs.modal', '#nueRetenV', function() {
		window.setTimeout(function() {
			<?php
			if($_SESSION['privilegio']!=1 && $_SESSION['privilegio']!=2)
			{
				header("Location: ../../index.php?acceso=1 ");
				exit;
			}
			?>
			$('#id_fact_venta', this).focus();
			$('#nueRetenV').modal({ keyboard: false });
			document.onkeypress = stopRKey;
			
			url = '<?php echo $_SERVER['REQUEST_URI'];?>';
			patron1 = 'cargarRetenVenta';
			
			if(url.search(patron1) > 0){
				//document.forms["formModal"].elements["stock"].readOnly = null;
				//document.forms["formModal"].elements["stock"].lang = "si-number";
				//document.forms["formModal"].elements["bpmpvj"].disabled = null;
				
				$(document).on("click", "#cont_m_iva_reten", function () {
					//alert();
					var tot_iva = document.getElementById('tot_iva').value;
					if(tot_iva == ""){//VALIDO
						alert('Debe Llenar el VALOR TOTAL IVA');
						$('#busFact').modal('show');
					}else{
						$('#calReten').modal('show');
						$(".modal-body #tot_iva").val(tot_iva);
					}
				});
			}
			
		}.bind(this), 100);	
	});
});
	
	function modRReten(formulario) {
		//funcion de validacion
		document.getElementById("txtHintAPROV").innerHTML = "";
		var valido = validarFormulario(formulario);
		
		if(valido==1)
		{
		  //paramentros y funciones de registro AJAX	
		  var xhttp;
		  //variables contenidas en el formulariuo
		  var id_fact_venta = $("input#id_fact_venta").val();
		  var num_compro_reten = $("input#num_compro_reten").val();
		  var fecha_compro_reten = $("input#fecha_compro_reten").val();
		  var m_iva_reten = $("input#m_iva_reten").val();
		  var mes_apli_reten = $("input#mes_apli_reten").val();
		  
		  xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				
			    document.getElementById('txtHintAPROV').innerHTML = xhttp.responseText;
				document.getElementById("id_fact_venta").value = "";
			}
		  };
		  //	MODIFICAR RETENCION
		  	url = '<?php echo $_SERVER['REQUEST_URI'];?>';
			patronA = 'cargarRetenVenta';//patronB = 'compra|venta'
			
		    if(url.search(patronA) > 0){
				xhttp.open("POST", "modales/retenV/m_retenV.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				
				xhttp.send("id_fact_venta="+ id_fact_venta +
						   "&num_compro_reten="+ num_compro_reten +
						   "&fecha_compro_reten="+ fecha_compro_reten +
						   "&m_iva_reten="+ m_iva_reten+
						   "&mes_apli_reten="+ mes_apli_reten
						   );
			}
			/*
			else if(  (url.search(patronB) > 0)  ){
				xhttp.send("codigo="+ codigo +"&nombre_i="+ nombre_i +"&cant_min="+ cant_min +"&cant_max="+ cant_max +"&stock="+ stock +"&valor_unitario="+ valor_unitario+"&fecha="+ fecha);
				selecProd(codigo, nombre_i, valor_unitario, stock, document.form1.numCampoActual.value);
				fcalculo();
			}
			*/
		}
			
	}	
</script>

<!-- Modal nueProv-->
    <div id="nueRetenV" class="modal fade" data-backdrop="static"  role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            <h4 class="modal-title">Venta - Aplicar Retencion</h4>
          </div>
          <form name="formModal" method="post">
          <div class="modal-body">
              <div class="form-group">
                	<div class="row">
                        <!--para mostrar resultado de acciones de insercion y demas-->
                        <label class="col-md-12 col-lg-12" id="txtHintAPROV" data-bs-dismiss="modal"></label>
                    </div>
                	<div class="row">
                    	<label class="col-md-4 col-lg-4" id="res_id_fact_venta" data-bs-toggle="modal" data-bs-target="#busFact">
                        	<input type="hidden" class="form-control" name="id_fact_venta" id="id_fact_venta" lang="si-general" required>
                            Num. Factura de Venta:<br>
                            <span class="input-group" id="cont_id_fact_venta">
                            <input class="form-control" id="num_fact_venta" readonly="readonly" lang="si-general" required="required">
                            	<span class="input-group-btn">
                                <button type="button" class="btn btn-info">Buscar Factura</button>
                                </span>
                            </span>
                        </label>
                        <label class="col-md-4 col-lg-4">
                        	Serie Factura de Venta:<br />
                        	<input type="text" class="form-control" id="serie_fact_venta"  data-bs-toggle="modal" data-bs-target="#busFact" readonly="readonly" lang="si-general" required="required">
                        </label>
                        <label class="col-md-4 col-lg-4">
                        	Cliente:<br />
                        	<input type="text" class="form-control" id="cliente_fact_venta"  data-bs-toggle="modal" data-bs-target="#busFact" readonly="readonly" lang="si-general" required="required">
                        </label>
                    </div>
                    <div class="row">
                        <label class="col-md-4 col-lg-4" id="res_num_compro_reten">
                        	Num. Comp. de Retencion:<br>
                        	<span id="cont_num_compro_reten">
                            <input type="text" class="form-control" name="num_compro_reten" id="num_compro_reten" lang="si-num_compro_reten" onBlur="validar_repetidoM('fact_venta', 'num_compro_reten', this.value, 'num_compro_reten')" required>
                            </span>
                        </label>
                        <label class="col-md-4 col-lg-4">
                            Fecha del Comp. de Retencion:<br>
                            <input type="date" class="form-control" name="fecha_compro_reten" id="fecha_compro_reten" lang="si-general">
                        </label>
                    	<label class="col-md-4 col-lg-4">
                            Mes de Aplicacion Retencion:<br>
                            <input type="month" class="form-control" name="mes_apli_reten" id="mes_apli_reten" value="" lang="si-general">
                        </label>
                    </div>
                    <div class="row">
                    	<label class="col-md-6 col-lg-6">
                        	Total I.V.A.:<br />
                    		<input type="text" class="form-control" id="tot_iva"  data-bs-toggle="modal" data-bs-target="#busFact" readonly="readonly" lang="si-general" required="required">
                    	</label>
                    	<label class="col-md-6 col-lg-6" id="res_m_iva_reten">
                            I.V.A. Retenido:<br>
                            <span class="input-group" id="cont_m_iva_reten">
                                <input class="form-control" name="m_iva_reten" id="m_iva_reten" readonly="readonly" lang="si-general" required="required">
                                    <span class="input-group-btn ">
                                    <button type="button" class="btn btn-info">Calcular Retencion</button>
                                    </span>
                            </span>
                            
                        </label>
                    </div>
              </div><!--form-group-->
          </div><!--modal-bosy-->
          
          <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="modRReten(this.form);">Agregar y Seleccionar</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          </div>
          </form><!--maprov-->
        </div>
    
      </div>
    </div>