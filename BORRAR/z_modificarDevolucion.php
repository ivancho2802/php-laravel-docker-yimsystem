<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}

include('conexion.php');
$idDevolucion=$_GET["id"]; 

$sql_ok="select * from devolucion where id='$idDevolucion'";
$ok_ok=mysqli_query($conexion,$sql_ok); 
$datos_ok=mysql_fetch_assoc($ok_ok); 


$sql="select * from compra where id='$datos_ok[fk_compra]'";
$ok=mysqli_query($conexion,$sql); 
$datos=mysql_fetch_assoc($ok); 

$sql1=mysqli_query($conexion,"select nombre from inventario where id='$datos[fk_inventario]'");
$inventario=mysql_fetch_assoc($sql1);

$sql2=mysqli_query($conexion,"select nombre from proveedor where id='$datos[fk_proveedor]'");
$proveedor=mysql_fetch_assoc($sql2);


?>
<br>
<script language="javascript" type="text/javascript" src="javascript/funciones.js"></script>
<link rel="stylesheet" href="css/estilos_entrada.css" type="text/css"/>
<form id="form1" name="form1" method="post" action="z_recibirDevolucionModificar.php">
<input type="hidden" name="idCompra" id="idCompra" value="<?php echo $datos_ok["fk_compra"] ?>">
<input type="hidden" name="idDevolucion" id="idDevolucion" value="<?php echo $idDevolucion ?>">
<div>
  <table width="50%" border="0" align="center" class="tabla1">
    <tr>
      <td colspan="2" class="titulo" align="center">Datos de la Compra</td>
    </tr>
     <tr>
    <td>Fecha de la Compra:</td>
    <td><input type="date" name="fecha_compra" id="fecha_compra" size="10" value="<?php echo $datos["fecha_compra"]; ?>" readonly ></td>
    </tr>
    <tr>
      <td width="151">Código del Producto:</td>
      <td width="275"><label for="nombre"></label>
      <input type="text" name="cod_prod" id="cod_prod" size="9" maxlength="9"  required onBlur="buscar_dato(1)" value="<?php echo $datos["id"]; ?>" readonly><a href="#">Buscar</a></td>
    </tr>
    <tr>
      <td width="151">Nombre del Producto:</td>
      <td width="275" id="nom_pro"><?php echo $inventario["nombre"] ?></td>
    </tr>
    <tr>
      <td>Número de Orden:</td>
      <td><label for="num_ord"></label>
      <input type="text" name="num_ord" id="num_ord"  value="<?php echo $datos["num_ord"]; ?>" readonly/></td>
    </tr>
    
    <tr>
      <td>Costo:</td>
      <td><label for="costo"></label>
      <input type="text" name="costo" id="costo" value="<?php echo $datos["costo"]; ?>" readonly/></td>
    </tr>
    <tr>
      <td>Cantidad:</td>
      <td><label for="cantidad"></label>
      <input type="text" name="cantidad" id="cantidad" value="<?php echo $datos["cantidad"]; ?>"  readonly/></td>
    </tr>
    <tr>
      <td>Código del Proveedor:</td>
      <td><label for="nombre_proveedor"></label>
      <input type="text" name="cod_prov" id="cod_prov" size="9" maxlength="9"  readonly required onBlur="buscar_dato(2)" value="<?php echo $datos["fk_proveedor"]; ?>"><a href="#">Buscar</a></td>
    </tr>
     <tr>
      <td width="151">Nombre del Proveedor:</td>
      <td width="275" id="nom_prov"><?php echo $proveedor["nombre"] ?></td>
    </tr>
        <tr>
      <td colspan="2" class="titulo" align="center">Datos de la Devolución</td>
    </tr>
    <tr>
      <td>Fecha de la Devolución:</td>
      <td>
      <input type="date" name="fecha_devolucion" id="fecha_devolucion"  value="<?php echo $datos_ok["fecha_devolucion"] ?>" lang="si-general"/></td>
    </tr>
    <tr>
      <td>Cantidad Devuelta:</td>
      <td>
      <input type="text" name="cantidad_devuelta" id="cantidad_devuelta"  onKeyUp="validar_cantidad()" value="<?php echo $datos_ok["cantidad_devuelta"] ?>" lang="si-number" /></td>
    </tr>
    <tr>
      <td>Motivo Devolución:</td>
      <td>
      <input type="text" name="motivo_devolucion" id="motivo_devolucion"  size="40"  maxlength="80" value="<?php echo $datos_ok["motivo_devolucion"] ?>" lang="si-general"/></td>
    </tr>
    <tr>
      <td>Monto Devolución Bs:</td>
      <td>
      <input type="text" name="monto_bs" id="monto_bs"  readonly  value="<?php echo $datos_ok["monto_bs"] ?>" lang="si-number"/></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="button" name="agregar" id="agregar" value="Modificar" onClick="guardar(this.form)" />
      </div></td>
    </tr>
  </table>
</form>
 

 <div>