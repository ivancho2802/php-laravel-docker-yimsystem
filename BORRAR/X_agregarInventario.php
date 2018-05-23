<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}


?>
<br>
<script language="javascript" type="text/javascript" src="../javascript/funciones.js"></script>
<link rel="stylesheet" href="../css/estilos_entrada.css" type="text/css"/>
<form id="form1" name="form1" method="post" action="../z_recibirProducto.php">
<div>
  <table width="436" border="0" align="center" class="tabla1">
    <tr>
      <td colspan="2" class="titulo" align="center">Agregar Producto</td>
    </tr>
    <tr>
      <td width="151">Nombre del Producto:</td>
      <td width="275" id="nom_pro"> 
      <input type="text" name="nombre" id="nombre"  /></td>
    </tr>
    <tr>
      <td>Descripción del Producto:</td>
      <td>
      <input type="text" name="descripcion" id="descripcion"  /></td>
    </tr>
    
    <tr>
      <td>Cant Min:</td>
      <td>
      <input type="text" name="cant_min" id="cant_min" /></td>
    </tr>
    <tr>
      <td>Cant. Max:</td>
      <td>
      <input type="text" name="cant_max" id="cant_max"  /></td>
    </tr>
    <tr>
      <td>Stock:</td>
      <td>
      <input type="text" name="stock" id="stock" size="9" maxlength="9"  required  ></td>
    </tr>
      <tr>
      <td>Valor Unitario:</td>
      <td>
      <input type="text" name="valor_unitario" id="valor_unitario" size="9" maxlength="9"  required ></td>
    </tr>
     
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="agregar" id="agregar" value="Agregar Inventario" />
      </div></td>
    </tr>
  </table>
</form>
 

 <div>