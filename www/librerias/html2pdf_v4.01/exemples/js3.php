<?php
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF
 * Distribué sous la licence LGPL. 
 *
 * @author		Laurent MINGUET <webmaster@html2pdf.fr>
 * 
 * IncludeJS : permet d'inclure du Javascript au format PDF
 * 
 * isset($_GET['vuehtml']) n'est pas obligatoire
 * il permet juste d'afficher le résultat au format HTML
 * si le paramètre 'vuehtml' est passé en paramètre _GET
 */
 	ob_start();
?>
<page>
	<h1>Test de JavaScript 3</h1><br>
	<br>
	Normalement une valeur devrait vous être demandée, puis affichée
</page>
<?php
	$content = ob_get_clean();

	$script = "
var rep = app.response('Donnez votre nom');
app.alert('Vous vous appelez '+rep);
td {
  border-collapse: collapse;
  border: 1px black solid;
}
tr:nth-of-type(5) td:nth-of-type(1) {
  visibility: hidden;
}
.rotate {
  /* FF3.5+ */
  -moz-transform: rotate(-90.0deg);
  /* Opera 10.5 */
  -o-transform: rotate(-90.0deg);
  /* Saf3.1+, Chrome */
  -webkit-transform: rotate(-90.0deg);
  /* IE6,IE7 */
  filter: progid: DXImageTransform.Microsoft.BasicImage(rotation=0.083);
  /* IE8 */
  -ms-filter: 'progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)';
  /* Standard */
  transform: rotate(-90.0deg);
}
";	

	include_once(dirname(__FILE__).'/../html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P','A4','fr', false, 'ISO-8859-15');
		$html2pdf->pdf->IncludeJS($script);
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('js3.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }
	