<?php
session_start(); 
if($_SESSION['logeado']!="SI")
{
header("location: index.php?acceso=1 ");
exit;
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<?php 
$id=$_POST['id'];
?>
<body>
<h2 align="center">ESTA SEGURO QUE DESEA ELIMINAR EL REGISTRO
</h2>
<p>&nbsp;</p>
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100"><h2 align="center"><a href="z_borrarProveedor.php?id=<?php echo $id ?>">SI</a></h2></td>
    <td width="100"><h2 align="center"><a href="z_proveedores.php">NO</a></h2></td>
  </tr>
</table>
</body>
</html>