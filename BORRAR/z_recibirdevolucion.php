<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}
include('conexion.php');
$idCompra=$_POST["idCompra"];
$fecha_devolucion=$_POST["fecha_devolucion"];
$cantidad_devuelta=$_POST["cantidad_devuelta"];
$motivo_devolucion=$_POST["motivo_devolucion"];
$monto_bs=$_POST["monto_bs"];



$sql="insert into devolucion (fk_compra,motivo_devolucion,fecha_devolucion,cantidad_devuelta,monto_bs) values($idCompra,'$motivo_devolucion','$fecha_devolucion','$cantidad_devuelta',$monto_bs) ";

$res=mysqli_query($conexion,$sql);
		
	  if($res){
		  echo 'Compra realizada con éxito';
		  ?>
<p><a href="cargarcompra.php" target="principal">Hacer Otra Devolución</a></p>
<p><a href="compra.php">Ir al listado</a></p>
		  
	<?php	  
	  }else{
		  echo 'Error al Agregar Compra';
	  }
?>