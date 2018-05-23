<?php
@session_start();
@$_SESSION["usuario"]="";
@$_SESSION["privilegio"]="";
@session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Devoluciones</title>
<link rel="stylesheet" href="estilos2.css" type="text/css"/>
<!--
<link  rel="stylesheet" type="text/css" href="menu_assets/styles.css"/>
-->
<script  language="javascript" type="text/javascript">
  function getElement(aID)
    {
        return (document.getElementById) ?document.getElementById(aID):document.all[aID];
    }

    function getIFrameDocument(aID){
        var rv = null;
        var frame=getElement(aID);
       if (frame.contentDocument)
            rv = frame.contentDocument;
        else
            rv = document.frames[aID].document;
        return rv;
    }
function adjustMyFrameSize()
    {
        var frame = getElement("centro2");
        var frameDoc = getIFrameDocument("centro2");
        frame.height = frameDoc.body.offsetHeight+20;
        if(frame.height<800)
           frame.height=800;
       
    }
</script>
</head>

<body background="imagenes/fondo.png">
<div id="contenedor" background="imagenes/fondo.png">
<div id="superior">
<img  src="imagenes/banner.jpg"/>
</div>

<div id="centro" >
<?php
if(@$_REQUEST["agregado"]==1)
echo "<div align='center'><h1>Usuario agregado correctamente</h1></div>";
?>
<form name="formulario" id="formulario" action="controladores/entrada.php" method="POST">

<table  align="center" class="letra_gris" width="40%">
<tr>
 <td colspan='2' align='center' class="titulo">Entrada al Sistema</td>
</tr>

<tr>
 <td width="35%">Usuario:</td>
 <td width="65%"><input  type="text" name="usuario" id="usuario" size="20" required="required" maxlength="15"/></td>
</tr>

<tr>
 <td>Clave:</td>
 <td><input  type="password" name="clave" id="clave" size="20" required="required" maxlength="15"/></td>
</tr>

<tr>
<td colspan="2" align="center"> <a href='pantallas/agregar_usuario.php'>¿No estás Registrado</a> <a href='pantallas/cambio_clave.php'>¿Olvidó su contraseña?</a> </td>
</tr>

<tr>
 <td colspan="2" align="center"><input  type="submit" value="Ingresar"/></td>
</tr>
</table>
<!--
<br /><br /><br />
<br /><br /><br />
<br /><br /><br />
<br /><br /><br />

<br /><br /><br />
<br /><br /><br />
<br /><br /><br />
<br /><br /><br />
<br /><br /><br />
-->
</form>

</div>
<div id="pie">
<div align="center" class="pie_letra">
<BR />
Sistema De Facturaci&oacute;n Derechos de Autor Ing. Ivan Diaz 2016-2017
</div>
</div>
</div>
</body>
</html>
