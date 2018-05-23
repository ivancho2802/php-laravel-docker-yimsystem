<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}
 
include('conexion.php');
$ci=$_POST['ci'];
$nombre=$_POST['nombre'];
$sueldo=$_POST['sueldo'];
$cargo=$_POST['cargo'];
$telefono=$_POST['telefono'];
$direccion=$_POST['direccion'];
$codigo_empleado=$_POST['codigo_empleado'];

		
$sql="UPDATE empleados SET nombre='$nombre',
	                    sueldo='$sueldo',
						cargo='$cargo',
						telefono='$telefono',
						direccion='$direccion',
						codigo_empleado='$codigo_empleado' WHERE ci=$ci";

$ok=mysqli_query($conexion,$sql);
$filas=mysql_affected_rows();
if($filas>0)
{
echo "<div align='center'><h3>Actualización exitosa</h3></div>";
echo "<div align='center'><h3><a href='listado_empleados.php'>Volver al Listado</a></h3></div>";
}
 else
  echo "<div align='center'>No se modificó ningún registro</div>";	


?>