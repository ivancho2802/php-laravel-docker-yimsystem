<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}
include('conexion.php');
$idCompra=$_POST["idCompra"];
$idDevolucion=$_POST["idDevolucion"];
$fecha_devolucion=$_POST["fecha_devolucion"];
$cantidad_devuelta=$_POST["cantidad_devuelta"];
$motivo_devolucion=$_POST["motivo_devolucion"];
$monto_bs=$_POST["monto_bs"];



$sql="update devolucion set motivo_devolucion='$motivo_devolucion',fecha_devolucion='$fecha_devolucion',cantidad_devuelta=$cantidad_devuelta,monto_bs=$monto_bs where id='$idDevolucion' ";
$res=mysqli_query($conexion,$sql);
$filas=mysql_affected_rows();
if($filas>0)
{
echo "<div align='center'><h3>Actualización exitosa</h3></div>";
echo "<div align='center'><h3><a href='listado_devolucion.php'>Volver al Listado de Devoluciones</a></h3></div>";
}
 else
  echo "<div align='center'>No se modificó ningún registro</div>";	 
		
	  
?>