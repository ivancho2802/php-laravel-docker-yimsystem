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
$sql="DELETE FROM inventario WHERE id=$id";
pg_query($conexion,$sql);
echo 'Seleccion ha sido borrada';
?>
 
</html>
                         </head>
                             <meta http-equiv="refresh" content="2; url= inventario.php">
                           </head>
                     </html>