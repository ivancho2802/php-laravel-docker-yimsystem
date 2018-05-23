<!--BOOSTRAP-->
<script language="javascript" type="text/javascript" src="bootstrap-3.3.6/js/jquery-1.12.0.min.js"></script>
<script language="javascript" type="text/javascript" src="bootstrap-3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
<link rel="stylesheet" href="css/font-awesome-4.6.3/css/font-awesome.min.css" type="text/css"/>
<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("Location: index.php?acceso=1 ");
exit;
}
?>
<?php include('conexion.php');

//insertar en EMPRE
$sql=sprintf("INSERT INTO empre (cod_empre, rif_empre, razon_empre, nom_empre, contri_empre, dir_empre, est_empre, fk_usuarios,  retenIVA, tel_empre, url_report) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                       $_POST['cod_empre'],// v
					   $_POST['rif_empre'],// v
					   $_POST['razon_empre'],//v
					   $_POST['nom_empre'],//v
					   
					   $_POST['contri_empre'],//v
                       $_POST['dir_empre'],//v
					   $_POST['est_empre'],//v
					   $_POST['fk_usuarios'],//v
					   
					   $_POST['retenIVA'],//v
					   $_POST['tel_empre'],//v
					   $_POST['url_report']);//v
$res = mysqli_query($conexion,$sql)or die('Registro NO realizado con éxito'.mysql_error());
?>
<div align="center">
    <div class="page-header">
        <h1>Atencion en Empresa</h1>
    </div>
    <div class="container theme-showcase">
        <div class="alert alert-success fade in" role="alert">
            <strong>Excelente!</strong> Registro realizado con Exito.
            <span class="glyphicon glyphicon-ok text-success"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="close">×</button>
        </div>
        <div class="row">
        <ul class="bs-glyphicons">
        	<li>
            	<form target="principal" name="form1" method="post" action="modificarempre.php">
                    <button class="btn btn-warning" type="submit">
                        Activar la Empresa
                    </button>
                </form>
            </li>
            <li>
            <form target="principal" name="form2" method="post" action="x_cargarempresa.php">
                <button class="btn btn-success" type="submit">
                    Agregar Otra Compra
                </button>
            </form>
            </li>
            <li>
            <form target="principal" name="form2" method="post" action="compra.php">
                <button class="btn btn-success" type="submit">
                    <span class="glyphicon glyphicon-home" style="font-size:35px;" title="PDF"></span>
                </button> 
                <br>
                <label>Volver a Campras</label>
            </form>	
            </li>
        </ul>
        </div>
    </div>
</div>