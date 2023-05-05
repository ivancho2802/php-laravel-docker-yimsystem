<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

//insertar en RETIROSinventario
$sql = sprintf(
  "INSERT INTO inventario_retiros(cant_a, costo_a, fecha_inv_retiros, cant_inv_retiros, orden_inv_retiros, obs_inv_retiros, fk_inventario, fk_usuariosRI) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
  $_POST['stock'], //v
  $_POST['costo'], //v
  $_POST['fecha_inv_retiros'], //v

  $_POST['cant_inv_retiros'], //v
  $_POST['orden_inv_retiros'], //v
  $_POST['obs_inv_retiros'], //v

  $_POST['fk_inventario'], //v
  $_POST['fk_usuariosRI']
);
$res = pg_query($conexion, $sql) or die('Retiro NO realizado con éxito' . pg_last_error());

if ($res) {

  //consulta de la cantidad actual
  $consulta = pg_query($conexion, sprintf("SELECT * FROM inventario WHERE inventario.codigo = '%s'", $_POST["fk_inventario"]));
  // $filas = $sql_consul_inven->fetch_assoc();
  $filas = pg_fetch_assoc($consulta);

  //para el precio o costo este es el promediado de precios
  $stock_cantidad = $filas['stock'] - $_POST["cant_inv_retiros"];
  $sqlUpdateInven = sprintf(
    "UPDATE inventario SET stock = '%s' WHERE codigo = '%s'",
    $stock_cantidad,
    $_POST["fk_inventario"]
  );
  $UpdateInven = pg_query($conexion, $sqlUpdateInven) or die('Error al actualizar inventario' . pg_last_error());
  if ($UpdateInven) {
    //INSERTAR PARA EL  REGISTRO DE INVENTARIO LO ACTUAL SEGUN LA FECHA PARA KARDEX
    $InsertRegInv = sprintf(
      "INSERT INTO reg_inventario( tipo, fecha_reg_inv, costo_reg_inv, cantidad_reg_inv, fk_inventario, fecha_registro, hora_registro) VALUES
											('%s','%s','%s','%s','%s','%s','%s')",
      'retiro',
      $_POST['fecha_inv_retiros'],
      $filas['valor_unitario'], //costo actual para esta fecha
      $stock_cantidad, //cantidad actual para esta fecha
      $_POST["fk_inventario"],
      date('Y/m/d'),
      date('H:i:s')
    );
    $resInsertRegInv = pg_query($conexion, $InsertRegInv) or die('Registro inventario NO realizada con éxito' . pg_last_error());
  }
?>
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
        <!--
            <div class="col-xs-12 col-md-4 col-lg-4">
                <form name="form1" method="post" action="movUnidad.php">
                    <button class="btn btn-danger" type="submit">
                        <span class="fa fa-file-pdf-o" style="font-size:40px;" title="PDF"></span>
                    </button>
                    <br>
                    <label>Ver Movimiento de Unidades</label>
                </form>
            </div>
            -->
        <div class="col-xs-12 col-md-12 col-lg-12">
          <form name="form2" method="post" action="cargarRetirosInvent.php">
            <button class="btn btn-lg btn-success glyphicon glyphicon-plus" title="NUEVO" type="submit">

            </button>
            <br>
            <label>Cargar Otra Retiro</label>
          </form>
        </div>
        <!--
            <div class="col-xs-12 col-md-4 col-lg-4">
                <form name="form3" method="post" action="../home/status.php">
                    <button class="btn btn-lg btn-success glyphicon glyphicon-home" title="HOME" type="submit">
                    </button> 
                    <br>
                    <label>Volver a Home</label>
                </form>	
            </div>
            -->
      </div><!--ROW-->
    </div>
  </div>
<?php
} else {
  echo 'Error al Aplicar RETIRO';
}
?>