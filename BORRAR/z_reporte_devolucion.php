<?php
$conexion=mysql_connect("localhost","root","");
$conectado=mysql_select_db("panaderia");


require("librerias/html2pdf_v4.01/html2pdf.class.php");
$objPDF=new HTML2PDF;

$idDev=$_GET["id"];

$sql="select * from devolucion where id='$idDev'";

$ok=mysqli_query($conexion,$sql); 
$datos=mysql_fetch_assoc($ok); 

	$fk_compra=$datos['fk_compra'];//
	$motivo_devolucion=$datos['motivo_devolucion'];
	$fecha_devolucion=$datos['fecha_devolucion'];
	$cantidad_devuelta=$datos['cantidad_devuelta'];
	$monto_bs=$datos['monto_bs'];
	
	$sql1=mysqli_query($conexion,"select * from compra where id='$fk_compra'");
	$compra=mysql_fetch_assoc($sql1);
	
	$sql2=mysqli_query($conexion,"select * from proveedor where id='$compra[fk_proveedor]'");
	$proveedor=mysql_fetch_assoc($sql2);
	
	$sql3=mysqli_query($conexion,"select * from inventario where id='$compra[fk_inventario]'");
	$producto=mysql_fetch_assoc($sql3);

  
 
  $tabla="<page backtop='30mm' backleft='20mm'>
  <page_header><img src='imagenes/banner_pdf.jpg'></page_header>
  <table width='436' border='0' align='center' class='tabla1'>
    <tr>
      <td colspan='2' class='titulo' align='center'>Datos de la Compra</td>
    </tr>
     <tr>
    <td>Fecha de la Devoluci&oacute;n:</td>
    <td>$fecha_devolucion</td>
    </tr>
    <tr>
      <td width='151'>Nombre del Producto:</td>
      <td width='275'>$producto[nombre] </td>
    </tr>
    <tr>
      <td>Cantidad Devuelta:</td>
      <td><label for='costo'></label>
      $cantidad_devuelta</td>
    </tr>
    
    <tr>
      <td>Monto de Devoluci&oacute;n:</td>
      <td><label for='cantidad'></label>
      $monto_bs</td>
    </tr>
    <tr>
      <td>C&oacute;digo del Proveedor:</td>
      <td><label for='nombre_proveedor'></label>
      $proveedor[id]</td>
    </tr>
     <tr>
      <td width='151'>Nombre del Proveedor:</td>
      <td width='275' id='nom_prov'>$proveedor[nombre]</td>
    </tr>
	<tr>
      <td width='151'>Motivo De Devoluci&oacute;n:</td>
      <td width='275' id='nom_prov'> $motivo_devolucion </td>
    </tr>
</table>
</page>";


$objPDF->writeHTML($tabla);
$objPDF->Output("reporte_compra.pdf","D");

?>