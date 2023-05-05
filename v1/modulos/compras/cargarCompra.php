<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');
/*
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'index.php';
	echo $host."<br />".$uri."<br />".$extra;
	*/
?>
<!--PARA LLAMAR A EL cRUL RIF-->
<script>
	$(document).ready(function() {
		consulTablaProd = document.getElementById("res_consulTablaProd").innerHTML;
	});

	function tipoDocuC(str) {

		var tit_nfact_afectada = document.getElementById("tit_nfact_afectada");
		var infact_afectada = document.getElementById("nfact_afectada");
		var btnfact_afectada = document.getElementById("btn_nfact_afectada");
		var btnfact_b_afectada = document.getElementById("btn_b_nfact_afectada");


		if (str == 'NC-DESC' || str == 'NC-DEVO' || str == "ND") {
			if (str == "ND") {
				document.forms['form1'].elements['tipo_trans'].value = "02-reg";
				document.forms['form1'].elements['tipo_transc'].value = "02-reg";
			} else {
				document.forms['form1'].elements['tipo_trans'].value = "03-reg";
				document.forms['form1'].elements['tipo_transc'].value = "03-reg";
			}
			//ACTIVACION O PONER VISIBLE LOS CAMPOS DE SELÑECCINAR LA FACTURA
			tit_nfact_afectada.innerHTML = "N. Factura Afectada";

			infact_afectada.type = 'text';
			infact_afectada.setAttribute("data-bs-toggle", "modal");
			infact_afectada.setAttribute("data-target", "#busFact");
			infact_afectada.setAttribute("onfocus", "$('#busFact').modal('show')");
			//infact_afectada.setAttribute("readonly", "readonly");
			//infact_afectada.setAttribute("readonly", "readonly");


			btnfact_afectada.style = "display:compact"; // visible
			btnfact_b_afectada.style = "display:compact"; // visible

		} else if (str == 'F' || str == 'C' || str == 'NE') {
			document.forms['form1'].elements['tipo_trans'].value = "01-reg";
			document.forms['form1'].elements['tipo_transc'].value = "01-reg";
			//LA INVERSA DE LO QUE HACEN LAS NOTAS DE CREDITO
			infact_afectada.value = '';
			infact_afectada.type = 'hidden';
			btnfact_afectada.style = "display:none"; //no visible
			btnfact_b_afectada.style = "display:none"; //no visible
			tit_nfact_afectada.innerHTML = "";

		} else {
			document.forms['form1'].elements['tipo_trans'].value = "";
			document.forms['form1'].elements['tipo_transc'].value = "";
			//LA INVERSA DE LO QUE HACEN LAS NOTAS DE CREDITO
			infact_afectada.value = '';
			infact_afectada.type = 'hidden';
			btnfact_afectada.style = "display:none"; //no visible
			btnfact_b_afectada.style = "display:none"; //no visible 
			tit_nfact_afectada.innerHTML = "";
		}
		//vaciado de los productos
		document.getElementById("res_consulTablaProd").innerHTML = consulTablaProd;
	}

	//funcion para condicionar el llenado o suma de los totales
	function fcalculo(valido) {
		//como para que se llame ha esta funcion la i debe de existir entonces la vuelvo local para esta funcion
		//para saber cuantas veces voya sumar los prodcutos
		var n = parseInt(document.form1.numCampos.value);
		//totales 
		var acum_msubt_exento_compra = 0;
		var acum_msubt_bi_iva_12 = 0;
		var acum_msubt_bi_iva_8 = 0;
		var acum_msubt_bi_iva_27 = 0;
		var acum_iva_12 = 0;
		var acum_iva_8 = 0;
		var acum_iva_27 = 0;
		var acum_msubt_tot_bi_compra = 0;
		var acum_mtot_iva_compra = 0;
		///////////////////////////////////////
		for (i = 1; i <= n; i++) {
			if (document.form1.elements['fk_inventario' + i] != null) {
				//alert(document.form1.elements['fk_inventario'+i].value);
				var tipoCompraA = document.form1.elements['tipoCompra' + i].value;
				var fk_inventarioA = document.form1.elements['fk_inventario' + i].value;

				if (document.form1.elements['costo' + i].value !== "")
					var costoA = parseFloat(document.form1.elements['costo' + i].value);
				else
					costoA = 0;
				if (document.form1.elements['cantidad' + i].value !== "")
					var cantidadA = parseInt(document.form1.elements['cantidad' + i].value);
				else
					cantidadA = 0;

				if (document.getElementById('tipoDoc').value == "NC-DEVO") {
					var stockA = parseInt(document.form1.elements['stock' + i].value);

					if (cantidadA > stockA) {
						document.form1.elements['cantidad' + i].value = "";
						alert("la cantidad supera la existencia");
						//return 0;
					}
				}

				//validar que los campos anteriores esten llenos 
				if ((fk_inventarioA == "") || (costoA == "") || (cantidadA == "") || fk_inventarioA == 0 || costoA == 0 || cantidadA == 0 || fk_inventarioA == null || costoA == null || cantidadA == null || fk_inventarioA == "NaN" || costoA == "NaN" || cantidadA == "NaN") {
					if (valido == 1) {
						alert("Debe llenar los demas campos");
						//alert(fk_inventarioA+"\n"+costoA+"\n"+cantidadA);
						//tipoCompraA = "";

						//return 0;/*haber focus a ese campo vacio*/
					}
					document.form1.elements['tipoCompra' + i].value = "";
				} else { //por lo tanto los campos estan llenos
					bi = costoA * cantidadA; //base imponible
					if (tipoCompraA == "IN_EX" || tipoCompraA == "IN_EXO" || tipoCompraA == "IN_NS" || tipoCompraA == "IN_SDCF") {
						document.form1.nplanilla_import.readOnly = true;
						document.form1.nexpe_import.readOnly = true;
						document.form1.naduana_import.readOnly = true;
						document.form1.fechaduana_import.readOnly = true;
						acum_msubt_exento_compra += bi;

					} else if (tipoCompraA == "IN_BI_12") {
						document.form1.nplanilla_import.readOnly = true;
						document.form1.nexpe_import.readOnly = true;
						document.form1.naduana_import.readOnly = true;
						document.form1.fechaduana_import.readOnly = true;
						acum_msubt_bi_iva_12 += bi;
						acum_iva_12 += bi * 0.12;

					} else if (tipoCompraA == "IN_BI_27") {
						document.form1.nplanilla_import.readOnly = true;
						document.form1.nexpe_import.readOnly = true;
						document.form1.naduana_import.readOnly = true;
						document.form1.fechaduana_import.readOnly = true;
						acum_msubt_bi_iva_27 += bi;
						acum_iva_27 += bi * 0.27;

					} else if (tipoCompraA == "IN_BI_8") {
						document.form1.nplanilla_import.readOnly = true;
						document.form1.nexpe_import.readOnly = true;
						document.form1.naduana_import.readOnly = true;
						document.form1.fechaduana_import.readOnly = true;
						acum_msubt_bi_iva_8 += bi;
						acum_iva_8 += bi * 0.08;

					} else if (tipoCompraA == "IM_EX" || tipoCompraA == "IM_EXO" || tipoCompraA == "IM_NS" || tipoCompraA == "IM_SDCF") {

						document.form1.nplanilla_import.readOnly = false;
						document.form1.nexpe_import.readOnly = false;
						document.form1.naduana_import.readOnly = false;
						document.form1.fechaduana_import.readOnly = false;

						acum_msubt_exento_compra += bi;
					} else if (tipoCompraA == "IM_BI_12") {

						document.form1.nplanilla_import.readOnly = false;
						document.form1.nexpe_import.readOnly = false;
						document.form1.naduana_import.readOnly = false;
						document.form1.fechaduana_import.readOnly = false;
						acum_msubt_bi_iva_12 += bi;
						acum_iva_12 += bi * 0.12;

					} else if (tipoCompraA == "IM_BI_27") {

						document.form1.nplanilla_import.readOnly = false;
						document.form1.nexpe_import.readOnly = false;
						document.form1.naduana_import.readOnly = false;
						document.form1.fechaduana_import.readOnly = false;
						acum_msubt_bi_iva_27 += bi;
						acum_iva_27 += bi * 0.27;

					} else if (tipoCompraA == "IM_BI_8") {

						document.form1.nplanilla_import.readOnly = false;
						document.form1.nexpe_import.readOnly = false;
						document.form1.naduana_import.readOnly = false;
						document.form1.fechaduana_import.readOnly = false;
						acum_msubt_bi_iva_8 += bi;
						acum_iva_8 += bi * 0.08;
					}

				}
				document.form1.msubt_exento_compra.value = acum_msubt_exento_compra;

				document.form1.msubt_bi_iva_12.value = acum_msubt_bi_iva_12;
				document.form1.msubt_bi_iva_8.value = acum_msubt_bi_iva_8;
				document.form1.msubt_bi_iva_27.value = acum_msubt_bi_iva_27;

				msubt_tot_bi_compra = acum_msubt_bi_iva_12 + acum_msubt_bi_iva_27 + acum_msubt_bi_iva_8
				document.form1.msubt_tot_bi_compra.value = Math.round10(msubt_tot_bi_compra, -2);

				document.form1.iva_12.value = Math.round10(acum_iva_12, -2);
				document.form1.iva_8.value = Math.round10(acum_iva_8, -2);
				document.form1.iva_27.value = Math.round10(acum_iva_27, -2);

				tot_iva = acum_iva_12 + acum_iva_27 + acum_iva_8;
				document.form1.tot_iva.value = Math.round10(tot_iva, -2);

				document.form1.mtot_iva_compra.value = Math.round10(acum_msubt_exento_compra + msubt_tot_bi_compra + tot_iva, -2);
			} else {
				//document.form1.elements['tipoCompra'+i].value = "";
				//alert("Debe llenar los demas campos");
			} //if existe
		} //FOR
	}
	//funcion para seleccionar mas inputs
	function agreInput(numCampos) {

		//var capa = document.getElementById("capa");
		var resCompra = document.getElementById("resCompra");
		var hilera = document.createElement("tr");
		var celda1 = document.createElement("td");
		var celda2 = document.createElement("td");
		var celda3 = document.createElement("td");
		var celda4 = document.createElement("td");
		var celda5 = document.createElement("td");
		var celda6 = document.createElement("td");
		///////////////////////campos a insertar com productos
		var iid_compra = document.createElement("input");
		var ifk_inventario = document.createElement("input");
		var inom_fk_inventario = document.createElement("input");
		var icosto = document.createElement("input");
		var icantidad = document.createElement("input");
		var iStock = document.createElement("input"); //////////////////////////campo oculto
		var bBorrarFila = document.createElement("button");
		var spanmenos = document.createElement("span");

		var spaninputgroup = document.createElement("span");
		var spaninputgroupaddon = document.createElement("span");

		var spaninputgroupB = document.createElement("span");
		var spaninputgroupBtn = document.createElement("span");
		var bPMPVJ = document.createElement("button");
		var ipmpvj = document.createElement("input");
		var br = document.createElement("br");

		var divlistgroupProd1 = document.createElement("div");
		var btnlistgroupProd1 = document.createElement("input");

		var divlistgroupProd2 = document.createElement("div");
		var btnlistgroupProd2 = document.createElement("input");

		var itipoCompra = document.createElement("select");
		var span = document.createElement("span");

		//Create array of options to be added&prime; Exoneradas&prime; No Sujetas&prime; Sin derecho a Credito Fiscal&prime;
		var arrayV = ["IN_EX", "IN_EXO", "IN_NS", "IN_SDCF", "IN_BI_12", "IN_BI_8", "IN_BI_27",
			"IM_EX", "IM_EXO", "IM_NS", "IM_SDCF", "IM_BI_8", "IM_BI_27"
		];

		var arrayTINTER = ["Internas Exentas",
			"Internas Exoneradas",
			"Internas No Sujetas",
			"Internas Sin derecho a Credito Fiscal",
			"Internas Base Imponible al 12%",
			"Internas Base Imponible al 8%",
			"Internas Base Imponible al 27%"
		];

		var arrayTIMPORT = ["Importaciones Exentas",
			"Importaciones Exoneradas",
			"Importaciones No Sujetas",
			"Importaciones Sin derecho a Credito Fiscal",
			"Importaciones Base Imponible al 8%",
			"Importaciones Base Imponible al 27%"
		];

		//var iid_fact_compra = document.createElement("input");

		var i = parseInt(numCampos) + 1;

		//////////////////////
		iid_compra.name = 'id_compra' + i;
		iid_compra.hidden = true;
		//campo oculto
		ifk_inventario.name = 'fk_inventario' + i;
		ifk_inventario.required = true;
		ifk_inventario.setAttribute("onClick", "ctrlSelecProd(" + i + ")");
		ifk_inventario.setAttribute("onfocus", "ctrlSelecProd(" + i + ")");
		ifk_inventario.setAttribute("type", "text");
		ifk_inventario.setAttribute("class", "form-control list-group-item");
		ifk_inventario.setAttribute("value", "");
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
		inom_fk_inventario.setAttribute("type", "text");
		inom_fk_inventario.setAttribute("class", "form-control list-group-item");
		inom_fk_inventario.setAttribute("value", "");
		//////////////////
		btnlistgroupProd2.setAttribute("type", "button");
		btnlistgroupProd2.setAttribute("class", "list-group-item active");
		btnlistgroupProd2.setAttribute("onclick", "ctrlSelecProd(1)");
		btnlistgroupProd2.setAttribute("value", "Seleccionar Producto");
		//////////////////
		divlistgroupProd2.setAttribute("class", "list-group");
		//////////
		icosto.name = 'costo' + i;
		icosto.setAttribute("class", "form-control");
		icosto.required = true;
		icosto.setAttribute("type", "number");
		icosto.setAttribute("min", "0");
		icosto.setAttribute("step", "0.0000001");
		icosto.setAttribute("value", "");
		icosto.setAttribute("placeholder", "0.00 Clic aqui");
		icosto.setAttribute("onBlur", "fcalculo()");
		icosto.setAttribute("class", "form-control");
		/////////////
		ipmpvj.setAttribute("class", "form-control");
		ipmpvj.name = 'pmpvj' + i;
		ipmpvj.id = 'pmpvj' + i;
		ipmpvj.setAttribute("type", "number");
		ipmpvj.setAttribute("min", "0");
		ipmpvj.setAttribute("step", "0.0000001");
		ipmpvj.setAttribute("value", "");
		ipmpvj.setAttribute("placeholder", "0.00");
		ipmpvj.setAttribute("readonly", "readonly");
		ipmpvj.required = true;
		/////////////
		bPMPVJ.setAttribute("class", "btn btn-primary");
		bPMPVJ.setAttribute("type", "button");
		bPMPVJ.innerHTML = "P. Venta";
		bPMPVJ.setAttribute("onClick", "ctrlSelecPMPVJ(" + i + ")");
		////////////////
		spaninputgroupB.setAttribute("class", "input-group");
		spaninputgroupBtn.setAttribute("class", "input-group-btn");
		///////////7
		icantidad.name = 'cantidad' + i;
		icantidad.setAttribute("class", "form-control");
		icantidad.required = true;
		icantidad.setAttribute("type", "number");
		icantidad.setAttribute("min", "0");
		icantidad.setAttribute("onBlur", "fcalculo()");
		//		icantidad.setAttribute("onclick","val_cv_fech(document.form1.fecha_fact_compra.value, 'fecha_fact_compra')");
		////////////////////////////////
		spaninputgroupaddon.setAttribute("class", "input-group-addon");
		spaninputgroupaddon.innerHTML = "/";
		spaninputgroup.setAttribute("class", "input-group");
		//////////////////
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
		bBorrarFila.setAttribute("onclick", "elimInput(" + i + ")")
		bBorrarFila.appendChild(spanmenos);

		///valores predeterminados
		var optDefault = document.createElement("option");
		optDefault.text = "Seleccione";
		optDefault.setAttribute("value", "");
		var optGroup1 = document.createElement("optgroup");
		optGroup1.setAttribute("label", "Internas");
		////////////////////
		var optGroup2 = document.createElement("optgroup");
		optGroup2.setAttribute("label", "Importaciones");
		/////////////////////
		for (j = 0; j < arrayV.length; j++) {
			var option = document.createElement("option");

			if (j < 7) {
				option.text = arrayTINTER[j]; //import inter
				option.value = arrayV[j];

				optGroup1.appendChild(option);
			} else
			if (j >= 7) {
				option.text = arrayTIMPORT[j - 7];
				option.value = arrayV[j];

				optGroup2.appendChild(option);
			}

		}
		//meter dentro del select
		itipoCompra.appendChild(optDefault);
		itipoCompra.appendChild(optGroup1);
		itipoCompra.appendChild(optGroup2);
		//para que al cargar la funcion haga su cometido
		itipoCompra.name = 'tipoCompra' + i;
		itipoCompra.id = 'tipoCompra' + i;
		itipoCompra.setAttribute("class", "selectpicker form-control");
		itipoCompra.setAttribute("data-style", "btn-primary");
		itipoCompra.setAttribute("onChange", "fcalculo(1)");
		itipoCompra.setAttribute("required", "required");
		///////////////
		hilera.setAttribute("class", "alert fade in");

		spaninputgroup.appendChild(icantidad);
		spaninputgroup.appendChild(spaninputgroupaddon);
		spaninputgroup.appendChild(iStock);

		spaninputgroupB.appendChild(ipmpvj);
		spaninputgroupB.appendChild(spaninputgroupBtn);
		spaninputgroupBtn.appendChild(bPMPVJ);

		celda1.appendChild(iid_compra);

		divlistgroupProd1.appendChild(ifk_inventario);
		divlistgroupProd1.appendChild(btnlistgroupProd1);
		celda1.appendChild(divlistgroupProd1);

		divlistgroupProd2.appendChild(inom_fk_inventario);
		divlistgroupProd2.appendChild(btnlistgroupProd2);
		celda2.appendChild(divlistgroupProd2);

		celda3.appendChild(icosto);
		celda3.appendChild(br);
		celda3.appendChild(spaninputgroupB);
		celda4.appendChild(spaninputgroup);
		celda5.appendChild(itipoCompra);
		celda6.setAttribute("align", "center");
		celda6.appendChild(bBorrarFila);

		hilera.appendChild(celda1);
		hilera.appendChild(celda2);
		hilera.appendChild(celda3);
		hilera.appendChild(celda4);
		hilera.appendChild(celda5);
		hilera.appendChild(celda6);
		resCompra.appendChild(hilera);

		document.form1.numCampos.value = i; //para el contador	
	}
	//funcion para restar campos
	function elimInput(numCampoActual) {
		fcalculo();
	}


	//scriprt para el modal
	//MODALES
	/* lo mande a funciones
	function mConsulFact(str){
		//alert(str);
		var xhttp;
		xhttp = new XMLHttpRequest();
		
		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
			  document.getElementById("res_nfact_afectada").innerHTML = xhttp.responseText;
			  $('#mostrarFact').modal('show');
			}
		};
		url = '../<?php //res_nfact_afectadaecho $extra
					?>modales/fact_c/m_b_fact_c_det.php';
		xhttp.open("POST", url, true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("nfact_afectada="+ str);
		
	}
	*/
</script>
<?php

$consulta = pg_query($conexion, "SELECT * FROM empre WHERE empre.est_empre = '1'");
$filas = pg_fetch_assoc($consulta);
// $resEmpreActiva=$consulEmpreActiva->fetch_assoc();
$total_consulEmpreActiva = pg_num_rows($consulta);
$extra = "../../";

//llamado de modales el id es "busFact"
include_once($extra . "modales/fact_c/m_b_fact_c.php");
//llamado de modales el id es "mostrarFact"
//esta en el id res_nfact_afectada aqui

//llamando de modales el id es "nueProv"
include_once($extra . "modales/prov/m_a_prov.php");
//llamado de modales el id es "busProv"
include_once($extra . "modales/prov/m_b_prov.php");
//llamando de modales el id es "modProv"
include_once($extra . "modales/prov/m_m_prov.php");

//llamado de modales el id es "busProd"
include_once($extra . "modales/prod/m_b_prod.php");
//llamando de modales el id es "nueProd"
include_once($extra . "modales/prod/m_a_prod.php");
//llamando de modales el id es "mmProd"
include_once($extra . "modales/prod/m_m_prod.php");
//llamando de modales el id es "calPMPVJ"
include_once($extra . "modales/prod/m_PMPVJ.php");


?>
<br>
<!--para mostrar resultado de acciones de insercion y demas-->
<!--<label class="col-md-12 col-lg-12" id="txtHintA"></label>-->
<div class="bs-example" id="cargarCompra">
	<div class="">
		<h1 class="bd-title">Agregar Compra</h1>

	</div>
	<div class="bs-marco-form">
		<form id="form1" name="form1" method="post" action="recibirCompra.php">
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">
					<!--campos ocultos-->
					<input type="hidden" name="fk_usuariosC" value="<?php echo $_SESSION["id_usu"] ?>" /><!--que usuario operador hiso el registro-->
					<input type="hidden" name="id_fact_compra" value="" /><!--el id auoincremento de la factura-->
					<input type="hidden" name="empre_cod_empre" value="<?php echo $resEmpreActiva["cod_empre"] ?>" /><!--el id de la empresa actual del sistema-->
					<label for="tipodocumnto">Tipo de Documento:</label><br />
					<select id="tipoDoc" class="form-control" name="tipo_fact_compra" onchange="tipoDocuC(this.value)" required>
						<option value="">Seleccione</option>
						<option value="F">Factura</option>
						<option value="ND">Nota de D&eacute;bito</option>
						<option value="NC-DESC">Nota de Cr&eacute;dito - Descuento</option>
						<option value="NC-DEVO">Nota de Cr&eacute;dito - Devoluciones</option>
						<option value="C">Certificaci&oacute;n</option>
						<option value="NE">Nota de Entrega</option>
						<!--
                <optgroup label="Existencia Inicial">
                    <option value="II">Inventario Inicial</option>
                </optgroup>
                -->
					</select>
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4" id="resTipoDoc">
					<span id="tit_nfact_afectada"></span>
					<br />
					<span class="input-group">
						<input class="form-control btn-default" name="nfact_afectada" id="nfact_afectada" type="hidden" value="Clic Aqui" />
						<span class="input-group-btn">
							<button type="button" style="display:none" class="btn btn-primary" name="btn_b_nfact_afectada" id="btn_b_nfact_afectada" title="Buscar Factura" data-bs-toggle="modal" data-target="#busFact">
								B <i class="glyphicon glyphicon-search"></i>
							</button>

							<button type="button" style="display:none" class="btn btn-info" name="btn_nfact_afectada" id="btn_nfact_afectada" onclick="mConsulFact(document.form1.nfact_afectada.value)">
								D <i class="glyphicon glyphicon-th-list"></i>
							</button>
							<!--style="display:none" no visible-->
						</span>
					</span>
					<span id="res_nfact_afectada"></span>
				</div><!-- cierre del col este define por ajax el numero de documento o factura afectada-->
				<div class="col-xs-4 col-md-4 col-lg-4" id="res_serie_fact_compra">
					<span id="cont_serie_fact_compra">
						Serie de Documento<br />
						<input type="text" class="form-control" name="serie_fact_compra" id="serie_fact_compra" value="" size="20" onKeyUp="javascript:this.value=this.value.toUpperCase();" onblur="codFactProvee('form1', 'serie_fact_compra', 'num_fact_compra', 'fk_proveedor', 'id_fact_compra')">
						<!--no es requerido por que a veces las facturas no tienen numero de serie-->
					</span>
				</div>
			</div><!--ROW-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>N° Documento:</label><br />
					<input type="number" class="form-control" min="0" name="num_fact_compra" value="" size="20" required="required" onblur="codFactProvee('form1', 'serie_fact_compra', 'num_fact_compra', 'fk_proveedor', 'id_fact_compra')" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>N° Control:</label><br>
					<input type="text" class="form-control" name="num_ctrl_factcompra" id="num_ctrl_factcompra" value="00-" size="20" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
			</div><!--row-->
			<div class="row" id="ResselecProv">
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>R.I.F. del Proveedor:</label><br />
					<div class="list-group">
						<input name="fk_proveedor" class="open-busProv form-control list-group-item" required="required" onblur="javascript:this.value=this.value.toUpperCase();" onclick="modalbusProv('N')" onfocus="modalbusProv('N')" value="" type="text" placeholder="Clic aqui" />
						<button type="button" class="list-group-item active" onclick="modalbusProv('N')">Seleccionar Proveedor</button>
					</div>
					<!--codFactProvee('form1', 'serie_fact_compra', 'num_fact_compra', 'fk_proveedor', 'id_fact_compra')-->
					<!--en onclocl queda la funcion que desactiva la tecla enter del teclado-->
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Nombre o Raz&oacute;n Social:</label><br />
					<div class="list-group">
						<input id="nom_prov_ajax" name="nombre" class="form-control" required="required" onclick="modalbusProv('N')" onfocus="modalbusProv('N')" value="" type="text" placeholder="Clic aqui" />
						<button type="button" class="list-group-item active" onclick="modalbusProv('N')">Seleccionar Proveedor</button>
					</div>
				</div>
			</div><!--row-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4" id="res_fecha_fact_compra">
					<span id="cont_fecha_fact_compra">
						<label>Fecha de Emisi&oacute;n:</label><br><!--de la Compra-->
						<input type="date" class="form-control" name="fecha_fact_compra" id="fecha_fact_compra" size="20" lang="si-general" onblur="val_comp_ii_fech(this.value, 'fecha_fact_compra')" required /><br />
						<span id="nota_compra"></span>
					</span>
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Tipo de Transacci&oacute;n:</label><br />
					<select id="tipoTrans" class="form-control" name="tipo_transc" required disabled="disabled">
						<option value="01-reg">01-reg --> Factura</option>
						<option value="02-reg">02-reg --> Nota de Debito</option>
						<option value="03-reg">03-reg --> Nota de Credito</option>
						<option value="01-anul">01-anul --> Anulada</option>
					</select>
					<input id="tipoTrans" type="hidden" name="tipo_trans" value="" required>
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
			</div><!--row-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>N° Planilla de Importaci&oacute;n:</label><br>
					<input type="text" class="form-control" name="nplanilla_import" value="" size="20" required readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>N° Exp de Importaci&oacute;n:</label><br>
					<input type="text" class="form-control" name="nexpe_import" value="" size="20" required readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>N° Declaraci&oacute;n Aduana:</label><br>
					<input type="text" class="form-control" name="naduana_import" value="" size="20" required readonly="readonly" />
				</div>
			</div><!--row-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Fecha Aduana Importacion:</label><br>
					<input type="date" class="form-control" name="fechaduana_import" value="" size="20" required readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
			</div><!--row-->
			<hr id="res_cargarCompra" class="featurette-divider">
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12" id="res_consulTablaProd">
					<table class="table_nada table table-bordered table_black">
						<thead id="resCompra">
							<tr>
								<th width="16.5%">
									<p>Codigo Producto</p>
								</th>
								<th width="16.5%">
									<p>Nombre Producto</p>
								</th>
								<th width="16.5%">
									<p>Costo (BsF.) &frasl; Precio de Venta</p>
								</th>
								<th width="16.5%">
									<p>Cantidad</p>
								</th>
								<th width="24%">
									<p>Tipo de Compra</p>
								</th>
								<th width="10%">
									<p align="center">Accion</p>
								</th>
							</tr>
							<tr class="alert fade in">
								<td>
									<input name="id_compra1" hidden="">
									<div class="list-group">
										<input name="fk_inventario1" class="form-control list-group-item" onclick="ctrlSelecProd(1)" onfocus="ctrlSelecProd(1)" value="" type="text" required="required">
										<button type="button" class="list-group-item active" onclick="ctrlSelecProd(1)">Seleccionar Producto</button>
									</div>
								</td>
								<td>
									<div class="list-group">
										<input name="nom_fk_inventario1" class="form-control list-group-item" onclick="ctrlSelecProd(1)" value="" type="text" required="required">
										<button type="button" class="list-group-item active" onclick="ctrlSelecProd(1)">Seleccionar Producto</button>
									</div>
								</td>
								<td>
									<input class="form-control" name="costo1" required="" type="number" min="0" step="0.0000001" value="" onblur="fcalculo()" placeholder="0.00" />
									<br>
									<span class="input-group">
										<input class="form-control" name="pmpvj1" id="pmpvj1" type="number" min="0" step="0.0000001" value="" placeholder="0.00" required="required" readonly="readonly" />
										<span class="input-group-btn">
											<button class="btn btn-primary" type="button" onclick="ctrlSelecPMPVJ(1)">P. Venta</button>
										</span>
									</span>
								</td>
								<td>
									<span class="input-group">
										<input class="form-control" name="cantidad1" required="" type="number" min="1" onblur="fcalculo()" value="" />
										<span class="input-group-addon">
											/
										</span>
										<input class="form-control" name="stock1" type="text" value="" readonly="readonly">
									</span>
								</td>
								<td>
									<select name="tipoCompra1" id="tipoCompra1" class="selectpicker form-control" data-style="btn-primary" onchange="fcalculo(1)" required>
										<option value="">Seleccione</option>
										<optgroup label="Internas">

											<option value="IN_EX">Internas Exentas</option>
											<option value="IN_EXO">Internas Exoneradas</option>
											<option value="IN_NS">Internas No Sujetas</option>
											<option value="IN_SDCF">Internas Sin derecho a Credito Fiscal</option>
											<option value="IN_BI_12">Internas Base Imponible al 12%</option>
											<option value="IN_BI_8">Internas Base Imponible al 8%</option>
											<option value="IN_BI_27">Internas Base Imponible al 27%</option>
										</optgroup>
										<optgroup label="Importaciones">
											<option value="IM_EX">Importaciones Exentas</option>
											<option value="IM_EXO">Importaciones Exoneradas</option>
											<option value="IM_NS">Importaciones No Sujetas</option>
											<option value="IM_SDCF">Importaciones Sin derecho a Credito Fiscal</option>
											<!--<option value="IM_BI_12">Importaciones Base Imponible al 12%</option>-->
											<option value="IM_BI_8">Importaciones Base Imponible al 8%</option>
											<option value="IM_BI_27">Importaciones Base Imponible al 27%</option>
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
									<input type="hidden" name="numCampoActual" /><!--solo para el modal seleccion-->
									<button class="btn btn-sm btn-primary" type="button" onClick="agreInput(document.form1.numCampos.value)">
										<span class="glyphicon glyphicon-plus"></span>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div><!--row-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Monto Exento (BsF.):</label><br />
					<input type="text" class="form-control" name="msubt_exento_compra" value="0" size="20" readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
			</div><!--row-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Base Imponible (BsF.):</label><br />
					<input type="text" class="form-control" name="msubt_bi_iva_12" value="0" size="20" readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>IVA al 12 &#37;:</label><br />
					<input type="number" class="form-control" min="0" step="0.01" value="0.00" placeholder="0.00" name="iva_12" required="required" onkeyup="fcalculoTotC(this.value, document.form1.iva_8.value, document.form1.iva_27.value)" />
				</div>
			</div><!--row-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Base Imponible (BsF.):</label><br />
					<input type="text" class="form-control" name="msubt_bi_iva_8" value="0" size="20" readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>IVA al 8 &#37;:</label><br />
					<input type="number" class="form-control" min="0" step="0.01" value="0.00" placeholder="0.00" name="iva_8" required="required" onkeyup="fcalculoTotC(document.form1.iva_12.value, this.value,  document.form1.iva_27.value)" />
				</div>
			</div><!--row-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Base Imponible (BsF.):</label><br />
					<input type="text" class="form-control" name="msubt_bi_iva_27" value="0" size="20" readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>IVA al 27 &#37;:</label><br />
					<input type="number" class="form-control" min="0" step="0.01" value="0.00" placeholder="0.00" name="iva_27" required="required" onkeyup="fcalculoTotC(document.form1.iva_12.value, document.form1.iva_8.value, this.value)" />
				</div>
			</div><!--row-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Total Base Imponible (BsF.):</label><br />
					<input type="text" class="form-control" name="msubt_tot_bi_compra" value="0" size="20" readonly="readonly" />
				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">
					<label>Total Impuesto IVA:</label><br />
					<input type="text" class="form-control" name="tot_iva" value="0" size="20" readonly="readonly" />
				</div>
			</div><!--row-->

			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-6 col-lg-6">
					<label>Total de la Compra Incluyendo IVA (BsF.):</label><br />
					<input type="text" class="form-control" name="mtot_iva_compra" value="0" readonly="readonly" />
				</div>
			</div><!--row-->
			<hr id="res_cargarCompra" class="featurette-divider">
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12">
					<button type="submit" class="btn btn-lg btn-success col-xs-12 col-md-12 col-lg-12">Agregar Compra</button>
				</div>
			</div><!--row-->
			<div class="row">
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
				<div class="col-xs-4 col-md-4 col-lg-4">

				</div>
			</div>
			<!--row-->
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
						<!-- PARA DESPUES no existe en la bd
				<tr valign="baseline">
				<td nowrap="nowrap" align="right">Iva_retenido_vendedor_inter:</td>
				<td><input type="text" name="iva_retenido_vendedor_inter" value="" size="20" /></td>
				</tr>
				<tr valign="baseline">
				<td nowrap="nowrap" align="right">Iva_anticipo_import:</td>
				<td><input type="text" name="iva_anticipo_import" value="" size="20" required="required"/></td>
				</tr>
			-->
		</form>
	</div><!--bs-marco- -->
</div><!--cargarCompra-->