<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}
 
?>
<?php include('conexion.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<link rel="stylesheet" href="css/estilos_entrada.css" type="text/css"/>
<body>
<div>
<br />
    
 <table width="90%" border="1" align="center" class="tabla1">
 <tr class="titulo">
 <td colspan="10" align="center">Datos de los Empleados</td>
 </tr>
  <tr class="titulo">
    <td width="76"  >Cédula</td>
    <td  >Nombre</td>
    <td width="129">Sueldo</td>
    <td width="91" >Cargo</td>
    <td width="116" >Teléfono</td>
    <td width="116" >Dirección</td>
    <td width="116" >Código de Empleado</td>
    <td colspan="2" >Acción</td>
  </tr>
     <?php 
	  $consulta=mysqli_query($conexion,"select * from empleados");
      	
    while($filas=$consulta)){
		$id=$filas["ci"];
	?>
  <tr>
    <td width="76" ><?php echo $filas["ci"]; ?></td>
    <td width="76" ><?php echo $filas["nombre"]; ?></td>
    <td  align='left'><?php echo $filas["sueldo"]; ?></td>
    <td><?php echo $filas["cargo"]; ?></td>
    <td ><?php echo $filas["telefono"]; ?></td>
    <td ><?php echo $filas["direccion"]; ?></td>
    <td ><?php echo $filas["codigo_empleado"]; ?></td>
    <td width="32">
    <?php
    echo "<a href='modificar_empleado.php?id=$id' target='principal'>
    Actualizar</a>";
	?>
    </td>
    <td width="34" >
    <?php 
	  echo "<a href='borrarEmpleados.php?id=$id' target='principal'>  
     Eliminar</a>";
    ?>
    </form>
    </td>
  </tr>
  <?php } ?>
 
</table>
<p><a href="z_agregar_empleado.php" target="principal">
  <input type="submit" name="agregar" id="agregar" value="Agregar Empleado" />
</a></p>
</body>
</html>