<?php
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
if(strpos($uri, 'modulos'))
	$extra = '/../../../';
else
	$extra = '/';
///////////////////////////////////////////////////////////////////////////////////
//			FUNCIONES
////////////////////////////////////////////////////////////////////////////////////
include_once("../../librerias/conexion.php");
/////////////////////////////////////////////////////////////
include_once('../../php/funciones.php');
/////////////////////////////////////////////////////////////
include_once('../../includes_SISTEM/include_login.php');
/////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////				CONSULTAS SQL

if (isset($_POST['mes'])){
	$mes = $_POST['mes'];
	$mesi = $mes."-01";
	$mesf = ($mes=='02')? $mes."-28":((int) $mes%2==0) ? $mes."-31" : $mes."-30";
	//consulta de los datos de la empreas PARA SABE LA ACTIVA empresa
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
//////////////////////////////////////////////////////////////////////				LIBRERIA
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
	date_default_timezone_set('America/Caracas');
	
	/** Include PHPExcel */
	include_once ('../../librerias/PHPExcel_1.8.0/Classes/PHPExcel.php');
	
	// Create new PHPExcel object
	//echo date('H:i:s') , " Create new PHPExcel object" , EOL;
	$objPHPExcel = new PHPExcel();
	
	// Set document properties
	//echo date('H:i:s') , " Set document properties" , EOL;
	$objPHPExcel->getProperties()->setCreator("Ing. Ivan Diaz")
							 ->setLastModifiedBy("Ing. Ivan Diaz")
							 ->setTitle("Sistema: ".$_SESSION["alias"].'Version:'.$_SESSION["version"])
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
	// Set default font
	//echo date('H:i:s') , " Set default font" , EOL;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
											  ->setSize(9);
	// Add some data
	//echo date('H:i:s') , " Add some data" , EOL;
	
	
	//PROPUIEDADES DE LA PAGINA				ORIENTACION DE LA HOJA
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	//								ESCALA
	$objPHPExcel->getActiveSheet()->getPageSetup()->setScale('60');
	//								TIPO CARTA
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
	//		HEADER Y			FOOTER
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('Libro de Compras Fecha de Exportación: '.date('d/m/Y'));
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' .'Sistema:'.$_SESSION["alias"].'Version:'.$_SESSION["version"].'&RPagina &P of &N');
	////////////////////////////////////////////////		ESTILOS
	////////////////////////////////////////////////			TABLA1
	//echo date('H:i:s') , "CREACION DE ESTILOS" , EOL;		
	$styleArrayT1H = array(
		'font' => array(
			'bold' => true
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
		),
	);
	$styleArrayT1M = array(
		'font' => array(
			'bold' => true,
			'color' => array('rgb' => 'FFFFF')
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
		),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			),
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				'rgb' => '004080' 
			),
		),	
	);
	$styleArrayTot = array(
		'font' => array(
			'bold' => true
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
		),
		'borders' => array(
			
			'bottom' => array(
				'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
				'color' => array(
				  'rgb' => '000000'
				)
			)
		)
	);
	$styleArrayT1MV = array(
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			'rotation' => 90
		)
	);
	$styleArrayT1MH = array(
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY
		)
	);
	$styleArrayT1B = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			),
		),
	);
	
	////////////////////////////////////////////////			TABLA1
	//		MENBRETE		TABLA1	
	//////////////////////////////////////////////////7			metodo para obtener el mes con la fecha	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Reporte de Compras')->mergeCells('A1:AI1')
										->setCellValue('A2', $filas2['titular_rif_empre']." - ". $filas2['nom_empre'])->mergeCells('A2:AI2')
										->setCellValue('A3', $filas2['rif_empre'])->mergeCells('A3:AI3')
										->setCellValue('A4', 'Dirección: '.$filas2['dir_empre'])->mergeCells('A4:AI4')
										->setCellValue('A5', 'Contribuyente: '.$filas2['contri_empre'])->mergeCells('A5:AI5')
										->setCellValue('A6', 'LIBRO DE COMPRAS CORRESPONDIENTE AL MES DE'.mesNum_Texto($mes))->mergeCells('A6:AI6')
										;
	$objPHPExcel->getActiveSheet()->getStyle('A1:A6')->applyFromArray($styleArrayT1H);// ESTILO
	//		HEADER		//////////////
						//FILA		7
	$objPHPExcel->getActiveSheet()		->setCellValue('S7',"IMPORTACIONES")->mergeCells('S7:X7')
										->setCellValue('Y7',"INTERNAS")->mergeCells('Y7:AG7')
	;
	$objPHPExcel->getActiveSheet()->getStyle('S7:AG7')->applyFromArray($styleArrayT1M);// ESTILO 
						//FILA		8
	$objPHPExcel->getActiveSheet()	->setCellValue('A8',"Nro. Operaciones")//class="v"
									->setCellValue('B8',"Fecha del Documento")//class="h"
									->setCellValue('C8',"N° R.I.F. ó Cedula de Identidad")//class="h"
									->setCellValue('D8',"Nombre ó Razón Social")//class="h"
									->setCellValue('E8',"Tipo de Proveedor")//class="h"
	
									->setCellValue('F8',"Nro. de Comprobante de Retención")//class="v"
									->setCellValue('G8',"Fecha de Aplicación de Retención")//class="v"
	
									->setCellValue('H8',"Nro. de Planilla de Importación")//class="v"
									->setCellValue('I8',"Nro. del Expediente de Importación")//class="v"
									->setCellValue('J8',"Nro. de Declaración de Aduana")//class="v"
									->setCellValue('K8',"Fecha de Declaración de Aduana")//class="v"
	
									->setCellValue('L8',"Serie del Documento")//class="v"
									->setCellValue('M8',"Nro. del Documento")//class="h"
									->setCellValue('N8',"Nro. de Control")//class="h"
									->setCellValue('O8',"Nro. de Nota de Debito")//class="h"
									->setCellValue('P8',"Nro. de Nota de Credito")//class="h"
									->setCellValue('Q8',"Tipo de Transacción")//class="h"<!--tipo Compra-->
									->setCellValue('R8',"Nro. de Documento afectado")//class="v"
					//<!--IMPORTACIONES-->
									->setCellValue('S8',"Total de Importaciones  incluyendo el IVA")//class="v"
									->setCellValue('T8',"Importaciones Exentas /Exoneradas")//class="v"
									->setCellValue('U8',"Total Base Imponible")//class="v"
									->setCellValue('V8',"Subtotal B.I. al 12%")//class="v"
									->setCellValue('W8',"Subtotal B.I. al 8%")//class="v"
									->setCellValue('X8',"Subtotal B.I. al 27%")//class="v"
					//<!--INTERNAS-->
									->setCellValue('Y8',"Total de Compra internas incluyendo el IVA")//class="v"
									->setCellValue('Z8',"Compras sin derecho a credito IVA")//class="v"
									->setCellValue('AA8',"Compras Exentas")//class="v"
									->setCellValue('AB8',"Compras Exoneradas")//class="v"
									->setCellValue('AC8',"Compras no Sujetas")//class="v"
									->setCellValue('AD8',"Base Imponible")//class="v"
									->setCellValue('AE8',"Subtotal B.I. al 12%")//class="v"
									->setCellValue('AF8',"Subtotal B.I. al 8%")//class="v"
									->setCellValue('AG8',"Subtotal B.I. al 27%")//class="v"
									->setCellValue('AH8',"Impuesto I.V.A.")//class="v"
									->setCellValue('AI8',"I.V.A. Retenido")//class="v"
									;
	$objPHPExcel->getActiveSheet()->getStyle('A8:AI8')->applyFromArray($styleArrayT1M);	// ESTILO MENBRETE
	
	$objPHPExcel->getActiveSheet()->getStyle('A8')->applyFromArray($styleArrayT1MV);	// ESTILO VERTICAL
	$objPHPExcel->getActiveSheet()->getStyle('F8:L8')->applyFromArray($styleArrayT1MV);	// ESTILO VERTICAL
	$objPHPExcel->getActiveSheet()->getStyle('R8:AI8')->applyFromArray($styleArrayT1MV);// ESTILO VERTICAL
	
	$objPHPExcel->getActiveSheet()->getStyle('B8:E8')->applyFromArray($styleArrayT1MH);// ESTILO HORIZONTAL
	$objPHPExcel->getActiveSheet()->getStyle('M8:Q8')->applyFromArray($styleArrayT1MH);// ESTILO HORIZONTAL
	
																						// TAMANO POR RANGOS
										//		A8
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4); 					//tamano horizontal
										//		F8:L8
	for($columnID='F';$columnID<='L';$columnID++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(4); 			//tamano horizontal
	}									//		F8:L8
	for($columnID='R';$columnID!='AJ';$columnID++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(4); 			//tamano horizontal
	}
										//		B8:E8
	for($columnID='B';$columnID!='E';$columnID++) {
		if($columnID!='D'){
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(11); 			//tamano vertical
	$objPHPExcel->getActiveSheet()->getStyle($columnID)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
	$objPHPExcel->getActiveSheet()->getStyle($columnID)->getNumberFormat()->setFormatCode('0000');
	//$objPHPExcel->getActiveSheet()->getStyle($columnID)->applyFromArray($styleArrayT1MH);
		}
	}									//		M8:Q8
	for($columnID='M';$columnID!='Q';$columnID++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(11); 			//tamano vertical
	$objPHPExcel->getActiveSheet()->getStyle($columnID)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
	$objPHPExcel->getActiveSheet()->getStyle($columnID)->getNumberFormat()->setFormatCode('0000');
	//$objPHPExcel->getActiveSheet()->getStyle($columnID)->applyFromArray($styleArrayT1MH);
	}
	for($columnID='S';$columnID!='AJ';$columnID++) {
	$objPHPExcel->getActiveSheet()->getStyle($columnID)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	}	
	//		BODY		//////////////7
	  				//FILA		9 en adelante	
						//CONSULTA DE LAS DEMAS CELDAS CON UN WHILE PARA EL BODY
	//echo date('H:i:s') , " WHILE BD INICIANDO" , EOL;
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
	$it1 = 9;
	// el contador de columnas lo inicializo edentro del EHILE
	//contador de operaciones
	$nop = 1;

    do{
		//CONSULTAS RELACIONALES
		//consulta las notas si existen 
		$consulta3 = pg_query($conexion,sprintf("SELECT * FROM notas_cd, fact_compra WHERE fact_compra.id_fact_compra = notas_cd.id_fact_compra AND notas_cd.id_fact_compra = '%s'",$filas['id_fact_compra']));
		// $filas3 = $consultaNota->fetch_assoc();
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
			
			$acum_msubt_bi_iva_12_inter = 		$acum_msubt_bi_iva_12_inter + $msubt_bi_iva_12_inter;
			$acum_msubt_bi_iva_8_inter = 		$acum_msubt_bi_iva_8_inter + $msubt_bi_iva_8_inter;
			$acum_msubt_bi_iva_27_inter = 		$acum_msubt_bi_iva_27_inter + $msubt_bi_iva_27_inter;
			
			
		}
		$acum_msubt_exento_compra = $acum_msubt_exento_compra + round($filas['msubt_exento_compra'],2);
		
		$acum_m_iva_reten = $acum_m_iva_reten + round($filas['m_iva_reten'],2);
		$acum_tot_iva = $acum_tot_iva + round($filas['tot_iva'],2);
		
		//////////////////////7			IMPRESION DE LOS DATOS
		// //contador de columnas
		$jt1 = 'A';// INICIALIZO LAS COLUMNAS EN A
						//<!--Numero de Operqciones-->
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($jt1.$it1, $nop++)
    					//<!--FACTURA-->
											->setCellValue(++$jt1.$it1, fechaInver($filas['fecha_fact_compra']));
    					//<!--PROVEEDOR-->

		if($total_consulta <= 0)
			$nombreR = "*** Sin Actividad Comercial ***";
		else 
			$nombreR = $filas['nombre'];
		$condRif = condRif($filas['rif']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $filas['rif'])
											->setCellValue(++$jt1.$it1, $nombreR)
											->setCellValue(++$jt1.$it1, $condRif);//<!--TIPO DE PROVEEDOR-->
							//<!--FACTURA RETENCION-->
		if($filas['fecha_compro_reten']=='0000-00-00')
			$fechaInver1 = "";
		else
			$fechaInver1 = fechaInver($filas['fecha_compro_reten']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $filas['num_compro_reten'])
											->setCellValue(++$jt1.$it1,  $fechaInver1);
							//<!--FACTURA IMPORTACION-->
		if($filas['fechaduana_import']=='0000-00-00')
			$fechaInver2 = "";
		else
			$fechaInver2 = fechaInver($filas['fechaduana_import']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $filas['nplanilla_import'])
											->setCellValue(++$jt1.$it1, $filas['nexpe_import'])
											->setCellValue(++$jt1.$it1, $filas['naduana_import'])
											->setCellValue(++$jt1.$it1, $fechaInver2)
							//<!--FACTURA-->
											->setCellValue(++$jt1.$it1, $filas['serie_fact_compra'])
											->setCellValue(++$jt1.$it1, $filas['num_fact_compra'])
											->setCellValue(++$jt1.$it1, $filas['num_ctrl_factcompra']);
							//<!--FACTURA NOTA CREDITO-->
											$notas_credito = "";
											if($total_consulta > 0)
											{ 
												do{
													if($filas3['tipo_notas_cd'] == 'NC')
													$notas_credito = $notas_credito . $filas3['num_notas_cd'].",";
											  	}while($filas3 = pg_fetch_assoc($consulta3));
											}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $notas_credito);
							//<!--FACTURA NOTA DEBITO-->
											$notas_debito = "";		
											if($total_consulta > 0)
											{ 
												do{
													if($filas3['tipo_notas_cd'] == 'ND')
													$notas_debito = $notas_debito . $filas3['num_notas_cd'].",";
												}while($filas3 = pg_fetch_assoc($consulta3));
											}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $notas_debito);									
							//<!--FACTURA RETENCION QUE Y A QUIEN-->
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $filas['tipo_trans'])
											->setCellValue(++$jt1.$it1, $filas['nfact_afectada'])
							//<!--FACTURA TOTALES IMPORTACIONES-->
											->setCellValue(++$jt1.$it1, $mtot_iva_compra_import)
											->setCellValue(++$jt1.$it1, $msubt_exento_compra_import)
											->setCellValue(++$jt1.$it1, $msubt_tot_bi_compra_import)
											->setCellValue(++$jt1.$it1, $msubt_bi_iva_12_import)
											->setCellValue(++$jt1.$it1, $msubt_bi_iva_8_import)
											->setCellValue(++$jt1.$it1, $msubt_bi_iva_27_import);
							//<!--FACTURA TOTALES INTERNAS-->
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $mtot_iva_compra_inter)
											->setCellValue(++$jt1.$it1, sumSinIVA($filas['id_fact_compra'], 'IN_SDCF'))
											->setCellValue(++$jt1.$it1, sumSinIVA($filas['id_fact_compra'], 'IN_EX') )
											->setCellValue(++$jt1.$it1, sumSinIVA($filas['id_fact_compra'], 'IN_EXO') )
											->setCellValue(++$jt1.$it1, sumSinIVA($filas['id_fact_compra'], 'IN_NS') )
											->setCellValue(++$jt1.$it1, $msubt_tot_bi_compra_inter)
											->setCellValue(++$jt1.$it1, $msubt_bi_iva_12_inter)
											->setCellValue(++$jt1.$it1, $msubt_bi_iva_8_inter)
											->setCellValue(++$jt1.$it1, $msubt_bi_iva_27_inter)
							//<!--monto total de impuesto IVA-->
											->setCellValue(++$jt1.$it1, round($filas['tot_iva'],2))
							//<!--FACTURA TOTALES DE RETENCIONES-->
											->setCellValue(++$jt1.$it1, $filas['m_iva_reten'])
									;
		++$it1;//in cremento fials
	}while($filas=pg_fetch_assoc($consulta));
	//////////////////////////////////
	// FOR PARA AJUSTAR SOLO LOS ELEMENTOS LLENOS
	//////////////////////////////////
	++$jt1;//para que sea AI
	
	$vectNoColum = array ('D','F','G','H','I','J','K','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ');
	for($fila = 9; $fila <= $it1; $fila++){//AI 10
		for($columna='A';$columna!= $jt1;$columna++){
			for($numCol='0';$numCol<count($vectNoColum);$numCol++){
				if($columna == $vectNoColum[$numCol]){
					$valCelda = $objPHPExcel->getActiveSheet()->getCell($columna.$fila)->getValue();
					if(strlen($valCelda) >=1 ){
						$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setAutoSize(true);// 	AJUSTAR HORIZONTAL
					}
				}
			}
		}
	}
	//echo date('H:i:s') , " WHILE BD TERMINANDO" , EOL;
	//dandole estilo al cuerpo de la tabla 1 SOLO BORDES
	$itb1 = $it1;
	$objPHPExcel->getActiveSheet()->getStyle('A9:AI'.--$itb1)->applyFromArray($styleArrayT1B);	// ESTILO BODY
	
	$it2 = $it1;
	$jt2 = "A";
	
	function expo_var($var, $cant){					
		for($auxi = 1;$auxi != $cant;$auxi++)
			$res_ev = ++$var;
		return $res_ev;
	}
	//////////////////////////////////////////////////////////
	//	sumatoria de los resultados		 TOTALES
	//
	//
	////////////////////////////////////////////////////////////
	
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2,"TOTALES:");							//		FILA 1
	$objPHPExcel->getActiveSheet()		->mergeCells($jt2.$it2.":".expo_var($jt2, 18).$it2);
	//////////////////////////////////7
	//		IMPORTACIONES
	/////////////////////////////////////						
	//								TOTAL DE IMPORTACIONEES INCLUYENDO EL IVA
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,19).$it2,$acum_mtot_iva_compra_import);		//		FILA 1
	
	//								TOTAL DE IMPORTACIONES EXENTAS O EXONERADAS		
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,20).$it2,$acum_msubt_exento_compra_import);		//		FILA 1
	
	//								TOTALES DE LAS BASES IMPONIBLES
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,21).$it2,$acum_msubt_tot_bi_compra_import);		//		FILA 1
	
	//								TOTAL BI 12 IMPORT
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,22).$it2,$acum_msubt_bi_iva_12_import);		//		FILA 1
	
	//								TOTAL BI 8 IMPORT
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,23).$it2,$acum_msubt_bi_iva_8_import);		//		FILA 1
	
	//								TOTAL BI 27 IMPORT
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,24).$it2,$acum_msubt_bi_iva_27_import);		//		FILA 1
	
	//////////////////////////////////7
	//		INTERNAS
	////////////////////////////////////
	
	//								total compras incluyendo el iva
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,25).$it2,$acum_mtot_iva_compra_inter);		//		FILA 1
	
	//								TOTAL DE IMPORTACIONES EXENTAS O EXONERADAS		
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,26).$it2,$acum_IN_SDCF_compra_inter);		//		FILA 1
	
	//								TOTALES DE LAS BASES IMPONIBLES
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,27).$it2, $acum_IN_EX_compra_inter);		//		FILA 1
	
	//								TOTAL BI 12 IMPORT
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,28).$it2, $acum_IN_EXO_compra_inter);		//		FILA 1
	
	//								TOTAL BI 8 IMPORT
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,29).$it2, $acum_IN_NS_compra_inter);		//		FILA 1
	
	//								TOTAL BI 27 IMPORT
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,30).$it2, $acum_msubt_tot_bi_compra_inter);		//		FILA 1
	
	//								TOTAL BI 27 IMPORT
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,31).$it2, $acum_msubt_bi_iva_12_inter);		//		FILA 1

	//								TOTAL BI 27 IMPORT
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,32).$it2, $acum_msubt_bi_iva_8_inter);		//		FILA 1
	
	//								TOTAL BI 27 IMPORT
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,33).$it2, $acum_msubt_bi_iva_27_inter);		//		FILA 1

	//								TOTAL BI 27 IMPORT
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,34).$it2, $acum_tot_iva);		//		FILA 1
	
	//								TOTAL BI 27 IMPORT
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,35).$it2, $acum_m_iva_reten);		//		FILA 1
	//////////////////////////////////////
	//		ESTILOS
	////////////////////////////////////
	$objPHPExcel->getActiveSheet()->getStyle($jt2.$it2.":".expo_var($jt2, 35).$it2)->applyFromArray($styleArrayTot);
 
	/////////////////////////////////////////////////////			
	//		TABLA 2
	// RESUMEN DE LA COMPRA
	// ESTA ES LA ULTIMA FILA QUE QUEDO			$it1
	// ESTA COLUMNA VUELVE A EMPEZAR			$jt1
		$it2 = $it1+4;// LE SUME 3 POR EL ESPACIO ENTRE LAS TABLAS
		//			HEADER
		// Incremento 5 letras mas para la celda del HEADRE larga para la tabla 2
		//$it2_q_estaba = $it2;// HAY MAS COLUMNAS GUARDO EL VALOR DE LA FILA	
		$mesNum_Texto2 = mesNum_Texto($mes);							
		$it2hi = $it2;//inicializando header
		
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2,"RESUMEN DE COMPRAS DEl MES DE ".$mesNum_Texto2);
	$objPHPExcel->getActiveSheet()		->mergeCells($jt2.$it2.":".expo_var($jt2, 21).$it2);																									//		FILA 2
		++$it2;
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Descripción");								
	$objPHPExcel->getActiveSheet()		->mergeCells($jt2.$it2.":".expo_var($jt2, 11).expo_var($it2, 2))			// OCUPA 11 COL 2 FILAS
									->setCellValue(expo_var($jt2, 12).$it2, "Base Imponible")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 4 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "Credito Fiscal")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 21).$it2);			// OCUPA 2 COLUMNAS
		++$it2;																										//		FILA 3
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2, 12).$it2, "Item")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 13).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 14).$it2, "Monto")
										->mergeCells(expo_var($jt2, 14).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "Item")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 18).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 19).$it2, "Monto")
										->mergeCells(expo_var($jt2, 19).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	;
		$it2hf = $it2;
		++$it2;
		$it2bi = $it2;//inicializando cuerpo																										//		FILA 4
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Compras no Gravadas y/o sin Derecho a Credito Fiscal")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "30")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 13).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 14).$it2, $acum_msubt_exento_compra)
										->mergeCells(expo_var($jt2, 14).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "-")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 18).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 19).$it2, "-")
										->mergeCells(expo_var($jt2, 19).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	;
		++$it2;																										//		FILA 5
	$iva_12_import = $acum_msubt_bi_iva_12_import * 0.12;
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Importaciones Gravadas por Alicuata General 12%")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "31")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 13).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 14).$it2, $acum_msubt_bi_iva_12_import)
										->mergeCells(expo_var($jt2, 14).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "32")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 18).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 19).$it2, $iva_12_import)
										->mergeCells(expo_var($jt2, 19).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	; 
		++$it2;																										//		FILA 6
	$iva_27_import = $acum_msubt_bi_iva_27_import * 0.27;
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Importaciones Gravadas por Alicuata General mas Adicional 27%")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "312")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 13).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 14).$it2, $acum_msubt_bi_iva_27_import)
										->mergeCells(expo_var($jt2, 14).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "322")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 18).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 19).$it2, $iva_27_import)
										->mergeCells(expo_var($jt2, 19).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	; 
		++$it2;																										//		FILA 7
	$iva_8_import = $acum_msubt_bi_iva_8_import * 0.08;
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Importaciones Gravadas por Alicuata Reducida 8%")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "313")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 13).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 14).$it2, $acum_msubt_bi_iva_8_import)
										->mergeCells(expo_var($jt2, 14).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "323")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 18).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 19).$it2, $iva_8_import)
										->mergeCells(expo_var($jt2, 19).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	; 
		++$it2;																										//		FILA 8
	$iva_12_inter = $acum_msubt_bi_iva_12_inter * 0.12;
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Compras Internas Gravadas por Alicuota General 12%")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "33")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 13).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 14).$it2, $acum_msubt_bi_iva_12_inter)
										->mergeCells(expo_var($jt2, 14).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "34")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 18).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 19).$it2, $iva_12_inter)
										->mergeCells(expo_var($jt2, 19).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	; 
		++$it2;																										//		FILA 9
	$iva_27_inter = $acum_msubt_bi_iva_27_inter * 0.27;
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Compras Internas Gravadas por Alicuota General mas Alicuota Adicional 27%")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "332")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 13).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 14).$it2, $acum_msubt_bi_iva_27_inter)
										->mergeCells(expo_var($jt2, 14).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "342")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 18).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 19).$it2, $iva_27_inter)
										->mergeCells(expo_var($jt2, 19).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	; 
		++$it2;																										//		FILA 10
	$iva_8_inter = $acum_msubt_bi_iva_8_inter * 0.08;
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Compras Internas Gravadas por Alicuota Reducida 8%")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "333")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 13).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 14).$it2, $acum_msubt_bi_iva_8_inter)
										->mergeCells(expo_var($jt2, 14).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "343")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 18).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 19).$it2, $iva_8_inter)
										->mergeCells(expo_var($jt2, 19).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	; 
		++$it2;																										//		FILA 11
	$tot_c_c_f	=		$acum_msubt_exento_compra + $acum_msubt_bi_iva_12_import + $acum_msubt_bi_iva_27_import + 
					   	$acum_msubt_bi_iva_8_import + $acum_msubt_bi_iva_12_inter + $acum_msubt_bi_iva_27_inter + 
						$acum_msubt_bi_iva_8_inter;
	$tot_iva_c_c_f =	$iva_12_import + $iva_27_import + $iva_8_import + $iva_12_inter + $iva_27_inter + $iva_8_inter;
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Total Compras y Creditos Fiscales del Periodo:")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "38")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 13).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 14).$it2, $tot_c_c_f)
										->mergeCells(expo_var($jt2, 14).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "36")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 18).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 19).$it2, $tot_iva_c_c_f)
										->mergeCells(expo_var($jt2, 19).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	; 
//////////////////////////////////////////////////////////////////////
//			ESTILOS
///////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->getStyle($jt2.$it2hi.':'.expo_var($jt2, 21).$it2hf)->applyFromArray($styleArrayT1M);	// ESTILO HEAD
$objPHPExcel->getActiveSheet()->getStyle($jt2.$it2bi.':'.expo_var($jt2, 21).$it2)->applyFromArray($styleArrayT1B);	// ESTILO BODY
//////////////////////////////////////////////////////////////////////
//			NUEVA TABLA
///////////////////////////////////////////////////////////////////////
$it2 = $it2 + 3; //TRES CELDAS MAS ABAJO
$it2Mi = $it2;
$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2Mi, "I.V.A. Retenido por el Comprador")
									->mergeCells($jt2.$it2Mi.":".expo_var($jt2, 3).$it2)			// OCUPA 2 COLUMNAS
								->setCellValue($jt2.++$it2, round($acum_m_iva_reten,2))
									->mergeCells($jt2.$it2.":".expo_var($jt2, 3).$it2)			// OCUPA 2 COLUMNAS
	;
//////////////////////////////////////////////////////////////////////
//			ESTILOS
///////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->getStyle($jt2.$it2Mi.':'.$jt2.$it2Mi)->applyFromArray($styleArrayT1M);	// ESTILO HEAD
$objPHPExcel->getActiveSheet()->getStyle($jt2.$it2Mi.':'.$jt2.$it2Mi)->applyFromArray($styleArrayT1MH);	// ESTILO HEAD

$objPHPExcel->getActiveSheet()->getStyle($jt2.$it2.':'.expo_var($jt2, 3).$it2)->applyFromArray($styleArrayT1B);	// ESTILO BODY
//	JUSTIFICAR TEXTO Y FORMATO DE NUMEROS

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Rename worksheet
    //echo date('H:i:s') , " Rename worksheet" , EOL;
	
    $objPHPExcel->getActiveSheet()->setTitle('Reporte_Compras');
    
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
	/*
    //	CREACION DEL NOMBRE DEL ARCHIVO
	$url_archivo = $filas2['url_report'];
	
	// Save Excel 2007 file
	//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
	$callStartTime = microtime(true);
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	
	if(file_exists($url_archivo)){
		$nombre_archivo = 'reporte_compras_'.$mes;
		if(file_exists($url_archivo.'/'.$nombre_archivo.'.xlsx')){
			$num_repet = 0;
			do{
				$num_repet++;
			}while(file_exists($url_archivo.'/'.$nombre_archivo.'('.$num_repet.')'.'.xlsx') == true);// EXISTE
			$objWriter->save($url_archivo.'/'.$nombre_archivo.'('.$num_repet.')'.'.xlsx');
		}else{
			$objWriter->save($url_archivo.'/'.$nombre_archivo.'.xlsx');
			}
	}else{
		$url_archivo = sprintf("C:\%s_reportes",$_SESSION["alias"]);
		if(file_exists ($url_archivo) == false)
			mkdir($url_archivo, 0700, true);//creo la carpeta por defecto
			
		$nombre_archivo = 'reporte_compras_'.$mes;
		
		if(file_exists($url_archivo.'/'.$nombre_archivo.'.xlsx')){
			$num_repet = 0;
			do{
				$num_repet++;
			}while(file_exists($url_archivo.'/'.$nombre_archivo.'('.$num_repet.')'.'.xlsx') == true);// EXISTE
			$objWriter->save($url_archivo.'/'.$nombre_archivo.'('.$num_repet.')'.'.xlsx');
		}else{
			$objWriter->save($url_archivo.'/'.$nombre_archivo.'.xlsx');
			}
		//llamar a modal
	}
	$callEndTime = microtime(true);
	$callTime = $callEndTime - $callStartTime;
	
	//echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
	//echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
	// Echo memory usage
	//echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;
	
	
	// Save Excel 95 file
	//echo date('H:i:s') , " Write to Excel5 format" , EOL;
	$callStartTime = microtime(true);
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	if(file_exists($url_archivo)){
		$nombre_archivo = 'reporte_compras_'.$mes;
		if(file_exists($url_archivo.'/'.$nombre_archivo.'.xls')){
			$num_repet = 0;
			do{
				$num_repet++;
			}while(file_exists($url_archivo.'/'.$nombre_archivo.'('.$num_repet.')'.'.xls') == true);// EXISTE
			$objWriter->save($url_archivo.'/'.$nombre_archivo.'('.$num_repet.')'.'.xls');
		}else{
			$objWriter->save($url_archivo.'/'.$nombre_archivo.'.xls');
			}
	}else{
		$url_archivo = sprintf("C:\%s_reportes",$_SESSION["alias"]);
		if(file_exists ($url_archivo) == false)
			mkdir($url_archivo, 0700, true);//creo la carpeta por defecto
		
		$nombre_archivo = 'reporte_compras_'.$mes;
		if(file_exists($url_archivo.'/'.$nombre_archivo.'.xls')){
			$num_repet = 0;
			do{
				$num_repet++;
			}while(file_exists($url_archivo.'/'.$nombre_archivo.'('.$num_repet.')'.'.xls') == true);// EXISTE
			$objWriter->save($url_archivo.'/'.$nombre_archivo.'('.$num_repet.')'.'.xls');
		}else{
			$objWriter->save($url_archivo.'/'.$nombre_archivo.'.xls');
			}
		//llamar a modal
	}

	$callEndTime = microtime(true);
	$callTime = $callEndTime - $callStartTime;
	
	//echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
	//echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
	// Echo memory usage
	//echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;
	
	
	// Echo memory peak usage
	//echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;
	
	// Echo done
	//echo date('H:i:s') , " Done writing files" , EOL;
	echo '
	<div align="center">
		<h1>Archivos listos</h1>
    	<h2>Los Archivos Han Sido Creados en la RUTA:<br />
			<a href="file:///'.$url_archivo.'/'.$nombre_archivo.'.xls">'.$url_archivo.'</a>
		</h2>
		<h1 class="text-success"><span class="glyphicon glyphicon-ok"></span></h1>
	</div>', EOL;
	fopen("C:\\SistemYIMI_reportes", "r");//"c:\\folder\\resource.txt"
	echo str_replace('\/','\\\\',$url_archivo);
	*/
	// Redirect output to a client's web browser ()
	
	$nombre_archivo = 'reporte_compras_'.$mes.'.xlsx';
	//$file ="excel_compras.xlsx";	
	
	
	//PHP en general
	  
	
	header("Content-type: application/vnd.ms-excel"); 
	header("Content-Disposition: attachment; filename=\"$nombre_archivo\"\n");
	header("Pragma: no-cache");
header("Expires: 0");
	// readfile($nombre_archivo);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');

}// este es de las consultas de arriba si son exitosa 
?>