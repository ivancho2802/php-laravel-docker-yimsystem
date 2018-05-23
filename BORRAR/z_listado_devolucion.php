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
 <td colspan="10" align="center">Datos de la Compra</td>
 </tr>
  <tr class="titulo">
    <td width="76"  >Id Devolución</td>
    <td  >Fecha Devolución</td>
    <td width="129">Producto</td>
    <td width="91" >Cantidad Devuelta</td>
    <td width="116" >Monto Devolución</td>
    <td width="116" >Proveedor</td>
    <td width="116" >Motivo de la Devolución</td>
    <td colspan="3" >Acción</td>
  </tr>
     <?php 
	  $consulta=mysqli_query($conexion,"select * from devolucion");
      	
    while($filas=$consulta)){
	$id=$filas['id'];
	$fk_compra=$filas['fk_compra'];
	$motivo_devolucion=$filas['motivo_devolucion'];
	$fecha_devolucion=$filas['fecha_devolucion'];
	$cantidad_devuelta=$filas['cantidad_devuelta'];
	$monto_bs=$filas['monto_bs'];
	
	$sql1=mysqli_query($conexion,"select * from compra where id='$fk_compra'");
	$compra=mysql_fetch_assoc($sql1);
	
	$sql2=mysqli_query($conexion,"select * from proveedor where id='$compra[fk_proveedor]'");
	$proveedor=mysql_fetch_assoc($sql2);
	
	$sql3=mysqli_query($conexion,"select * from inventario where id='$compra[fk_inventario]'");
	$producto=mysql_fetch_assoc($sql3);
	?>
  <tr>
    <td width="76" ><?php echo $id; ?></td>
    <td width="76" ><?php echo $fecha_devolucion; ?></td>
    <td  align='left'><?php echo $producto["nombre"]; ?></td>
    <td><?php echo $cantidad_devuelta; ?></td>
    <td ><?php echo $monto_bs; ?> Bs.</td>
    <td ><?php echo $proveedor["nombre"]; ?></td>
    <td align='left'><?php echo $motivo_devolucion; ?></td>
    <td width="32">
    <?php
    echo "<a href='modificarDevolucion.php?id=$id' target='principal'>
    Actualizar</a>";
	?>
    </td>
    <td width="32" >
    <?php 
	  echo "<a href='borrarDevolucion.php?id=$id' target='principal'>  
     Eliminar</a>";
    ?>
    </form>
    </td>
    <td width="32">
    <?php echo "<a target='_blank' href='reporte_devolucion.php?id=$id'> PDF </a>"; ?>
    </td>
  </tr>
  <?php } ?>
 
</table>

</body>
</html>