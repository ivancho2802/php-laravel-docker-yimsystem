<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
	header("location: index.php?acceso=1 ");
	exit;
} 
if (! empty($_SESSION["usuario"])) 
  echo "debe iniciar sesion";
else//este es igual login osea si alguien se ha logeado
  //echo "id_usu:".$_SESSION["id_usu"];
?>
<script language="javascript" type="text/javascript" src="javascript/js/jquery-1.6.4.min.js"></script>
<!--BOOSTRAP-->
<script language="javascript" type="text/javascript" src="bootstrap-3.3.6/js/jquery-1.12.0.min.js"></script>
<script language="javascript" type="text/javascript" src="bootstrap-3.3.6/js/bootstrap.min.js"></script>

<script language="javascript" type="text/javascript" src="javascript/funciones.js"></script>
<!--PARA LLAMAR A EL cRUL RIF-->
<script>
/*$('#busProv').on('show.bs.modal', function (e) {
  if (!data) return e.preventDefault(); // stops modal from being shown
})*/
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
	  document.getElementById("txtHint").innerHTML = xhttp.responseText;
	}
  };
  //xhttp.open("GET", "c.php?q="+str, true);
  //xhttp.send();
	//var pre=$('#pre_rif_empre').val();
	
	xhttp.open("POST", "funciones_ivan/cURL/ajax_rif_empre.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("rif="+ str);
}
</script>

<link rel="stylesheet" href="css/estilos_entrada.css" type="text/css"/>

<?php 
	/*
	include_once("conexion.php");
	
	$consulEmpreActiva=mysqli_query($conexion,"SELECT * FROM empre WHERE empre.est_empre = '1'");
	$resEmpreActiva=$consulEmpreActiva);
	$total_consulEmpreActiva = mysqli_num_rows($consulEmpreActiva);
	*/
?>
<br>
<form id="form1" name="form1" method="post" action="x_recibirempresa.php">
  <table align="center" class="tabla3">
  <tbody>
    <tr>
      <td colspan="8" class="titulo" align="center"><h4>Cargar Empresa</h4></td>
      <!--campos ocultos-->
      <input type="hidden" name="fk_usuarios" value="<?php echo $_SESSION["id_usu"]?>"/><!--que usuario operador hiso el registro-->
      <input type="hidden" name="cod_empre" value=""/><!--auto-->
    </tr>
    <tr>
    	<td class="col-md-6 col-lg-6">
        	R.I.F.:<br />
            <span>
        		<input type="text" class="form-control" name="rif_empre" id="rif_empre" pattern="[JVEGP][0-9]{9}"  onKeyUp="javascript:this.value=this.value.toUpperCase();" lang="si-general" required/>
            	<span class="help-block">Formato: V012223334</span>
            </span>
        </td>
        
        <td width="20%" class="col-md-6 col-lg-6">
            Nombre &oacute; Raz&oacute;n Social:<br />
            <span class="input-group">
                    <input type="text" class="form-control" name="razon_empre" id="razon_empre" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();" lang="si-general" required>
                <span class="input-group-btn">
                <button type="button" onclick="cURLdocu('razon_empre');" class="btn btn-info">Buscar del SENIAT(INTERNET)</button>
                <!--cURLdocu('campo');-->
                </span>
            </span>
        </td>
        <td width="20%" class="col-md-6 col-lg-6" id="res_rif_empre">
            Nombre o Raz&oacute;n Social:<br />
            <span class="input-group" id="cont_cod_empre">
                <span id="resRifE">
                    <input type="text" class="form-control" name="nom_empre" id="nom_empre" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();" onBlur="validar_repetidoM('empre', 'cod_empre', this.value, 'cod_empre')" lang="si-general" required>
                </span>
                <span class="input-group-btn">
                <button type="button" onclick="cURLrif('empre','cod_empre','curl_rif_msm');" class="btn btn-info">Buscar del SENIAT(INTERNET)</button>
                </span>
            </span>
        </td>
        
        <td width="20%" id="res_serie_fact_compra">
        	<span id="cont_serie_fact_compra">
        	Serie de Documento<br />
        	<input type="text" name="serie_fact_compra" id="serie_fact_compra" value="" size="20" onKeyUp="javascript:this.value=this.value.toUpperCase();" onblur="codFactProvee('form1', 'serie_fact_compra', 'num_fact_compra', 'fk_proveedor', 'id_fact_compra')">
            <!--no es requerido por que a veces las facturas no tienen numero de serie-->
            </span>
        </td>
        <td width="20%">
            N° Documento:<br />
            <input type="number" min="0" name="num_fact_compra" value="" size="20" required="required" onblur="codFactProvee('form1', 'serie_fact_compra', 'num_fact_compra', 'fk_proveedor', 'id_fact_compra')"/>
        </td>
    	
        <td>N° Control:<br>
			<input type="number" min="0" name="num_ctrl_factcompra" id="num_ctrl_factcompra" value="" size="20" />
        </td>
       
    </tr>
    <tr id="bajar-tabla3">
    	 <!--AQUI SE MOSTRARA EL RESULTADO DE LA CONSUKLTA Y SU SELECCION-->
        <td colspan="2" class="conter_table_nadatd" width="40%">
            <table class="table_nada">
                <tr id="ResselecProv">
                  <td>
                   <!--en onclocl queda la funcion que desactiva la tecla enter del teclado-->
                    R.I.F. del Proveedor:<br />
                    <input name="fk_proveedor" required="required" onblur="javascript:this.value=this.value.toUpperCase();codFactProvee('form1', 'serie_fact_compra', 'num_fact_compra', 'fk_proveedor', 'id_fact_compra')" data-toggle="modal" data-target="#busProv" onfocus="$('#busProv').modal('show');" readonly="readonly"/>
                  </td>
                  <td>
                    Nombre o Raz&oacute;n Social:<br />
                    <input id="nom_prov_ajax" required="required" data-toggle="modal" data-target="#busProv" onfocus="$('#busProv').modal('show');" readonly="readonly"/>
                  </td>
               </tr>
              </table>
        </td>
    	
        <td id="res_fecha_fact_compra">
        	<span id="cont_fecha_fact_compra">
            Fecha de la Compra:<br>
        	<input type="date" name="fecha_fact_compra" id="fecha_fact_compra" size="20" lang="si-general" onblur="val_comp_ii_fech(this.value, 'fecha_fact_compra')" required/><br />
            <span id="nota_compra"></span>
            </span>
        </td>
        <td>Tipo de Transacci&oacute;n:<br />
			<select id="tipoTrans" name="tipo_trans" required>
                <option value="reg-01">res-01</option>
                <option value="anul-03">anul-03</option>
            </select>
        </td>
    </tr>
    
    <!--DE AQUI EN ADELANDE CONSICIONADOS PARA SERR OCULTOS O NO POR JAVBASCRIPT-->
    <tr id="borde-tabla3">
        <td width="20%">
        	N° Planilla de Importaci&oacute;n:<br>
            <input type="text" name="nplanilla_import" value="" size="20" required readonly="readonly"/>
        </td>
        <td width="20%">N° Exp de Importaci&oacute;n:<br>
            <input type="text" name="nexpe_import" value="" size="20" required readonly="readonly"/> 
        </td>
        <td width="20%">N° Declaraci&oacute;n Aduana:<br>
            <input type="text" name="naduana_import" value="" size="20" required readonly="readonly"/>
        </td>
        <td width="20%">Fecha Aduana Importacion:<br>
            <input type="date" name="fechaduana_import" value="" size="20" required readonly="readonly"/>
        </td>
        <td width="20%">&nbsp;</td>
    </tr>
<!--///////////////////////////////////////PARA LA INSERCION DE PRODUCTOS-->
	<tr>
    	<td colspan="5" class="conter_table_nadatd" width="100%">
        	<table class="table_nada table table-bordered table_black">
              <thead id="resCompra">
              	<tr>
                	<th width="16.5%"><p>Codigo Producto</p></th>
                	<th width="16.5%"><p>Nombre Producto</p></th>
                    <th width="16.5%"><p>Costo (BsF.) &frasl; Precio de Venta</p></th>
                    <th width="16.5%"><p>Cantidad</p></th>
                    <th width="24%"><p>Tipo de Compra</p></th>
                    <th width="10%"><p align="center">Accion</p></th>
                </tr>
                <tr class="alert fade in">
                <td>
                <input name="id_compra1" hidden="">
                <input name="fk_inventario1" required="" onclick="ctrlSelecProd(1)" onfocus="ctrlSelecProd(1)" readonly="readonly">
                </td>
                <td>
                <input name="nom_fk_inventario1" onclick="ctrlSelecProd(1)" readonly="readonly">
                </td>
                <td>
                <input class="form-control" name="costo1" required="" type="number" min="0" step="0.0000001" value="0.00" placeholder="0.00" onblur="fcalculo()"/>
                <br>
                <span class="input-group">
                	<input class="form-control" name="pmpvj1" id="pmpvj1" type="number" min="0" step="0.0000001" value="" placeholder="0.00"  required="required"  />
                	<span class="input-group-btn">
                		<button class="btn btn-primary" type="button" onclick="ctrlSelecPMPVJ(1)">P. Venta</button>
                	</span>
                </span>
                </td>
                <td>
                <span class="input-group">
                    <input class="form-control" name="cantidad1" required="" type="number" min="0" onblur="fcalculo()"/>
                        <span class="input-group-addon">
                            /
                        </span>
                    <input class="form-control" name="stock1" type="text" value="" readonly="readonly">
                </span>
                </td>
                <td>
                <select name="tipoCompra1" id="tipoCompra1" class="selectpicker" data-style="btn-primary" onchange="fcalculo(1)">
                	<optgroup label="Internas">
                        <option value="">Seleccione</option>
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
                        <option value="IM_BI_12">Importaciones Base Imponible al 12%</option>
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
        </td>
    </tr>    
    <tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
    	<!--AQUI SOLO UNO DE ESTOS-->
        <td>Monto Exento (BsF.):<br />
			<input type="text" name="msubt_exento_compra" value="0" size="20" readonly="readonly"/>
        </td>
        <td>&nbsp;</td>
    </tr>

    <tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
        <td>Base Imponible (BsF.):<br />
			<input type="text" name="msubt_bi_iva_12" value="0" size="20" readonly="readonly"/>
        </td>
        <td>IVA al 12 &#37;:<br />
        	<input type="number" min="0" step="0.01" value="0.00" placeholder="0.00" name="iva_12" required="required"/>
		</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
        <td>Base Imponible (BsF.):<br />
			<input type="text" name="msubt_bi_iva_8" value="0" size="20" readonly="readonly"/>
        </td>
        <td>IVA al 8 &#37;:<br />
        	<input type="number" min="0" step="0.01" value="0.00" placeholder="0.00" name="iva_8" required="required"/>
		</td>
    </tr>
    <tr id="bajar-tabla3">
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
        <td>Base Imponible (BsF.):<br />
			<input type="text" name="msubt_bi_iva_27" value="0" size="20" readonly="readonly"/>
        </td>
        <td>IVA al 27 &#37;:<br />
        	<input type="number" min="0" step="0.01" value="0.00" placeholder="0.00" name="iva_27" required="required"/>
		</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        
        <td id="borde-tabla3">Total Base Imponible (BsF.):<br />
			<input type="text" name="msubt_tot_bi_compra" value="0" size="20" readonly="readonly"/>
        </td>
        <td id="borde-tabla3">Total Impuesto IVA:<br />
        	<input type="text" name="tot_iva" value="0" size="20" readonly="readonly"/>
		</td>
    </tr>
    <tr>
    	<td><br /><br /><br /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" align="center" >Total de la Compra Incluyendo IVA (BsF.):<br />
			<input type="text" name="mtot_iva_compra" value="0" size="20" readonly="readonly"/>
        </td>
    </tr>
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
<!-- PARA DESPUES    ya existe en la bad como muchos a muchos bucle
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ndebito_factcompra:</td>
      <td><input type="text" name="ndebito_factcompra" value="" size="20" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ncredito_factcompra:</td>
      <td><input type="text" name="ncredito_factcompra" value="" size="20" /></td>
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
    <tr valign="baseline">
      <td colspan="5" align="center"><label><button type="submit" class="btn btn-lg btn-success">Agregar Compra</button></label></td>
    </tr>
    <!--
    <tr>
      <td colspan="2">
          <div align="center">
            <input type="button" name="agregar" id="agregar" value="Agregar"  onClick="guardar(this.form)"/>
          </div>
      </td>
    </tr>
    -->
  </tbody>
  </table>
</form>