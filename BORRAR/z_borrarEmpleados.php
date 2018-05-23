<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}
 
 
?>
<?php include('conexion.php');
$ci=$_GET['id']; 
$sql="DELETE FROM empleados WHERE ci='$ci'";
mysqli_query($conexion,$sql);
header("Location: listado_empleados.php");
?>
 
