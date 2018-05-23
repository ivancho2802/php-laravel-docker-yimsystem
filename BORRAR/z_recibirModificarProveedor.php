<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}
 
include('conexion.php');
$id=$_POST['id'];
$nombre=$_POST['nombre'];
$asesor=$_POST['asesor'];
$telefono=$_POST['telefono'];
$direccion=$_POST['direccion'];
$email=$_POST['email'];
$rif=$_POST['rif'];

		
$sql="UPDATE proveedor SET nombre='$nombre',
	                    asesor='$asesor',
						telefono='$telefono',
						direccion='$direccion',
						email='$email',
						rif='$rif' WHERE id=$id";

$ok=mysqli_query($conexion,$sql);
$filas=mysql_affected_rows();
if($filas>0)
{
echo "<div align='center'><h3>Actualización exitosa</h3></div>";
echo "<div align='center'><h3><a href='proveedores.php'>Volver al Listado</a></h3></div>";
}
 else
  echo "<div align='center'>No se modificó ningún registro</div>";	


?>