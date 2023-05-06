<?php
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF
 * Distribu� sous la licence LGPL. 
 *
 * @author		Laurent MINGUET <webmaster@html2pdf.fr>
 * 
 * isset($_GET['vuehtml']) n'est pas obligatoire
 * il permet juste d'afficher le r�sultat au format HTML
 * si le param�tre 'vuehtml' est pass� en param�tre _GET
 */
 	// r�cup�ration du contenu HTML
 	ob_start();
 	include(dirname(__FILE__).'/res/draw.php');
 	$content = ob_get_clean();
	
	// conversion HTML => PDF
	include_once(dirname(__FILE__).'/../html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P','A4','fr', false, 'ISO-8859-15', 10);
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('draw.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }
	