<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}
 
?>
<?php include('conexion.php'); ?>
<?php
$nombre=$_POST['nombre'];
$asesor=$_POST['asesor'];
$telefono=$_POST['telefono'];
$direccion=$_POST['direccion'];
$email=$_POST['email'];
$rif=$_POST['rif'];

$sql="INSERT INTO proveedor(nombre,asesor,telefono,direccion,email,rif)values('".$nombre."',
      '".$asesor."',
	  '".$telefono."',
	  '".$direccion."',
	  '".$email."',
	  '".$rif."')";
	  if($telefono<0){
		   echo 'Error Solo se permiten numeros positivos';
		   ?>
           <p><a href="z_proveedores.php">Volver a Proveedor</a></p>
           <?php
	  }else{
		 
     $res=mysqli_query($conexion,$sql);
		
	  if($res){
		  echo 'Insercion con exito';
		  ?>
<p><a href="z_agregar_proveedor.php">Agregar Otro</a></p>
<p><a href="z_proveedores.php">Volver a Proveedores</a></p>
		  
	<?php	  
	  }else{
		  echo 'No se puede insertar';
		  ?>
          <p><a href="z_proveedores.php">Volver a Proveedores</a></p>
	<?php	  
	  }
	  }
	  ?>