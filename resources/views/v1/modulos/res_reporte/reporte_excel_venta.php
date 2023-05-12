<?php
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
if(strpos($uri, 'modulos'))
	$extra = '/../../';
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
	$consulta = pg_query($conexion,"SELECT * FROM empre WHERE empre.est_empre = '1'");
	// $filasEmpre = pg_fetch_assoc($consultaEmpre);
	$filas=pg_fetch_assoc($consulta);
	$total_consultaEmpre = pg_num_rows($consulta);
	//consulta de la factura con sus datos relacionados
	$consulta=pg_query($conexion,sprintf("SELECT * FROM empre, fact_venta, cliente WHERE
	  																			fact_venta.empre_cod_empre = empre.cod_empre AND
																				empre.cod_empre = '%s' AND
																				fact_venta.fk_cliente = cliente.ced_cliente AND
																				fact_venta.fecha_fact_venta BETWEEN '%s' AND '%s'",
																				$filas['cod_empre'], $mesi, $mesf));
																				
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
	$objPHPExcel->getActiveSheet()->getPageSetup()->setScale('70');
	//								TIPO CARTA
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
	//		HEADER Y			FOOTER
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('Libro de Ventas Fecha de Exportación: '.date('d/m/Y'));
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
	//		HEADER		TABLA1	
	//////////////////////////////////////////////////7			metodo para obtener el mes con la fecha	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Reporte de Ventas')->mergeCells('A1:AG1')
										->setCellValue('A2', $filas['titular_rif_empre']." - ". $filas['nom_empre'])->mergeCells('A2:AG2')
										->setCellValue('A3', $filas['rif_empre'])->mergeCells('A3:AG3')
										->setCellValue('A4', 'Dirección: '.$filas['dir_empre'])->mergeCells('A4:AG4')
										->setCellValue('A5', 'Contribuyente: '.$filas['contri_empre'])->mergeCells('A5:AG5')
										->setCellValue('A6', 'LIBRO DE VENTAS CORRESPONDIENTE AL MES DE'.mesNum_Texto($mes))->mergeCells('A6:AH6')
										;
	$objPHPExcel->getActiveSheet()->getStyle('A1:AH6')->applyFromArray($styleArrayT1H);// ESTILO
	//		MENBRETE		//////////////
						//FILA		7
	$objPHPExcel->getActiveSheet()		->setCellValue('U7',"EXPORTACIONES")->mergeCells('U7:U8')
										->setCellValue('V7',"NACIONALES")->mergeCells('V7:AF7')
	;
						//FILA		8
	$objPHPExcel->getActiveSheet()		->setCellValue('AA8',"Contribuyente")->mergeCells('AA8:AC8')
										->setCellValue('AD8',"No Contribuyente")->mergeCells('AD8:AF8')
	;
	$objPHPExcel->getActiveSheet()->getStyle('U7:AF8')->applyFromArray($styleArrayT1M);// ESTILO 					
						//FILA		9
	$objPHPExcel->getActiveSheet()	->setCellValue('A9',"Nro. Operaciones")//class="v"
									->setCellValue('B9',"Fecha del Documento")//class="h"
									->setCellValue('C9',"N° R.I.F. ó Cedula de Identidad")//class="h"
									->setCellValue('D9',"Nombre ó Razón Social")//class="h"
									->setCellValue('E9',"Tipo de Cliente")//class="h"
	
									->setCellValue('F9',"Nro. de Planilla de Exportación")//class="v"
									->setCellValue('G9',"Nro. del Expediente de Exportación")//class="v"
									->setCellValue('H9',"Nro. de Declaración de Aduana")//class="v"
									->setCellValue('I9',"Fecha de Declaración de Aduana")//class="v"
	
									->setCellValue('J9',"Serie del Documento")//class="v"
									->setCellValue('K9',"Nro. del Documento")//class="h"
									->setCellValue('L9',"Nro. de Control")//class="h"
									->setCellValue('M9',"Registro de Maquina Fiscal")//class="h"
									->setCellValue('N9',"Nro. de Reporte Z")//class="h"
									
									->setCellValue('O9',"Nro. de Nota de Debito")//class="h"
									->setCellValue('P9',"Nro. de Nota de Credito")//class="h"
									
									->setCellValue('Q9',"Tipo de Transacción")//class="h"<!--tipo venta-->
									
									->setCellValue('R9',"Nro. de Comprobante de Retención")//class="v"
									->setCellValue('S9',"Fecha de Aplicación de Retención")//class="v"
									
									->setCellValue('T9',"Nro. de Documento afectado")//class="v"
					//<!--Exportacion-->
									->setCellValue('U9',"Ventas Exportacion Exentas /Exoneradas")//class="v"
					//<!--NACIONALES-->				
									->setCellValue('V9',"Total de Venta Nacional incluyendo el IVA")//class="v"
									->setCellValue('W9',"Ventas sin derecho a credito IVA")//class="v"
					
									->setCellValue('X9',"Ventas Exentas")//class="v"
									->setCellValue('Y9',"Ventas Exoneradas")//class="v"
									->setCellValue('Z9',"Ventas no Sujetas")//class="v"
									->setCellValue('AA9',"Subtotal B.I. al 12%")//class="v"
									->setCellValue('AB9',"Subtotal B.I. al 8%")//class="v"
									->setCellValue('AC9',"Subtotal B.I. al 27%")//class="v"
									->setCellValue('AD9',"Subtotal B.I. al 12%")//class="v"
									->setCellValue('AE9',"Subtotal B.I. al 8%")//class="v"
									->setCellValue('AF9',"Subtotal B.I. al 27%")//class="v"
									->setCellValue('AG9',"Impuesto IVA")//class="v"
									->setCellValue('AH9',"IVA Retenido")//class="v"
									
									//->setCellValue('AA9',"Impuesto retenido al vendedorIVA")//class="v"
									//->setCellValue('AA9',"Anticipo de IVA (Importacion)")//class="v"
									;
	$objPHPExcel->getActiveSheet()->getStyle('U7:AF8')->applyFromArray($styleArrayT1M);	// ESTILO MENBRETE
	$objPHPExcel->getActiveSheet()->getStyle('A9:AH9')->applyFromArray($styleArrayT1M);	// ESTILO MENBRETE
	
	$objPHPExcel->getActiveSheet()->getStyle('A9')->applyFromArray($styleArrayT1MV);	// ESTILO VERTICAL
	$objPHPExcel->getActiveSheet()->getStyle('E9:H9')->applyFromArray($styleArrayT1MV);	// ESTILO VERTICAL
	$objPHPExcel->getActiveSheet()->getStyle('J9')->applyFromArray($styleArrayT1MV);	// ESTILO VERTICAL
	$objPHPExcel->getActiveSheet()->getStyle('Q9')->applyFromArray($styleArrayT1MV);	// ESTILO VERTICAL
	$objPHPExcel->getActiveSheet()->getStyle('R9')->applyFromArray($styleArrayT1MV);	// ESTILO VERTICAL
	$objPHPExcel->getActiveSheet()->getStyle('U9:AH9')->applyFromArray($styleArrayT1MV);// ESTILO VERTICAL
	
	$objPHPExcel->getActiveSheet()->getStyle('B9:D9')->applyFromArray($styleArrayT1MH);	// ESTILO HORIZONTAL
	$objPHPExcel->getActiveSheet()->getStyle('I9')->applyFromArray($styleArrayT1MH);	// ESTILO HORIZONTAL
	$objPHPExcel->getActiveSheet()->getStyle('K9:P9')->applyFromArray($styleArrayT1MH);	// ESTILO HORIZONTAL
	$objPHPExcel->getActiveSheet()->getStyle('S9:T9')->applyFromArray($styleArrayT1MH);	// ESTILO HORIZONTAL
	
																						// TAMANO POR RANGOS
										//		A8
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4); 					//tamano vertical
										//		F8:L8
	for($columnID='E';$columnID<='H';$columnID++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(4); 			//tamano vertical
	}									
										//		J
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(4); 					//tamano vertical 
										//		Q
	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(4); 					//tamano vertical 
										//		R
	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(4); 					//tamano vertical 
										//		U9:AH9
	for($columnID='U';$columnID!='AH';$columnID++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(4); 			//tamano vertical 
	}
	
										//		B9:D9
	for($columnID='B';$columnID!='D';$columnID++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(12); 			//tamano horizontal
	}
										//		I
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);					//tamano horizontal 
										//		K8:P8
	for($columnID='K';$columnID!='P';$columnID++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(9); 			//tamano horizontal
	}
										//		S: T
	for($columnID='S';$columnID!='T';$columnID++) {
	$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(9); 			//tamano horizontal
	}
	
	//		BODY		//////////////7
	  				//FILA		9 en adelante	
						//CONSULTA DE LAS DEMAS CELDAS CON UN WHILE PARA EL BODY
	//echo date('H:i:s') , " WHILE BD INICIANDO" , EOL;
	//$consulta esta arriba
	  //acumulador
	$acum_msubt_exento_venta = 0;
	
	$acum_msubt_bi_iva_12_n = 0;
	$acum_msubt_bi_iva_8_n = 0;
	$acum_msubt_bi_iva_27_n = 0;
	
	$acum_msubt_bi_iva_12_n_CONTRI = 0;
	$acum_msubt_bi_iva_8_n_CONTRI = 0;
	$acum_msubt_bi_iva_27_n_CONTRI = 0;
	
	$acum_msubt_bi_iva_12_n_NO_CONTRI = 0;
	$acum_msubt_bi_iva_8_n_NO_CONTRI = 0;
	$acum_msubt_bi_iva_27_n_NO_CONTRI = 0;

	$acum_mtot_iva_venta_n = 	0;
	$acum_IN_SDCF_venta_n  =	0;
	$acum_IN_EX_venta_n = 		0;
	$acum_IN_EXO_venta_n  =	0;  
	$acum_IN_NS_venta_n  = 	0;
	
	$acum_msubt_exento_venta_export = 0;
	
	$acum_m_iva_reten = 0;
	$acum_tot_iva = 0;
	//contador de filas
	$it1 = 10;
	// el contador de columnas lo inicializo edentro del EHILE
	//contador de filas
	$nop = 1;
    do{
			//CONSULTAS RELACIONALES
				//consulta las notas si existen 
				$consulta2 = pg_query($conexion,sprintf("SELECT * FROM notas_cd_venta, fact_venta WHERE fact_venta.id_fact_venta = notas_cd_venta.id_fact_venta AND notas_cd_venta.id_fact_venta = '%s'",$filas['id_fact_venta']));
				// $filasConsultaNota = $consultaNota->fetch_assoc();
				$filas2=pg_fetch_assoc($consulta2);
				$total_ConsultaNota = pg_num_rows($consulta2);
				/////		FACTURA TOTALES EXPORTACIONES
			if($filas['nplanilla_export'] !== ""){
				$msubt_exento_venta_export = round($filas['mtot_iva_venta'],2);
				/////////////////////////////////////////////
				$mtot_iva_venta_n = 0;
				$msubt_tot_bi_venta_n = 0;
				$msubt_bi_iva_12_n = 0;
				$msubt_bi_iva_8_n = 0;
				$msubt_bi_iva_27_n = 0;
				//ACUMULADORES
				$acum_msubt_exento_venta_export = $acum_msubt_exento_venta_export + round($filas['msubt_exento_venta'],2);
			/////		FACTURA TOTALES EXPORTACIONES	
			}elseif($filas['nplanilla_export'] == ""){
				$msubt_exento_venta_export = 0;
				
				//////////////////////////////////////////7
				$mtot_iva_venta_n = round($filas['mtot_iva_venta'],2);
					//las excentas ya estan hechas por una funcion ya que estas son desglozadas
				$msubt_tot_bi_venta_n = round($filas['msubt_tot_bi_venta'],2);
				$msubt_bi_iva_12_n = round($filas['msubt_bi_iva_12'],2);
				$msubt_bi_iva_8_n = round($filas['msubt_bi_iva_8'],2);
				$msubt_bi_iva_27_n = round($filas['msubt_bi_iva_27'],2);
				//ACUMULADORES
				if($filas['tipo_contri'] !== "NO_CONTRI"){
					$acum_msubt_bi_iva_12_n_NO_CONTRI = $acum_msubt_bi_iva_12_n + round($filas['msubt_bi_iva_12'],2);
					$acum_msubt_bi_iva_8_n_NO_CONTRI = $acum_msubt_bi_iva_8_n + round($filas['msubt_bi_iva_8'],2);
					$acum_msubt_bi_iva_27_n_NO_CONTRI = $acum_msubt_bi_iva_27_n + round($filas['msubt_bi_iva_27'],2);
				}elseif($filas['tipo_contri'] == "NO_CONTRI"){
					$acum_msubt_bi_iva_12_n_CONTRI = $acum_msubt_bi_iva_12_n + round($filas['msubt_bi_iva_12'],2);
					$acum_msubt_bi_iva_8_n_CONTRI = $acum_msubt_bi_iva_8_n + round($filas['msubt_bi_iva_8'],2);
					$acum_msubt_bi_iva_27_n_CONTRI = $acum_msubt_bi_iva_27_n + round($filas['msubt_bi_iva_27'],2);
				}
					$acum_msubt_bi_iva_12_n = $acum_msubt_bi_iva_12_n + round($filas['msubt_bi_iva_12'],2);
					$acum_msubt_bi_iva_8_n = $acum_msubt_bi_iva_8_n + round($filas['msubt_bi_iva_8'],2);
					$acum_msubt_bi_iva_27_n = $acum_msubt_bi_iva_27_n + round($filas['msubt_bi_iva_27'],2);
				
				$acum_msubt_exento_venta_export = $acum_msubt_exento_venta_export + round($filas['msubt_exento_venta'],2);
				
				$acum_mtot_iva_venta_n = 	$acum_mtot_iva_venta_n + round($filas['mtot_iva_venta'],2);
				$acum_IN_SDCF_venta_n  =	$acum_IN_SDCF_venta_n + sumSinIVAventas($filas['id_fact_venta'], 'IN_SDCF');
				$acum_IN_EX_venta_n = 		$acum_IN_EX_venta_n + sumSinIVAventas($filas['id_fact_venta'], 'IN_EX');
				$acum_IN_EXO_venta_n  =	$acum_IN_EXO_venta_n +  sumSinIVAventas($filas['id_fact_venta'], 'IN_EXO');
				$acum_IN_NS_venta_n  = 	$acum_IN_NS_venta_n + sumSinIVAventas($filas['id_fact_venta'], 'IN_NS');
			}
			$acum_msubt_exento_venta = $acum_msubt_exento_venta + round($filas['msubt_exento_venta'],2);
			$acum_m_iva_reten = $acum_m_iva_reten + round($filas['m_iva_reten'],2);
			$acum_tot_iva = $acum_tot_iva + round($filas['tot_iva'],2);

		//////////////////////7			IMPRESION DE LOS DATOS
		// //contador de columnas
		$jt1 = 'A';// INICIALIZO LAS COLUMNAS EN A
						//<!--Numero de Operqciones-->
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($jt1.$it1, $nop++)
    					//<!--FACTURA-->
											->setCellValue(++$jt1.$it1, fechaInver($filas['fecha_fact_venta']));
    					//<!--CLIENTE-->

		if($total_consulta <= 0)
			$nombreR = "*** Sin Actividad Comercial ***";
		else 
			$nombreR = $filas['nom_cliente'];
		$condRif = condRif($filas['ced_cliente']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $filas['ced_cliente'])
											->setCellValue(++$jt1.$it1, $nombreR)
											->setCellValue(++$jt1.$it1, $condRif);//<!--TIPO DE CLIENTE-->
							//<!--FACTURA EXPORTACIPONES-->
		$fechaInver2 = fechaInver($filas['fechaduana_export']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $filas['nplanilla_export'])
											->setCellValue(++$jt1.$it1, $filas['nexpe_export'])
											->setCellValue(++$jt1.$it1, $filas['naduana_export'])
											->setCellValue(++$jt1.$it1, $fechaInver2)
							//<!--FACTURA-->
											->setCellValue(++$jt1.$it1, $filas['serie_fact_venta'])
											->setCellValue(++$jt1.$it1, $filas['num_fact_venta'])
											->setCellValue(++$jt1.$it1, $filas['num_ctrl_factventa'])
							//<!--registro z-->
											->setCellValue(++$jt1.$it1, $filas['reg_maq_fis'])
											->setCellValue(++$jt1.$it1, $filas['num_repo_z'])
											;
							//<!--FACTURA NOTA CREDITO-->
							$notas_credito = "";
							if($total_consulta > 0)
								{ 
									do{
										if($filas2['tipo_notas_cd_venta'] == 'NC')
											$notas_credito = $notas_credito . $filas2['num_notas_cd_venta'].",";
									}while($filas2 = pg_fetch_assoc($consulta2));
								}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $notas_credito);
							//<!--FACTURA NOTA DEBITO-->
							$notas_debito = "";
							if($total_consulta > 0)
							{ 
								do{
									if($filas2['tipo_notas_cd_venta'] == 'ND')
										$notas_debito = $notas_debito . $filas2['num_notas_cd_venta'].",";
								}while($filas2 = pg_fetch_assoc($consulta2));
							}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $notas_debito);									
							//<!--FACTURA RETENCION QUE Y A QUIEN-->
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $filas['tipo_trans']);
		$fechaInver1 = fechaInver($filas['fecha_compro_reten']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $filas['num_compro_reten'])
											->setCellValue(++$jt1.$it1,  $fechaInver1)
		;
							//NOTA DE DEBITO CREDITO
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $filas['nfact_afectada']);
							//<!--FACTURA TOTALES IMPORTACIONES-->
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $msubt_exento_venta_export);
							//<!--FACTURA TOTALES NACIONALES-->
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $mtot_iva_venta_n)
											->setCellValue(++$jt1.$it1, sumSinIVAventas($filas['id_fact_venta'], 'IN_SDCF'))
											->setCellValue(++$jt1.$it1, sumSinIVAventas($filas['id_fact_venta'], 'IN_EX') )
											->setCellValue(++$jt1.$it1, sumSinIVAventas($filas['id_fact_venta'], 'IN_EXO') )
											->setCellValue(++$jt1.$it1, sumSinIVAventas($filas['id_fact_venta'], 'IN_NS') )
		;
		$msubt_bi_iva_12_nacion = 0;
		$msubt_bi_iva_8_nacion = 0;
		$msubt_bi_iva_27_nacion = 0;
			
		if($filas['tipo_contri'] !== "NO_CONTRI")
		{
			$msubt_bi_iva_12_nacion_CONTRI = round($filas['msubt_bi_iva_12'],2);
			$msubt_bi_iva_8_nacion_CONTRI = round($filas['msubt_bi_iva_8'],2);
			$msubt_bi_iva_27_nacion_CONTRI = round($filas['msubt_bi_iva_27'],2);
			
			$msubt_bi_iva_12_nacion_NO_CONTRI = 0;
			$msubt_bi_iva_8_nacion_NO_CONTRI = 0;
			$msubt_bi_iva_27_nacion_NO_CONTRI = 0;
		}else{
			$msubt_bi_iva_12_nacion_NO_CONTRI = round($filas['msubt_bi_iva_12'],2);
			$msubt_bi_iva_8_nacion_NO_CONTRI = round($filas['msubt_bi_iva_8'],2);
			$msubt_bi_iva_27_nacion_NO_CONTRI = round($filas['msubt_bi_iva_27'],2);
			
			$msubt_bi_iva_12_nacion_CONTRI = 0;
			$msubt_bi_iva_8_nacion_CONTRI = 0;
			$msubt_bi_iva_27_nacion_CONTRI = 0;
		}
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $msubt_bi_iva_12_nacion_CONTRI)
											->setCellValue(++$jt1.$it1, $msubt_bi_iva_8_nacion_CONTRI)
											->setCellValue(++$jt1.$it1, $msubt_bi_iva_27_nacion_CONTRI)
		;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, $msubt_bi_iva_12_nacion_NO_CONTRI)
											->setCellValue(++$jt1.$it1, $msubt_bi_iva_8_nacion_NO_CONTRI)
											->setCellValue(++$jt1.$it1, $msubt_bi_iva_27_nacion_NO_CONTRI)
		;
							//<!--monto total de impuesto IVA-->
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(++$jt1.$it1, round($filas['tot_iva'],2))
							//<!--FACTURA TOTALES DE RETENCIONES-->
											->setCellValue(++$jt1.$it1, round($filas['m_iva_reten'],2))
		;
		++$it1;//in cremento fials
	}while($filas=pg_fetch_assoc($consulta));
	//////////////////////////////////
	// FOR PARA AJUSTAR SOLO LOS ELEMENTOS LLENOS
	//////////////////////////////////
	++$jt1;//para que sea AH
	$vectNoColum = array ('A','E','F','G','H','J','Q','R','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH');
	for($fila = 10; $fila <= $it1; $fila++){//AH 10
		for($columna='A';$columna!= $jt1;$columna++){
			for($numCol='0';$numCol<count($vectNoColum);$numCol++){
				if($columna == $vectNoColum[$numCol]){
					$valCelda = $objPHPExcel->getActiveSheet()->getCell($columna.$fila)->getValue();
					if(strlen($valCelda) >=4 ){
						$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setAutoSize(true);// 	AJUSTAR HORIZONTAL
					}
				}
			}
			
		}
	}
	for($fila = 10; $fila <= $it1; $fila++){//AH 10
		for($columnID='U';$columnID!='AI';$columnID++) {
			$objPHPExcel->getActiveSheet()->getStyle($columnID)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		}
	}
	//echo date('H:i:s') , " WHILE BD TERMINANDO" , EOL;
	//dandole estilo al cuerpo de la tabla 1
	$itb1 = $it1;
	$objPHPExcel->getActiveSheet()->getStyle('A10:AH'.--$itb1)->applyFromArray($styleArrayT1B);	// ESTILO BODY
	$jt2 = "A";
	$it2 = $it1;
	
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
	$objPHPExcel->getActiveSheet()		->mergeCells($jt2.$it2.":".expo_var($jt2, 20).$it2);
	//////////////////////////////////7
	//		EXPORTACIONES
	/////////////////////////////////////						
	//								TOTAL DE EXPORTACIONEZS
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,21).$it2,$acum_msubt_exento_venta_export);		//		FILA 1
	//////////////////////////////////7
	//		NACIONALES
	////////////////////////////////////
	//								TOTAL DE DE VENTAS NACIONALES INCLUYENDO EL IVA
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,22).$it2,$acum_mtot_iva_venta_n);		//		FILA 1
	
	//								TOTALES DE VENTAS SIN DERECHO A CREDITO IVA
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,23).$it2,$acum_IN_SDCF_venta_n);		//		FILA 1
	
	//								TOTAL DE VENTAS EXENTAS
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,24).$it2,$acum_IN_EX_venta_n);		//		FILA 1
	
	//								TOTAL DE VENTAS EXONERADAS
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,25).$it2,$acum_IN_EXO_venta_n);		//		FILA 1
	
	//								TOTAL DE VENTAS NO SUJETAS
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,26).$it2,$acum_IN_NS_venta_n);		//		FILA 1
	
	
	//								total  SUBTOTAL AL 12 NO CONTRIBUYENTE
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,27).$it2, $acum_msubt_bi_iva_12_n_NO_CONTRI);		//		FILA 1
	
	//								TOTAL  SUBTOTAL 8	NO CONTRIBUYENTE
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,28).$it2, $acum_msubt_bi_iva_8_n_NO_CONTRI);		//		FILA 1
	
	//								TOTALES  SUBTOTAL AL 27 NO  CONTRIBUYENTE
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,29).$it2, $acum_msubt_bi_iva_27_n_NO_CONTRI);		//		FILA 1
	
	
		//								total  SUBTOTAL AL 12 CONTRIBUYENTE
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,30).$it2, $acum_msubt_bi_iva_12_n_CONTRI);		//		FILA 1
	
	//								TOTAL  SUBTOTAL 8 CONTRIBUYENTE
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,31).$it2, $acum_msubt_bi_iva_8_n_CONTRI);		//		FILA 1
	
	//								TOTALES  SUBTOTAL AL 27  CONTRIBUYENTE
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,32).$it2, $acum_msubt_bi_iva_27_n_CONTRI);		//		FILA 1

	//								TOTAL DE IMPUESTO IVA
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,33).$it2, $acum_tot_iva);		//		FILA 1
	
	//								TOTAL DE IVA RETENIDO
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,34).$it2, $acum_m_iva_reten);		//		FILA 1
	
	
	//////////////////////////////////////
	//		ESTILOS
	////////////////////////////////////
	$objPHPExcel->getActiveSheet()->getStyle($jt2.$it2.":".expo_var($jt2, 34).$it2)->applyFromArray($styleArrayTot);
	
	/////////////////////////////////////////////////////			
	//		TABLA 2
	// RESUMEN DE LA VENTAS
	// ESTA ES LA ULTIMA FILA QUE QUEDO			$it1
	// ESTA COLUMNA VUELVE A EMPEZAR			$jt1
	
	$it2 = $it1+3;// LE SUME 3 POR EL ESPACIO ENTRE LAS TABLAS
	
	//			HEADER
	// Incremento 5 letras mas para la celda del HEADRE larga para la tabla 2
	
	
	
										//$it2_q_estaba = $it2;// HAY MAS COLUMNAS GUARDO EL VALOR DE LA FILA	
	$mesNum_Texto2 = mesNum_Texto($mes);
	
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2,"RESUMEN DE VENTAS DEl MES DE ".$mesNum_Texto2);		//		FILA 1
	$objPHPExcel->getActiveSheet()		->mergeCells($jt2.$it2.":".expo_var($jt2, 21).$it2);						// OCUPA 5 COLUMNAS
		$it2hi = $it2;//inicializando header
		++$it2;																										//		FILA 2
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Descripción");								
	$objPHPExcel->getActiveSheet()		->mergeCells($jt2.$it2.":".expo_var($jt2, 11).expo_var($it2, 2))			// OCUPA 11 COL 2 FILAS
									->setCellValue(expo_var($jt2, 12).$it2, "Base Imponible")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 4 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "Debito Fiscal")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 21).$it2);			// OCUPA 2 COLUMNAS
		++$it2;																										//		FILA 3
	$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2, 12).$it2, "Item")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 14).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 15).$it2, "Monto")
										->mergeCells(expo_var($jt2, 15).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "Item")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 19).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 20).$it2, "Monto")
										->mergeCells(expo_var($jt2, 20).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	;
		$it2hf = $it2;
		++$it2;
		$it2bi = $it2;//inicializando cuerpo																										//		FILA 4
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Ventas Internas No Gravadas")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "40")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 14).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 15).$it2, round($acum_msubt_exento_venta,2))
										->mergeCells(expo_var($jt2, 15).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "-")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 19).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 20).$it2, "-")
										->mergeCells(expo_var($jt2, 20).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	;
		++$it2;												
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Ventas de Exportaci&oacute;n")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "41")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 14).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 15).$it2, round($msubt_exento_venta_export,2))
										->mergeCells(expo_var($jt2, 15).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "-")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 19).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 20).$it2, "-")
										->mergeCells(expo_var($jt2, 20).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	; 
		++$it2;																										//		FILA 6
	$msubt_iva_12 = $acum_msubt_bi_iva_12_n * 0.12;
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Ventas Internas o Nacionales Gravadas por Alicuota General 12%")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "42")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 14).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 15).$it2, round($acum_msubt_bi_iva_12_n,2))
										->mergeCells(expo_var($jt2, 15).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "43")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 19).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 20).$it2, round($msubt_iva_12,2))
										->mergeCells(expo_var($jt2, 20).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	; 
 
		++$it2;																										//		FILA 8
	$msubt_iva_27 = $acum_msubt_bi_iva_27_n * 0.27;
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Ventas Internas o Nacionales Gravadas por Alicuota General mas Alicuota Adicional 27%")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "442")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 14).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 15).$it2, round($acum_msubt_bi_iva_27_n,2))
										->mergeCells(expo_var($jt2, 15).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "452")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 19).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 20).$it2, round($msubt_iva_27,2))
										->mergeCells(expo_var($jt2, 20).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	; 
		++$it2;																										//		FILA 9
	$msubt_iva_8 = $acum_msubt_bi_iva_8_n * 0.08;
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Ventas Internas o Nacionales Gravadas por Alicuota Reducida 8%")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "333")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 14).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 15).$it2, round($acum_msubt_bi_iva_8_n,2))
										->mergeCells(expo_var($jt2, 15).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "343")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 19).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 20).$it2, round($msubt_iva_8,2))
										->mergeCells(expo_var($jt2, 20).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
	; 
		++$it2;		
																										//		FILA 11
	$tot_v	=		$acum_msubt_exento_venta + $acum_msubt_bi_iva_12_n + $acum_msubt_bi_iva_27_n +  $acum_msubt_bi_iva_8_n;
	$tot_iva_v =	$msubt_iva_12 + $msubt_iva_27 + $msubt_iva_8;
	
	$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2, "Total Ventas y Debitos Fiscales para Efectos de Determinacion:")
										->mergeCells($jt2.$it2.":".expo_var($jt2, 11).$it2)							// OCUPA 5 COLUMNAS
									->setCellValue(expo_var($jt2, 12).$it2, "46")
										->mergeCells(expo_var($jt2, 12).$it2.":".expo_var($jt2, 14).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 15).$it2, round($tot_v,2))
										->mergeCells(expo_var($jt2, 15).$it2.":".expo_var($jt2, 16).$it2)			// OCUPA 2 COLUMNAS
									->setCellValue(expo_var($jt2, 17).$it2, "47")
										->mergeCells(expo_var($jt2, 17).$it2.":".expo_var($jt2, 19).$it2)			// OCUPA 3 COLUMNAS
									->setCellValue(expo_var($jt2, 20).$it2, round($tot_iva_v,2))
										->mergeCells(expo_var($jt2, 20).$it2.":".expo_var($jt2, 21).$it2)			// OCUPA 2 COLUMNAS
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
    $objPHPExcel->getActiveSheet()->setTitle('Reporte_Ventas');
    
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    //	CREACION DEL NOMBRE DEL ARCHIVO
	$url_archivo = $filas['url_report'];
	/*
	// Save Excel 2007 file
	//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
	$callStartTime = microtime(true);
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	if(file_exists($url_archivo)){
		$nombre_archivo = 'reporte_ventas_'.$mes;
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
			
		$nombre_archivo = 'reporte_ventas_'.$mes;
		
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
		$nombre_archivo = 'reporte_ventas_'.$mes;
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
		
		$nombre_archivo = 'reporte_ventas_'.$mes;
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
		$nombre_archivo = 'reporte_ventas_'.$mes.'.xlsx';
	//$file ="excel_compras.xlsx";	
	
	
	//PHP en general
	  
	
	header("Content-type: application/vnd.ms-excel"); 
	header("Content-Disposition: attachment; filename=\"$nombre_archivo\"\n");
	header("Pragma: no-cache");
header("Expires: 0");
	//readfile($file);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');

}// este es de las consultas de arriba si son exitosa 
?>
