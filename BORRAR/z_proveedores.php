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
    
 <table width="80%" border="1" align="center" class="tabla1">
 <tr class="titulo">
 <td colspan="7" align="center">Datos de la Compra</td>
 </tr>
  <tr class="titulo">
    <td   >Id</td>
    <td>Rif</td>
    <td>Nombre</td>
    <td>Asesor</td>
    <td>Teléfono</td>
    <td>Dirección</td>
    <td  >Acción</td>
  </tr>
     <?php 
$consulta=mysqli_query($conexion,"select * from proveedor");     	
while($filas=$consulta)){
	$id=$filas["id"];
	?>
  <tr>
    <td><?php echo $filas["id"]; ?></td>
    <td><?php echo $filas["rif"];; ?></td>
    <td><?php echo $filas["nombre"]; ?></td>
    <td><?php echo $filas["asesor"]; ?></td>
    <td ><?php echo $filas["telefono"]; ?></td>
    <td ><?php echo $filas["direccion"]; ?></td>
    <td>
    <?php
    echo "<a href='modificarProveedor.php?id=$id' target='principal'>
    Actualizar</a>";
	?>
    </td>
   </tr>
  <?php } ?>
 
</table>
<p><a href="z_agregar_proveedor.php" target="principal">
  <input type="submit" name="agregar" id="agregar" value="Agregar Proveedor" />
</a></p>
</body>
</html>