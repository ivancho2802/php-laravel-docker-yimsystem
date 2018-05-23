<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--BOOSTRAP-->
<script language="javascript" type="text/javascript" src="bootstrap-3.3.6/js/jquery-1.12.0.min.js"></script>
<script language="javascript" type="text/javascript" src="bootstrap-3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
<link rel="stylesheet" href="css/font-awesome-4.6.3/css/font-awesome.min.css" type="text/css"/>
<title>Pruebador</title>
</head>
<body>

<div align="center">
    <div class="page-header">
        <h1>Atencion en Retiros Inventarios</h1>
    </div>
    <div class="container theme-showcase">
        <div class="alert alert-success fade in" role="alert">
            <strong>Excelente!</strong> Retiro del Inventario realizado con Exito.
            <span class="glyphicon glyphicon-ok text-success"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="close">×</button>
        </div>
        <div class="row">
        <ul class="bs-glyphicons">
        	<li>
            	<form target="_blank" name="form1" method="post" action="mov_unidad.php">
                    <button class="btn btn-danger" type="submit">
                        <span class="fa fa-file-pdf-o" style="font-size:40px;" title="PDF"></span>
                    </button>
                    <br>
                    <label>Imprimir Reporte de Compras</label>
                </form>
            </li>
            <li>
            <form target="principal" name="form2" method="post" action="cargarRetirosInventario.php">
                <button class="btn btn-success" type="submit">
                    <span class="glyphicon glyphicon-plus" style="font-size:35px;" title="PDF"></span>
                </button> 
                <br>
                <label>Seguir Retirando del Inventario</label>
            </form>
            </li>
            <li>
            <form target="principal" name="form3" method="post" action="compras.php">
                <button class="btn btn-success" type="submit">
                    <span class="glyphicon glyphicon-home" style="font-size:35px;" title="PDF"></span>
                </button> 
                <br>
                <label>Volver al Inicio</label>
            </form>	
            </li>
            <li>
            </li>
        </ul>
        </div>
    </div>
</div>

</body>
</html>