<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}
include('conexion.php');
$id=$_GET["id"]; 
$sql="select * from proveedor where id=$id";
$ok=mysqli_query($conexion,$sql);
$datos=mysql_fetch_assoc($ok);
?>
<br>
<script language="javascript" type="text/javascript" src="javascript/funciones.js"></script>
<link rel="stylesheet" href="css/estilos_entrada.css" type="text/css"/>
<form id="form1" name="form1" method="post" action="z_recibirModificarProveedor.php">
<input type="hidden" name="id" id="id"  value="<?php echo $id ?>">
<div>
  <table width="436" border="0" align="center" class="tabla1">
    <tr>
      <td colspan="2" class="titulo" align="center">Actualizar Proveedor</td>
    </tr>
    <tr>
    <td>Rif:</td>
    <td><input type="text" name="rif" id="rif" size="10" value="<?php echo $datos["rif"] ?>" lang="si-general"></td>
    </tr>
    <tr>
    <td>Nombre:</td>
    <td><input type="text" name="nombre" id="nombre" size="30" value="<?php echo $datos["nombre"] ?>" lang="si-general"></td>
    </tr>
    <tr>
      <td width="151">Asesor:</td>
      <td width="275">
     <input type="text" name="asesor" id="asesor"  required  value="<?php echo $datos["asesor"] ?>" lang="si-general"></td>
    </tr>
    <tr>
      <td>Teléfono</td>
      <td><input type="text" name="telefono" id="telefono" value="<?php echo $datos["telefono"] ?>"  lang="si-number"/></td>
    </tr>
    
    <tr>
      <td>Dirección:</td>
      <td><input type="text" name="direccion" id="direccion" value="<?php echo $datos["direccion"] ?>" lang="no-general"/></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td>
      <input type="text" name="email" id="email" value="<?php echo $datos["email"] ?>" size="40" lang="no-email"/></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="button" name="agregar" id="agregar" value="Modificar" onClick="guardar(this.form)" />
        
      </div></td>
    </tr>
  </table>
</form>
 

 <div>