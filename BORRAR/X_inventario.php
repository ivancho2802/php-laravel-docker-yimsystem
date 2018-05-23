<?php
session_start(); 
if($_SESSION['privilegio']!=1 && $_SESSION['privilegio']!=2)
{
header("location: index.php?acceso=1 ");
exit;
}
 
?>
<?php include('conexion.php'); ?>
<link rel="stylesheet" href="estilos/estilos_entrada.css" type="text/css"/>
<br>
<form method="POST">
<table class="tabla1 table">
  <tbody align="center">
	<tr>
 	  <td class="titulo" colspan="11" align="center"><b>Inventario de Productos</b></td>
 	</tr>
    <tr class="titulo">
      <td><b>Id</b></td>
      <td><b>Producto</b></td>
      <td><b>Descripción</b></td>
      <td><b>Cantidad Min.</b></td>
      <td><b>Cantidad Máx.</b></td>
      <td><b>Stock.</b></td>
      <td><b>Valor Unit.</b></td>
      <td><b>Ult. Mov</b></td>
      <td colspan="3" >Acción</b></td>
    </tr>
  </tbody>    
     <?php 
    $consulta=mysqli_query($conexion,"select * from inventario");   	
    while($inventario=$consulta->fetch_assoc()){
	
    $id=$inventario["id"];;
	?>
  <tr>
    <td width="76" ><?php echo $inventario["id"]; ?></td>
    <td  align='left'><?php echo $inventario["nombre"]; ?></td>
    <td><?php echo $inventario["descripcion"]; ?></td>
    <td ><?php echo $inventario["cant_min"]; ?></td>
    <td ><?php echo $inventario["cant_max"]; ?></td>
    <td ><?php echo $inventario["stock"]; ?></td>
    <td ><?php echo $inventario["valor_unitario"]; ?></td>
    <td ><?php echo $inventario["fecha"]; ?></td>
    <td width="32">
    <?php
    echo "<a href='modificarInventario.php?id=$id' target='principal'>
    Actualizar</a>";
	?>
    </td>
    <td width="34">
    <?php 
	  echo "<a href='borrarInventario.php?id=$id' target='principal'>  
      Eliminar</a>";
    ?>
    </td>
    <td>
      <?php echo "<a target='_blank' href='reporte_inventario.php?id=$id'> PDF </a>"; ?>
    </td>
  </tr>
  <?php } ?>
 
</table>
</form>
<p><a href="agregarInventario.php" target="principal">
  <input type="submit" name="agregar" id="agregar" value="Agregar" />
</a></p>