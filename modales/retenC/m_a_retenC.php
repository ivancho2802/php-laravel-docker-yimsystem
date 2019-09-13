<?php include_once('../../includes_SISTEM/include_head.php');?>
<script>

$(document).ready(function() {
	$(window.document).on('shown.bs.modal', '#nueRetenC', function() {
		window.setTimeout(function() {
			<?php include_once($extra.'includes_SISTEM/include_login.php');?>
			$('#id_fact_compra', this).focus();
			$('#nueRetenC').modal({ keyboard: false });
			document.onkeypress = stopRKey;
			
			url = '<?php echo $_SERVER['REQUEST_URI'];?>';
			patron1 = 'cargarRetenCompra';
			
			if(url.search(patron1) > 0){
				//document.forms["formModal"].elements["stock"].readOnly = null;
				//document.forms["formModal"].elements["stock"].lang = "si-number";
				//document.forms["formModal"].elements["bpmpvj"].disabled = null;
				/*$(document).on("click", "#cont_id_fact_compra", function () {
					
					var inputPU = document.getElementById('valor_unitario').value;
					if(inputPU == ""){//VALIDO
						alert('VALOR UNITARIO NECESARIO');
						document.getElementById('valor_unitario').focus();
					}else{}
					
					$('#busFact').modal('show');
					//$(".modal-body #costoActual").val(inputPU);//llevarme este valor al modal nuevo
				});*/
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
				//
				formGroupNueRetenC = document.getElementById('form-group-nueRetenC').innerHTML;
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
		  var id_fact_compra = $("input#id_fact_compra").val();
		  var num_compro_reten = $("input#num_compro_reten").val();
		  var fecha_compro_reten = $("input#fecha_compro_reten").val();
		  var m_iva_reten = $("input#m_iva_reten").val();
		  var mes_apli_reten = $("input#mes_apli_reten").val();
		  
		  xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				
			    document.getElementById('txtHintAPROV').innerHTML = xhttp.responseText;
				document.getElementById("id_fact_compra").value = "";
			}
		  };
		  //	MODIFICAR RETENCION
		  	url = '<?php echo $_SERVER['REQUEST_URI'];?>';
			patronA = 'cargarRetenCompra';//patronB = 'compra|venta'
			
		    if(url.search(patronA) > 0){
				xhttp.open("POST", "<?php echo $extra?>modales/retenC/m_retenC.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				
				xhttp.send("id_fact_compra="+ id_fact_compra +
						   "&num_compro_reten="+ num_compro_reten +
						   "&fecha_compro_reten="+ fecha_compro_reten +
						   "&m_iva_reten="+ m_iva_reten+
						   "&mes_apli_reten="+ mes_apli_reten
						   );
				document.getElementById('form-group-nueRetenC').innerHTML = formGroupNueRetenC;
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
	$(document).ready(function(){
		
		$('#fecha_compro_reten').on('change', function() {
			if($('#fecha_compro_reten').val() !== "")
			{
				var ano_mes = $('#fecha_compro_reten').val().substr(0, 7);
				document.getElementById('num_compro_reten').value = ano_mes+"-";
				document.getElementById('mes_apli_reten').value = ano_mes;
			}
		});
	});	
</script>

<!-- Modal nueProv-->
    <div id="nueRetenC" class="modal fade" data-backdrop="static"  role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close disabled">&times;</button><!-- data-dismiss="modal"-->
            <h4 class="modal-title">Compra - Aplicar Retencion</h4>
          </div>
          <form name="formModal" method="post">
          <div class="modal-body">
          	  <div class="row">
                <!--para mostrar resultado de acciones de insercion y demas-->
                <label class="col-md-12 col-lg-12" id="txtHintAPROV" data-dismiss="modal"></label>
              </div>
              <div class="form-group" id="form-group-nueRetenC">
                	
                	<div class="row">
                    	<label class="col-md-4 col-lg-4" id="res_id_fact_compra">
                        	<input type="hidden" class="form-control" name="id_fact_compra" id="id_fact_compra" lang="si-general" required>
                            Num. Documento:<br>
                            <span class="input-group" id="cont_id_fact_compra">
                            <input class="form-control" id="num_fact_compra" name="num_fact_compra" readonly="readonly" lang="si-general" required="required">
                            	<span class="input-group-btn">
                                <button type="button" class="btn btn-primary" title="Buscar Factura" data-toggle="modal" data-target="#busFact">
                                B <i class="glyphicon glyphicon-search"></i>
                                </button>
                                <button type="button" class="btn btn-info" title="Detalles Factura" onclick="mConsulFact(document.getElementById('id_fact_compra').value)">
                                D <i class="glyphicon glyphicon-th-list"></i>
                                </button>
                                
                                </span>
                            </span>
                            
                        </label>
                        <label class="col-md-4 col-lg-4">
                        	Serie Factura de Compra:<br />
                        	<input type="text" class="form-control" id="serie_fact_compra"  data-toggle="modal" data-target="#busFact" readonly="readonly" lang="si-general" required="required">
                        </label>
                        <label class="col-md-4 col-lg-4">
                        	Proveedor:<br />
                        	<input type="text" class="form-control" id="proveedor_fact_compra"  data-toggle="modal" data-target="#busFact" readonly="readonly" lang="si-general" required="required">
                        </label>
                    </div>
                    <div class="row">
                        <label class="col-md-4 col-lg-4">
                            Fecha del Comp. de Retencion:<br>
                            <input type="date" class="form-control" name="fecha_compro_reten" id="fecha_compro_reten" lang="si-general">
                        </label>
                        <label class="col-md-4 col-lg-4" id="res_num_compro_reten">
                        	Num. Comp. de Retencion:<br>
                        	<span class="input-group" id="cont_num_compro_reten">
                            <input type="text" class="form-control" name="num_compro_reten" id="num_compro_reten" lang="si-num_compro_reten" onBlur="validar_repetidoM('fact_compra', 'num_compro_reten', this.value, 'num_compro_reten')" required>
                            	<span class="input-group-btn">
                                <button type="button" onclick="generarNum(document.getElementById('num_compro_reten').value,'num_compro_reten','fact_compra')" class="btn btn-primary">Generar</button>
                                </span>
                            </span>
                        </label>
                        
                    	<label class="col-md-4 col-lg-4">
                            Mes de Aplicacion Retencion:<br>
                            <input type="month" class="form-control" name="mes_apli_reten" id="mes_apli_reten" value="" lang="si-general">
                        </label>
                    </div>
                    <div class="row">
                    	<label class="col-md-6 col-lg-6">
                        	Total I.V.A.:<br />
                    		<input type="text" class="form-control" id="tot_iva"  data-toggle="modal" data-target="#busFact" readonly="readonly" lang="si-general" required="required">
                    	</label>
                    	<label class="col-md-6 col-lg-6" id="res_m_iva_reten">
                            I.V.A. Retenido:<br>
                            <span class="input-group" id="cont_m_iva_reten">
                                <input class="form-control" name="m_iva_reten" id="m_iva_reten" readonly="readonly" lang="si-general" required="required">
                                    <span class="input-group-btn ">
                                    <button type="button" class="btn btn-primary">Calcular Retencion</button>
                                    </span>
                            </span>
                            
                        </label>
                    </div>
              </div><!--form-group-->
          </div><!--modal-bosy-->
          
          <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="modRReten(this.form);">Aplicar Retenci&oacute;n</button>
            <button type="button" class="btn btn-danger disabled" >Cancelar</button>
          </div>
          </form><!--maprov data-dismiss="modal"-->
        </div>
    
      </div>
    </div>