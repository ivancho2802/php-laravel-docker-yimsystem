<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

$mensaje = '<strong><span class="glyphicon glyphicon-warning-sign" style="font-size:60;float:left"></span></strong> 
				Lo sentimos ud debe cumplir ciertas condiciones para retener en compras Debe Ser<br />
				- Contribuyente Especial<br />
				- Debe Retener IVA segun pagina del SENIAT'; //EL MENSAJE DEL ALERT
$extra = "../../";
//llamando de modales "alert"
include_once($extra . "modales/alert/m_alert.php");

//consultade los datos de la empresa ACTIVA
$consulta2 = pg_query($conexion, "SELECT * FROM empre WHERE empre.est_empre = '1'");
// $filas2 = pg_fetch_assoc($consultaEmpre);
$filas2 = pg_fetch_assoc($consulta2);
$total_consultaEmpre = pg_num_rows($consulta2);
?>
<script>
  function consulReten(formulario) {
    var valido = validarFormulario(formulario);
    if (valido == 1) {
      formulario.submit();
    }
  }
</script>
<br>
<?php
$retenC = "";
$contriC = "";

if ($total_consultaEmpre > 0) {
  $retenC = $filas2["reteniva"];
  $contriC = $filas2["contri_empre"];
}
if ($retenC == 'SI' && $contriC == 'Especial') {
?>
  <div id="retenCompra" class="container">
    <div class="row">
      <h1 class="bd-title">Reimprimir Comprobante de Retenci&oacute;n</h1>
    </div>
    <div class="row">
      <div class="form-group">
        <div class="col-xs-6 col-md-6 col-lg-6">
          <form method="POST" name="form1">
            <label class="control-label">Consulta Por Mes:</label>
            <div class="input-group">
              <input type="month" name="mes" class="form-control" value="<?php if (isset($_POST['mes'])) echo $_POST['mes']; ?>" required="required" />
              <span class="input-group-btn">
                <input class="btn btn-primary" type="submit" name="" value="Buscar Comprobante" />
              </span>
            </div>
          </form>
        </div>
        <div class="col-xs-6 col-md-6 col-lg-6">
          <form method="POST" name="form2">
            <label class="control-label">Consulta por Numero de Comprabante:</label>
            <div class="input-group">
              <input type="text" name="num_compro_reten" class="form-control" id="num_compro_reten" value="<?php if (isset($_POST['num_compro_reten'])) echo $_POST['num_compro_reten']; ?>" lang="si-num_compro_reten" required="required" />
              <span class="input-group-btn">
                <input class="btn btn-primary" type="button" onClick="consulReten(this.form)" value="Buscar Comprobante" />
              </span>
            </div>
          </form>
        </div>
      </div><!--form-group-->
    </div><!--row-->
  </div><!--container-->
  <hr id="res_retenCompra" class="featurette-divider" />
  <?php
  if (isset($_POST['mes']) || isset($_POST['num_compro_reten'])) {
    if (isset($_POST['mes'])) {
      $mes = $_POST['mes'];

      $mesi = $mes . "-01";
      $mesf = ($mes == '02') ?
        $mes . "-28" : (((int) $mes % 2 == 0) ? $mes . "-31" : $mes . "-30");


      //consulta de la factura con sus datos relacionados
      $consulta = pg_query($conexion, sprintf(
        "SELECT * FROM empre, fact_compra, proveedor WHERE
																					empre.est_empre = '1' AND
																					fact_compra.empre_cod_empre = empre.cod_empre AND
																					fact_compra.fk_proveedor = proveedor.rif AND
																					fact_compra.fecha_compro_reten BETWEEN '%s' AND '%s'",
        $mesi,
        $mesf
      ));

      $filas = pg_fetch_assoc($consulta);
      $total_consulta = pg_num_rows($consulta);

      /*//consulta de los datos de la empreas PARA SABE LA ACTIVA 
      $consultaEmpre = pg_query($conexion,"SELECT * FROM empre WHERE empre.est_empre = '1'");
      $filas2 = $consultaEmpre);
      $total_consultaEmpre = pg_num_rows($consultaEmpre);
      */
    } elseif (isset($_POST['num_compro_reten'])) {
      $num_compro_reten = $_POST['num_compro_reten'];
      //consulta de la factura con sus datos relacionados
      $consulta = pg_query($conexion, sprintf(
        "SELECT * FROM empre, fact_compra, proveedor WHERE
																					empre.est_empre = '1' AND
																					fact_compra.empre_cod_empre = empre.cod_empre AND
																					fact_compra.fk_proveedor = proveedor.rif AND
																					fact_compra.num_compro_reten = '%s'",
        $num_compro_reten
      ));

      $filas = pg_fetch_assoc($consulta);
      $total_consulta = pg_num_rows($consulta);

      /*//consulta de los datos de la empreas PARA SABE LA ACTIVA 
		$consultaEmpre = pg_query($conexion,"SELECT * FROM empre WHERE empre.est_empre = '1'");
		$filas2 = $consultaEmpre);
		$total_consultaEmpre = pg_num_rows($consultaEmpre);
		*/
    }

  ?>
    <script>
      $(document).ready(function() {
        hoverScrool('#btn-res_retenCompra');
      });
    </script>
    <div class="container">
      <div class="row">
        <div id="btn-res_retenCompra" class="col-xs-12 col-lg-12" align="center">
          <button type="button" class="btn btn-sm btn-primary col-xs-12 col-lg-12 glyphicon glyphicon-chevron-up" onclick="hoverScrool('#retenCompra')"></button>
        </div>
      </div>
      <div class="jumbotron">
        <div><?php echo $filas2['titular_rif_empre'] . " - " . $filas2['nom_empre']; ?></div>
        <div><?php echo $filas['rif_empre']; ?></div>
        <div>Direcci&oacute;n: &nbsp;<?php echo $filas['dir_empre']; ?></div>
        <div>Contribuyente <?php echo $filas['contri_empre']; ?></div>
        <div>Comprobantes de Retencion
          <?php if (isset($_POST['mes'])) echo 'Correspondiente Al Mes De ' . mesNum_Texto($mes);
          else echo 'Numero: ' . $_POST['num_compro_reten'];
          ?>
        </div>
      </div>
    </div><!--contaner-->
    <div class="container">
      <div class="table-desplazable">
        <div class="table-content">
          <table class="tabla1 table  table-bordered table-hover">
            <tbody align="center">
              <tr class="titulo">
                <td colspan="4"><b>Comprobante de Retencion</b></td>
                <td colspan="2"><b>Datos Proveedor</b></td>
                <!--ACCIONES-->
                <td rowspan="2"><b>ACCIONES</b></td>
              </tr>
              <tr class="titulo">
                <td><b>Numero</b></td>
                <td><b>Fecha</b></td>
                <td><b>Monto I.V.A. Retenido</b></td>
                <td><b>Mes de Aplicacion</b></td>
                <!--proveedor-->
                <td><b>R.I.F.</b></td>
                <td><b>Razon Social</b></td>
                <!--ACCIONES-->
              </tr>
              <?php
              if ($filas) {
                do { ?>
                  <tr>
                    <!--Numero de Operqciones-->
                    <td><?php echo $filas['num_compro_reten']; ?></td>
                    <td><?php echo fechaInver($filas['fecha_compro_reten']); ?></td>
                    <td><?php echo round($filas['m_iva_reten'], 2); ?></td>
                    <td><?php echo mesNum_Texto($filas['mes_apli_reten']); ?></td>
                    <!--PROVEEDOR-->
                    <td><?php echo $filas['rif']; ?></td>
                    <td><?php echo $filas['nombre']; ?></td>
                    <!--ACCIONES-->
                    <td><?php $id = $filas['id_fact_compra']; ?>
                      <form target="_blank" name="form1" method="post" action="../reporte_pdf_RetenCompra.php">
                        <label class="">
                          <button class="btn btn-danger" type="submit" name="num_compro_reten" value="<?php echo $filas['num_compro_reten']; ?>">
                            <span class="fa fa-file-pdf-o" style="font-size:40px;" title="PDF"></span>
                          </button>
                        </label>
                      </form>
                    </td>
                  </tr>
                <?php   } while ($filas = pg_fetch_assoc($consulta));
              } else { ?>
                <td colspan="5">
                  <h4>Lo sentimos pero no hay resultados</h4>
                </td>
              <?php } ?>
            </tbody>
          </table>
          <br>
          <br>
          <br>
          <br>
          <br>
        </div><!--table content-->
      </div><!--table desplazable-->
    </div><!--container-->
  <?php } //si se envia mes o comprnbante
} else { //de si retiene y es especial
  ?>
  <script>
    $('#alert').modal('show');
  </script>
<?php
}
?>