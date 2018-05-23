<?php
session_start(); 
if($_SESSION['privilegio']!=1 && $_SESSION['privilegio']!=2)
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
 <td colspan="9" align="center">Datos de la Compra</td>
 </tr>
  <tr class="titulo">
    <td width="76"  >Id</td>
    <td  >Fecha</td>
    <td width="129">Nombre</td>
    <td width="91" >Numero de Orden</td>
    <td width="116" >Costo</td>
    <td width="116" >Cantidad</td>
    <td width="116" >Nombre del proveedor</td>
    <td  >Hacer Devolución</td>
  </tr>
     <?php 
	  $consulta=mysqli_query($conexion,"select * from compra");
      	
    while($filas=$consulta)){
	$id=$filas['id'];
	$fk_inventario=$filas['fk_inventario'];
	$num_ord=$filas['num_ord'];
	$costo=$filas['costo'];
	$cantidad=$filas['cantidad'];
	$fk_proveedor=$filas['fk_proveedor'];
	
	$sql1=mysqli_query($conexion,"select nombre from inventario where id='$fk_inventario'");
	$inventario=mysql_fetch_assoc($sql1);
	
	$sql2=mysqli_query($conexion,"select nombre from proveedor where id='$fk_proveedor'");
	$proveedor=mysql_fetch_assoc($sql2);
	?>
  <tr>
    <td width="76" ><?php echo $id; ?></td>
    <td width="76" ><?php echo $filas["fecha_compra"]; ?></td>
    <td  align='left'><?php echo $inventario["nombre"]; ?></td>
    <td><?php echo $num_ord; ?></td>
    <td ><?php echo $costo; ?></td>
    <td ><?php echo $cantidad; ?></td>
    <td align='left'><?php echo $proveedor["nombre"]; ?></td>
    <td width="32">
    <?php
    echo "<a href='hacerDevolucion.php?id=$id' target='principal'>
    <input type='image' name='eliminar' id='eliminar' src='imagen/actualizar.ico'/></a>";
	?>
    </td>
  </tr>
  <?php } ?>
 
</table>

</body>
</html>