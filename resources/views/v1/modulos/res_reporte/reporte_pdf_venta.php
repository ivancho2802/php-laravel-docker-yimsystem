<?php
include_once('../includes_SISTEM/include_head_report.php');
///////////////////////////////////////////////////////////////////////////////////
//			FUNCIONES
////////////////////////////////////////////////////////////////////////////////////
include_once("../librerias/conexion.php");
/////////////////////////////////////////////////////////////
include_once('../php/funciones.php');
/////////////////////////////////////////////////////////////
include_once('../includes_SISTEM/include_login.php');
/////////////////////////////////////////////////////////////
?>
<link rel="stylesheet" href="../css/estilos_reportes.css" type="text/css" />
<?php
if (isset($_POST['mes'])) {
  $mes = $_POST['mes'];
  $mesi = $mes . "-01";
  $mesf = ($mes == '02') ? $mes . "-28" : ((int) $mes % 2 == 0) ? $mes . "-31" : $mes . "-30";
  //consulta de los datos de la empreas PARA SABE LA ACTIVA 
  $consultaEmpre = pg_query($conexion, "SELECT * FROM empre WHERE empre.est_empre = '1'");
  $filasEmpre = pg_fetch_assoc($consultaEmpre);;
  $total_consultaEmpre = pg_num_rows($consultaEmpre);
  //consulta de la factura con sus datos relacionados
  $consulta = pg_query($conexion, sprintf(
    "SELECT * FROM empre, fact_venta, cliente WHERE
	  																			fact_venta.empre_cod_empre = empre.cod_empre AND
																				empre.cod_empre = '%s' AND
																				fact_venta.fk_cliente = cliente.ced_cliente AND
																				fact_venta.fecha_fact_venta BETWEEN '%s' AND '%s'",
    $filasEmpre['cod_empre'],
    $mesi,
    $mesf
  ));

  $filas = pg_fetch_assoc($consulta);
  $total_consulta = pg_num_rows($consulta);
?>
  <page_header>
    <table style="width: 90%;">
      <tr>
        <td style="text-align: left;	width: 33%"><?php echo "Sistema " . $_SESSION["alias"] . " - " . $_SESSION["version"] ?></td>
        <td style="text-align: center;	width: 34%">Reporte de Ventas</td>
        <td style="text-align: right;	width: 33%"><?php echo date('d/m/Y'); ?></td>
      </tr>
    </table>
  </page_header>
  <page_footer>
    <table style="width: 100%;">
      <tr>
        <td style="text-align: left;	width: 50%"><?php echo "Sistema " . $_SESSION["alias"] . " - " . $_SESSION["version"] ?></td>
        <td style="text-align: right;	width: 50%">page [[page_cu]]/[[page_nb]]</td>
      </tr>
    </table>
  </page_footer>
  <br>
  <br>
  <br>
  <table cellpadding="0" cellspacing="0" class="tabla1 table">
    <thead>
      <tr>
        <th colspan="35">
          <div><?php echo utf8_decode($filasEmpre['titular_rif_empre'] . " - " . $filasEmpre['nom_empre']); ?></div>
        </th>
      </tr>
      <tr>
        <th colspan="34">
          <div><?php echo $filasEmpre['rif_empre']; ?></div>
        </th>
      </tr>

      <tr>
        <th colspan="34">
          <div>Direcci&oacute;n: &nbsp;<?php echo utf8_decode($filasEmpre['dir_empre']); ?></div>
        </th>
      </tr>
      <tr>
        <th colspan="34">
          <div>Contribuyente <?php echo $filasEmpre['contri_empre']; ?></div>
        </th>
      </tr>
      <tr>
        <th colspan="34">
          <div>LIBRO DE VENTAS CORRESPONDIENTE AL MES DE <?php echo mesNum_Texto($mes); ?></div>
        </th>
      </tr>
      <?php //funcion para convertir la fechaa mes en letras y ano
      ?>
      <tr>
        <td colspan="20" rowspan="2"><b></b></td>
        <td class="titulo" colspan="1" rowspan="2">
          <div class="subTitulo">EXPORTACIONES</div>
        </td>
        <td class="titulo" colspan="11">
          <div class="subTitulo">NACIONALES</div>
        </td>
        <td colspan="2" rowspan="2"><b></b></td>
      </tr>
      <tr>
        <td colspan="5" class="titulo">&nbsp;</td>
        <td colspan="3" class="titulo">Contribuyente</td>
        <td colspan="3" class="titulo">No Contribuyente</td>
      </tr>
      <tr class="titulo">
        <td class="cont_v">
          <div>Nro. Operaciones</div>
        </td>
        <td>
          <div class="h">Fecha <br>del <br>Documento</div>
        </td>
        <td>
          <div class="h">N&deg; R.I.F. &oacute;<br />Cedula de <br />Identidad</div>
        </td>
        <td>
          <div class="h">Nombre &oacute; <br />Raz&oacute;n Social</div>
        </td>
        <td>
          <div class="h">Tipo <br />de <br />Cliente</div>
        </td>

        <td class="cont_v">
          <div>Nro. de Planilla de Exportaci&oacute;n</div>
        </td>
        <td class="cont_v">
          <div>Nro. del Expediente de Exportaci&oacute;n</div>
        </td>
        <td class="cont_v">
          <div>Nro. de Declaraci&oacute;n de Aduana</div>
        </td>
        <td class="cont_v">
          <div>Fecha de Declaraci&oacute;n de Aduana</div>
        </td>

        <td class="cont_v">
          <div>Serie del Documento</div>
        </td>
        <td class="cont_v">
          <div>Nro. del Documento</div>
        </td>
        <td class="cont_v">
          <div>Nro. de Control</div>
        </td>
        <td class="cont_v">
          <div>Registro de Maquina Fiscal</div>
        </td>
        <td class="cont_v">
          <div>Nro. de Reporte Z</div>
        </td>
        <td class="cont_v">
          <div>Nro. de Nota de Debito</div>
        </td>
        <td class="cont_v">
          <div>Nro. de Nota de Credito</div>
        </td>
        <td class="cont_v">
          <div>Tipo de Transacci&oacute;n</div>
        </td><!--tipo Venta-->

        <td class="cont_v">
          <div>Nro. de Documento <br>afectado</div>
        </td>

        <td class="cont_v">
          <div>Nro. de <br />Comprob <br />de <br />Retenci&oacute;n</div>
        </td>
        <td class="cont_v">
          <div>Fecha de <br />Aplicaci&oacute;n <br />de <br />Retenci&oacute;n</div>
        </td>

        <!--EXPORTACIONES-->
        <td class="cont_v">
          <div>Ventas Exportacion Exentas /Exoneradas</div>
        </td>
        <!--nacional-->
        <td class="cont_v">
          <div>Total de Venta Nacional incluyendo el IVA</div>
        </td>
        <td class="cont_v">
          <div>Ventas sin derecho a credito IVA</div>
        </td>
        <td class="cont_v">
          <div>Ventas Exentas</div>
        </td>
        <td class="cont_v">
          <div>Ventas Exoneradas</div>
        </td>
        <td class="cont_v">
          <div>Ventas no Sujetas</div>
        </td>
        <td class="cont_v">
          <div>Subtotal B.I. al 12%</div>
        </td>
        <td class="cont_v">
          <div>Subtotal B.I. al 8%</div>
        </td>
        <td class="cont_v">
          <div>Subtotal B.I. al 27%</div>
        </td>

        <td class="cont_v">
          <div>Subtotal B.I. al 12%</div>
        </td>
        <td class="cont_v">
          <div>Subtotal B.I. al 8%</div>
        </td>
        <td class="cont_v">
          <div>Subtotal B.I. al 27%</div>
        </td>
        <td class="cont_v">
          <div>Impuesto I.V.A.</div>
        </td>
        <td class="cont_v">
          <div>I.V.A. Retenido</div>
        </td>
        <!--ACCIONES-->
      </tr>
    </thead>
    <tbody>
                  
      <?php
      //$consulta esta arriba
      //acumulador
      $acum_msubt_exento_venta = 0;

      $acum_msubt_bi_iva_12_n = 0;
      $acum_msubt_bi_iva_8_n = 0;
      $acum_msubt_bi_iva_27_n = 0;

      $acum_msubt_bi_iva_12_n_CONTRI = 0;
      $acum_msubt_bi_iva_8_n_CONTRI = 0;
      $acum_msubt_bi_iva_27_n_CONTRI = 0;

      $acum_msubt_bi_iva_12_n_NO_CONTRI = 0;
      $acum_msubt_bi_iva_8_n_NO_CONTRI = 0;
      $acum_msubt_bi_iva_27_n_NO_CONTRI = 0;

      $acum_mtot_iva_venta_n =   0;
      $acum_IN_SDCF_venta_n  =  0;
      $acum_IN_EX_venta_n =     0;
      $acum_IN_EXO_venta_n  =  0;
      $acum_IN_NS_venta_n  =   0;

      $acum_msubt_exento_venta_export = 0;

      $acum_m_iva_reten = 0;
      $acum_tot_iva = 0;
      //contador de filas
      $nop = 1;
      do {
        //CONSULTAS RELACIONALES
        //consulta las notas si existen 
        $consulta2 = pg_query($conexion, sprintf("SELECT * FROM notas_cd_venta, fact_venta WHERE fact_venta.id_fact_venta = notas_cd_venta.id_fact_venta AND notas_cd_venta.id_fact_venta = '%s'", $filas['id_fact_venta']));
        // $filas2 = pg_fetch_assoc($consulta2);
        $filas2 = pg_fetch_assoc($consulta2);
        $total_ConsultaNota = pg_num_rows($consulta2);
        /////		FACTURA TOTALES EXPORTACIONES
        if ($filas['nplanilla_export'] != "") {
          $msubt_exento_venta_export = round($filas['mtot_iva_venta'], 2);
          /////////////////////////////////////////////
          $mtot_iva_venta_n = 0;
          $msubt_tot_bi_venta_n = 0;
          $msubt_bi_iva_12_n = 0;
          $msubt_bi_iva_8_n = 0;
          $msubt_bi_iva_27_n = 0;
          //ACUMULADORES
          $acum_msubt_exento_venta_export = $acum_msubt_exento_venta_export + round($filas['msubt_exento_venta'], 2);
          $acum_msubt_bi_iva_12_n = 0;
          $acum_msubt_bi_iva_8_n = 0;
          $acum_msubt_bi_iva_27_n = 0;
          /////		FACTURA TOTALES EXPORTACIONES	
        } elseif ($filas['nplanilla_export'] == "") {
          $msubt_exento_venta_export = 0;
          $acum_msubt_exento_venta_export = 0;
          //////////////////////////////////////////7
          $mtot_iva_venta_n = round($filas['mtot_iva_venta'], 2);
          //las excentas ya estan hechas por una funcion ya que estas son desglozadas
          $msubt_tot_bi_venta_n = round($filas['msubt_tot_bi_venta'], 2);
          $msubt_bi_iva_12_n = round($filas['msubt_bi_iva_12'], 2);
          $msubt_bi_iva_8_n = round($filas['msubt_bi_iva_8'], 2);
          $msubt_bi_iva_27_n = round($filas['msubt_bi_iva_27'], 2);
          //ACUMULADORES
          if ($filas['tipo_contri'] !== "NO_CONTRI") {
            $acum_msubt_bi_iva_12_n_NO_CONTRI = $acum_msubt_bi_iva_12_n + round($filas['msubt_bi_iva_12'], 2);
            $acum_msubt_bi_iva_8_n_NO_CONTRI = $acum_msubt_bi_iva_8_n + round($filas['msubt_bi_iva_8'], 2);
            $acum_msubt_bi_iva_27_n_NO_CONTRI = $acum_msubt_bi_iva_27_n + round($filas['msubt_bi_iva_27'], 2);
          } elseif ($filas['tipo_contri'] == "NO_CONTRI") {
            $acum_msubt_bi_iva_12_n_CONTRI = $acum_msubt_bi_iva_12_n + round($filas['msubt_bi_iva_12'], 2);
            $acum_msubt_bi_iva_8_n_CONTRI = $acum_msubt_bi_iva_8_n + round($filas['msubt_bi_iva_8'], 2);
            $acum_msubt_bi_iva_27_n_CONTRI = $acum_msubt_bi_iva_27_n + round($filas['msubt_bi_iva_27'], 2);
          }
          $acum_msubt_bi_iva_12_n = $acum_msubt_bi_iva_12_n + round($filas['msubt_bi_iva_12'], 2);
          $acum_msubt_bi_iva_8_n = $acum_msubt_bi_iva_8_n + round($filas['msubt_bi_iva_8'], 2);
          $acum_msubt_bi_iva_27_n = $acum_msubt_bi_iva_27_n + round($filas['msubt_bi_iva_27'], 2);

          $acum_msubt_exento_venta_export = $acum_msubt_exento_venta_export + round($filas['msubt_exento_venta'], 2);

          $acum_mtot_iva_venta_n =   $acum_mtot_iva_venta_n + round($filas['mtot_iva_venta'], 2);
          $acum_IN_SDCF_venta_n  =  $acum_IN_SDCF_venta_n + sumSinIVAventas($filas['id_fact_venta'], 'IN_SDCF');
          $acum_IN_EX_venta_n =     $acum_IN_EX_venta_n + sumSinIVAventas($filas['id_fact_venta'], 'IN_EX');
          $acum_IN_EXO_venta_n  =  $acum_IN_EXO_venta_n +  sumSinIVAventas($filas['id_fact_venta'], 'IN_EXO');
          $acum_IN_NS_venta_n  =   $acum_IN_NS_venta_n + sumSinIVAventas($filas['id_fact_venta'], 'IN_NS');
        }
        $acum_msubt_exento_venta = $acum_msubt_exento_venta + round($filas['msubt_exento_venta'], 2);
        $acum_m_iva_reten = $acum_m_iva_reten + round($filas['m_iva_reten'], 2);
        $acum_tot_iva = $acum_tot_iva + round($filas['tot_iva'], 2);
      ?>
        <tr>
          <!--Numero de Operqciones-->
          <td><?php echo $nop++; ?></td>
          <!--FACTURA-->
          <td><?php echo fechaInver($filas['fecha_fact_venta']) ?></td>
          <!--cliente-->
          <td><?php echo $filas['ced_cliente'] ?></td>
          <td><?php echo $filas['nom_cliente'];
              if ($total_consulta <= 0) echo "*** Sin Actividad Comercial ***"; ?></td>
          <td><?php if ($total_consulta > 0)
                echo condRif($filas['ced_cliente']);
              else
                echo 'PN'; ?></td><!--TIPO DE cliente-->

          <!--FACTURA EXPORTACIPONES-->
          <td><?php echo $filas['nplanilla_export'] ?></td>
          <td><?php echo $filas['nexpe_export'] ?></td>
          <td><?php echo $filas['naduana_export'] ?></td>
          <td><?php echo fechaInver($filas['fechaduana_export']) ?></td>
          <!--FACTURA-->
          <td><?php echo $filas['serie_fact_venta'] ?></td>
          <td><?php echo $filas['num_fact_venta'] ?></td>
          <td><?php echo $filas['num_ctrl_factventa'] ?></td>
          <!--registro z-->
          <td><?php echo $filas['reg_maq_fis'] ?></td>
          <td><?php echo $filas['num_repo_z'] ?></td>
          <!--FACTURA NOTA-->
          <td class="conter_table_nadatd">
            <table class="table_nada">
              <?php if ($total_consulta > 0) {
                do {
                  if ($filas2['tipo_notas_cd_venta'] == 'ND')
                    echo "<tr><td>" . $filas2['num_notas_cd_venta'] . "</td></tr>";
                } while ($filas2 = pg_fetch_assoc($consulta2));
              }
              ?>
            </table>
          </td>
          <td>
            <table class="table_nada">
              <?php if ($total_consulta > 0) {
                do {
                  if ($filas2['tipo_notas_cd_venta'] == 'NC')
                    echo "<tr><td>" . $filas2['num_notas_cd_venta'] . "</td></tr>";
                } while ($filas2 = pg_fetch_assoc($consulta2));
              }
              ?>
            </table>
          </td>
          <!--FACTURA RETENCION QUE Y A QUIEN-->
          <td><?php echo $filas['tipo_trans'] ?></td>
          <td><?php echo $filas['nfact_afectada'] ?></td>
          <!--FACTURA RETENCION-->
          <td><?php if ($filas['num_compro_reten'] != "") echo $filas['num_compro_reten'];
              else echo "-"; ?></td>
          <td><?php echo fechaInver($filas['fecha_compro_reten']) ?></td>
          <!--FACTURA TOTALES Exportacion-->
          <td><?php echo $msubt_exento_venta_export; ?></td>
          <!--FACTURA TOTALES nacional-->
          <td><?php echo $mtot_iva_venta_n; ?></td>
          <td><?php echo sumSinIVAventas($filas['id_fact_venta'], 'IN_SDCF') ?></td>
          <td><?php echo sumSinIVAventas($filas['id_fact_venta'], 'IN_EX') ?></td>
          <td><?php echo sumSinIVAventas($filas['id_fact_venta'], 'IN_EXO') ?></td>
          <td><?php echo sumSinIVAventas($filas['id_fact_venta'], 'IN_NS') ?></td>

          <td><?php if ($filas['tipo_contri'] != "NO_CONTRI") echo round($filas['msubt_bi_iva_12'], 2);
              else echo 0; ?></td>
          <td><?php if ($filas['tipo_contri'] != "NO_CONTRI") echo round($filas['msubt_bi_iva_8'], 2);
              else echo 0; ?></td>
          <td><?php if ($filas['tipo_contri'] != "NO_CONTRI") echo round($filas['msubt_bi_iva_27'], 2);
              else echo 0; ?></td>

          <td><?php if ($filas['tipo_contri'] == "NO_CONTRI") echo round($filas['msubt_bi_iva_12'], 2);
              else echo 0; ?></td>
          <td><?php if ($filas['tipo_contri'] == "NO_CONTRI") echo round($filas['msubt_bi_iva_8'], 2);
              else echo 0; ?></td>
          <td><?php if ($filas['tipo_contri'] == "NO_CONTRI") echo round($filas['msubt_bi_iva_27'], 2);
              else echo 0; ?></td>
          <!--monto total de impuesto IVA-->
          <td><?php echo round($filas['tot_iva'], 2) ?></td>
          <!--FACTURA TOTALES DE RETENCIONES-->
          <td><?php echo round($filas['m_iva_reten'], 2) ?></td>
        </tr>
      <?php } while ($filas = pg_fetch_assoc($consulta)); ?>
      <tr>
        <td colspan="20">Totales</td>
        <td><?php echo $acum_msubt_exento_venta_export; ?></td>
        <td><?php echo $acum_mtot_iva_venta_n; ?></td>
        <td><?php echo $acum_IN_SDCF_venta_n; ?></td>
        <td><?php echo $acum_IN_EX_venta_n; ?></td>
        <td><?php echo $acum_IN_EXO_venta_n; ?></td>
        <td><?php echo $acum_IN_NS_venta_n; ?></td>
        <td><?php echo $acum_msubt_bi_iva_12_n_NO_CONTRI ?></td>
        <td><?php echo $acum_msubt_bi_iva_8_n_NO_CONTRI ?></td>
        <td><?php echo $acum_msubt_bi_iva_27_n_NO_CONTRI; ?></td>

        <td><?php echo $acum_msubt_bi_iva_12_n_CONTRI; ?></td>
        <td><?php echo $acum_msubt_bi_iva_8_n_CONTRI; ?></td>
        <td><?php echo $acum_msubt_bi_iva_27_n_CONTRI; ?></td>

        <td><?php echo $acum_tot_iva; ?></td>
        <td><?php echo $acum_m_iva_reten; ?></td>
      </tr>
    </tbody>
  </table>
  <br>
  <br>
  <br>
  <br>
  <br>
  <!--RESUMEN DE LA VENTA-->
  <table cellspacing="0" class="tabla1 table">
    <tbody>
      <tr class="titulo">
        <td colspan="5">
          <div class="subTitulo">RESUMEN DE VENTAS DEl MES DE <?php echo mesNum_Texto($mes); ?></div>
        </td>
      </tr>
      <tr class="titulo">
        <td rowspan="2">
          <div class="subTitulo">Descripci&oacute;n</div>
        </td>
        <td colspan="2">Base Imponible</td>
        <td colspan="2">Debito Fiscal</td>
      </tr>
      <tr>
        <td>Item</td>
        <td>Monto</td>
        <td>Item</td>
        <td>Monto</td>
      </tr>

      <tr>
        <td>Ventas Internas No Gravadas</td>
        <td>40</td>
        <td><?php echo $acum_msubt_exento_venta; ?></td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr>
        <td>Ventas de Exportaci&oacute;n</td>
        <td>41</td>
        <td><?php echo $msubt_exento_venta_export; ?>
        </td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr>
        <td>Ventas Internas o Nacionales Gravadas por Alicuota General 12%</td>
        <td>42</td>
        <td><?php echo $acum_msubt_bi_iva_12_n; ?>
        </td>
        <td>43</td>
        <td><?php echo $msubt_iva_12 = $acum_msubt_bi_iva_12_n * 0.12; ?></td>
      </tr>
      <tr>
        <td>Ventas Internas o Nacionales Gravadas por Alicuota General mas Alicuota Adicional 27%</td>
        <td>442</td>
        <td><?php echo $acum_msubt_bi_iva_27_n; ?>
        </td>
        <td>452</td>
        <td><?php echo $msubt_iva_27 = $acum_msubt_bi_iva_27_n * 0.27; ?></td>
      </tr>
      <tr>
        <td>Ventas Internas o Nacionales Gravadas por Alicuota Reducida 8%</td>
        <td>333</td>
        <td><?php echo $acum_msubt_bi_iva_8_n; ?>
        </td>
        <td>343</td>
        <td><?php echo $msubt_iva_8 = $acum_msubt_bi_iva_8_n * 0.08; ?></td>
      </tr>
      <tr>
        <td><b>Total Ventas y Debitos Fiscales para Efectos de Determinacion:</b></td>
        <td>46</td>
        <td><?php echo $acum_msubt_exento_venta + $acum_msubt_bi_iva_12_n + $acum_msubt_bi_iva_27_n +  $acum_msubt_bi_iva_8_n; ?></td>
        <td>47</td>
        <td><?php echo $msubt_iva_12 + $msubt_iva_27 + $msubt_iva_8; ?></td>
      </tr>
    </tbody>
  </table>

  <div style="float:right;text-align: right;">
    <br />
    <br /><br />
    <table cellspacing="0" class="tabla1 table" style="text-align: right;">
      <thead>
        <tr>
          <td width="70px" class="titulo"><b style="text-align:center">I.V.A. Retenido por el Comprador</b></td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $acum_m_iva_reten; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
<?php
}
