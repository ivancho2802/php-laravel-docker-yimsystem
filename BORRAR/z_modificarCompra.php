<?php
session_start(); 
if($_SESSION['privilegio']!=1)
{
header("location: index.php?acceso=1 ");
exit;
}

include('conexion.php');
$idCompra=$_GET["id"]; 
$sql="select * from fact_compra where id_fact_compra='$idCompra'";
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
<form id="form1" name="form1" method="post" action="z_recibirModificarCompra.php">
<input type="hidden" name="idCompra" id="idCompra" value="<?php echo $idCompra ?>">
<div>
  <table width="436" border="0" align="center" class="tabla1">
    <tr>
      <td colspan="2" class="titulo" align="center">Modificar Compra</td>
    </tr>
     <tr>
    <td>Fecha de la Compra:</td>
    <td><input type="date" name="fecha_compra" id="fecha_compra" size="10" value="<?php echo $datos["fecha_compra"]; ?>" lang="si-general"></td>
    </tr>
    <tr>
      <td width="151">Código del Producto:</td>
      <td width="275"><label for="nombre"></label>
      <input type="text" name="cod_prod" id="cod_prod" size="9" maxlength="9"  required onBlur="buscar_dato(1)" value="<?php echo $datos['fk_inventario']; ?>" lang="si-general">
      <button type="button" onclick='href="#"'>Buscar</button></td>
    </tr>
    <tr>
      <td width="151">Nombre del Producto:</td>
      <td width="275" id="nom_pro"><?php echo $inventario["nombre"] ?></td>
    </tr>
    <tr>
      <td>Número de Orden:</td>
      <td><label for="num_ord"></label>
      <input type="text" name="num_ord" id="num_ord"  value="<?php echo $datos["num_ord"]; ?>" lang="si-general"/></td>
    </tr>
    
    <tr>
      <td>Costo:</td>
      <td><label for="costo"></label>
      <input type="text" name="costo" id="costo" value="<?php echo $datos["costo"]; ?>" lang="si-float"/><span>Formato:00.00</span></td>
    </tr>
    <tr>
      <td>Cantidad:</td>
      <td><label for="cantidad"></label>
      <input type="text" name="cantidad" id="cantidad" value="<?php echo $datos["cantidad"]; ?>" lang="si-number" onKeyUp="validar_positivos()"/></td>
    </tr>
    <tr>
      <td>Código del Proveedor:</td>
      <td><label for="nombre_proveedor"></label>
      <input type="text" name="cod_prov" id="cod_prov" size="9" maxlength="9"  required onBlur="buscar_dato(2)" value="<?php echo $datos["fk_proveedor"]; ?>" lang="si-general">
      <button type="button" onclick='href="#"'>Buscar</button></td>
    </tr>
     <tr>
      <td width="151">Nombre del Proveedor:</td>
      <td width="275" id="nom_prov"><?php echo $proveedor["nombre"] ?></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
     <input type="button" name="agregar" id="agregar" value="Agregar"  onClick="guardar(this.form)"/>
      </div></td>
    </tr>
  </table>
</form>
 

 <div>