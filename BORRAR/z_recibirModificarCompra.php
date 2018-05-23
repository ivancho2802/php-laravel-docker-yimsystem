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
$id=$_POST['cod_prod'];
$num_ord=$_POST['num_ord'];
$costo=$_POST['costo'];
$cantidad=$_POST['cantidad'];
$fk_proveedor=$_POST['cod_prov'];
$fecha_compra=$_POST['fecha_compra'];
$idCompra=$_POST["idCompra"];
 	
$sql="UPDATE compra SET num_ord=$num_ord,
						costo=$costo,
						cantidad=$cantidad,fk_inventario=$id,
						fk_proveedor=$fk_proveedor,fecha_compra='$fecha_compra' WHERE id=$idCompra";
						

$ok=mysqli_query($conexion,$sql);
$filas=mysql_affected_rows();
if($filas>0)
{
echo "<div align='center'><h3>Actualización exitosa</h3></div>";
echo "<div align='center'><h3><a href='compra.php'>Volver al Listado de Compras</a></h3></div>";
}
 else
  echo "<div align='center'>No se modificó ningún registro</div>";	 
?>
 
