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
<form id="form1" name="form1" method="post" action="recibirInventario.php">
  <table width="200" border="0">
    <tr>
      <td colspan="2">Cargar Inventario</td>
    </tr>
    <tr>
      <td>Nombre:</td>
      <td><label for="nombre"></label>
      <input type="text" name="nombre" id="nombre" /></td>
    </tr>
    <tr>
      <td>Descripcion:</td>
      <td><label for="descripcion"></label>
      <input type="text" name="descripcion" id="descripcion" /></td>
    </tr>
    <tr>
      <td>Cantidad Minima:</td>
      <td><label for="cant_min"></label>
      <input type="text" name="cant_min" id="cant_min" /></td>
    </tr>
    <tr>
      <td>Cantidad Maxima:</td>
      <td><label for="cant_max"></label>
      <input type="text" name="cant_max" id="cant_max" /></td>
    </tr>
    <tr>
      <td>En Stock:</td>
      <td><label for="stock"></label>
      <input type="text" name="stock" id="stock" /></td>
    </tr>
    <tr>
      <td>Valor Unitario:</td>
      <td><label for="valor_unitario"></label>
      <input type="text" name="valor_unitario" id="valor_unitario" /></td>
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
<table width="66" border="0">
  <tr>
    <td width="56"><form id="form2" name="form2" method="post" action="inventario.php">
      <input type="submit" name="Cancelar" id="Cancelar" value="Cancelar" />
    </form></td>
  </tr>
</table>
<div>