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
if (isset($_POST['mes'])){
$mes = $_POST['mes'];
$mesi = $mes."-01";
$mesf = ($mes=='02')? $mes."-28":((int) $mes%2==0) ? $mes."-31" : $mes."-30";
	//consulta de los datos de la empreas PARA SABE LA ACTIVA 
	$consulta2 = pg_query($conexion,"SELECT * FROM empre WHERE empre.est_empre = '1'");
	// $filasEmpre = pg_fetch_assoc($consultaEmpre);
    $filas2=pg_fetch_assoc($consulta2);
	$total_consultaEmpre = pg_num_rows($consulta2);
	//consulta de la factura con sus datos relacionados
	$consulta=pg_query($conexion,sprintf("SELECT * FROM empre, fact_compra, proveedor WHERE
	  																			fact_compra.empre_cod_empre = empre.cod_empre AND
																				empre.cod_empre = '%s' AND
																				fact_compra.fk_proveedor = proveedor.rif AND
																				fact_compra.fecha_fact_compra BETWEEN '%s' AND '%s'",
																				$filas2['cod_empre'], $mesi, $mesf));
																				
	$filas=pg_fetch_assoc($consulta);
	$total_consulta = pg_num_rows($consulta);																				
?>
	<page_header>
		<table style="width: 90%;">
			<tr>
				<td style="text-align: left;	width: 33%"><?php echo "Sistema ".$_SESSION["alias"]." - ".$_SESSION["version"]?></td>
				<td style="text-align: center;	width: 34%">Reporte de Compras</td>
				<td style="text-align: right;	width: 33%"><?php echo date('d/m/Y'); ?></td>
			</tr>
		</table>
	</page_header>
	<page_footer>
		<table style="width: 100%;">
			<tr>
				<td style="text-align: left;	width: 50%"><?php echo "Sistema ".$_SESSION["alias"]." - ".$_SESSION["version"]?></td>
				<td style="text-align: right;	width: 50%">page [[page_cu]]/[[page_nb]]</td>
			</tr>
		</table>
	</page_footer>
    <br>
	<br>
	<br>
    
 <table id="bloc_page" cellpadding="0" cellspacing="0" class="tabla1 table" >
 <thead>
 	<tr>
 		<th colspan="35">
 			<div><?php echo utf8_decode($filas2['titular_rif_empre']." - ". $filas2['nom_empre']);?>
 			</div>
 		</th>
 	</tr>
    <tr><th colspan="35"><div><?php echo $filas2['rif_empre'];?></div></th></tr>
    <tr><th colspan="35"><div>Direcci&oacute;n: &nbsp;<?php echo utf8_decode($filas2['dir_empre']);?></div></th></tr>
    <tr><th colspan="35"><div>Contribuyente <?php echo $filas2['contri_empre'];?></div></th></tr>
    <tr><th colspan="35"><div>LIBRO DE COMPRAS CORRESPONDIENTE AL MES DE <?php echo mesNum_Texto($mes);?></div></th></tr>
	<?php //funcion para convertir la fechaa mes en letras y ano?>
      <tr>
        <td colspan="18"></td>
        <td class="titulo" colspan="6"><div class="subTitulo">IMPORTACIONES</div></td>
        <td class="titulo" colspan="9"><div class="subTitulo">INTERNAS</div></td>
        <td colspan="2"></td>
      </tr>
      <tr class="titulo">
        <td class="cont_v"><div>Nro. Operaciones</div></td>
        <td class="cont_v"><div>Fecha del Documento</div></td>
        <td class="cont_v"><div>N&deg;R.I.F. &oacute; Cedula de Identidad</div></td>
        <td><div class="h">Nombre &oacute; <br />Raz&oacute;n Social</div></td>
        <td><div class="h">Tipo <br />de <br />Provee</div></td>
        
        <td class="cont_v"><div>Nro. de Comprob de Retenci&oacute;n</div></td>
        <td class="cont_v"><div>Fecha de Aplicaci&oacute;n de Retenci&oacute;n</div></td>
        
        <td class="cont_v"><div>Nro. de Planilla de Importaci&oacute;n</div></td>
        <td class="cont_v"><div>Nro. del Expediente de Importaci&oacute;n</div></td>
        <td class="cont_v"><div>Nro. de Declaraci&oacute;n de Aduana</div></td>
        <td class="cont_v"><div>Fecha de Declaraci&oacute;n de Aduana</div></td>
        
        <td class="cont_v"><div>Serie del Documento</div></td>
        <td><div class="h">Nro. <br />del <br />Documento</div></td>
        <td><div class="h">Nro. <br />de <br />Control</div></td>
        <td><div class="h">Nro. <br />de <br />Nota <br />de <br />Debito</div></td>
        <td><div class="h">Nro. <br />de <br />Nota <br />de <br />Credito</div></td>
        <td class="cont_v"><div>Tipo de Transacci&oacute;n</div></td><!--tipo Compra-->
        
        <td class="cont_v"><div>Nro. de Documento afectado</div></td>
        <!--IMPORTACIONES-->
        <td class="cont_v"><div>Total de Import.  incluyendo el IVA</div></td>
        <td class="cont_v"><div>Import. Exentas /Exoneradas</div></td>
        <td class="cont_v"><div>Total Base Imponible</div></td>
        <td class="cont_v"><div>Subtotal B.I. al 12%</div></td>
        <td class="cont_v"><div>Subtotal B.I. al 8%</div></td>
        <td class="cont_v"><div>Subtotal B.I. al 27%</div></td>
        <!--INTERNAS-->
        <td class="cont_v"><div >Total de Compra  internas incluyendo el IVA</div></td>
        <td class="cont_v"><div >Compras sin derecho a credito IVA</div></td>
        <td class="cont_v"><div >Compras Exentas</div></td>
        <td class="cont_v"><div >Compras Exoneradas</div></td>
        <td class="cont_v"><div >Compras no Sujetas</div></td>
        <td class="cont_v"><div >Base Imponible</div></td>
        <td class="cont_v"><div >Subtotal B.I. al 12%</div></td>
        <td class="cont_v"><div >Subtotal B.I. al 8%</div></td>
        <td class="cont_v"><div >Subtotal B.I. al 27%</div></td>
        <td class="cont_v"><div >Impuesto I.V.A.</div></td>
        <td class="cont_v"><div >I.V.A. Retenido</div></td>
        <!--ACCIONES-->
      </tr>
    </thead>
 	<tbody>
     <?php 
	//$consulta esta arriba
	//acumulador
	$acum_msubt_exento_compra = 0;
	
	$acum_msubt_bi_iva_12_inter = 0;
	$acum_msubt_bi_iva_8_inter = 0;
	$acum_msubt_bi_iva_27_inter = 0;
	
	$acum_msubt_bi_iva_12_import = 0;
	$acum_msubt_bi_iva_8_import = 0;
	$acum_msubt_bi_iva_27_import = 0;
	
	$acum_mtot_iva_compra_import = 0;
	$acum_msubt_exento_compra_import = 0;
	$acum_msubt_tot_bi_compra_import = 0;
	
	$acum_mtot_iva_compra_inter = 	0;
	$acum_IN_SDCF_compra_inter  =	0;
	$acum_IN_EX_compra_inter = 		0;
	$acum_IN_EXO_compra_inter  =	0;  
	$acum_IN_NS_compra_inter  = 	0;
	$acum_msubt_tot_bi_compra_inter = 	0;
	$acum_msubt_bi_iva_12_inter = 		0;
	$acum_msubt_bi_iva_8_inter = 		0;
	$acum_msubt_bi_iva_27_inter = 		0;
	
	$acum_m_iva_reten = 0;
	$acum_tot_iva = 0;
	//contador de filas
	$nop = 1;
    do{
			//CONSULTAS RELACIONALES
			//consulta las notas si existen 
			$consulta3 = pg_query($conexion,sprintf("SELECT * FROM notas_cd, fact_compra WHERE fact_compra.id_fact_compra = notas_cd.id_fact_compra AND notas_cd.id_fact_compra = '%s'",$filas['id_fact_compra']));
			// $filasConsultaNota = $consultaNota->fetch_assoc();
            $filas3=pg_fetch_assoc($consulta3);
			$total_ConsultaNota = pg_num_rows($consulta3);
			/////		FACTURA TOTALES IMPORTACIONES
			if($filas['nplanilla_import'] != ""){
				$mtot_iva_compra_import = round($filas['mtot_iva_compra'],2);
				$msubt_exento_compra_import = round($filas['msubt_exento_compra'],2);
				$msubt_tot_bi_compra_import = round($filas['msubt_tot_bi_compra'],2);
				$msubt_bi_iva_12_import = round($filas['msubt_bi_iva_12'],2);
				$msubt_bi_iva_8_import = round($filas['msubt_bi_iva_8'],2);
				$msubt_bi_iva_27_import = round($filas['msubt_bi_iva_27'],2);
				/////////////////////////////////////////////7
				$mtot_iva_compra_inter = 0;
				$msubt_tot_bi_compra_inter = 0;
				$msubt_bi_iva_12_inter = 0;
				$msubt_bi_iva_8_inter = 0;
				$msubt_bi_iva_27_inter = 0;
				//ACUMULADORES
				$acum_mtot_iva_compra_import = $acum_mtot_iva_compra_import + $mtot_iva_compra_import;
				$acum_msubt_exento_compra_import = $acum_msubt_exento_compra_import + $msubt_exento_compra_import;
				$acum_msubt_tot_bi_compra_import = $acum_msubt_tot_bi_compra_import + $msubt_tot_bi_compra_import;
				
				$acum_msubt_bi_iva_12_import = $acum_msubt_bi_iva_12_import + $msubt_bi_iva_12_import;
				$acum_msubt_bi_iva_8_import =  $acum_msubt_bi_iva_8_import + $msubt_bi_iva_8_import;
				$acum_msubt_bi_iva_27_import = $acum_msubt_bi_iva_27_import + $msubt_bi_iva_27_import;
			/////		FACTURA TOTALES INTERNAS	
			}elseif($filas['nplanilla_import'] == ""){
				$mtot_iva_compra_import = 0;
				$msubt_exento_compra_import = 0;
				$msubt_tot_bi_compra_import = 0;
				$msubt_bi_iva_12_import = 0;
				$msubt_bi_iva_8_import = 0;
				$msubt_bi_iva_27_import = 0;
				//////////////////////////////////////////7
				$mtot_iva_compra_inter = round($filas['mtot_iva_compra'],2);
					//las excentas ya estan hechas por una funcion ya que estas son desglozadas
				$msubt_tot_bi_compra_inter = round($filas['msubt_tot_bi_compra'],2);
				$msubt_bi_iva_12_inter = round($filas['msubt_bi_iva_12'],2);
				$msubt_bi_iva_8_inter = round($filas['msubt_bi_iva_8'],2);
				$msubt_bi_iva_27_inter = round($filas['msubt_bi_iva_27'],2);
				//ACUMULADORES
				$acum_mtot_iva_compra_inter = 	$acum_mtot_iva_compra_inter + $mtot_iva_compra_inter;
				$acum_IN_SDCF_compra_inter  =	$acum_IN_SDCF_compra_inter + sumSinIVA($filas['id_fact_compra'], 'IN_SDCF');
				$acum_IN_EX_compra_inter = 		$acum_IN_EX_compra_inter + sumSinIVA($filas['id_fact_compra'], 'IN_EX');
				$acum_IN_EXO_compra_inter  =	$acum_IN_EXO_compra_inter + sumSinIVA($filas['id_fact_compra'], 'IN_EXO');  
				$acum_IN_NS_compra_inter  = 	$acum_IN_NS_compra_inter + sumSinIVA($filas['id_fact_compra'], 'IN_NS');
				$acum_msubt_tot_bi_compra_inter = 	$acum_msubt_tot_bi_compra_inter + $msubt_tot_bi_compra_inter;
				
				$acum_msubt_bi_iva_12_inter = $acum_msubt_bi_iva_12_inter + round($filas['msubt_bi_iva_12'],2);
				$acum_msubt_bi_iva_8_inter = $acum_msubt_bi_iva_8_inter + round($filas['msubt_bi_iva_8'],2);
				$acum_msubt_bi_iva_27_inter = $acum_msubt_bi_iva_27_inter + round($filas['msubt_bi_iva_27'],2);
			}
			$acum_msubt_exento_compra = $acum_msubt_exento_compra + round($filas['msubt_exento_compra'],2);
			$acum_m_iva_reten = $acum_m_iva_reten + round($filas['m_iva_reten'],2);
			
			$acum_tot_iva = $acum_tot_iva + round($filas['tot_iva'],2);
	?>
  <tr>
    <!--Numero de Operqciones-->
    <td><?php echo $nop++;?></td>
    <!--FACTURA-->
    <td><?php echo fechaInver($filas['fecha_fact_compra']) ?></td>
    <!--PROVEEDOR-->
    <td><?php echo $filas['rif'] ?></td>
    <td><?php echo utf8_decode($filas['nombre']); if($total_consulta <= 0)echo "*** Sin Actividad Comercial ***";?></td>
    <td><?php if($total_consulta > 0)condRif($filas['rif'])?></td><!--TIPO DE PROVEEDOR-->
    <!--FACTURA RETENCION-->
    <td><?php if($filas['num_compro_reten'] !="")echo $filas['num_compro_reten']; else echo "-"; ?></td>
    <td><?php echo fechaInver($filas['fecha_compro_reten'])?></td>
    <!--FACTURA IMPORTACION-->
    <td><?php echo $filas['nplanilla_import'] ?></td>
    <td><?php echo $filas['nexpe_import'] ?></td>
    <td><?php echo $filas['naduana_import'] ?></td>
    <td><?php echo fechaInver($filas['fechaduana_import']) ?></td>
    <!--FACTURA-->
    <td><?php echo $filas['serie_fact_compra'] ?></td>
    <td><?php echo $filas['num_fact_compra'] ?></td>
    <td><?php echo $filas['num_ctrl_factcompra']?></td>
    <!--FACTURA NOTA-->
    <td class="conter_table_nadatd">
    	<table class="table_nada">
		<?php if($total_consulta > 0)
				{ 
					do{
						if($filas3['tipo_notas_cd'] == 'NC')
						echo "<tr><td>".$filas3['num_notas_cd']."</td></tr>";
					}while($filas3 = pg_fetch_assoc($consulta3));
				}
		?>
        </table>
    </td>
    <td>
        <table class="table_nada">
		<?php if($total_consulta > 0)
				{ 
					do{
						if($filas3['tipo_notas_cd'] == 'ND')
						echo "<tr><td>".$filas3['num_notas_cd']."</td></tr>";
					}while($filas3 = pg_fetch_assoc($consulta3));
				}
		?>
        </table>
    </td>
    <!--FACTURA RETENCION QUE Y A QUIEN-->
    <td><?php echo $filas['tipo_trans']?></td>
    <td><?php echo $filas['nfact_afectada']?></td>
    <!--FACTURA TOTALES IMPORTACIONES-->
    <td><?php echo $mtot_iva_compra_import;?></td>
    <td><?php echo $msubt_exento_compra_import;?></td>
    <td><?php echo $msubt_tot_bi_compra_import;?></td>
    <td><?php echo $msubt_bi_iva_12_import;?></td>
    <td><?php echo $msubt_bi_iva_8_import;?></td>
    <td><?php echo $msubt_bi_iva_27_import;?></td>
    <!--FACTURA TOTALES INTERNAS-->
    <td><?php echo $mtot_iva_compra_inter?></td>
    <td><?php echo sumSinIVA($filas['id_fact_compra'], 'IN_SDCF') ?></td>
    <td><?php echo sumSinIVA($filas['id_fact_compra'], 'IN_EX') ?></td>
    <td><?php echo sumSinIVA($filas['id_fact_compra'], 'IN_EXO') ?></td>
    <td><?php echo sumSinIVA($filas['id_fact_compra'], 'IN_NS')?></td>
	
    <td><?php echo $msubt_tot_bi_compra_inter;?></td>
    <td><?php echo $msubt_bi_iva_12_inter;?></td>
    <td><?php echo $msubt_bi_iva_8_inter;?></td>
    <td><?php echo $msubt_bi_iva_27_inter;?></td>
    <!--monto total de impuesto IVA-->
    <td><?php echo round($filas['tot_iva'],2)?></td>
    <!--FACTURA TOTALES DE RETENCIONES-->
    <td><?php echo round($filas['m_iva_reten'],2)?></td>
  </tr>
  <?php }while($filas=pg_fetch_assoc($consulta)); ?>
  <tr>
  	<td colspan="18">Totales</td>
    <!-- IMPORTACIONES -->
    <td><?php echo $acum_mtot_iva_compra_import; ?></td><!-- TOTAL DE IMPORTACIONEES INCLUYENDO EL IVA-->
    <td><?php echo $acum_msubt_exento_compra_import; ?></td><!--TOTAL DE IMPORTACIONES EXENTAS O EXONERADAS	 -->
    <td><?php echo $acum_msubt_tot_bi_compra_import; ?></td><!--TOTALES DE LAS BASES IMPONIBLES -->
    <td><?php echo $acum_msubt_bi_iva_12_import; ?></td><!--TOTAL BI 12 IMPORT -->
    <td><?php echo $acum_msubt_bi_iva_8_import; ?></td><!--TOTAL BI 8 IMPORT -->
    <td><?php echo $acum_msubt_bi_iva_27_import; ?></td><!--TOTAL BI 27 IMPORT -->
    <!-- INTERNAS -->
    <td><?php echo $acum_mtot_iva_compra_inter; ?></td><!--total compras incluyendo el iva --> 
    <td><?php echo $acum_IN_SDCF_compra_inter; ?></td><!--TOTAL DE IMPORTACIONES EXENTAS O EXONERADAS	 -->
    <td><?php echo $acum_IN_EX_compra_inter; ?></td><!--TOTALES DE LAS BASES IMPONIBLES -->
    <td><?php echo $acum_IN_EXO_compra_inter; ?></td><!--TOTAL BI 12 IMPORT --> 
    <td><?php echo $acum_IN_NS_compra_inter; ?></td><!--TOTAL BI 8 IMPORT --> 
    <td><?php echo $acum_msubt_tot_bi_compra_inter; ?></td><!--TOTAL BI 27 IMPORT -->
    <td><?php echo $acum_msubt_bi_iva_12_inter; ?></td><!--TOTAL BI 27 IMPORT -->
    <td><?php echo $acum_msubt_bi_iva_8_inter; ?></td><!--TOTAL BI 27 IMPORT -->
    <td><?php echo $acum_msubt_bi_iva_27_inter; ?></td><!--TOTAL BI 27 IMPORT -->
    <td><?php echo $acum_tot_iva; ?></td><!--TOTAL BI 27 IMPORT -->
   <td><?php echo $acum_m_iva_reten;?></td>
    
  </tr>
 </tbody>
</table>
<br>
<br>
<br>
<br>
<br>
<!--RESUMEN DE LA COMPRA-->
<table cellspacing="0" class="tabla1 table">
  <tbody>
	<tr class="titulo">
    	<td colspan="5"><div class="subTitulo">RESUMEN DE COMPRAS DEl MES DE <?php echo mesNum_Texto($mes);?></div></td>
    </tr>
    <tr class="titulo">
    	<td rowspan="2"><div class="subTitulo">Descripci&oacute;n</div></td>
        <td colspan="2">Base Imponible</td>
        <td colspan="2">Credito Fiscal</td>
    </tr>
    <tr>
    	<td>Item</td>
        <td>Monto</td>
        <td>Item</td>
        <td>Monto</td>
    </tr>
 
	<tr>
    	<td>Compras no Gravadas y/o sin Derecho a Credito Fiscal</td>
        <td>30</td>
        <td><?php echo $acum_msubt_exento_compra; ?></td>
        <td>-</td>
        <td>-</td>
    </tr> 
    <tr>
    	<td>Importaciones Gravadas por Alicuata General 12%</td>
        <td>31</td>
        <td><?php echo $acum_msubt_bi_iva_12_import;?>
        </td>
        <td>32</td>
        <td><?php echo $iva_12_import = $acum_msubt_bi_iva_12_import * 0.12;?></td>
    </tr> 
    <tr>
    	<td>Importaciones Gravadas por Alicuata General mas Adicional 27%</td>
        <td>312</td>
        <td><?php echo $acum_msubt_bi_iva_27_import;?>
        </td>
        <td>322</td>
        <td><?php echo $iva_27_import = $acum_msubt_bi_iva_27_import * 0.27;?></td>
    </tr> 
    <tr>
    	<td>Importaciones Gravadas por Alicuata Reducida 8%</td>
        <td>313</td>
        <td><?php echo $acum_msubt_bi_iva_8_import;?>
        </td>
        <td>323</td>
        <td><?php echo $iva_8_import = $acum_msubt_bi_iva_8_import * 0.08;?></td>
    </tr> 
    <tr>
    	<td>Compras Internas Gravadas por Alicuota General 12%</td>
        <td>33</td>
        <td><?php echo $acum_msubt_bi_iva_12_inter;?>
        </td>
        <td>34</td>
        <td><?php echo $iva_12_inter = $acum_msubt_bi_iva_12_inter * 0.12;?></td>
    </tr> 
    <tr>
    	<td>Compras Internas Gravadas por Alicuota General mas Alicuota Adicional 27%</td>
        <td>332</td>
        <td><?php echo $acum_msubt_bi_iva_27_inter;?></td>
        <td>342</td>
        <td><?php echo $iva_27_inter = $acum_msubt_bi_iva_27_inter * 0.27;?></td>
    </tr> 
    <tr>
    	<td>Compras Internas Gravadas por Alicuota Reducida 8%</td>
        <td>333</td>
        <td><?php echo $acum_msubt_bi_iva_8_inter;?></td>
        <td>343</td>
        <td><?php echo $iva_8_inter = $acum_msubt_bi_iva_8_inter * 0.08;?></td>
    </tr> 
    <tr>
    	<td>Total Compras y Creditos Fiscales del Periodo:</td>
        <td>38</td>
        <td><?php echo 	$acum_msubt_exento_compra + $acum_msubt_bi_iva_12_import + $acum_msubt_bi_iva_27_import + 
					   	$acum_msubt_bi_iva_8_import + $acum_msubt_bi_iva_12_inter + $acum_msubt_bi_iva_27_inter + 
						$acum_msubt_bi_iva_8_inter;?></td>
        <td>36</td>
        <td><?php echo $iva_12_import + $iva_27_import + $iva_8_import + $iva_12_inter + $iva_27_inter + $iva_8_inter;?></td>
    </tr>    
  </tbody>  
</table>
<div style="float:right;text-align: right;">
<br />
<br /><br />
<table cellspacing="0" class="tabla1 table" style="text-align: right;" >
	<thead>
    	<tr><td width="70px" class="titulo"><b style="text-align:center">I.V.A. Retenido por el Comprador</b></td></tr>
    </thead>
    <tbody>
    	<tr><td><?php echo $acum_m_iva_reten;?></td></tr>
    </tbody>
</table>
</div>
<?php
}