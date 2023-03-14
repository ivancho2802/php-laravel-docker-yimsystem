<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
include_once dirname(__FILE__) . '/../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
//HEADER			FOOTER							 
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&HPlease treat this document as confidential!');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

// Add some data
include_once('../../../funciones_ivan/funciones.php');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', mesNum_Texto("2016-01-01"))
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Helloaaaaaaaaaaaa')
            ->setCellValue('D2', 'worldlkxmfl smd cls!')
			->setCellValue('D3', 'w')
			->setCellValue('H1', 'world!')->mergeCells('H1:I1')
			->setCellValue('H2', 'worldaaaaaaaaa!')
			->setCellValue('F3', 'PRUEEEEEEEEEEBA')
			->setCellValue('F4', 'PRUEEEEEEEEEEEEEEEE')
			->setCellValue('A10', '336219,52')
			;
			$objPHPExcel->getActiveSheet()->getStyle('A10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			//SABER EL VCALOR DE UNA CELDA
//$a = $objPHPExcel->getActiveSheet()->getCell("H1")->getValue();
//echo $a;
$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(40);
//$objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(100); //darle dimension
//$objWorkSheet = $objPHPExcel->createSheet($i);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('20'); //ajustar la celda pero al al horizontal
//$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); //ajustar la celda pero al al horizontal
//$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); //ajustar la celda pero al al horizontal
//$objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1);

$objPHPExcel->getActiveSheet()->getStyle('A10')->getAlignment()->setTextRotation(90);
						
$styleArrayTCH = array(
	'font' => array(
		'bold' => true,
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY
	),
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
		),
	),
);
$styleArrayP = array(
'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '06C'),
        'size'  => 15,
        'name'  => 'Verdana'
));
$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleArrayP);
	
$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($styleArrayTCH);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('F4')->setAutoSize(true); //ajustar la celda pero al al horizontal
//$objPHPExcel->getActiveSheet()->getStyle('A1:B2')->applyFromArray($styleArrayTCH);


// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;