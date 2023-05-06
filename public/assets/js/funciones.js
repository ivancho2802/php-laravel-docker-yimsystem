// JavaScript Document
var extra = '../../';
//funcion login para modales

//	funcion para aplicar scrooll HA FUNCIONADO
function scrollTo(element, to, duration) {
    if (duration <= 0) return;
    var difference = to - element.scrollTop;
    var perTick = difference / duration * 10;

    setTimeout(function() {
        element.scrollTop = element.scrollTop + perTick;
        if (element.scrollTop === to) return;
        scrollTo(element, to, duration - 10);
    }, 10);
}

function vaciar(str){
	document.getElementById(str).value = "";
}

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
	url = extra+'modales/fact_c/m_b_fact_c_det.php';
	xhttp.open("POST", url, true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("nfact_afectada="+ str);
	
}



function mmProv(str){
	//alert(str);
	var xhttp;
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  document.getElementById("res_mmProv").innerHTML = xhttp.responseText;
		  
		  $('#mmProv').modal('show');
		  $(window.document).on('shown.bs.modal', '#mmProv', function() {
			window.setTimeout(function() {
				//<?php
				//include_once('../../includes_SISTEM/include_login.php');
				//?>
				$('#rif_m_m_prov', this).focus();
				document.forms['form_mmProv'].elements['rif_m_m_prov'].focus();
				//esta variable contirnr rn realidad un rif paselo si no no
				//if (/[JVEGPjvepg][0-9]{8}$/.test(document.getElementById('b_prov').value) || /[JVEGPjvepg][0-9]{9}$/.test(document.getElementById('b_prov').value) || /[0-9]{8}$/.test(document.getElementById('b_prov').value)) 
					//document.getElementById('rif').value = document.getElementById('b_prov').value;
			}.bind(this), 100);
		  });
		}
	};
	url = extra+'modales/prov/m_b_m_prov.php';
	xhttp.open("POST", url, true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("rif_prov="+ str);
	
}
function mmCliente(str){
	//alert(str);
	var xhttp;
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  document.getElementById("res_mmCliente").innerHTML = xhttp.responseText;
		  
		  $('#mmCliente').modal('show');
		  $(window.document).on('shown.bs.modal', '#mmCliente', function() {
			window.setTimeout(function() {
				//<?php
				//include_once('../../includes_SISTEM/include_login.php');
				//?>
				$('#ced_cliente_m_nue', this).focus();
				document.forms['form_mmCliente'].elements['ced_cliente_m_nue'].focus();
				//esta variable contirnr rn realidad un rif paselo si no no
				//if (/[JVEGPjvepg][0-9]{8}$/.test(document.getElementById('b_prov').value) || /[JVEGPjvepg][0-9]{9}$/.test(document.getElementById('b_prov').value) || /[0-9]{8}$/.test(document.getElementById('b_prov').value)) 
					//document.getElementById('rif').value = document.getElementById('b_prov').value;
			}.bind(this), 100);
		  });
		}
	};
	url = extra+'modales/cliente/m_b_m_cliente.php';
	xhttp.open("POST", url, true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("ced_cliente="+ str);
	
}

function mmProd(str){
	//alert(str);
	var xhttp;
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  document.getElementById("res_mmProd").innerHTML = xhttp.responseText;
		  
		  $('#mmProd').modal('show');
		  $(window.document).on('shown.bs.modal', '#mmProd', function() {
			window.setTimeout(function() {
				//<?php
				//include_once('../../includes_SISTEM/include_login.php');
				//?>
				$('#codigo_m_m_prod', this).focus();
				document.forms['form_mmProd'].elements['codigo_m_m_prod_nue'].focus();
				//esta variable contirnr rn realidad un rif paselo si no no
				//if (/[JVEGPjvepg][0-9]{8}$/.test(document.getElementById('b_prov').value) || /[JVEGPjvepg][0-9]{9}$/.test(document.getElementById('b_prov').value) || /[0-9]{8}$/.test(document.getElementById('b_prov').value)) 
					//document.getElementById('rif').value = document.getElementById('b_prov').value;
			}.bind(this), 100);
		  });
		}
	};
	url = extra+'modales/prod/m_b_m_prod.php';
	xhttp.open("POST", url, true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("codigo_prod="+ str);
	
}

//funcion para autoseleccionar el tipod e contribuyente
function autos_tipo_contri(docu_cliente,z_dinamica){
	
	var aguja = new RegExp(/[A-Za-z.]/);
	pajar = docu_cliente;
	
	
		if(pajar != ""){		
			if (aguja.test(pajar) && pajar.length == 10)//esto es un rif y contribuyente
				document.getElementById(z_dinamica).value = "CONTRI_ORD";
			else//esto es un cedula NO contribuyente
				document.getElementById(z_dinamica).value = "NO_CONTRI";
		}else{
			document.getElementById(z_dinamica).value = "";
		}
}
	
function consulTablaProd(str){
	//alert(str);
	var xhttp;
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  document.getElementById("res_consulTablaProd").innerHTML = xhttp.responseText;
		  fcalculo(1);
		}
	};
	url = extra+'php/consul_sql/b_tablaProd.php';
	xhttp.open("POST", url, true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("id_fact_compra="+ str);
	
}

function hoverScrool(str,IDanimationToogle){
	
	
	var strCont = $(str);
	
	//scrollTo(strCont, 0, 600);
	//animacion opacity
	
	if ($("#"+IDanimationToogle)) {
		//INICIALIZO EN OPACITY EL AREA
		
		//-para bajar con houver hasta la tabla menos el menu fijo OJO EL STR DEBE TENER # O . SEGUN CLASE O {"ID"}
		//-$('html, body').animate({scrollTop: strCont.offset().top  }, 'slow');
		//-$('html, body').animate({scrollTop: (strCont.offset().top) - 600}, 2000);
		//-$(str).scroll(5000,0);
		
		//-$(animationToogle).slideDown("slow");
		
		//$("#"+IDanimationToogle).slideToggle("slow");
		
		$("#"+IDanimationToogle).animate({height: 'show', opacity: '0'}, "slow");
		$("#"+IDanimationToogle).animate({ opacity: '1'}, "slow");
		//$("#"+IDanimationToogle).scroll(0,100);
		//var body = $("html, body");
		
	}else{
		alert('este elemento no existe hoverScrool:'+$("#"+IDanimationToogle));
	
	}
}
// funcion para recalcular los precias al editar los ivas
function fcalculoTotC(iva_12,iva_8,iva_27){//		fcalculoTot(iva_12,iva_8,iva_27)
	document.form1.tot_iva.value = iva_12 + iva_8 + iva_27;
	document.form1.mtot_iva_compra.value = document.form1.tot_iva.value + document.form1.msubt_tot_bi_compra.value ;
}
/*
function fcalculoTotV(iva_12,iva_8,iva_27){//		fcalculoTot(iva_12,iva_8,iva_27)
	document.form1.tot_iva.value = iva_12 + iva_8 + iva_27;
	document.form1.mtot_iva_venta.value = document.form1.tot_iva.value + document.form1.msubt_tot_bi_venta.value ;
}
*/

 
// funcion para generar numeros de algo mas uno
function generarNum(valor,inputID,tabla){// campo = inputID
	var valor = valor.substr(0,8);
	var columna = inputID;
	var actNumero, sigNumero;
	var xhttp;
	
	
	if (valor !== ""){
		
		xhttp = new XMLHttpRequest();
		xhttp.open("GET", extra+"php/consul_sql/b_tabla_may.php?columna="+ columna+"&tabla="+tabla);		
		
		xhttp.onreadystatechange = function() {
			if(xhttp.readyState == 4 && xhttp.status == 200) {
				if(xhttp.responseText !== 0 ){// si la ocnsulta ha dado exito
					if ( xhttp.responseText == "0")
						actNumero = 0;
					else
						actNumero = xhttp.responseText.substr(10,16);//extraigo los 8 numeros finales del numero actual 
					sigNumero = "" +(parseFloat(actNumero) + 1);
					//		
					pad = "00000000";
					ans = pad.substring(0, pad.length - sigNumero.length) + sigNumero;
					document.getElementById(inputID).value = valor + ans;
				}else {
					alert("error al cargar el archivo")
				}
			}
		};
		xhttp.send(null)
	}else{
		if(columna == 'num_compro_reten'){
			alert('Debe Seleccionar la Fecha del comprobante primero');
			document.getElementById('fecha_compro_reten').value ="";
			document.getElementById('fecha_compro_reten').focus();
		}
	}
}
//	FUNCION PARA VALIDAR QUE LA CANTIDAD SEA MENOR AL STOCK O LA EXISTENCIA*/
function valCantidadStock(cantidadA,stockA, zona_dinamica){
	//alert(cantidadA+'-'+stockA)
	if(parseInt(cantidadA) !== "" && parseInt(stockA) !== ""){
		if(parseInt(cantidadA) > parseInt(stockA) ){
			document.form1.elements[zona_dinamica].value = "";
			
			alert("la cantidad supera la existencia");
			document.getElementById(zona_dinamica).focus();
		}
	}
}

//para evitar que la tecla enter envie el formulario
function stopRKey(evt) {
	var evt = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
//funcion de redondeo
function decimalAdjust(type, value, exp) {
    // Si el exp no está definido o es cero...
    if (typeof exp === 'undefined' || +exp === 0) {
      return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // Si el valor no es un número o el exp no es un entero...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
      return NaN;
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
  }

  // Decimal round
  if (!Math.round10) {
    Math.round10 = function(value, exp) {
      return decimalAdjust('round', value, exp);
    };
  }
  // Decimal floor
  if (!Math.floor10) {
    Math.floor10 = function(value, exp) {
      return decimalAdjust('floor', value, exp);
    };
  }
  // Decimal ceil
  if (!Math.ceil10) {
    Math.ceil10 = function(value, exp) {
      return decimalAdjust('ceil', value, exp);
    };
  }
function cURLcne(campo, posVec, formu, resCampo, boton){
  var spanbtnload = document.createElement("span");
  spanbtnload.setAttribute("class", "bootstrap-dialog-button-icon glyphicon glyphicon-asterisk glyphicon-spin");
  
  var xhttp2;
  
  xhttp2 = new XMLHttpRequest();
  xhttp2.onreadystatechange = function() {
	if (xhttp2.readyState == 4 && xhttp2.status == 200) {
		//alert('c');
		//document.getElementById(zona_dinamica).innerHTML = xhttp2.responseText;
		$('#'+boton).prop('disabled', false);
		document.getElementById(boton).removeChild(spanbtnload);
		
		if(xhttp2.responseText.search("FALLECIDO") > 0){
			//alert(url.search(patron1));
			document.forms[formu].elements[resCampo].placeholder = "FALLECIDO";
			alert('FALLECIDO intentelo de nuevo');
		}else if(xhttp2.responseText == "Rif Incorrecto o Cedula Inexistente" || xhttp2.responseText.search("Notice") > 0){
			alert("Error Soporte CNE");
			//alert(xhttp2.responseText);
			//document.forms[formu].elements[resCampo].value = "";
		}else
			document.forms[formu].elements[resCampo].value = xhttp2.responseText;
		//alert(xhttp2.responseText);
	}else{
		document.getElementById(boton).setAttribute("disabled", "disabled");
		document.getElementById(boton).setAttribute("class", "form-control btn btn-primary active");
        document.getElementById(boton).appendChild(spanbtnload);
	}
  };
  //xhttp2.open("GET", "c.php?q="+str, true);
  //xhttp2.send();
	
	xhttp2.open("POST", extra+"php/cURL/ajax_ced.php", true);
	//xhttp2.open("POST", extra+"php/cURL/ajax_rif_"+tabla+".php", true);
	xhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp2.send("campo="+ campo + "&posVec="+ posVec );
}
//funcion seleccionar nombre de internet por el RIF mediante la CURL
//el srt es para la tabla 
function cURLrifC(strI,strII,strIII,resCampo,strIV, boton) {//cURLrifC('posVec','campo','fomulario','resCampo','zona dimmia');
  var posVec = strI;												//		V
  var campo = document.getElementById(strII).value;					//		V
  var formu = strIII;												//		V
  var zona_dinamica = strIV;										//		V
  
  var spanbtnload = document.createElement("span");
  spanbtnload.setAttribute("class", "bootstrap-dialog-button-icon glyphicon glyphicon-asterisk glyphicon-spin");
  
  var xhttp;
  if (campo.length == 0) {
	document.getElementById(strII).placeholder = "Campo Vacio";
	alert("Campo CEDULA Vacio");
	document.getElementById(strII).focus();
	return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
	if (xhttp.readyState == 4 && xhttp.status == 200) {
		//alert('c');
		$('#'+boton).prop('disabled', false);
		document.getElementById(boton).removeChild(spanbtnload);
		
		if(xhttp.responseText == "Rif Inexistente o Inválido" || xhttp.responseText == "No Existe Soporte Curl"){
			//document.forms[formu].elements[resCampo].placeholder = xhttp.responseText;		CURL CNE
			cURLcne(campo, posVec, formu, resCampo, boton);
		}else
			document.forms[formu].elements[resCampo].value = xhttp.responseText;
		//alert(xhttp.responseText);
	}else{
		//alert(boton)
		document.getElementById(boton).setAttribute("disabled", "disabled");
		document.getElementById(boton).setAttribute("class", "form-control btn btn-primary active");
        document.getElementById(boton).appendChild(spanbtnload);
		//document.getElementById(zona_dinamica).innerHTML =  '<div id="myModalLoad" class="modal fade "><div class="modal-dialog modal-ms loader"></div></div>';
		//$('#myModalLoad').modal('show');
	}
  };
  //xhttp.open("GET", "c.php?q="+str, true);
  //xhttp.send();
	
	xhttp.open("POST", extra+"php/cURL/ajax_rif.php", true);
	//xhttp.open("POST", extra+"php/cURL/ajax_rif_"+tabla+".php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("campo="+ campo + "&posVec="+ posVec );
}
	
//
function modalbusProv(otroModal) {
	
	if(otroModal == "N"){
		
		document.getElementById('otroModal').value = '';
		$('#busProv').modal('show');
		return
	}else if(otroModal == 'formMbf'){
		
		document.getElementById('otroModal').value = 'formMbf';//formulario de el modal bFactC
		$('#busProv').modal('show');
		return
	}
				 
}
//selector de proveedor
//para enviar el rif del proveedor y nombre a cargarcompra.php	
	function selecProv(strI,strII,url){
	  var patron1 = "cargarRetenCompra";
	  var patron2 = "cargarCompra";
	  var patron3 = "modificarCompra";
	  var otroModal = document.getElementById('otroModal').value;
	  
	  	if(url.search(patron1) > 0){
		  document.formMbf.elements["fk_proveedor"].value = strI;
		  document.formMbf.elements["nom_prov_ajax"].value = strII;
		  
		  consulFact();
		}else if(url.search(patron2) > 0 || url.search(patron3) > 0){
		  if(otroModal == ""){
		  	document.form1.elements["fk_proveedor"].value = strI;
		    document.form1.elements["nom_prov_ajax"].value = strII;
		  }else if(otroModal == "formMbf"){
		  	document.forms[otroModal].elements["fk_proveedor"].value = strI;
		    document.forms[otroModal].elements["nom_prov_ajax"].value = strII;
			consulFact();
		  }
		  codFactProvee('form1', 'serie_fact_compra', 'num_fact_compra', 'fk_proveedor', 'id_fact_compra');
		}else
			alert("No existe este la url en la toma de deciciones patron en la funcion SelecProv()");
	}
//selector de facturas
//para enviar el numero ID de fla factura a cargarcompra.php
	function selecFactC(strI){
	  document.form1.elements["nfact_afectada"].value = strI;
	}
	//selector de facturas
//para enviar el numero ID de fla factura a cargarcompra.php
	function selecFactCM(strI,strII,strIII,strIV,strV,strVI,strVII,strVIII,strIX){
	  if(strVIII !=="")
		{
			alert('Esta factura YA POSEE RETENCION Si continua se MODIFICARAN LOS DATOS'+strII);
		}
	  document.getElementById("id_fact_compra").value = strI;
	  document.getElementById("num_fact_compra").value = strII;
	  document.getElementById("serie_fact_compra").value = strIII;
	  document.getElementById("proveedor_fact_compra").value = strIV;
	  document.getElementById("tot_iva").value = strV;
	  if(strVI =="0.000")
	  strVI="";
	  document.getElementById("m_iva_reten").value = strVI;
	  document.getElementById("mes_apli_reten").value = strVII;
	  document.getElementById("num_compro_reten").value = strVIII;
	  if(strIX =="0000-00-00")
	  	strIX="";
	  document.getElementById("fecha_compro_reten").value = strIX;
	}
	function selecFactMF(strI,strII,strIII,strIV,strV,strVI,strVII,strVIII,strIX,strX){
		/*selecFactMF('
		id_fact_compra,
		num_fact_compra
		serie_fact_compra
		fk_proveedor
		nombre
		tot_iva
		tipo_fact_compra 7
		num_ctrl_factcompra
		fecha_fact_compra
		tipo trans
		------------
		m_iva_reten 
		mes_apli_reten
		num_compro_reten
		fecha_compro_reten
		
		tipo_transc
		*/
	  document.form1.id_fact_compra_old.value = strI;
	  document.form1.id_fact_compra.value = strI;
	  
	  document.form1.num_fact_compra.value = strII;
	  document.form1.serie_fact_compra.value = strIII;
	  document.form1.fk_proveedor.value = strV;//proveedor_fact_compra
	  document.form1.nombre.value = strIV;
	  document.form1.mtot_iva_compra.value = strVI;
	  document.form1.tipo_fact_compra.value = strVII;
	  document.form1.num_ctrl_factcompra.value = strVIII;
	  document.form1.fecha_fact_compra.value = strIX;
	  //una es para mostrar y la otra es para seleccionear
	  document.form1.tipo_transc.value = strX;
	  document.form1.tipo_trans.value = strX;
	  
	  consulTablaProd(strI);
	  
	}
//selector de facturas
//para enviar el numero ID de fla factura a cargarcompra.php
	function selecFactV(strI){
	  document.form1.elements["nfact_afectada"].value = strI;
	}
//selector de facturas
//para enviar el numero ID de fla factura a cargarcompra.php
	function selecFactVM(strI,strII,strIII,strIV,strV,strVI,strVII,strVIII,strIX){
		if(strVIII !=="")
		{
			alert('Esta factura YA POSEE RETENCION Si continua se MODIFICARAN LOS DATOS');
		}
	  document.formModal.elements["id_fact_venta"].value = strI;
	  document.getElementById("num_fact_venta").value = strII;
	  document.getElementById("serie_fact_venta").value = strIII;
	  document.getElementById("cliente_fact_venta").value = strIV;
	  document.getElementById("tot_iva").value = strV;
	  if(strVI =="0.000")
	  strVI="";
	  document.getElementById("m_iva_reten").value = strVI;
	  document.getElementById("mes_apli_reten").value = strVII;
	  document.getElementById("num_compro_reten").value = strVIII;
	  if(strIX =="0000-00-00")
	  	strIX="";
	  document.getElementById("fecha_compro_reten").value = strIX;
	  
	}
//selector de proveedor
//para enviar el rif del proveedor y nombre a cargarcompra.php	
	function selecCliente(strI,strII,strIII){
	  document.form1.elements["fk_cliente"].value = strI;
	  document.form1.elements["nom_cliente_ajax"].value = strII;
	  document.form1.elements["tipo_contri"].value = strIII;
	}	
//control del seleccionador del producto
function ctrlSelecProd(i){
	//if(tipo ="con")
	//{0
		document.form1.numCampoActual.value = i;
		
		$('#busProd').modal('show');
		
	//}else if(tipo = "agre"){
			
	//}
	
}
//calculo del pmvpj vs utilidd
function SelecPMPVJ(strI ,numCampoActual){
	 document.getElementById("pmpvj"+numCampoActual).value = strI
}
function SeleccalReten(str){
	document.getElementById("m_iva_reten").value = str;
}
//selector de producto
//para enviar el codigo del producto y nombre a cargarcompra.php	
function selecProd(strI,strII,strIII,strIV,numCampoActual){
	//alert(document.form1.elements['fk_inventario9'])
	var error = 0;
	var item_existen = "";
	for(var j=1;j<= parseInt(document.form1.elements['numCampos'].value);j++){
		//
		//alert(document.form1.elements['fk_inventario'+parseInt(j)]);
		if(document.form1.elements['fk_inventario'+j] != null){//[object HTMLInputElement]		//SI ITEM NO EXISTE
			//alert("variable existe"+document.form1.elements['fk_inventario'+parseInt(j)].value+'numero'+j);
			if(document.form1.elements['fk_inventario'+parseInt(j)].value == strI){
				item_existen = document.form1.elements['fk_inventario'+j].value;
				//return false
				error++;
				//alert(document.form1.elements['fk_inventario'+parseInt(j)].value+" - "+strI);
			}else{//		SI SELECCIONO POR QUE NO ESTA
				//alert(document.form1.elements['fk_inventario'+parseInt(j)].value+" - "+strI);
			}
		}else{//SI ITEM  EXISTE
			//alert("el elemento no existe");
		}
	}//FOR
	if(error == 0){
		//alert("variable no existe"+document.form1.elements['fk_inventario'+parseInt(j)].value);
				//vacion antes de seleccionrar los datos que no se leccionan para este producto
				document.form1.elements["pmpvj"+numCampoActual].value = ""; 
				
				//ahora si paso el resro de los valores 
				document.form1.elements["fk_inventario"+numCampoActual].value = strI
				document.form1.elements["nom_fk_inventario"+numCampoActual].value = strII
				document.form1.elements["costo"+numCampoActual].value = strIII
				document.form1.elements["stock"+numCampoActual].value = strIV
				
				//SOLO PARA COMPRAS EN NOTAS DE CREDITO DESCUENTOS
				if($('#tipoDoc').length ){
					if(document.getElementById('tipoDoc').value == 'NC-DESC'){
						document.form1.elements["cantidad"+numCampoActual].setAttribute("readonly", true);
						document.form1.elements["cantidad"+numCampoActual].value = strIV;
						
					}else{
						document.form1.elements["cantidad"+numCampoActual].value = "";
						//document.form1.elements["cantidad"+numCampoActual].removeAttribute("readonly");
						
					}
				}
				if(numCampoActual !== "")
					fcalculo();	
					//alert(document.form1.elements['fk_inventario'+parseInt(i)].value+'num'+i);	
	}else{
		alert("Ya exise este item: "+item_existen);
	}
	
}

function confirmDel()
{
  var agree=confirm("¿Realmente desea eliminarlo? ");
  if (agree) return true ;
  return false;
}

function buscar_dato(id_dato,str)
{
	alert('inhabilitada')
	/*
 if(id_dato == '1')//Buscamos un producto inventario
 {
   zona_dinamica=new Array('res_prod');
   valor= str;
   tabla="inventario"
   campo="codigo"
   campo_retorno="codigo"
 }
 
 if(id_dato == '2')//Buscamos un proveedor
 {
   zona_dinamica=new Array('res_prov');
   valor=str;
//   valor=document.getElementById("cod_prod").value
   tabla="proveedor"
   campo="rif"
   campo_retorno="rif"
 }
  if(id_dato == '3')//Buscamos un proveedor
 {
   zona_dinamica=new Array('res_cliente');
   valor=str;
//   valor=document.getElementById("cod_prod").value
   tabla="cliente"
   campo="ced_cliente"
   campo_retorno="ced_cliente"
 }
 
 objAjax=new XMLHttpRequest()
 objAjax.open("GET","controladores/controlador.php?accion=buscar_dato&valor="+valor+"&tabla="+tabla+"&campo="+campo+"&campo_retorno="+campo_retorno)
 objAjax.onreadystatechange=function()
 {   
	if(objAjax.status==200 && objAjax.readyState==4)
	  {  
		document.getElementById(zona_dinamica).innerHTML=objAjax.responseText 	 
	  } 
	 
 }
 objAjax.send(null)	*
 */
}


function validar_positivos()
{
numero=parseFloat(document.getElementById("cantidad").value)
if(numero<0)
{
 alert("El valor debe ser positivo")	
 document.getElementById("cantidad").value=""
}
}

function validar_cantidad()
{
cantidad1=parseInt(document.getElementById("cantidad").value)
cantidad2=parseInt(document.getElementById("cantidad_devuelta").value)

if(cantidad2>cantidad1)
{
	alert("No puede devolver mas de "+cantidad1+" productos")
    document.getElementById("cantidad_devuelta").value=""
	document.getElementById("monto_bs").value=""
}else
{
bs=parseInt(document.getElementById("cantidad_devuelta").value)*parseInt(document.getElementById("costo").value)
document.getElementById("monto_bs").value=bs
}
	
}


function guardar(formulario)
{
	valido=validarFormulario(formulario);
	if(valido==1)
	{
	document.form1.submit();
	}
}

function validarFormulario(formulario) {  

   
  var numElement=formulario.length;

  var error=0;
  var i=0;
  var campoObligatorio="";
  var campoEspecial="";
   for(i=0;i<numElement && error==0;i++)
  { 
    var objElement=formulario[i];
	//alert(objElement.value);		para ver si esta leyendo los elementos
	if(objElement.lang !=='' )
	{  
		valor=objElement.lang.split('-');
		campoObligatorio=valor[0];
		campoEspecial=valor[1];
	   
	}else{
	   campoObligatorio="";
       campoEspecial="";
	 }
	var caract_ext=":";
	objElement.style.border="";//"1px  #666666 solid";
     switch(objElement.type){
	 case 'text': //alert('esto es un texto');
	              valCarat=1;
				  caract_ext="()?=,/:.;&";//ojo si general
				  if(campoEspecial=="especial") caract_ext="@.-º?=,/:"; 
				  if(campoEspecial=="float") { 
				  		caract_ext=".,"; 
						valCarat=3;
				  }
	 			  if(error!=1 &&(campoObligatorio=="si" && objElement.value=="")) 
				  { error=1;
				    alert("Campo Obligatorio Vacío");			
				  }
				  if( error!=1 && ((campoObligatorio=="si" && campoEspecial=="general" && objElement.value=="") ) )
				    {
							error=1;
				    		alert("Campo Obligatorio Vacío");
								
					}
				  if( error!=1 && ((campoObligatorio=="si" && campoEspecial=="email") || (campoObligatorio=="no" && campoEspecial=="email" && objElement.value!==""))	)	  
				    {   caract_ext="@.";
					    if(!validarEmail(objElement.value)) 
					 		{ error=1;
							  alert("Campo Email Inválido");	
							}
					}
				  if( error!=1 && ((campoObligatorio=="si" && campoEspecial=="rif") || (campoObligatorio=="no" && campoEspecial=="rif" && objElement.value!==""))	)	  
				    {   
					    if(!validarRif(objElement.value)) 
					 		{ error=1;
							  alert("Campo R.I.F. Inválido Formato V012223334");
							  document.getElementById(objElement.name).focus();	
							}
					}
				  if( error!=1 && ((campoObligatorio=="si" && campoEspecial=="num_compro_reten") || (campoObligatorio=="no" && campoEspecial=="num_compro_reten" && objElement.value!==""))	)	  
				    {   
					    if(!validarNum_compro_reten(objElement.value)) 
					 		{ error=1;
							  alert("Campo Numero de Comprobante de Retencion Inválido \n Formato [Año-Mes-8dijitos] \n Ejem: 2016-12-00040008");
							  document.getElementById(objElement.name).focus();	
							}
					}
				
				  if( error!=1 && ((campoObligatorio=="si" && campoEspecial=="telf") || (campoObligatorio=="no" && campoEspecial=="telf" && objElement.value!==""))	)	  
				    {   
					    if(!validarTelf(objElement.value)) 
					 		{ error=1;
							  alert("Campo Telefono Inválido Formato 04161234567");
							  document.getElementById(objElement.name).focus();	
							}
					}
				  
				  if(error!=1 && campoObligatorio=="si" && campoEspecial=="confirmacion") {
						  caract_ext="@.";
					     campo=objElement.name;//
				  		 campo=campo.substring(0,campo.length-1);
						 if(document.getElementById(campo).value!==objElement.value){
						 	error=1;
					  		alert("Campos de emails no son iguales");	
						 }
					  }
				 if(error!=1 && campoEspecial!=="noValidar" && !validarExpresionRegula(objElement.value,caract_ext,valCarat)) error=1;
	 			  break;
	 case 'number':
	 				if(campoObligatorio=="si" && objElement.value=="") 
				 		 {  error=1;
				    		alert("Campo Obligatorio Vacío");			
				  		 }
					if( error!=1 && ((campoObligatorio=="si" && campoEspecial=="number") || (campoObligatorio=="no" && campoEspecial=="number" && objElement.value!=="0")) )
						{
							if(!validarNumber(objElement.value)) 
								{ error=1;
								  alert("Campo Numérico Inválido");
								  document.getElementById(objElement.name).focus();	
								}
						}
	 break;
	 case 'date':
	 				if(campoObligatorio=="si" && objElement.value=="") 
				 		 {  error=1;
				    		alert("Campo Obligatorio Vacío");			
				  		 }
					/*	 
					if( error!=1 && ((campoObligatorio=="si" && campoEspecial=="general") || (campoObligatorio=="no" && campoEspecial=="general" && objElement.value!="")) )
						{
							if(!validarNumber(objElement.value)) 
								{ error=1;
								  alert("Campo Numérico Inválido");
								  document.getElementById(objElement.name).focus();	
								}
						}
					*/	
	 break;
	 case 'month':
	 				if(campoObligatorio=="si" && objElement.value=="") 
				 		 {  error=1;
				    		alert("Campo Obligatorio Vacío");			
				  		 }
					/*	 
					if( error!=1 && ((campoObligatorio=="si" && campoEspecial=="general") || (campoObligatorio=="no" && campoEspecial=="general" && objElement.value!="")) )
						{
							if(!validarNumber(objElement.value)) 
								{ error=1;
								  alert("Campo Numérico Inválido");
								  document.getElementById(objElement.name).focus();	
								}
						}
					*/	
	 break;  
	 case 'password': 
	 				  if(campoObligatorio=="si" && objElement.value=="") 
				 		 {  error=1;
				    		alert("Campo Obligatorio Vacío");			
				  		 }	
					  if(error!=1 && campoObligatorio=="si" && campoEspecial=="confirmar") {
					     campo=objElement.name;//
				  		 campo=campo.substring(0,campo.length-1);
						 if(document.getElementById(campo).value!==objElement.value){
						 	error=1;
					  		alert("Campos de passwords no son iguales");	
						 }
					  }
	 				  if(error!=1 && campoObligatorio=="si" && campoEspecial=="clave") caract_ext="&*@#$";
				      if(error!=1 && !validarExpresionRegula(objElement.value,caract_ext,1)) error=1;
	 				 break;
	 case 'textarea': //alert('esto es un texto_area'); 
	 			 if(campoObligatorio=="si" && objElement.value=="") 
				  { alert("Campo Obligatorio Vacío");
					error=1;
				  }
				  
	 			  break;
	 case 'checkbox': if(campoObligatorio=="si" && objElement.checked==false) 
				  { alert("Campo Obligatorio Vacío");
					error=1;
				  }
	 			  break;
	 case 'select': //alert('esto es un select - one'); 
	 			if(campoObligatorio=="si" && objElement.value=="") 
				  { alert("Campo obligatorio debe estar seleccionado");
					error=1;
				  }
	 			  break;
	 case 'select-one': //alert('esto es un select - one'); 
	 			if(campoObligatorio=="si" && objElement.value=="") 
				  { alert("Campo obligatorio debe estar seleccionado");
					error=1;
				  }
	 			  break;
	 case 'select-multiple': 
//	 alert('esto es un select - multiple');
	 			if(campoObligatorio=="si" && objElement.selectedIndex<0) 
				  { alert("Campo obligatorio debe elegir al menos una opción");
					error=1;
				  }
	 			  break;
	 case 'hidden': //alert('esto es un select - one'); 		
				if(error!=1 && campoObligatorio=="si" && campoEspecial=="repetido" && objElement.value==1)
				  { 
				  error=1;
				  campo=objElement.name;//
				  campo=campo.substring(0,campo.length-1);
				  objElement=document.getElementById(campo);
				  alert("Valor ya existe ");
				  }
				  
	 			  break;
	 case 'submit': //alert('esto es un submit'); 
	 			  break;
	 }
  }

   if(error==1) 
  {
objElement.style.border="1px #FF0000 solid";
    objElement.focus();	 
	return (false);	
  }	else return (true);
  
}

function validarEmail(valor) {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(valor))  return (true)
  else   return (false)
 }
 function validarRif(valor) {
	if (/[JVEGPjvepg][0-9]{8}$/.test(valor) || /[JVEGPjvepg][0-9]{9}$/.test(valor))  return (true)
  else   return (false)
 }
 function validarNum_compro_reten(valor) {
	if (/^\w+([0-2][0][0-9][0-9]?\w+)*-\w+([0-1][0-9]?\w+)*-\w+([0-9]?\w+){7}$/.test(valor))  return (true)
  else   return (false)
 }
 function validarTelf(valor){
 	if (/[0][42][123456789][123456789][0-9]{7}$/.test(valor))  return (true)
  else   return (false)
 }
 function validarNumber(valor){
	 
	 if (parseFloat(valor)>0)
	 	if (/^(\d|-)?(\d|,)*\.?\d*$/.test(parseFloat(valor) ) ) 	return (true)
	 	else	return (false)
	else	return (false)
	 
 }

function validarExpresionRegula(campo, caract_extra,opc) {
  var ubicacion="";
  var enter = "\n";
  var caracteres="";
  var letras="abcdefghijklmnopqrstuvwxyzñ ABCDEFGHIJKLMNOPQRSTUVWXYZÑáéíóúáÉÍÓÚ-/_,?:";
  var numeros="1234567890";
  if(opc==1) // 1=letras y numeros  ,,,, 2=letras ,, 3=numeros
    caracteres =letras + numeros + String.fromCharCode(13) + enter + caract_extra
  else if(opc==2)
  		caracteres =letras + String.fromCharCode(13) + enter + caract_extra
		else caracteres = numeros + String.fromCharCode(13) + enter + caract_extra
  var contador = 0
  var sw=true;
  var lonCampo=campo.length;
  for (i=0; i < lonCampo && sw; i++) {
    ubicacion = campo.substring(i, i + 1)
    if (caracteres.indexOf(ubicacion) !== -1) {
      contador++
    } else {
      alert("ERROR: No se acepta el caracter '" + ubicacion + "'.")
      sw=false;
    }
  }
  return (sw);
}

function solo_numeros(evt)
{   
	var nav4 = window.Event ? true : false;
	var key = nav4 ? evt.which : evt.keyCode;   
	return (key <= 13 || (key>= 48 && key <= 57));
}

function validar_longitud()
{
	var rif_cli=document.getElementById("rif_cli").value
	var tam=rif_cli.length
	if(tam<6 || tam>9)
	{
	 alert("La longitud de la Cedula o RIF es invalida, Ingresela nuevamente")
	 document.getElementById("rif_cli").value=""
	 document.getElementById("rif_cli").focus()	
	}
}

function validar_cedula()
{
	var rif_cli=document.getElementById("ced_per").value
	var tam=rif_cli.length
	if(tam<6 || tam>9)
	{
	 alert("La longitud de la Cedula, Ingresela nuevamente")
	 document.getElementById("ced_per").value=""
	 document.getElementById("ced_per").focus()	
	}
}

function validar_repetidoM(tabla, columna, valor, zona_dinamica)
{
 if(valor !== ""){
	objAjax=new XMLHttpRequest()
	objAjax.open("GET",extra+"php/consul_sql/b_tabla.php?valor="+valor+"&tabla="+tabla+"&columna="+columna)
	objAjax.onreadystatechange=function()
	{
	 if(objAjax.status==200 && objAjax.readyState==4)
	 {
		var span = document.createElement("span");//console.log(objAjax.responseText);
		
		if(objAjax.responseText==1){
			document.getElementById(zona_dinamica).value = "";
			document.getElementById(zona_dinamica).placeholder = "EXISTENTE";
			
			span.setAttribute("class", "has-error");
			document.getElementById("res_"+zona_dinamica).appendChild(span);
			span.appendChild(document.getElementById("cont_"+zona_dinamica));
			
			if( tabla == "fact_venta"){
			alert("Los datos para FACTURA de VENTA ya existen en el sistema");
			document.form1.num_fact_venta.value = "";
			document.form1.fk_cliente.value = "";
			document.getElementById('nom_cliente_ajax').value = "";
			document.getElementById('tipoDoc').value = "";
			}
			else if( tabla == "fact_compra"){
			alert("Esta FACTURA de compra y RAZON SOCIAL ya existen en el sistema");
			document.form1.num_fact_compra.value = "";
			document.form1.fk_proveedor.value = "";
			document.getElementById('nom_prov_ajax').value = "";
			document.getElementById('tipoDoc').value = "";
			}
			else if(tabla == "inventario"){
				alert("Este CODIGO ó NOMBRE DE PRODUCTO ya existen en el sistema");
			}else if(tabla == "cliente"){
				alert("La CEDULA o RIF del CLIENTE ya existen en el sistema");
				document.getElementById(zona_dinamica).focus();
			}else if(tabla == "proveedor" && columna == "rif"){
				alert("La CEDULA o RIF del PROVEEDOR ya existen en el sistema");
				document.getElementById(zona_dinamica).focus();
			}
			
		}else{
			span.setAttribute("class", "has-success");
			document.getElementById("res_"+zona_dinamica).appendChild(span);
			span.appendChild(document.getElementById("cont_"+zona_dinamica));	
		}
	 } 	 
	}
	objAjax.send(null)	
 }
}

//BUENO PARA BORRAR O QUE
//ajax que manda para probar el rif en la pagina
function showHint1(str) {
  var xhttp;
  if (str.length == 0) {
	document.getElementById("txtHint").innerHTML = "<br>No ha introducido nada el campo<br><br><br><br>";
	return;
  }
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
		  document.getElementById("txtHint").innerHTML = xhttp.responseText;
		}
	};
	//xhttp.open("GET", "c.php?q="+str, true);
	//xhttp.send();
	//var pre=$('#pre_rif_empre').val();
	
	xhttp.open("POST", "<?php echo $extra?>php/cURL/ajax_rif_empre.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("rif="+ str);
}