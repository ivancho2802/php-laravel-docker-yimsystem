<?php
include_once('../includes_SISTEM/include_head_report.php');
///////////////////////////////////////////////////////////////////////////////////
//			FUNCIONES
////////////////////////////////////////////////////////////////////////////////////
include_once("../librerias/conexion.php");
/////////////////////////////////////////////////////////////
include_once('../php/funciones.php');
/////////////////////////////////////////////////////////////
include_once('../includes_SISTEM/include_login.php');
/////////////////////////////////////////////////////////////
?>
<link rel="stylesheet" href="../css/estilos_reportes.css" type="text/css"/>
<?php
if (isset($_POST['id_fact_venta'])){
	$id_fact_venta = $_POST['id_fact_venta'];
	//consulta de los datos de la empreas PARA SABE LA ACTIVA 
	$consulta2 = pg_query($conexion,"SELECT * FROM empre WHERE empre.est_empre = '1'");
	// $filas2 = pg_fetch_assoc($consultaEmpre);
    $filas2=pg_fetch_assoc($consulta2);
	$total_consultaEmpre = pg_num_rows($consulta2);
	
	//consulta de la factura con sus datos relacionados
	$consulta=pg_query($conexion,sprintf("SELECT * FROM empre, fact_venta, venta, inventario, cliente, usuarios WHERE
	  													fact_venta.empre_cod_empre = empre.cod_empre 	AND
														fact_venta.empre_cod_empre = '%s' 				AND
                                                        fact_venta.id_fact_venta = venta.fk_fact_venta 	AND
                                                        venta.fk_inventario = inventario.codigo 		AND
														fact_venta.fk_cliente = cliente.ced_cliente 	AND
														fact_venta.fk_usuariosV = usuarios.idusuario 	AND
														fact_venta.id_fact_venta = '%s'",
														$filas2['cod_empre'], $id_fact_venta));
	$filas=pg_fetch_assoc($consulta);
	$total_consulta = pg_num_rows($consulta);
}
if($total_consulta>0){
?>
<page format="215x140" orientation="L" backcolor="" style="font: arial; font-size:9px">
<page_header style="font: arial; font-size:9px">
 <table  cellpadding="0" cellspacing="0" style=" width:100%">
 	<tr>
    	<td style=" width:100%" colspan="8">
        
        </td>
    </tr>
 	<tr>
    	<td colspan="6"></td>
        <th >Factura N&deg;: </th>
        <td ><?php echo $filas['num_fact_venta'];?></td>
    </tr>
    <tr>
    	<td  colspan="6"></td>
        <th >N&deg; Control:</th>
        <td ><?php echo $filas['num_ctrl_factventa'];?></td>
    </tr>
    <tr>
    	<td  colspan="6"></td>
        <th >Emision: </th>
    	<td ><?php echo fechaInver($filas['fecha_fact_venta']);?></td>
    </tr>
    <tr>
    	<td  colspan="6"></td>
        <th >Vencimiento: </th>
        <td >
        <?php
            $fecha_venc = new DateTime($filas['fecha_fact_venta']);
            $fecha_venc->add(new DateInterval('P'.$filas['dias_venc'].'D'));
            echo $fecha_venc->format('d-m-Y');
        ?>
    	</td>
    </tr>
    <tr>
    	<td ><br /><br /><br /></td>
    </tr>
    <tr>
    	<th >Nombre del Cliente: </th>
    	<td ><?php echo $filas['nom_cliente'];?></td>
    </tr>
    <tr>
    	<th>R.I.F.: </th>
        <td ><?php echo $filas['ced_cliente'];?></td>
    </tr>
    <tr>  
        <th>Telefono: </th>
        <td ><?php echo $filas['tel_cliente'];?></td>
    </tr>
    <tr>
        <th>C / Pago: </th>
        <td >
		  <?php 
			if($filas['tipo_pago'] == "C")
				echo"CREDITO A ".$filas['dias_venc']." Dias.";
			elseif($filas['tipo_pago'] == "E")
				echo "EFECTIVO";
		  ?>
        </td>
    </tr>
    <tr>
        <th >Direcci&oacute;n: </th>
        <td ><?php echo $filas['dir_cliente'];?></td>
    </tr>
    <tr>
        <td colspan="6">&nbsp;</td>
        <th >Nombre del Vendedor:</th>
        <td ><?php echo $filas['usuario'];?></td>
    </tr>
    <tr>
        <td colspan="6">&nbsp;</td>
        <th >Cedula del Vendedor:</th>
        <td ><?php echo $filas['idusuario'];?></td>
    </tr>
</table>
</page_header>
<!---->
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table cellpadding="0" cellspacing="0" style=" width:100%">
  <tr>
  	<th style="width: 20%;border:1px solid;">REFERENCIA</th>
    <th style="width: 20%;border:1px solid;">DESCRIPCION</th>
    <th style="width: 20%;border:1px solid;">CANTIDAD</th>
    <th style="width: 20%;border:1px solid;">PRECIO</th>
    <th style="width: 20%;border:1px solid;">TOTAL</th>
  </tr>
<?php
	if($filas['nplanilla_export'] != ""){
		$msubt_exento_venta_export = round($filas['mtot_iva_venta'],2);
		/////////////////////////////////////////////
		$mtot_iva_venta_n = 0;
		$msubt_tot_bi_venta_n = 0;
		$msubt_bi_iva_12_n = 0;
		$msubt_bi_iva_8_n = 0;
		$msubt_bi_iva_27_n = 0;
		//ACUMULADORES
		$acum_msubt_exento_venta_export = round($filas['msubt_exento_venta'],2);
		$acum_msubt_bi_iva_12_n = 0;
		$acum_msubt_bi_iva_8_n = 0;
		$acum_msubt_bi_iva_27_n = 0;
	/////		FACTURA TOTALES EXPORTACIONES	
	}elseif($filas['nplanilla_export'] == ""){
		$msubt_exento_venta_export = 0;
		$acum_msubt_exento_venta_export = 0;
		//////////////////////////////////////////7
		$mtot_iva_venta_n = round($filas['mtot_iva_venta'],2);
			//las excentas ya estan hechas por una funcion ya que estas son desglozadas
		$msubt_tot_bi_venta_n = round($filas['msubt_tot_bi_venta'],2);
		$msubt_bi_iva_12_n = round($filas['msubt_bi_iva_12'],2);
		$msubt_bi_iva_8_n = round($filas['msubt_bi_iva_8'],2);
		$msubt_bi_iva_27_n = round($filas['msubt_bi_iva_27'],2);
		//ACUMULADORES
		$acum_msubt_bi_iva_12_n = round($filas['msubt_bi_iva_12'],2);
		$acum_msubt_bi_iva_8_n = round($filas['msubt_bi_iva_8'],2);
		$acum_msubt_bi_iva_27_n = round($filas['msubt_bi_iva_27'],2);
	}
	$acum_msubt_exento_venta = round($filas['msubt_exento_venta'],2);
	
	$acum_m_iva_reten = round($filas['m_iva_reten'],2);
	$msubt_iva_12 = $acum_msubt_bi_iva_12_n * 0.12;
	$msubt_iva_8 = $acum_msubt_bi_iva_8_n * 0.08;
	$msubt_iva_27 = $acum_msubt_bi_iva_27_n * 0.27;
	do{
?>
  <tr>
  	<td><?php echo $filas['codigo'];?></td>
    <td><?php echo utf8_decode($filas['nombre_i']);?></td>
    <td><?php echo $filas['cantidad'];?></td>
    <td><?php echo round($filas['precio_venta'],2);?></td>
    <td><?php echo round($filas['precio_venta'],2) * $filas['cantidad'];?></td>
  </tr>
<?php		
  	}while($filas=pg_fetch_assoc($consulta));
?>
</table>
<page_footer style="font: arial; font-size:9px">
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<table cellpadding="0" cellspacing="0" style=" width:100%">
    <tr>
        <td style="width: 60%;">&nbsp;</td>
        <th style="width: 20%;">Base Imponible 12 &#37;:</th>
        <td style="width: 20%;"><?php echo $msubt_bi_iva_12_n;?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <th>Base Imponible 8 &#37;:</th>
        <td><?php echo $msubt_bi_iva_8_n;?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <th>Base Imponible 27 &#37;:</th>
        <td><?php echo $msubt_bi_iva_27_n;?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <th>I.V.A. Al 12 &#37;:</th>
        <td><?php echo $msubt_iva_12;?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <th>I.V.A. Al 8 &#37;:</th>
        <td><?php echo $msubt_iva_8;?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <th>I.V.A. Al 27 &#37;:</th>
        <td><?php echo $msubt_iva_27;?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <th>Monto Exento:</th>
        <td><?php echo $acum_msubt_exento_venta?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <th>Total de la Operaci&oacute;n:</th>
        <td><?php echo $mtot_iva_venta_n;?></td>
    </tr>
    <tr>
    	<td><br /><br /><br /></td>
    </tr>
</table>
<br />
<table style="width:100%; border:1px solid">
    <tr>
        <td style="width: 50%;text-align: left;"><?php echo "Sistema ".$_SESSION["alias"]." - ".$_SESSION["version"]?></td>
        <td style="width: 50%;text-align: right;">Pagina [[page_cu]]/[[page_nb]]</td>
    </tr>
</table>
</page_footer>
</page>
<?php
}else{
?>
	<div><h1>No hay Resultados</h1></div>
<?php	
}
?>