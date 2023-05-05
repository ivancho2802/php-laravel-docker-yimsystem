<?php
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
if(strpos($uri, 'modulos'))
	$extra = '/../../';
else
	$extra = '/';
///////////////////////////////////////////////////////////////////////////////////
//			FUNCIONES
////////////////////////////////////////////////////////////////////////////////////
include_once($extra."librerias/conexion.php");
/////////////////////////////////////////////////////////////
include_once($extra.'php/funciones.php');
/////////////////////////////////////////////////////////////
include_once('../../includes_SISTEM/include_login.php');
/////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////				CONSULTAS SQL
	//consulta de los datos de la empreas PARA SABE LA ACTIVA 
	$consulta = pg_query($conexion,"SELECT * FROM empre WHERE empre.est_empre = '1'");
	// $filas = pg_fetch_assoc($consultaEmpre);
	$filas=pg_fetch_assoc($consulta);
	$total_consultaEmpre = pg_num_rows($consulta);
	//	CONSULTA DE TODO LO QUE HAY EN EL INVENTARIO PARA MOSTRARLO JUNTO CON SU MOVIMIN¿ENTO
	$consulta2=pg_query($conexion,sprintf("SELECT * FROM inventario WHERE 1=1 ORDER BY codigo"));
	// $filas_inventario=$sql_inventario->fetch_assoc();
	$filas2=pg_fetch_assoc($consulta2);
	$total_inventario = pg_num_rows($consulta2);


if (isset($_POST['mes']) || isset($_POST['ano']) || (isset($_POST['fechai']) && isset($_POST['fechaf'])) || isset($_POST['dia']) ){
	//validando que la fecha o ano que se introduzca no sea menor al menor del sistema
	/*SELECT fact_compra.fecha_fact_compra AS fecha FROM fact_compra
	UNION
	SELECT fact_venta.fecha_fact_venta AS fecha FROM fact_venta
	UNION
	SELECT inventario_retiros.fecha_inv_retiros AS fecha FROM inventario_retiros
	UNION
	SELECT reg_inventario.fecha_reg_inv AS fecha FROM reg_inventario
	ORDER BY fecha ASC*/
	$consulta3=pg_query($conexion,sprintf("SELECT fact_compra.fecha_fact_compra AS fecha FROM fact_compra
	UNION
	SELECT fact_venta.fecha_fact_venta AS fecha FROM fact_venta
	UNION
	SELECT inventario_retiros.fecha_inv_retiros AS fecha FROM inventario_retiros
	UNION
	SELECT reg_inventario.fecha_reg_inv AS fecha FROM reg_inventario
	ORDER BY fecha ASC"));
	// $filas3 = $sql_fecha_menor->fetch_assoc();
	$filas3=pg_fetch_assoc($consulta3);
	$total_fecha_menor = pg_num_rows($consulta3);
	
	//completando con ano y/o mes la fecha
	if(isset($_POST['mes'])){
		$mes = $_POST['mes'];
		$fechai = $mes."-01";
		$fechaf = ($mes=='02')? $mes."-28":((int) $mes%2==0) ? $mes."-31" : $mes."-30";
		//echo $filas3['fecha'];
		
	}elseif(isset($_POST['ano'])){
		$ano = $_POST['ano'];
		if ($ano >= substr($filas3['fecha'],0,4))
			$fechai = $filas3['fecha'];
		else
			$fechai = "errorano";
		$fechaf = $ano."-12-31";
	}elseif(isset($_POST['fechai']) && isset($_POST['fechaf'])){
		$fechai = $_POST['fechai'];
		$fechaf = $_POST['fechaf'];
	}elseif(isset($_POST['dia']) ){
		$dia = $_POST['dia'];
		if ($dia >= $filas3['fecha']){
			$fechai = $_POST['dia'];
			$fechaf = $_POST['dia'];
		}else 
			$fechai = "errorano";
	}
	
	if($fechai == "errorano" || $fechai < $filas3['fecha'])//para AÑO o mes y 
	{
		echo "Error con la fecha debe ser mayor a mes de ".mesNum_Texto($filas3['fecha']);
	}else{
		/////////////////////////////
		//	TABLA DE LA CONSULT6A
		///////////////////////////
		//	INICIALIZACION DE LAS LIBRERIAS DEL EXCEL
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
		$objPHPExcel->getActiveSheet()->getPageSetup()->setScale('80');
		//								TIPO CARTA
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
		//		HEADER Y			FOOTER
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('Reporte Movimiento de Unidades Fecha de Exportación: '.date('d/m/Y'));
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
		////////////////////////////////////////////////
		//		MENBRETE 		TABLA1	
		//////////////////////////////////////////////////7			metodo para obtener el mes con la fecha	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Reporte Movimiento de Unidades')->mergeCells('A1:O1')
											->setCellValue('A2', $filas['titular_rif_empre']." - ". $filas['nom_empre'])->mergeCells('A2:O2')
											->setCellValue('A3', 'N.I.T./R.I.F.:'.$filas['rif_empre'])->mergeCells('A3:O3')
											->setCellValue('A4', 'Dirección: '.$filas['dir_empre'])->mergeCells('A4:O4')
											->setCellValue('A5', 'Contribuyente: '.$filas['contri_empre'])->mergeCells('A5:O5')
											->setCellValue('A6', 'Telefono: '.$filas['tel_empre'])->mergeCells('A6:O6')
											->setCellValue('A7', 'Clasificacion ')->mergeCells('A7:O7')
											->setCellValue('A8', 'Activos: Todos ')->mergeCells('A8:O8')
											->setCellValue('A9', 'Fecha Desde: '.fechaInver( $fechai))->mergeCells('A9:O9')
											->setCellValue('A10','Fecha Hasta: '.fechaInver( $fechaf))->mergeCells('A10:O10')
											->setCellValue('A11','MOVIMIENTO DE UNIDADES')->mergeCells('A11:O11')
											->setCellValue('A12','Según el artículo N° 177 Ley de Impuesto Sobre la Renta')->mergeCells('A12:O12')
											;
		$objPHPExcel->getActiveSheet()->getStyle('A1:O12')->applyFromArray($styleArrayT1H);// ESTILO
		//		HEADER		//////////////
							//FILA		7
		$objPHPExcel->getActiveSheet()		->setCellValue('C13',"Existencia Inicial")->mergeCells('C13:E13')
											->setCellValue('F13',"Entradas")->mergeCells('F13:G13')
											->setCellValue('H13',"Salidas")->mergeCells('H13:I13')
											->setCellValue('J13',"Auatoconsumos")->mergeCells('J13:K13')
											->setCellValue('L13',"Retiros")->mergeCells('L13:M13')
											->setCellValue('N13',"Existecia Inicial")->mergeCells('N13:O13')
		
		;
		$objPHPExcel->getActiveSheet()->getStyle('C13:O13')->applyFromArray($styleArrayT1M);// ESTILO 
							//FILA		8
							
		$objPHPExcel->getActiveSheet()	->setCellValue('A14',"Codigo")//c
										->setCellValue('B14',"Nombre ó Descripción")//c
										->setCellValue('C14',"Costo Unitario")//
										->setCellValue('D14',"Cantidad")//
										->setCellValue('E14',"Monto")//<!--ETRADAS-->
										->setCellValue('F14',"Cantidad")//
										->setCellValue('G14',"Monto")//
										->setCellValue('H14',"Cantidad")// <!--SALIDAS-->
										->setCellValue('I14',"Monto")//
										->setCellValue('J14',"Cantidad")//<!--AUTOCUNSUMOS-->
										->setCellValue('K14',"Monto")//
										->setCellValue('L14',"Cantidad")//<!--RETIROS-->
										->setCellValue('M14',"Monto")//
										->setCellValue('N14',"Cantidad")//<!--INVENTARIUO ACTUAL-->
										->setCellValue('O14',"Monto")//
										;
		$objPHPExcel->getActiveSheet()->getStyle('A14:O14')->applyFromArray($styleArrayT1M);	// ESTILO MENBRETE
		
		
		//				ESTILOS DE LOS RESULTADOS
											//		F8:L8
		for($columnID='A';$columnID<='O';$columnID++) {
		$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(4); 			//tamano horizontal
		}
		/*									//		F8:L8
		for($columnID='R';$columnID!='AJ';$columnID++) {
		$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(4); 			//tamano horizontal
		}
		*/									//		B8:E8										FORMATO NUM
		
		for($columnID='A';$columnID!='O';$columnID++) {
		$objPHPExcel->getActiveSheet()->getStyle($columnID)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		}	
		//		BODY		//////////////
		$acum_miicu = 0;
		$acum_miic 	= 0;
		$acum_miim	= 0;
		$acum_mcc	= 0;
		$acum_mcm	= 0;
		$acum_mvc	= 0;
		$acum_mvm	= 0;
		$acum_mirc	= 0;
		$acum_mirm	= 0;
		$acum_mifc	= 0;
		$acum_mifm	= 0;
		$it1 = 15;//LAS FILAS DESDE
		do{
			$inv_cod = $filas2["codigo"];////////FORMATO c_cv_inventario($codigoInv, $fechi, $fechaf, $accion);
			
			$jt1 = 'A';// INICIALIZO LAS COLUMNAS EN A
			
			$acum_miicu = $acum_miicu 	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "miicu");
			$acum_miic 	= $acum_miic 	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "miic");
			$acum_miim	= $acum_miim	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "miim");
			$acum_mcc	= $acum_mcc		+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mcc");
			$acum_mcm	= $acum_mcm		+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mcm");
			$acum_mvc	= $acum_mvc		+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mvc");
			$acum_mvm	= $acum_mvm		+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mvm");
			$acum_mirc	= $acum_mirc	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mirc");
			$acum_mirm	= $acum_mirm	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mirm");
			$acum_mifc	= $acum_mifc	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mifc");
			$acum_mifm	= $acum_mifm	+ c_cv_inventario($inv_cod, $fechai, $fechaf, "mifm");
			
			 
			// NO SE VAN A MOSTRAR PRODUCTOS QUE NO TENGAN CANTIDAD DE INVENTARIO INICIAL Y FINAL
			if((c_cv_inventario($inv_cod, $fechai, $fechaf, "miic") == 0 && c_cv_inventario($inv_cod, $fechai, $fechaf, "mifc") == 0)){
				
			}else{
				//////////////////////7			IMPRESION DE LOS DATOS
				
				
				$objPHPExcel->setActiveSheetIndex(0)	->setCellValue($jt1.$it1, $inv_cod)
														->setCellValue(++$jt1.$it1, $filas2["nombre_i"])
														->setCellValue(++$jt1.$it1, c_cv_inventario($inv_cod, $fechai, $fechaf, "miicu"))
														->setCellValue(++$jt1.$it1, c_cv_inventario($inv_cod, $fechai, $fechaf, "miic"))
														->setCellValue(++$jt1.$it1, c_cv_inventario($inv_cod, $fechai, $fechaf, "miim"))
														->setCellValue(++$jt1.$it1, c_cv_inventario($inv_cod, $fechai, $fechaf, "mcc"))
														->setCellValue(++$jt1.$it1, c_cv_inventario($inv_cod, $fechai, $fechaf, "mcm"))
														// EXISTEMNCIA INICIAL
														->setCellValue(++$jt1.$it1, c_cv_inventario($inv_cod, $fechai, $fechaf, "mvc"))
														->setCellValue(++$jt1.$it1, c_cv_inventario($inv_cod, $fechai, $fechaf, "mvm"))
														->setCellValue(++$jt1.$it1, 0)
														->setCellValue(++$jt1.$it1, 0)
														->setCellValue(++$jt1.$it1, c_cv_inventario($inv_cod, $fechai, $fechaf, "mirc"))
														->setCellValue(++$jt1.$it1, c_cv_inventario($inv_cod, $fechai, $fechaf, "mirm"))
														->setCellValue(++$jt1.$it1, c_cv_inventario($inv_cod, $fechai, $fechaf, "mifc"))
														->setCellValue(++$jt1.$it1, c_cv_inventario($inv_cod, $fechai, $fechaf, "mifm"))		
																		
				;
				
				++$it1;//in cremento fials
			}//	IF SI ES 0 0?
	   // }while($filas2 = $consulta2->fetch_assoc());
	   }while($filas2=pg_fetch_assoc($consulta2));
	   
	   	//////////////////////////////////////////////////////////
		//	sumatoria de los resultados		 TOTALES
		//
		//
		////////////////////////////////////////////////////////////
		function expo_var($var, $cant){					
			for($auxi = 1;$auxi != $cant;$auxi++)
				$res_ev = ++$var;
			return $res_ev;
		}
		$it2 = $it1;
		$jt2 = 'A';
		
		$objPHPExcel->getActiveSheet()	->setCellValue($jt2.$it2,"TOTALES:");							//		FILA 1
		$objPHPExcel->getActiveSheet()		->mergeCells($jt2.$it2.":".expo_var($jt2, 2).$it2);
		
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,3).$it2,$acum_miicu);
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,4).$it2,$acum_miic);
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,5).$it2,$acum_miim);
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,6).$it2,$acum_mcc);
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,7).$it2,$acum_mcm);
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,8).$it2,$acum_mvc);
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,9).$it2,$acum_mvm);
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,10).$it2,0);
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,11).$it2,0);
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,12).$it2,$acum_mirc);
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,13).$it2,$acum_mirm);
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,14).$it2,$acum_mifc);
		$objPHPExcel->getActiveSheet()	->setCellValue(expo_var($jt2,15).$it2,$acum_mifm);
     	//////////////////////////////////////
		//		ESTILOS
		////////////////////////////////////
		$objPHPExcel->getActiveSheet()->getStyle($jt2.$it2.":".expo_var($jt2, 15).$it2)->applyFromArray($styleArrayTot);
	   ///////////////////////////////////////////
	   //				ESTILO DE REAJUSTE DEL TEXTO
	   //$vectNoColum = array ('A','F','G','H','I','J','K','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ');
	   ++$jt1;
		for($fila = 13; $fila <= $it1; $fila++){//AI 10
			for($columna='A';$columna!= 'P';$columna++){
				//for($numCol='0';$numCol<count($vectNoColum);$numCol++){
					//if($columna == $vectNoColum[$numCol]){
						$valCelda = $objPHPExcel->getActiveSheet()->getCell($columna.$fila)->getValue();
						if(strlen($valCelda) >=1 ){
							$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setAutoSize(true);// 	AJUSTAR HORIZONTAL
						}
					//}
				//}
			}
		}
		///////////////////////////////////////////////////////////////////////////////				
		///////////////////////////////////////////	///////////////////////////////
		// Rename worksheet
		//echo date('H:i:s') , " Rename worksheet" , EOL;
		$objPHPExcel->getActiveSheet()->setTitle('reporte_movimiento_unidades');
		
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
			$nombre_archivo = 'reporte_movimiento_unidades_'.$fechai.'-'.$fechaf;
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
				
			$nombre_archivo = 'reporte_movimiento_unidades_'.$fechai.'-'.$fechaf;
			
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
			$nombre_archivo = 'reporte_movimiento_unidades_'.$fechai.'-'.$fechaf;
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
			
			$nombre_archivo = 'reporte_movimiento_unidades_'.$fechai.'-'.$fechaf;
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
	$nombre_archivo = 'reporte_movimiento_unidades_'.$fechai.'.xlsx';
	//$file ="excel_compras.xlsx";	
	
	
	//PHP en general
	  
	
	header("Content-type: application/vnd.ms-excel"); 
	header("Content-Disposition: attachment; filename=\"$nombre_archivo\"\n");
	header("Pragma: no-cache");
header("Expires: 0");
	//readfile($file);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');	
	}
	
	
}else echo "NO SE HAN ENVIADO LAS VARIABLES DE FECHA";
?>
