<?php
session_start(); 
if($_SESSION['logeado']!="SI")
{
header("location: index.php?acceso=1 ");
exit;
}
 
?>
<?php include('conexion.php'); 
$id=$_POST['id'];
$cod_art=$_POST['cod_art'];
$nombre=$_POST['nombre'];
$monto=$_POST['monto'];
$fecha=$_POST['fecha'];

if(isset($id)){
	if($cod_art<0 or $monto<0){
		   echo 'Error Solo se permiten numeros positivos';
		   ?>
           <p><a href="z_devolucion.php">Volver a Devolucion</a></p>
           <?php
	  }else{
$sql="UPDATE devolucion SET cod_art='$cod_art',nombre='$nombre',monto='$monto',fecha='$fecha' WHERE id=$id";
mysqli_query($conexion,$sql);
echo 'Actualizacion exitosa ';
	  }
?>
 </html>
                         </head>
                             <meta http-equiv="refresh" content="1; url= z_devolucion.php">
                           </head>
                     </html>
<?php }else{
	echo 'No se pudo Actualizar';
	}
	?>