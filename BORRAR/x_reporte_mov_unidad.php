<?php
$conexion=mysql_connect("localhost","root","");
$conectado=mysql_select_db("panaderia");


require("librerias/html2pdf_v4.01/html2pdf.class.php");
$objPDF=new HTML2PDF;

$idInventario=$_GET["id"]; 
$sql="select * from inventario where id='$idInventario'";
$ok=mysqli_query($conexion,$sql); 
$datos=mysql_fetch_assoc($ok); 
  
 
  $tabla="<page backtop='30mm' backleft='20mm'>
  <page_header><img src='imagenes/banner_pdf.jpg'></page_header>
<table width='436' border='0' align='center' class='tabla1'>
    <tr>
      <td colspan='2' class='titulo' align='center'>Inventario</td>
    </tr>
    <tr>
      <td width='151'>Código del Producto:</td>
      <td width='275'><label for='nombre'></label>
     $datos[id]</td>
    </tr>
    <tr>
      <td width='151'>Nombre del Producto:</td>
      <td width='275' id='nom_pro'> 
     $datos[nombre]</td>
    </tr>
    <tr>
      <td>Descripción del Producto:</td>
      <td>
      $datos[descripcion]</td>
    </tr>
    
    <tr>
      <td>Cant Min:</td>
      <td>
      $datos[cant_min]</td>
    </tr>
    <tr>
      <td>Cant. Max:</td>
      <td>
      $datos[cant_max]</td>
    </tr>
    <tr>
      <td>Stock:</td>
      <td>
      $datos[stock]</td>
    </tr>
      <tr>
      <td>Valor Unitario:</td>
      <td>
      $datos[valor_unitario]</td>
    </tr>    
  </table>  
</page>";


$objPDF->writeHTML($tabla);
$objPDF->Output("reporte_compra.pdf","D");

?>






 
