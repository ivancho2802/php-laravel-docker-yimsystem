<?php
session_start(); 
if($_SESSION['logeado']!="SI")
{
header("location: index.php?acceso=1 ");
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
$fecha=$_POST['fecha'];

$sql="INSERT INTO inventario(nombre,descripcion,cant_min,cant_max,stock,valor_unitario,fecha)values('".$nombre."',
      '".$descripcion."',
	  '".$cant_min."',
	  '".$cant_max."',
	  '".$stock."',
	  '".$valor_unitario."',
	  '".$fecha."')";
	  if($cant_min<0 or $cant_max<0 or $stock<0 or $valor_unitario<0){
		   echo 'Error Solo se permiten numeros positivos';
		   ?>
           <p><a href="inventario.php">Volver a Inventario</a></p>
           <?php
	  }else{
		 
     $res=mysqli_query($conexion,$sql);
		
	  if($res){
		  echo 'Insercion con exito';
		  ?>
<p><a href="cargarInventario.php">Agregar Otro</a></p>
<p><a href="inventario.php">Volver a inventario</a></p>
		  
	<?php	  
	  }else{
		  echo 'No se puede insertar';
	  }
	  }
?>