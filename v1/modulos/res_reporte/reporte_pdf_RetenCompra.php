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
<style>
	.tabla_bordes {
		font-size: 12px;
		border: 1px solid;
		text-align: center;
	}

	.tabla_header {
		font-size: 12px;
		text-align: left;
	}

	b {
		font-size: 12px;
	}

	span {
		font-size: 12px;
	}
</style>
<?php
if (isset($_POST['num_compro_reten'])) {
	//consulta de los datos de la empreas PARA SABE LA ACTIVA 
	$consulta2 = pg_query($conexion, "SELECT * FROM empre WHERE empre.est_empre = '1'");
	// $filasEmpre = pg_fetch_assoc($consultaEmpre);
	$filas2 = pg_fetch_assoc($consulta2);
	$total_consultaEmpre = pg_num_rows($consulta2);

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
?>
	<page_header>
		<table style="width: 90%;">
			<tr>
				<td style="text-align: left;	width: 33%"><?php echo "Sistema " . $_SESSION["alias"] . " - " . $_SESSION["version"] ?></td>
				<td style="text-align: center;	width: 34%">Reporte de Comprobante de Retencion</td>
				<td style="text-align: right;	width: 33%">Fecha de Generaci&oacute;n<?php echo date('d/m/Y'); ?></td>
			</tr>
		</table>
	</page_header>
	<page_footer>
		<table style="width: 100%;">
			<tr>
				<td style="text-align: center;	width: 35%">________________________________</td>
				<td style="text-align: center;	width: 30%">________________________________</td>
				<td style="text-align: center;	width: 35%">________________________________</td>
			</tr>
			<tr>
				<td style="text-align: center;	width: 35%">FIRMA AGENTE DE RETENCI&Oacute;N</td>
				<td style="text-align: center;	width: 30%">FIRMA BENEFICIARIO</td>
				<td style="text-align: center;	width: 35%">FECHA DE RECEPCI&Oacute;N</td>
			</tr>
			<tr>
				<td style="text-align: left;	width: 50%"><?php echo "Sistema " . $_SESSION["alias"] . " - " . $_SESSION["version"] ?></td>
				<td style="text-align: right;	width: 50%">page [[page_cu]]/[[page_nb]]</td>
			</tr>
		</table>
	</page_footer>
	<br>
	<br>
	<br>
	<table cellpadding="0" cellspacing="0" class="tabla1 table" style="width: 100%;">
		<thead>
			<tr>
				<th colspan="14" class="tabla_header"><span style="font-size:18px;">
						<?php echo utf8_decode($filasEmpre['titular_rif_empre'] . " - " . $filasEmpre['nom_empre']); ?>
					</span></th>
			</tr>
			<tr>
				<th colspan="14" class="tabla_header">
					<div>&nbsp;</div>
				</th>
			</tr><!--NO QUITE EL DIV ES EL QUE HACE PONER LA TABLA AL 100-->
			<tr>
				<th colspan="12" class="tabla_header">Direcci&oacute;n: &nbsp;<?php echo utf8_decode($filas['dir_empre']); ?></th>
				<th colspan="2" class="tabla_bordes">PERIODO FISCAL</th>
			</tr>
			<tr>
				<th colspan="12" class="tabla_header">Telf. <?php echo $filas['tel_empre']; ?></th>
				<th class="tabla_bordes">A&ntilde;o</th>
				<th class="tabla_bordes">Mes</th>
			</tr>
			<tr>
				<th colspan="12" class="tabla_header">Rif: <?php echo $filas['rif_empre']; ?></th>
				<th colspan="2" class="tabla_bordes"><?php echo $filas['mes_apli_reten']; ?></th>
			</tr>
			<!--
    <tr>
    	<th colspan="12" class="tabla_header">Contribuyente <?php //echo $filas['contri_empre'];
															?></th>
    </tr>
    <tr><th colspan="4" class="tabla_header">Comprobantes de Retencion: <?php //echo $_POST['num_compro_reten'];
																		?></th></tr>
    -->
			<tr>
				<th>&nbsp;</th>
			</tr>
			<tr>
				<th>&nbsp;</th>
			</tr>
			<tr>
				<th class="tabla_bordes">Dia</th>
				<th class="tabla_bordes">Mes</th>
				<th class="tabla_bordes">A&ntilde;o</th>
				<th>&nbsp;</th>
				<th colspan="6">COMPROBANTE DE RETENCI&Oacute;N del I.V.A.</th>
				<th colspan="2"><b>Nro. de Comprobante:</b></th>
				<th colspan="2"><?php echo $filas['num_compro_reten']; ?></th>
			</tr>
			<?php $fech_format 	= date_create($filas['fecha_compro_reten']);
			$fech_format_d 	= date_format($fech_format, 'd');
			$fech_format_m_t = mesNum_Texto_solo(date_format($fech_format, 'm'));
			$fech_format_a 	= date_format($fech_format, 'Y');
			?>
			<tr>
				<th class="tabla_bordes"><?php echo $fech_format_d; ?></th>
				<th class="tabla_bordes"><?php echo $fech_format_m_t; ?></th>
				<th class="tabla_bordes"><?php echo $fech_format_a; ?></th>
				<th>&nbsp;</th>
				<th colspan="10" rowspan="3">
					<p>&#40;
						Ley IVA - Art. 11: &quot; Seran responsables del pago del impuesto en calidad de agente de retenci&oacute;n los compradores<br />
						o adquirientes de determinados bienes muebles y los receptores de ciertos servicios&#44; a quienes la administraci&oacute;n<br />
						tributaria designe como tal
						&quot;&#41;</p>
				</th>
			</tr>
			<tr>
				<th>&nbsp;</th>
			</tr>
			<tr>
				<th>&nbsp;</th>
			</tr>
			<tr>
				<th>&nbsp;</th>
			</tr>
			<?php //funcion para convertir la fechaa mes en letras y ano
			?>
			<tr>
				<td class="titulo" colspan="3"><b>Nombre &oacute; Raz&oacute;n Social:</b></td>
				<td class="titulo tabla_bordes" colspan="4"><?php echo utf8_decode($filas['nombre']); ?></td>
				<td class="titulo tabla_bordes" colspan="7"></td>
			</tr>
			<tr>
				<td class="titulo" colspan="3"><b>Nro. de R.I.F. :</b></td>
				<td class="titulo tabla_bordes" colspan="4"><?php echo $filas['rif']; ?></td>
				<td class="titulo tabla_bordes" colspan="7"></td>
			</tr>
			<tr>
				<td class="titulo" colspan="3"><b>Direcci&oacute;n Fiscal:</b></td>
				<td class="titulo tabla_bordes" colspan="4"><?php echo utf8_decode($filas['direccion']); ?></td>
				<td class="titulo tabla_bordes" colspan="7"></td>
			</tr>
			<tr class="titulo">
				<td class="h"><b>Op Nro.</b></td>
				<td class="h"><b>Fecha de <br>Factura</b></td>
				<td class="h"><b>Numero de<br> Factura</b></td>
				<td class="h"><b>Numero <br>Control de<br> Factura</b></td>
				<td class="h"><b>Numero <br>Nota de <br>Credito</b></td>
				<td class="h"><b>Numero <br>Nota de <br>Debito</b></td>
				<td class="h"><b>Tipo de <br>Transacci&oacute;n</b></td>
				<td class="h"><b>Numero de <br>Factura <br>Afectada</b></td>
				<td class="h"><b>Total <br>Compras <br>Incluyendo <br>I.V.A.</b></td>
				<td class="h"><b>Compras <br>Sin <br>Derecho a <br>Credito <br>I.V.A.</b></td>
				<td class="h"><b>Base <br>Imponible</b></td>
				<td class="h"><b>&#37; Alicuotas</b></td>
				<td class="h"><b>Impuesto <br>I.V.A.</b></td>
				<td class="h"><b>Monto I.V.A. <br>Retenido</b></td>
			</tr>
		</thead>
		<tbody>
			<?php $nop = 1;
			do {
				//consulta las notas si existen 
				$consulta3 = pg_query($conexion, sprintf("SELECT * FROM notas_cd, fact_compra WHERE fact_compra.id_fact_compra = notas_cd.id_fact_compra AND notas_cd.id_fact_compra = '%s'", $filas['id_fact_compra']));
				// $filasConsultaNota = $consultaNota->fetch_assoc();
				$filas3 = pg_fetch_assoc($consulta3);
				$total_consulta3 = pg_num_rows($consulta3);
				$alicuotas = "";
				if ($filas['msubt_bi_iva_12'] > 0) {
					$alicuotas = $alicuotas . "12";
				}
				if ($filas['msubt_bi_iva_8'] > 0) {
					$alicuotas = $alicuotas . ", 8";
				}
				if ($filas['msubt_bi_iva_27'] > 0) {
					$alicuotas = $alicuotas . ", 27";
				}
			?>
				<tr>
					<td><span><?php echo $nop++; ?></span></td>
					<td><span><?php echo fechaInver($filas['fecha_fact_compra']); ?></span></td>
					<td><span><?php echo $filas['num_fact_compra']; ?></span></td>
					<td><span><?php echo $filas['num_ctrl_factcompra']; ?></span></td>
					<td class="conter_table_nadatd">
						<table class="table_nada">
							<?php if ($total_consulta > 0) {
								do {
									if ($filasconsulta3['tipo_notas_cd'] == 'NC')
										echo "<tr><td>" . $filasconsulta3['num_notas_cd'] . "</td></tr>";
								} while ($filasconsulta3 = pg_fetch_assoc($consulta3));
							}
							?>
						</table>
					</td>
					<td>
						<table class="table_nada">
							<?php if ($total_consulta > 0) {
								do {
									if ($filasconsulta3['tipo_notas_cd'] == 'ND')
										echo "<tr><td>" . $filasconsulta3['num_notas_cd'] . "</td></tr>";
								} while ($filasconsulta3 = pg_fetch_assoc($consulta3));
							}
							?>
						</table>
					</td>
					<td><span><?php echo $filas['tipo_trans']; ?></span></td>
					<td><span><?php echo $filas['nfact_afectada']; ?></span></td>
					<td><span><?php echo round($filas['mtot_iva_compra'], 2) ?></span></td>
					<td><span><?php echo round($filas['msubt_exento_compra'], 2); ?></span></td>
					<td><span><?php echo round($filas['msubt_tot_bi_compra'], 2); ?></span></td>
					<td><span><?php echo $alicuotas; ?></span></td>
					<td><span><?php echo round($filas['tot_iva'], 2) ?></span></td>
					<td><span><?php echo round($filas['m_iva_reten'], 2); ?></span></td>
				</tr>
			<?php } while ($filas = pg_fetch_assoc($consulta)); ?>
		</tbody>
	</table>
	<br>
	<br>
	<br>
	<br>
	<br>
<?php } //si se envia um_reten
?>