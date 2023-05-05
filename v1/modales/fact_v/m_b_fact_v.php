<?php include_once('../../includes_SISTEM/include_head.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script>
	$(document).ready(function() {
		$(window.document).on('shown.bs.modal', '#busFact', function() {
			window.setTimeout(function() {
				//para desactivar el enter envie y cierre el modal
				document.onkeypress = stopRKey;
				$('#b_fact', this).focus();
				//edicion de los campos de busqueda
				<?php include_once('../../includes_SISTEM/include_login.php'); ?>
				url = '<?php echo $_SERVER['REQUEST_URI']; ?>';
				patron1 = 'cargarRetenVenta';
				patron2 = 'cargarVenta';
				patron3 = 'factVenta';
				inputTipoDocu = null;
				try {
					inputTipoDocu = document.getElementById('tipo_docu');
				} catch (err) {
					alert(err.message);
				}

				if (url.search(patron3) > 0 && inputTipoDocu == null) {

					document.getElementById('colum1').className = 'col-md-6 col-lg-6';
					var div_id_row1 = document.getElementById("row1");
					var div_c_colum2 = document.createElement("div");
					var select_tipo_docu = document.createElement("select");
					var array_tipo_docu = ["F", "RDV", "FNULL", "ND", "NC-DEVO", "NC-DESC", "NE",
						"Factura", "Resumen Diario de Ventas", "Factura Anulada", "Nota de Débito", "Nota de Crédito - Devoluciones", "Nota de Crédito - Descuentos", "Nota de Entrega"
					];
					var option_tipo_docu = document.createElement("option");

					div_c_colum2.setAttribute("class", "col-md-6 col-lg-6");
					div_c_colum2.setAttribute("align", "center");
					div_c_colum2.innerHTML = "Tipo de Documento<br />";
					div_id_row1.appendChild(div_c_colum2); //introduzco el div_c_colum2 en el div_id_row1

					select_tipo_docu.setAttribute("class", "form-control");
					select_tipo_docu.setAttribute("name", "tipo_docu");
					select_tipo_docu.setAttribute("id", "tipo_docu");
					select_tipo_docu.setAttribute("required", "required");
					select_tipo_docu.setAttribute("onchange", "consulFact(document.form_modal_fact_venta.b_fact.value)");

					/////////////////////
					for (j = 0; j < array_tipo_docu.length / 2; j++) {
						var option_tipo_docu = document.createElement("option");

						option_tipo_docu.value = array_tipo_docu[j]; //
						option_tipo_docu.text = array_tipo_docu[j + 7]; //
						select_tipo_docu.appendChild(option_tipo_docu); //introduzco el option_tipo_docu en el select_tipo_docu
					}
					div_c_colum2.appendChild(select_tipo_docu); //introduzco el select_tipo_docu en el div_c_colum2

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
				}
			}.bind(this), 100);
		});
		$('#busFact').on('hidden.bs.modal', function(e) {
			document.onkeypress = !stopRKey;
			//loseFocus('b_fact');

		});
	});
	//para ver si existe el rif en el sistema
	function consulFact(str) {
		var url = '<?php echo $_SERVER['REQUEST_URI']; ?>';

		var xhttp;
		if (str.length == 0) {
			document.getElementById("resFact").innerHTML = "Introduzca algo en el campo";
			return;
		}
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				document.getElementById("resFact").innerHTML = xhttp.responseText;
			}
		};

		////////////////////			CARGAR RETENCION
		if (url.search(patron1) > 0) {
			xhttp.open("POST", "<?php echo $extra ?>modales/fact_v/b_fact_v.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("fact=" + str + "&selecMFact=");
			///////////////////				CARGAR VENTA NOTAS D C
		} else if (url.search(patron2) > 0) {
			xhttp.open("POST", "<?php echo $extra ?>modales/fact_v/b_fact_v.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("fact=" + str);
		} else if (url.search(patron3) > 0) {
			///////////////////				FACT VENTA   ---->	detalles de fact
			tipo_docu = document.form_modal_fact_venta.tipo_docu.value;
			xhttp.open("POST", "<?php echo $extra ?>modales/fact_v/b_fact_v.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("fact=" + str + "&tipo_docu=" + tipo_docu + "&fact_venta=");
		}
	}
</script>
<!-- Modal nueCargo-->
<div id="busFact" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<form name="form_modal_fact_venta" method="post">
				<div class="modal-header" align="center">
					<button type="button" id="close_m_x" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Consulta Documento de Venta</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div id="row1" class="row" align="center">
							<div id="colum1" class="col-md-12 col-lg-12" align="center">
								Numero de Factura:<br />
								<input type="text" class="form-control" name="b_fact" id="b_fact" onKeyUp="consulFact(this.value);" autocomplete="off" required>
							</div>


						</div><!--row-->
						<div class="row" align="center">
							<br /><span>Presione Espacio para mostrar todos</span>
						</div>
						<div class="row">
							<div class="col-md-12 col-lg-12" id="resFact">

							</div>

						</div>
					</div><!--form-group-->
				</div><!--modal-bosy-->
			</form><!--mbprov-->
			<div class="modal-footer">
				<button type="button" id="close_m" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			</div>
		</div>

	</div>
</div>