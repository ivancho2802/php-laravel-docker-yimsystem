<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}
include('conexion.php');
$ci=$_POST["ci"];
$nombre=$_POST["nombre"];
$sueldo=$_POST["sueldo"];
$cargo=$_POST["cargo"];
$telefono=$_POST["telefono"];
$direccion=$_POST["direccion"];
$codigo_empleado=$_POST["codigo_empleado"];



$sql="insert into empleados (ci,nombre,sueldo,cargo,telefono,direccion,codigo_empleado) values('$ci','$nombre',$sueldo,'$cargo','$telefono','$direccion','$codigo_empleado') ";

$res=mysqli_query($conexion,$sql);
		
	  if($res){
		  echo 'Registro procesado con éxito';
		  ?>
<p><a href="z_agregar_empleado.php" target="principal">Registrar otro empleado</a></p>
<p><a href="z_listado_empleados.php">Ir al listado</a></p>
		  
	<?php	  
	  }else{
		  echo 'Error al Agregar Empleado';
	  }
?>