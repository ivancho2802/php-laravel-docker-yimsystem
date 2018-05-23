<?php
session_start(); 
if($_SESSION['logeado']!="SI")
{
header("location: index.php?acceso=1 ");
exit;
}
 
?>
<?php include('conexion.php');
$id=$_GET['id']; 
$sql="DELETE FROM proveedor WHERE id=$id";
mysqli_query($conexion,$sql);
echo 'Seleccion ha sido borrada';
?>
</html>
                         </head>
                             <meta http-equiv="refresh" content="2; url= z_proveedores.php">
                           </head>
                     </html>
