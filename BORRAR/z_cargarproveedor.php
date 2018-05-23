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
<form id="form1" name="form1" method="post" action="z_recibirproveedor.php">
  <table width="200" border="0">
    <tr>
      <td colspan="2">Agregar Proveedor</td>
    </tr>
    <tr>
      <td>Nombre:</td>
      <td><label for="nombre"></label>
      <input type="text" name="nombre" id="nombre" /></td>
    </tr>
    <tr>
      <td>Asesor:</td>
      <td><label for="asesor"></label>
      <input type="text" name="asesor" id="asesor" /></td>
    </tr>
    <tr>
      <td>Telefono:</td>
      <td><label for="telefono"></label>
      <input type="text" name="telefono" id="telefono" /></td>
    </tr>
    <tr>
      <td>Direccion:</td>
      <td><label for="direccion"></label>
      <input type="text" name="direccion" id="direccion" /></td>
    </tr>
    <tr>
      <td>Correo Electronico:</td>
      <td><label for="email"></label>
      <input type="text" name="email" id="email" /></td>
    </tr>
    <tr>
      <td>RIF:</td>
      <td><label for="rif"></label>
      <input type="text" name="rif" id="rif" /></td>
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
<table width="62" border="0">
  <tr>
    <td width="52"><form id="form2" name="form2" method="post" action="z_proveedores.php">
      <input type="submit" name="Cancelar" id="Cancelar" value="Cancelar" />
    </form></td>
  </tr>
</table>
<div>