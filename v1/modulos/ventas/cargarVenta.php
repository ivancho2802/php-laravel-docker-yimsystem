<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

date_default_timezone_set('America/Caracas');
setlocale(LC_ALL, "es_ES");
?>
<script>
	////////////////////				VALIDACION
	function tipoPago(str) {
		if (str == "C") {
			document.forms['form1'].elements['dias_venc'].required = true;
			document.forms['form1'].elements['dias_venc'].readOnly = null;
		} else { // if(str == "E"){
			document.forms['form1'].elements['dias_venc'].required = null;
			document.forms['form1'].elements['dias_venc'].readOnly = true;
		}
	}

	function vueltosPago(monto) {
		var mtot_iva_venta = parseFloat(document.forms['form1'].elements['mtot_iva_venta'].value);
		var monto_paga = parseFloat(monto);

		if (mtot_iva_venta > monto_paga) {
			document.getElementById('dvueltos').setAttribute("class", "form-group has-warning has-feedback");
			document.getElementById('svueltos').setAttribute("class", "glyphicon glyphicon-remove form-control-feedback");
		} else {
			document.getElementById('dvueltos').setAttribute("class", "form-group has-success has-feedback");
			document.getElementById('svueltos').setAttribute("class", "glyphicon glyphicon-ok form-control-feedback");
		}

		document.forms['form1'].elements['vueltos'].value = Math.round10(mtot_iva_venta - monto_paga, -2);
	}
	//tipoDocuV
	function tipoDocuV(str) {
		var infact_afectada = document.getElementById("nfact_afectada");
		var btnfact_afectada = document.getElementById("btn_nfact_afectada");
		if (str == "FNULL") {
			//anulo los demas datos
			document.forms['form1'].elements['fk_cliente'].value = "Anulado";
			document.forms['form1'].elements['nom_cliente_ajax'].value = "Anulado";
			document.forms['form1'].elements['tipo_contri'].value = "";

			document.forms['form1'].elements['tipo_trans'].value = "01-anul";
			document.forms['form1'].elements['tipo_transv'].value = "01-anul";

			document.forms['form1'].elements['num_fact_venta'].type = "number";

			document.forms['form1'].elements['nfact_afectada'].type = "hidden";
			document.forms['form1'].elements['nfact_afectada'].required = null;

			document.forms['form1'].elements['reg_maq_fis'].type = "hidden";
			document.forms['form1'].elements['reg_maq_fis'].value = "";
			document.getElementById("span_resTipoDoc").innerHTML = "";
			document.forms['form1'].elements['reg_maq_fis'].required = null;
			///////////////////////////////////////////////////////////////
			document.getElementById("span_resnum_repo_z").innerHTML = "";
			document.forms['form1'].elements['num_repo_z'].type = "hidden";
			document.forms['form1'].elements['num_repo_z'].required = null;
			///////////////////////////////////////////////////////////////
			document.forms['form1'].elements['num_ctrl_factventa'].value = "00-";
			document.forms['form1'].elements['num_ctrl_factventa'].type = "text";
			//document.forms['form1'].elements['num_ctrl_factventa'].min = 0;
			/////////////////////////////////////////////////////////// 			RDV
			document.forms['form1'].elements['num_ctrl_factventa'].readOnly = null;

			//LA INVERSA DE LO QUE HACEN LAS NOTAS DE CREDITO
			infact_afectada.value = '';
			infact_afectada.type = 'hidden';
			btnfact_afectada.style = "display:none"; //no visible

		} else if (str == "RDV") {
			//resumen diario de ventas pone automatico los campos de resumen y demas
			//randoly serie_fact_venta y vacio

			document.forms['form1'].elements['fk_cliente'].value = "RESUMEN";
			document.forms['form1'].elements['nom_cliente_ajax'].value = "Resumen Diario De Ventas";
			document.forms['form1'].elements['tipo_contri'].value = "";

			document.forms['form1'].elements['tipo_trans'].value = "01-reg";
			document.forms['form1'].elements['tipo_transv'].value = "01-reg";

			document.forms['form1'].elements['num_fact_venta'].type = "text";

			document.forms['form1'].elements['nfact_afectada'].type = "hidden";
			document.forms['form1'].elements['nfact_afectada'].required = null;

			document.getElementById("span_resTipoDoc").innerHTML = "Registro Maquina Fiscal";
			document.forms['form1'].elements['reg_maq_fis'].type = "text";
			document.forms['form1'].elements['reg_maq_fis'].required = "required";
			///////////////////////////////////////////////////////////////
			document.getElementById("span_resnum_repo_z").innerHTML = "Numero de Reporte Z";
			document.forms['form1'].elements['num_repo_z'].type = "number";
			document.forms['form1'].elements['num_repo_z'].min = 0;
			document.forms['form1'].elements['num_repo_z'].required = "required";
			///////////////////////////////////////////////////////////////
			document.forms['form1'].elements['num_ctrl_factventa'].type = "text";
			document.forms['form1'].elements['num_ctrl_factventa'].value = "";
			document.forms['form1'].elements['num_ctrl_factventa'].readOnly = true;
			//document.forms['form1'].elements['num_ctrl_factventa'].min = null;

			//LA INVERSA DE LO QUE HACEN LAS NOTAS DE CREDITO
			infact_afectada.value = '';
			infact_afectada.type = 'hidden';
			btnfact_afectada.style = "display:none"; //no visible

		} else if (str == 'F' || str == 'NE') {
			document.forms['form1'].elements['fk_cliente'].value = "";
			document.forms['form1'].elements['nom_cliente_ajax'].value = "";
			document.forms['form1'].elements['tipo_contri'].value = "";

			document.forms['form1'].elements['tipo_trans'].value = "01-reg";
			document.forms['form1'].elements['tipo_transv'].value = "01-reg";

			document.forms['form1'].elements['num_fact_venta'].type = "number";

			document.forms['form1'].elements['nfact_afectada'].type = "hidden";
			document.forms['form1'].elements['nfact_afectada'].required = null;

			document.forms['form1'].elements['reg_maq_fis'].type = "hidden";
			document.forms['form1'].elements['reg_maq_fis'].value = "";
			document.getElementById("span_resTipoDoc").innerHTML = "";
			document.forms['form1'].elements['reg_maq_fis'].required = null;
			///////////////////////////////////////////////////////////////
			document.getElementById("span_resnum_repo_z").innerHTML = "";
			document.forms['form1'].elements['num_repo_z'].type = "hidden";
			document.forms['form1'].elements['num_repo_z'].required = null;
			///////////////////////////////////////////////////////////////
			document.forms['form1'].elements['num_ctrl_factventa'].value = "00-";
			document.forms['form1'].elements['num_ctrl_factventa'].type = "text";
			//document.forms['form1'].elements['num_ctrl_factventa'].min = 0;
			/////////////////////////////////////////////////////////// 			RDV
			document.forms['form1'].elements['num_ctrl_factventa'].readOnly = null;

			//LA INVERSA DE LO QUE HACEN LAS NOTAS DE CREDITO
			infact_afectada.value = '';
			infact_afectada.type = 'hidden';
			btnfact_afectada.style = "display:none"; //no visible

		} else if (str == 'ND' || str == 'NC-DEVO' || str == 'NC-DESC') {

			document.forms['form1'].elements['fk_cliente'].value = "";
			document.forms['form1'].elements['nom_cliente_ajax'].value = "";
			document.forms['form1'].elements['tipo_contri'].value = "";

			document.forms['form1'].elements['num_fact_venta'].type = "number";

			document.forms['form1'].elements['reg_maq_fis'].type = "hidden";
			document.forms['form1'].elements['reg_maq_fis'].value = "";
			document.getElementById("span_resTipoDoc").innerHTML = "N. Factura Afectada";
			document.forms['form1'].elements['reg_maq_fis'].required = null;
			///////////////////////////////////////////////////////////////
			document.getElementById("span_resnum_repo_z").innerHTML = "";
			document.forms['form1'].elements['num_repo_z'].type = "hidden";
			document.forms['form1'].elements['num_repo_z'].required = null;
			///////////////////////////////////////////////////////////////
			document.forms['form1'].elements['num_ctrl_factventa'].value = "00-";
			document.forms['form1'].elements['num_ctrl_factventa'].type = "text";
			//document.forms['form1'].elements['num_ctrl_factventa'].min = 0;
			/////////////////////////////////////////////////////////// 			RDV
			document.forms['form1'].elements['num_ctrl_factventa'].readOnly = null;
			//ACTIVACION O PONER VISIBLE LOS CAMPOS DE SELÑECCINAR LA FACTURA
			//esta arriba document.getElementById("span_resTipoDoc").innerHTML = "N. Factura Afectada";

			infact_afectada.type = 'text';
			infact_afectada.setAttribute("data-bs-toggle", "modal");
			infact_afectada.setAttribute("data-target", "#busFact");
			infact_afectada.setAttribute("onfocus", "$('#busFact').modal('show')");
			infact_afectada.setAttribute("readonly", "readonly");

			btnfact_afectada.style = "display:compact"; // visible
			if (str == "ND") {
				document.forms['form1'].elements['tipo_trans'].value = "02-reg";
				document.forms['form1'].elements['tipo_transv'].value = "02-reg";
			} else {
				document.forms['form1'].elements['tipo_trans'].value = "03-reg";
				document.forms['form1'].elements['tipo_transv'].value = "03-reg";
			}
		}
	}
	//funcion para condicionar el llenado o suma de los totales
	function fcalculo(valido) {
		//como para que se llame ha esta funcion la i debe de existir entonces la vuelvo local para esta funcion
		//para saber cuantas veces voya sumar los prodcutos


		var n = parseInt(document.form1.numCampos.value);
		//totales  
		var acum_msubt_exento_venta = 0;
		var acum_msubt_bi_iva_12 = 0;
		var acum_msubt_bi_iva_8 = 0;
		var acum_msubt_bi_iva_27 = 0;
		var acum_iva_12 = 0;
		var acum_iva_8 = 0;
		var acum_iva_27 = 0;
		var acum_msubt_tot_bi_venta = 0;
		var acum_mtot_iva_venta = 0;

		////////////////////// CALCULO DEL STOCK ACTUAL
		//////////////////////	
		for (i = 1; i <= n; i++) {
			if (document.form1.elements['fk_inventario' + i] != null) {
				var tipoVentaA = document.form1.elements['tipoVenta' + i].value;
				var fk_inventarioA = document.form1.elements['fk_inventario' + i].value

				if (document.form1.elements['costo' + i].value !== "")
					var costoA = parseFloat(document.form1.elements['costo' + i].value)
				else
					costoA = 0;
				if (document.form1.elements['cantidad' + i].value !== "") {
					var cantidadA = parseInt(document.form1.elements['cantidad' + i].value);
					var stockA = parseInt(document.form1.elements['stock' + i].value);

					if (cantidadA > stockA) {
						document.form1.elements['cantidad' + i].value = "";
						alert("la cantidad supera la existencia");
						//return 0;
					}

				} else cantidadA = 0;

				//validar que los campos anteriores esten llenos 
				if ((fk_inventarioA == "") || (costoA == "") || (cantidadA == "") || fk_inventarioA == 0 || costoA == 0 || cantidadA == 0 || fk_inventarioA == null || costoA == null || cantidadA == null || fk_inventarioA == "NaN" || costoA == "NaN" || cantidadA == "NaN") {
					if (valido == 1) {
						alert("Debe llenar los demas campos");
						//tipoVentaA = "";
						document.form1.elements['tipoVenta' + i].value = "";
						//return 0;/*haber focus a ese campo vacio*/
					}
					document.form1.elements['tipoVenta' + i].value = "";
				} else { //por lo tanto los campos estan llenos
					bi = costoA * cantidadA; //base imponible
					if (tipoVentaA == "NA_EX" || tipoVentaA == "NA_EXO" || tipoVentaA == "NA_NS" || tipoVentaA == "NA_SDCF") {
						document.form1.nplanilla_export.readOnly = true;
						document.form1.nexpe_export.readOnly = true;
						document.form1.naduana_export.readOnly = true;
						document.form1.fechaduana_export.readOnly = true;
						acum_msubt_exento_venta += bi;

					} else if (tipoVentaA == "NA_BI_12") {
						document.form1.nplanilla_export.readOnly = true;
						document.form1.nexpe_export.readOnly = true;
						document.form1.naduana_export.readOnly = true;
						document.form1.fechaduana_export.readOnly = true;
						acum_msubt_bi_iva_12 += bi;
						acum_iva_12 += bi * 0.12;

					} else if (tipoVentaA == "NA_BI_27") {
						document.form1.nplanilla_export.readOnly = true;
						document.form1.nexpe_export.readOnly = true;
						document.form1.naduana_export.readOnly = true;
						document.form1.fechaduana_export.readOnly = true;
						acum_msubt_bi_iva_27 += bi;
						acum_iva_27 += bi * 0.27;

					} else if (tipoVentaA == "NA_BI_8") {
						document.form1.nplanilla_export.readOnly = true;
						document.form1.nexpe_export.readOnly = true;
						document.form1.naduana_export.readOnly = true;
						document.form1.fechaduana_export.readOnly = true;
						acum_msubt_bi_iva_8 += bi;
						acum_iva_8 += bi * 0.08;

					} else if (tipoVentaA == "EX_EX" || tipoVentaA == "EX_EXO" || tipoVentaA == "EX_NS" || tipoVentaA == "EX_SDCF") {

						document.form1.nplanilla_export.readOnly = false;
						document.form1.nexpe_export.readOnly = false;
						document.form1.naduana_export.readOnly = false;
						document.form1.fechaduana_export.readOnly = false;

						acum_msubt_exento_venta += bi;
					}

				}
				document.form1.msubt_exento_venta.value = acum_msubt_exento_venta;

				document.form1.msubt_bi_iva_12.value = Math.round10(acum_msubt_bi_iva_12, -2);
				document.form1.msubt_bi_iva_8.value = Math.round10(acum_msubt_bi_iva_8, -2);
				document.form1.msubt_bi_iva_27.value = Math.round10(acum_msubt_bi_iva_27, -2);

				msubt_tot_bi_venta = acum_msubt_bi_iva_12 + acum_msubt_bi_iva_27 + acum_msubt_bi_iva_8
				document.form1.msubt_tot_bi_venta.value = Math.round10(msubt_tot_bi_venta, -2);

				document.form1.iva_12.value = Math.round10(acum_iva_12, -2);
				document.form1.iva_8.value = Math.round10(acum_iva_8, -2);
				document.form1.iva_27.value = Math.round10(acum_iva_27, -2);

				tot_iva = acum_iva_12 + acum_iva_27 + acum_iva_8;
				document.form1.tot_iva.value = Math.round10(tot_iva, -2);

				document.form1.mtot_iva_venta.value = Math.round10(acum_msubt_exento_venta + msubt_tot_bi_venta + tot_iva, -2);
			} else {
				//document.form1.elements['tipoVenta'+i].value = "";
				//alert("Debe llenar los demas campos");
			} //if existe
		} //FOR
	}
	//funcion para seleccionar mas inputs
	function agreInput(numCampos) {

		//var iid_fact_venta = document.createElement("input");
		var i = parseInt(numCampos) + 1;
		//////////////7			VALIDACION DEL NUMERO DEL CAMPO
		/*for(j=1;j<i;j++)
		{
			if(document.form1.elements['fk_inventario'+parseInt(numCampos)].value == document.form1.elements['fk_inventario'+i].value)
			
		}*/
		//var capa = document.getElementById("capa");
		var resVenta = document.getElementById("resVenta");
		var hilera = document.createElement("tr");
		var celda1 = document.createElement("td");
		var celda2 = document.createElement("td");
		var celda3 = document.createElement("td");
		var celda4 = document.createElement("td");
		var celda5 = document.createElement("td");
		var celda6 = document.createElement("td");
		///////////////////////campos a insertar com productos
		var iid_venta = document.createElement("input");
		var ifk_inventario = document.createElement("input");
		var inom_fk_inventario = document.createElement("input");
		var icosto = document.createElement("input");
		var icantidad = document.createElement("input");
		var iStock = document.createElement("input"); //////////////////////////campo oculto
		var bBorrarFila = document.createElement("button");
		var bUPMPVJ = document.createElement("button");
		var ipmpvj = document.createElement("input");
		var spanmenos = document.createElement("span");
		var spaninputgroup = document.createElement("span");
		var spaninputgroupaddon = document.createElement("span");

		var divlistgroupProd1 = document.createElement("div");
		var btnlistgroupProd1 = document.createElement("input");

		var divlistgroupProd2 = document.createElement("div");
		var btnlistgroupProd2 = document.createElement("input");

		var itipoVenta = document.createElement("select");
		var span = document.createElement("span");

		//Create array of options to be added&prime; Exoneradas&prime; No Sujetas&prime; Sin derecho a Credito Fiscal&prime;
		var arrayV = ["NA_EX", "NA_EXO", "NA_NS", "NA_SDCF", "NA_BI_12", "NA_BI_8", "NA_BI_27",
			"EX_EX"
		];

		var arrayTNACION = [
			"Nacionales Exentas",
			"Nacionales Exoneradas",
			"Nacionales No Sujetas",
			"Nacionales Sin derecho a Credito Fiscal",
			"Nacionales Base Imponible al 12%",
			"Nacionales Base Imponible al 8%",
			"Nacionales Base Imponible al 27%"
		];

		var arrayTEXPORT = ["Exportaciones Exentas"];




		//////////////////////
		iid_venta.name = 'id_venta' + i;
		iid_venta.hidden = true;
		//campo oculto
		ifk_inventario.name = 'fk_inventario' + i;
		ifk_inventario.required = true;
		ifk_inventario.setAttribute("onClick", "ctrlSelecProd(" + i + ")");
		ifk_inventario.setAttribute("onfocus", "ctrlSelecProd(" + i + ")");
		ifk_inventario.readOnly = "true";
		ifk_inventario.setAttribute("class", "form-control list-group-item");
		ifk_inventario.setAttribute("placeholder", "Clic aqui");
		//////////
		btnlistgroupProd1.setAttribute("type", "button");
		btnlistgroupProd1.setAttribute("class", "list-group-item active");
		btnlistgroupProd1.setAttribute("onclick", "ctrlSelecProd(1)");
		btnlistgroupProd1.setAttribute("value", "Seleccionar Producto");
		///////////
		divlistgroupProd1.setAttribute("class", "list-group");
		//////////
		inom_fk_inventario.name = 'nom_fk_inventario' + i;
		inom_fk_inventario.setAttribute("onClick", "ctrlSelecProd(" + i + ")");
		inom_fk_inventario.setAttribute("onfocus", "ctrlSelecProd(" + i + ")");
		inom_fk_inventario.readOnly = "true";
		inom_fk_inventario.setAttribute("class", "form-control");
		inom_fk_inventario.setAttribute("placeholder", "Clic aqui");
		//////////////////
		btnlistgroupProd2.setAttribute("type", "button");
		btnlistgroupProd2.setAttribute("class", "list-group-item active");
		btnlistgroupProd2.setAttribute("onclick", "ctrlSelecProd(1)");
		btnlistgroupProd2.setAttribute("value", "Seleccionar Producto");
		//////////////////
		divlistgroupProd2.setAttribute("class", "list-group");
		//////////
		icosto.name = 'costo' + i;

		icosto.required = true;
		icosto.setAttribute("type", "number");
		icosto.setAttribute("min", "0");
		icosto.setAttribute("step", "0.0000001");
		icosto.setAttribute("value", "");
		icosto.setAttribute("placeholder", "0.00 Clic aqui");
		icosto.setAttribute("onBlur", "fcalculo()");
		icosto.setAttribute("class", "form-control active");
		/////////////

		ipmpvj.name = 'pmpvj' + i;
		ipmpvj.id = 'pmpvj' + i;
		ipmpvj.setAttribute("type", "hidden");
		ipmpvj.setAttribute("min", "0");
		ipmpvj.setAttribute("step", "0.0000001");
		ipmpvj.setAttribute("value", "");
		ipmpvj.setAttribute("placeholder", "0.00");
		ipmpvj.setAttribute("readonly", "readonly");
		ipmpvj.required = true;
		ipmpvj.setAttribute("class", "form-control");
		////////////
		bUPMPVJ.setAttribute("class", "btn btn-primary");
		bUPMPVJ.setAttribute("type", "button");
		bUPMPVJ.innerHTML = "Utilidad";
		bUPMPVJ.setAttribute("onClick", "ctrlSelecUPMPVJ(" + i + ")");
		bUPMPVJ.setAttribute("onFocus", "ctrlSelecUPMPVJ(" + i + ")");
		///////////7
		icantidad.name = 'cantidad' + i;
		icantidad.required = true;
		icantidad.setAttribute("type", "number");
		icantidad.setAttribute("min", "0");
		icantidad.setAttribute("onBlur", "fcalculo()");
		icantidad.setAttribute("class", "form-control");
		//		icantidad.setAttribute("onclick","val_venta_fech(document.form1.fecha_fact_venta.value, document.form1.fk_inventario"+i+".value, 'fecha_fact_venta')");
		///////////////////////////7
		spaninputgroupaddon.setAttribute("class", "input-group-addon");
		spaninputgroupaddon.innerHTML = "/";
		spaninputgroup.setAttribute("class", "input-group");
		////////////////
		iStock.name = 'stock' + i;
		iStock.setAttribute("class", "form-control");
		iStock.setAttribute("readonly", true);
		////////////////

		spanmenos.setAttribute("class", "glyphicon glyphicon-minus");
		///////////////////
		//bBorrarFila.name = 'borrarFila'+ i;
		bBorrarFila.setAttribute("class", "btn btn-sm btn-danger");
		bBorrarFila.type = "button";
		bBorrarFila.setAttribute("data-dismiss", "alert");
		bBorrarFila.setAttribute("aria.label", "close");
		bBorrarFila.setAttribute("onclick", "elimInput()")
		bBorrarFila.appendChild(spanmenos);

		/////////////
		var optDefault = document.createElement("option");
		optDefault.text = "Seleccione";
		optDefault.setAttribute("value", "");
		var optGroup1 = document.createElement("optgroup");
		optGroup1.setAttribute("label", "Nacionales");
		////////////////////
		var optGroup2 = document.createElement("optgroup");
		optGroup2.setAttribute("label", "Exportaciones");
		/////////////////////
		for (j = 0; j < arrayV.length; j++) {
			var option = document.createElement("option");
			if (j == 0) {
				option.text = arrayTNACION[j]; //export inter
				option.value = arrayV[j];
				itipoVenta.appendChild(option);
			} else
			if (j >= 1 && j <= 7) {
				option.text = arrayTNACION[j]; //export inter
				option.value = arrayV[j];

				optGroup1.appendChild(option);
			} else
			if (j >= 8) {
				option.text = arrayTEXPORT[j - 8];
				option.value = arrayV[j];

				optGroup2.appendChild(option);
			}
		}
		itipoVenta.appendChild(optDefault);
		itipoVenta.appendChild(optGroup1);
		itipoVenta.appendChild(optGroup2);
		//////////////////
		itipoVenta.name = 'tipoVenta' + i;
		itipoVenta.id = 'tipoVenta' + i;
		itipoVenta.required = true;
		itipoVenta.setAttribute("class", "selectpicker form-control");
		itipoVenta.setAttribute("data-style", "btn-primary");
		itipoVenta.setAttribute("onChange", "fcalculo(1)");
		///////////////
		hilera.setAttribute("class", "alert fade in");

		spaninputgroup.appendChild(icantidad);
		spaninputgroup.appendChild(spaninputgroupaddon);
		spaninputgroup.appendChild(iStock);

		celda1.appendChild(iid_venta);

		divlistgroupProd1.appendChild(ifk_inventario);
		divlistgroupProd1.appendChild(btnlistgroupProd1);
		celda1.appendChild(divlistgroupProd1);

		divlistgroupProd2.appendChild(inom_fk_inventario);
		divlistgroupProd2.appendChild(btnlistgroupProd2);
		celda2.appendChild(divlistgroupProd2);

		celda3.appendChild(icosto);
		celda6.appendChild(ipmpvj);
		celda4.appendChild(spaninputgroup);
		celda5.appendChild(itipoVenta);
		celda6.setAttribute("align", "center");
		celda6.appendChild(bBorrarFila);

		hilera.appendChild(celda1);
		hilera.appendChild(celda2);
		hilera.appendChild(celda3);
		hilera.appendChild(celda4);
		hilera.appendChild(celda5);
		hilera.appendChild(celda6);
		resVenta.appendChild(hilera);

		document.form1.numCampos.value = i; //para el contador	
	}
	//funcion para restar campos
	function elimInput() {
		//alert()
		//document.form1.numCampos.value = parseInt(document.form1.numCampos.value) -1;
	}

	//scriprt para el modal
	//MODALES
	function mConsulFact(str) {
		//alert(str);
		var xhttp;
		xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				document.getElementById("res_nfact_afectada").innerHTML = xhttp.responseText;
				$('#mostrarFact').modal('show');
			}
		};
		url = '<?php echo $extra ?>modales/fact_v/m_b_fact_v_det.php';
		xhttp.open("POST", url, true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("nfact_afectada=" + str);

	}
	$(document).ready(function() {
		consulTablaAjax('php/consul_sql/b_tabla_may.php', "fact_venta", "num_fact_venta", "num_fact_venta");
		//consulTablaAjax(url,tabla,campo,resCampo) 
		consulTablaAjax('php/consul_sql/b_tabla_may.php', "fact_venta", "num_ctrl_factventa", "num_ctrl_factventa");
	});
</script>
<?php

$consulta = pg_query($conexion, "SELECT * FROM empre WHERE empre.est_empre = '1'");
// $resEmpreActiva=$consulEmpreActiva->fetch_assoc();
$filas = pg_fetch_assoc($consulta);
$total_consulEmpreActiva = pg_num_rows($consulta);

$extra = "../../";
//llamado de modales el id es "busCliente"
include_once($extra . "modales/cliente/m_b_cliente.php");
//llamando de modales el id es "nueCliente"
include_once($extra . "modales/cliente/m_a_cliente.php");
//llamando de modales el id es "mmCliente"
include_once($extra . "modales/cliente/m_m_cliente.php");
//llamado de modales el id es "busProd"
include_once($extra . "modales/prod/m_b_prod.php");
$mes_inventario = ""; //variable usada en insertar inventario inicial aqui no
//llamando de modales el id es "nueProd"
include_once($extra . "modales/prod/m_a_prod.php");
//llamando de modales el id es "mmProd"
include_once($extra . "modales/prod/m_m_prod.php");
//llamando de modales el id es "calPMPVJ"
include_once($extra . "modales/prod/m_PMPVJ.php");
//llamado de modales el id es "busFact"
$extra = "../../";
include_once($extra . "modales/fact_v/m_b_fact_v.php");

?>
<br>
<!--para mostrar resultado de acciones de insercion y demas-->
<!--<label class="col-md-12 col-lg-12" id="txtHintA"></label>-->
<div class="bs-example" id="cargarVenta">
	<div class="">
		<h1 class="bd-title">Agregar Venta</h1>

	</div>
	<div class="bs-marco-form">
		<form id="form1" name="form1" method="post" action="recibirVenta.php">
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">
					<!--campos ocultos-->
					<input type="hidden" name="fk_usuariosV" value="<?php echo $_SESSION["id_usu"] ?>" /><!--que usuario operador hiso el registro-->
					<input type="hidden" name="id_fact_venta" value="" /><!--el id auoincremento de la factura-->
					<input type="hidden" name="empre_cod_empre" value="<?php echo $filas["cod_empre"] ?>" /><!--el id de la empresa actual del sistema-->
					<label>Tipo de Documento:</label>
					<select id="tipoDoc" class="form-control" name="tipo_fact_venta" onchange="tipoDocuV(this.value)" required>
						<option value="">Seleccione</option>
						<option value="F">Factura</option>
						<option value="RDV">Resumen Diario de Ventas</option>
						<option value="FNULL">Factura Anulada</option>
						<option value="ND">Nota de D&eacute;bito</option>
						<option value="NC-DEVO">Nota de Cr&eacute;dito - Devoluciones</option>
						<option value="NC-DESC">Nota de Cr&eacute;dito - Descuentos</option>
						<option value="NE">Nota de Entrega</option>
					</select>
				</div>
				<!--AQUI SE MOSTRARA EL RESULTADO DE LA CONSUKLTA Y SU SELECCION-->
				<div class="col-xs-4 col-md-4 col-lg-4" id="resTipoDoc">
					<span id="span_resTipoDoc"></span><br>
					<span class="input-group">
						<input type="hidden" name="nfact_afectada" class="form-control" id="nfact_afectada" />
						<input type="hidden" name="reg_maq_fis" class="form-control" onblur="javascript:this.value=this.value.toUpperCase();">
						<span class="input-group-btn">
							<button type="button" style="display:none" class="btn btn-primary" name="btn_nfact_afectada" id="btn_nfact_afectada" onclick="mConsulFact(document.form1.nfact_afectada.value)">
								Detalles Fact.
							</button>
						</span>
						<!--style="display:none" no visible-->
					</span>
					<span id="res_nfact_afectada"></span>
				</div><!--este define por ajax el numero de documento o factura afectada-->

				<div class="col-xs-4 col-md-4 col-lg-4">
					<span id="span_resnum_repo_z"></span><br>
					<input name="num_repo_z" class="form-control" type="hidden">
				</div>
			</div><!--ROW-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4" id="ResselecCliente">
					<label>Documento del Cliente:</label>
					<!--en onclocl queda la funcion que desactiva la tecla enter del teclado-->
					<input name="fk_cliente" required="required" onfocus="$('#busCliente').modal('show');" onblur="javascript:this.value=this.value.toUpperCase();codFactProvee('form1', 'serie_fact_venta', 'num_fact_venta', 'fk_cliente', 'id_fact_venta')" data-bs-toggle="modal" data-target="#busCliente" readonly="readonly" placeholder="Clic aqui" class="form-control btn-primary active" />
				</div>

				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Nombre o Raz&oacute;n Social:</label>
					<input name="nom_cliente_ajax" class="form-control btn-primary active" id="nom_cliente_ajax" required="required" data-bs-toggle="modal" data-target="#busCliente" onblur="javascript:this.value=this.value.toUpperCase();" onfocus="$('#busCliente').modal('show');" readonly="readonly" placeholder="Clic aqui" />
				</div>

				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Tipo de Contribuyente:</label>
					<input name="tipo_contri" class="form-control btn-primary active" id="tipo_contri" required="required" data-bs-toggle="modal" data-target="#busCliente" onblur="javascript:this.value=this.value.toUpperCase();" onfocus="$('#busCliente').modal('show');" readonly="readonly" placeholder="Clic aqui" />
				</div>
			</div><!--rOW-->

			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4" id="res_serie_fact_venta">
					<span id="cont_serie_fact_venta">
						<label>Serie de Documento</label>
						<input type="text" name="serie_fact_venta" class="form-control" id="serie_fact_venta" value="" size="20" onKeyUp="javascript:this.value=this.value.toUpperCase();" onblur="codFactProvee('form1', 'serie_fact_venta', 'num_fact_venta', 'fk_cliente', 'id_fact_venta')">
					</span>
					<!--no es requerido por que a veces las facturas no tienen numero de serie-->
				</div>

				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>N° Documento:</label>
					<input type="number" min="0" name="num_fact_venta" class="form-control" value="" size="20" required="required" onblur="codFactProvee('form1', 'serie_fact_venta', 'num_fact_venta', 'fk_cliente', 'id_fact_venta')" />
				</div>

				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>N° Control:</label><br>
					<input type="text" class="form-control" name="num_ctrl_factventa" id="num_ctrl_factventa" value="" size="20" />
				</div>

			</div><!--row-->

			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Tipo de Transacci&oacute;n:</label>
					<select id="tipoTrans" name="tipo_transv" class="form-control" required disabled="disabled">
						<option value="01-reg">01-reg --> Registro</option>
						<option value="02-reg">02-reg --> Nota de Debito</option>
						<option value="03-reg">03-reg --> Nota de Credito</option>
						<option value="01-anul">01-anul --> Anulada</option>
					</select>
					<input id="tipoTrans" type="hidden" class="form-control" name="tipo_trans" value="" required>
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4" id="res_fecha_fact_venta">
					<span id="cont_fecha_fact_venta">
						<label>Fecha de Emisi&oacute;n:</label><!--de la Venta-->
						<input type="date" name="fecha_fact_venta" class="form-control" id="fecha_fact_venta" size="20" lang="si-general" value="<?php echo date('Y-m-d') ?>" onblur="val_comp_ii_fech(this.value, 'fecha_fact_venta')" required />
					</span>
				</div>
			</div><!--row-->
			<div class="row"><!--DE AQUI EN ADELANDE CONSICIONADOS PARA SERR OCULTOS O NO POR JAVBASCRIPT-->
				<div class="col-xs-4 col-md-4 col-lg-4">
					N° Planilla de Exportaci&oacute;n:<br>
					<input type="text" name="nplanilla_export" class="form-control" value="" size="20" required readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>N° Exp de Exportaci&oacute;n:</label>
					<input type="text" name="nexpe_export" class="form-control" value="" size="20" required readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
			</div><!--ROW-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">
					N° Declaraci&oacute;n Aduana:<br>
					<input type="text" name="naduana_export" class="form-control" value="" size="20" required readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					Fecha Aduana Exportaci&oacute;n:<br>
					<input type="date" name="fechaduana_export" class="form-control" value="" size="20" required readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
			</div><!--ROW-->
			<!--///////////////////////////////////////PARA LA INSERCION DE PRODUCTOS-->
			<hr id="res_cargarVenta" class="featurette-divider">
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12">
					<table class="table_nada table table-bordered table_black">
						<thead id="resVenta">
							<tr>
								<th width="16.5%">
									<p>Codigo Producto</p>
								</th>
								<th width="16.5%">
									<p>Nombre Producto</p>
								</th>
								<th width="16.5%">
									<p>Precio de Venta (BsF.)</p>
								</th>
								<th width="16.5%">
									<p>Cantidad</p>
								</th>
								<th width="24%">
									<p>Tipo de Venta</p>
								</th>
								<th width="10%">
									<p align="center">Accion</p>
								</th>
							</tr>
							<tr>
								<td>
									<div class="list-group">
										<input name="fk_inventario1" class="form-control list-group-item" required="required" onclick="ctrlSelecProd(1)" onfocus="ctrlSelecProd(1)" readonly="readonly" placeholder="Clic aqui" />
										<button type="button" class="list-group-item active" onclick="ctrlSelecProd(1)">Seleccionar</button>
									</div>
									<input name="id_venta1" type="hidden">

								</td>
								<td>
									<div class="list-group">
										<input name="nom_fk_inventario1" class="form-control list-group-item" onclick="ctrlSelecProd(1)" readonly="readonly" placeholder="Clic aqui">
										<button type="button" class="list-group-item active" onclick="ctrlSelecProd(1)">Seleccionar</button>
									</div>
								</td>
								<td>
									<div class="list-group">
										<input class="form-control list-group-item" name="costo1" required="" type="number" min="0" step="0.0000001" value="" placeholder="0.00" onblur="fcalculo()">
										<button type="button" class="list-group-item active" onclick="ctrlSelecProd(1)">Seleccionar</button>
									</div>

									<input name="pmpvj1" class="form-control" type="hidden" />
								</td>
								<td>
									<span class="input-group">
										<input class="form-control" name="cantidad1" required="" type="number" min="0" onblur="fcalculo()">
										<!--vfecha, vfkinv, zona_dinamica-->
										<span class="input-group-addon">
											/
										</span>
										<input class="form-control" name="stock1" type="text" value="" readonly="readonly">
									</span>
								</td>
								<td>
									<select name="tipoVenta1" id="tipoVenta1" required="" class="selectpicker form-control" data-style="btn-primary" onchange="fcalculo(1)">
										<option value="">Seleccione</option>
										<optgroup label="Nacionales">
											<option value="NA_EX">Nacionales Exentas</option>
											<option value="NA_EXO">Nacionales Exoneradas</option>
											<option value="NA_NS">Nacionales No Sujetas</option>
											<option value="NA_SDCF">Nacionales Sin derecho a Credito Fiscal</option>
											<option value="NA_BI_12">Nacionales Base Imponible al 12%</option>
											<option value="NA_BI_8">Nacionales Base Imponible al 8%</option>
											<option value="NA_BI_27">Nacionales Base Imponible al 27%</option>
										</optgroup>
										<optgroup label="Exportaciones">
											<option value="EX_EX">Exportaciones Exentas</option>
										</optgroup>
									</select>
								</td>
								<td align="center"></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td align="center">
									<input type="hidden" name="numCampos" value="1">
									<input type="hidden" name="numCampoActual" />
									<button class="btn btn-sm btn-primary" type="button" onClick="agreInput(document.form1.numCampos.value)">
										<span class="glyphicon glyphicon-plus"></span>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div><!--ROW-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Monto Exento (BsF.):</label>
					<input type="text" class="form-control" name="msubt_exento_venta" value="0" size="20" readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
			</div><!--ROW-->

			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Base Imponible (BsF.):</label>
					<input type="text" class="form-control" name="msubt_bi_iva_12" value="0" size="20" readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>IVA al 12 &#37;:</label>
					<input type="number" class="form-control" min="0" step="0.01" value="0.00" placeholder="0.00" name="iva_12" readonly="readonly" />
				</div>
			</div><!--ROW-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Base Imponible (BsF.):</label>
					<input type="text" class="form-control" name="msubt_bi_iva_8" value="0" size="20" readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>IVA al 8 &#37;:</label>
					<input type="number" class="form-control" min="0" step="0.01" value="0.00" placeholder="0.00" name="iva_8" readonly="readonly" />
				</div>
			</div><!--ROW-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Base Imponible (BsF.):</label>
					<input type="number" class="form-control" min="0" step="0.01" value="0.00" placeholder="0.00" name="msubt_bi_iva_27" readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>IVA al 27 &#37;:</label>
					<input type="number" class="form-control" min="0" step="0.01" value="0.00" placeholder="0.00" name="iva_27" readonly="readonly" />
				</div>
			</div><!--ROW-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					Total Base Imponible (BsF.):<br />
					<input type="text" class="form-control" name="msubt_tot_bi_venta" value="0" size="20" readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					Total Impuesto IVA:<br />
					<input type="text" class="form-control" name="tot_iva" value="0" size="20" readonly="readonly" />
				</div>
			</div><!--ROW-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					Total de la Venta Incluyendo IVA (BsF.):<br />
					<input type="text" class="form-control" name="mtot_iva_venta" value="0" size="20" readonly="readonly" />
				</div>
			</div><!--ROW-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
			</div><!--ROW-->
			<!--   PARA DESPUES no existe en la bd
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Num_compro_reten:</td>
      <td><input type="text" name="num_compro_reten" value="" size="20" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha_compro_reten:</td>
      <td><input type="text" name="fecha_compro_reten" value="" size="20" /></td>
    </tr>
-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Tipo de Pago:</label>
					<select name="tipo_pago" class="form-control" onChange="tipoPago(this.value)" required="required">
						<option value="">Seleccione</option>
						<option value="D">Debito</option>
						<option value="C">Credito</option>
						<option value="E">Efectivo</option>
						<option value="T">Transferencia</option>
					</select>
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Dias a pagar:</label>
					<input type="number" class="form-control" min="0" name="dias_venc" value="" size="20" readonly="readonly" required="required" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
			</div><!--ROW-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Monto a Pagar:</label>
					<input name="monto_paga" type="number" class="form-control" onchange="vueltosPago(this.value)" min="0" step="0.01" value="" placeholder="0.00" required="required" />

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Vueltos:</label>
					<div id="dvueltos" class="">
						<input type="number" class="form-control" min="0" value="0.00" placeholder="0.00" name="vueltos" readonly="readonly" required="required" />
						<span id="svueltos" class=""></span>
					</div>
					<div class="col-sm-10">

					</div>
				</div>
			</div><!--ROW-->
			<hr id="res_cargarVenta" class="featurette-divider">
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12">
					<button type="submit" class="btn btn-lg btn-success col-xs-12 col-md-12 col-lg-12">Agregar Venta</button>
				</div>
			</div><!--row-->

			<!--
    <tr>
      <td colspan="2">
          <div align="center">
            <input type="button" name="agregar" id="agregar" value="Agregar"  onClick="guardar(this.form)"/>
          </div>
      </td>
    </tr>
    -->
		</form>
	</div><!--bs-marco- -->
</div><!--cargarVenta-->