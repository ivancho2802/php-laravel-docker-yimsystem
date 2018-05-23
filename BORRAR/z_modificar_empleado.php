<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}
$id=$_GET["id"];
include('conexion.php');



$sql="select * from empleados WHERE ci='$id'";
$ok=mysqli_query($conexion,$sql);
$datos=mysql_fetch_assoc($ok);
?>
<br>
<script language="javascript" type="text/javascript" src="javascript/funciones.js"></script>
<link rel="stylesheet" href="css/estilos_entrada.css" type="text/css"/>
<meta charset="utf-8">
<form id="form1" name="form1" method="post" action="z_recibirModificarEmpleado.php">
<div>
  <table width="436" border="0" align="center" class="tabla1">
    <tr>
      <td colspan="2" class="titulo" align="center">Editar Empleado</td>
    </tr>
    <tr>
    <td>Cédula:</td>
    <td><input type="text" name="ci" id="ci" size="12" value="<?php echo $datos['ci'] ?>" lang="si-general"></td>
    </tr>
    <tr>
    <td>Nombre:</td>
    <td><input type="text" name="nombre" id="nombre" size="30" value="<?php echo $datos['nombre'] ?>" lang="si-general"></td>
    </tr>
    <tr>
      <td >Sueldo:</td>
      <td >
     <input type="text" name="sueldo" id="sueldo"  value="<?php echo $datos['sueldo'] ?>"  lang="si-general"></td>
    </tr>
    <tr>
      <td>Cargo:</td>
      <td><input type="text" name="cargo" id="cargo" value="<?php echo $datos['cargo'] ?>"  lang="si-general"/></td>
    </tr>
    <tr>
      <td>Teléfono:</td>
      <td>
      <input type="text" name="telefono" id="telefono" value="<?php echo $datos['telefono'] ?>" lang="si-number"/></td>
    </tr>
    <tr>
      <td>Dirección:</td>
      <td><input type="text" name="direccion" id="direccion" value="<?php echo $datos['direccion'] ?>"  lang="si-general"/></td>
    </tr>
     <tr>
      <td>Código Empleado:</td>
      <td><input type="text" name="codigo_empleado" id="codigo_empleado" value="<?php echo $datos['codigo_empleado'] ?>"  lang="si-general"/></td>
    </tr>
    
    <tr>
      <td colspan="2"><div align="center">
        <input type="button" name="agregar" id="agregar" value="Agregar" onClick="guardar(this.form)" />
      </div></td>
    </tr>
  </table>
</form>
 

 <div>