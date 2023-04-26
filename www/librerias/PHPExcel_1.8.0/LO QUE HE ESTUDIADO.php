
<?php 
////////////////////////////////////////////////////////////////////
//			NOTAS IMPORTANTES

//se puede inicializar con un ancho especifico y luego ajustarlo con una celda con el ancho que le corresponde

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('H1')->setWidth(5); //ajustar la celda pero al al horizontal
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('H2')->setAutoSize(true); //ajustar la celda pero al al horizontal

//tamano horizontal por rangos
foreach(range('F','L') as $columnID) {//
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($columnID."8")->setWidth(5); //tamano horizontal
	}
//////////////////////////////////////////////////////////////////

//DATOS DEL DOCUMENTO
								//ESCALA
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale('80');
								//ORIENTACION DE LA HOJA
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
								//TIPO CARTA
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

								
								//HEADER AND FOOTER
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&HPlease treat this document as confidential!');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
				
//STILOS
								//AJUSTE ALTURA ANCHURA CELDAS
 $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40); 
//Puedes usar
 $objWorksheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
 $objWorksheet->getActiveSheet()->getColumnDimension('A')->setWidth(100); 
 //o definir de auto-size:
 $objWorksheet->getRowDimension('1')->setRowHeight(-1); 
 //								AUTO AUJUSTE DE ALTO ANCHO FILAS O COLUMNAS
$objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);								
								
//								ORIENTACION DEL TEXTO
$objPHPExcel->getActiveSheet()->getStyle('B7')->getAlignment()->setTextRotation(90);								
	//							HOJDA DE ESTILOS PARA VARIAS CELDAS
$styleArray = array(
	'font' => array(
		'bold' => true
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	),
	'borders' => array(
		'top' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
		),
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
		'rotation' => 90,
		'startcolor' => array(
			'argb' => 'FFA0A0A0',
		),
		'endcolor' => array(
			'argb' => 'FFFFFFFF',
		),
	),
	
);
$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FF0000'),
        'size'  => 15,
        'name'  => 'Verdana'
    ));
$objPHPExcel->getActiveSheet()->getStyle('B3:B7')->applyFromArray($styleArray);
//								COLOR A MULTIPLES CELDAS
$objPHPExcel->getActiveSheet()->getStyle('B3:B7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
//								ALINEAMDO MULTIPLES CELDAS
$objPHPExcel->getActiveSheet()->getStyle('A10:A'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
//								BORDER
$objPHPExcel->getActiveSheet()->getStyle('B2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$styleArrayTCH = array(
	'font' => array(
		'bold' => true,
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
	),
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
		),
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
		'rotation' => 180,
		'startcolor' => array(
			'argb' => 'FFA0A0A0',
		),
		'endcolor' => array(
			'argb' => 'FFFFFFFF',
		),
	),
);

//								COLOR
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
//								ALINEACION TEXTO
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

//							MARGENES
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1);
	//							NUMEROS
$objPHPExcel->getActiveSheet()->getStyle('C9')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
$objPHPExcel->getActiveSheet()->getStyle('C10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);
$objPHPExcel->getActiveSheet()->getStyle('C11')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIME);
//								AUTO TAMAO
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
//4.6.31.	Setting a row's height
//A row's height can be set using the following code:
$objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(100);
//								FONT
$objPayable->getFont()->setBold(true);
$objPayable->getFont()->setItalic(true);
$objPayable->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_DARKGREEN ) );

//			LLENADO CON UN FOR DE LETRAS PARA LAS CELDAS
$valor_fila8 = array('','','','','','','','','','','','','','','','','','','','','','','','',
					 '','','','','','','','','','','','','','','','');
//vector de la fila del header
	$i=0;//contador de las filas para el vector
   foreach (range('A', 'AH') as $letra){
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($letra.'8', $valor_fila8[$i]);
		$i++;//incremente el numeri del vector valor celda
   }
   for ($row = 1; $row <= 10; $row++) {
    $objPHPExcel->getActiveSheet()
        ->setCellValue(
            'J' . $row,
            '=SUM(A'.$row.':C'.$row.')/10 + SUM(D'.$row.':F'.$row.')/20 + SUM (G'.$row.':I'.$row.')/60'
        );
}
?>