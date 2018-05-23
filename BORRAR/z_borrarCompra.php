<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("Location: index.php?acceso=1 ");
exit;
} 
	
include('conexion.php');
$id=$_GET['id']; 
$sql="DELETE FROM compra WHERE id=$id";
$ok=mysqli_query($conexion,$sql);
$filas=mysql_affected_rows();
if($filas>0)
{
echo "<div align='center'><h3>Registro Borrado exitosamnte</h3></div>";
echo "<div align='center'><h3><a href='compra.php'>Volver al Listado de Compras</a></h3></div>";
}
else
 echo "<div align='center'><h3>No se ha borrado ningún registro</h3></div>"; 
?>


 
