<?php
session_start(); 
if($_SESSION['logeado']!="SI")
{
header("location: index.php?acceso=1 ");
exit;
}
 
?>
<style type="text/css">
div{
	border:0px solid black;
	padding:5px 20px;
	background: #FFFFCC;
	width:250;
	height:auto;
	border-radius:5px 5px 5px 5px;
	-moz-border-radius: 3px 3px 3px 3px;
	box-shadow:5px 2px 20px #888888;
	webkit-box-shadow:5px 2px 20px #888888;
	word-wrap:break-word;
	
}</style>
<div>
<form id="form1" name="form1" method="post" action="z_recibirdevolucion.php">
  <table width="250" border="0">
    <tr>
      <td colspan="2">Agregar Devolucion</td>
    </tr>
    <tr>
      <td width="96">Codigo de Articulo:</td>
      <td width="144"><label for="cod_art"></label>
      <input type="text" name="cod_art" id="cod_art" /></td>
    </tr>
    <tr>
      <td>Nombre:</td>
      <td><label for="nombre"></label>
      <input type="text" name="nombre" id="nombre" /></td>
    </tr>
    <tr>
      <td>Monto:</td>
      <td><label for="monto"></label>
      <input type="text" name="monto" id="monto" /></td>
    </tr>
    <tr>
      <td>Fecha:</td>
      <td><label for="fecha"></label>
      <input type="text" name="fecha" id="fecha" value="<?php echo date("Y-m-d"); ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="submit" name="Agregar" id="Agregar" value="Agregar" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<table width="50" border="0">
  <tr>
    <td width="40"><form id="form2" name="form2" method="post" action="z_devolucion.php">
      <input type="submit" name="Cancelar" id="Cancelar" value="Cancelar" />
    </form></td>
  </tr>
</table>
<div>