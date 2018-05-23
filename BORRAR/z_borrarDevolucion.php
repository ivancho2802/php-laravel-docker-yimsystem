<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}
 
 
?>
<?php include('conexion.php');
$id=$_GET['id']; 
$sql="DELETE FROM devolucion WHERE id=$id";
mysqli_query($conexion,$sql);
header("Location: listado_devolucion.php");
?>
 
