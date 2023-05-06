<?php

/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF
 * Distribué sous la licence LGPL. 
 *
 * @author		Laurent MINGUET <webmaster@html2pdf.fr>
 * 
 * isset($_GET['vuehtml']) n'est pas obligatoire
 * il permet juste d'afficher le résultat au format HTML
 * si le paramètre 'vuehtml' est passé en paramètre _GET
 */
// récupération du contenu HTML
ob_start();
include('res_reporte/reporte_pdf_RetenCompra.php');
$content = ob_get_clean();
//		SCRIPT
/*
	$script = "
$('.rotate').css('height', $('.rotate').width());
	";
	*/
// conversion HTML => PDF
include_once('../librerias/html2pdf_v4.01/html2pdf.class.php');
try {
	$html2pdf = new HTML2PDF('L', 'Legal', 'es', false, 'ISO-8859-15', 5);
	$html2pdf->pdf->IncludeJS('js/funciones.js');
	//$html2pdf->pdf->IncludeJS($script);
	$html2pdf->pdf->SetDisplayMode('fullpage');
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('reporte_compro_reten.pdf');
} catch (HTML2PDF_exception $e) {
	echo $e;
}
