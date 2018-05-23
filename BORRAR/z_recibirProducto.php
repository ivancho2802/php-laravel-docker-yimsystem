<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("Location: index.php?acceso=1 ");
exit;
} 
 
?>
<?php include('conexion.php'); ?>
<?php
$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];
$cant_min=$_POST['cant_min'];
$cant_max=$_POST['cant_max'];
$stock=$_POST['stock'];
$valor_unitario=$_POST['valor_unitario'];
$fecha=date("Y-m-d");

$sql="INSERT INTO inventario(nombre,descripcion,cant_min,cant_max,stock,valor_unitario,fecha)values('".$nombre."',
      '".$descripcion."',
	  '".$cant_min."',
	  '".$cant_max."',
	  '".$stock."',
	  '".$valor_unitario."',
	  '".$fecha."')";

$ok=mysqli_query($conexion,$sql);
$filas=mysql_affected_rows();
if($filas>0)
{
echo "<div align='center'><h3>Registro procesado satisfactoriamnte</h3></div>";
echo "<div align='center'><h3><a href='inventario.php'>Volver al Listado</a></h3></div>";
}
 else
  echo "<div align='center'>No se agregó ningún registro</div>";	
?>