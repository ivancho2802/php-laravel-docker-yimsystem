<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}
 
?>
<br>
<script language="javascript" type="text/javascript" src="javascript/funciones.js"></script>
<link rel="stylesheet" href="css/estilos_entrada.css" type="text/css"/>
<form id="form1" name="form1" method="post" action="z_recibirproveedor.php">
<div>
  <table width="436" border="0" align="center" class="tabla1">
    <tr>
      <td colspan="2" class="titulo" align="center">Agregar Proveeedor</td>
    </tr>
    <tr>
    <td>Rif:</td>
    <td><input type="text" name="rif" id="rif" size="10" lang="si-general"></td>
    </tr>
    <tr>
    <td>Nombre:</td>
    <td><input type="text" name="nombre" id="nombre" size="30" lang="si-general"></td>
    </tr>
    <tr>
      <td width="151">Asesor:</td>
      <td width="275">
     <input type="text" name="asesor" id="asesor"  required lang="si-general" ></td>
    </tr>
    <tr>
      <td>Teléfono</td>
      <td><input type="text" name="telefono" id="telefono"  lang="no-number"/></td>
    </tr>
    
    <tr>
      <td>Dirección:</td>
      <td><input type="text" name="direccion" id="direccion"  lang="no-general"/></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td>
      <input type="text" name="email" id="email" lang="no-email" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="button" name="agregar" id="agregar" value="Agregar"  onClick="guardar(this.form)" />
      </div></td>
    </tr>
  </table>
</form>
 

 <div>