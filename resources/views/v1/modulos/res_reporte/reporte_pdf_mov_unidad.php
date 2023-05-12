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

	td,
	th,
	div,
	span {
		font-size: 12px;
	}

	span {
		font-size: 12px;
	}

	.tabla1 {
		cellpadding: 0;
		cellspacing: 0;
	}
</style>
<?php
////////////////////////////////
//	DATOS DE CONEXION y de consulta decisiones
///////////////////////////////
//	consulta de los datos de la empreas PARA SABE LA ACTIVA 
$consulta = pg_query($conexion, "SELECT * FROM empre WHERE empre.est_empre = '1'");
// $filasEmpre = pg_fetch_assoc($consultaEmpre);
$filas = pg_fetch_assoc($consulta);
$total_consultaEmpre = pg_num_rows($consulta);
//	CONSULTA DE TODO LO QUE HAY EN EL INVENTARIO PARA MOSTRARLO JUNTO CON SU MOVIMIN¿ENTO
$consulta2 = pg_query($conexion, sprintf("SELECT * FROM inventario WHERE 1=1 ORDER BY codigo"));
// $filas_inventario=$sql_inventario->fetch_assoc();
$filas2 = pg_fetch_assoc($consulta2);
$total_inventario = pg_num_rows($consulta2);
//
if (isset($_POST['mes']) || isset($_POST['ano']) || (isset($_POST['fechai']) && isset($_POST['fechaf'])) || isset($_POST['dia'])) {
	//validando que la fecha o ano que se introduzca no sea menor al menor del sistema
	/*SELECT fact_compra.fecha_fact_compra AS fecha FROM fact_compra
		UNION
		SELECT fact_venta.fecha_fact_venta AS fecha FROM fact_venta
		UNION
		SELECT inventario_retiros.fecha_inv_retiros AS fecha FROM inventario_retiros
		UNION
		SELECT reg_inventario.fecha_reg_inv AS fecha FROM reg_inventario
		ORDER BY fecha ASC*/
	$consulta3 = pg_query($conexion, sprintf("SELECT fact_compra.fecha_fact_compra AS fecha FROM fact_compra
		UNION
		SELECT fact_venta.fecha_fact_venta AS fecha FROM fact_venta
		UNION
		SELECT inventario_retiros.fecha_inv_retiros AS fecha FROM inventario_retiros
		UNION
		SELECT reg_inventario.fecha_reg_inv AS fecha FROM reg_inventario
		ORDER BY fecha ASC"));
	// $filas_fecha_menor = $sql_fecha_menor->fetch_assoc();
	$filas3 = pg_fetch_assoc($consulta3);
	$total_fecha_menor = pg_num_rows($consulta3);

	//completando con ano y/o mes la fecha
	if (isset($_POST['mes'])) {
		$mes = $_POST['mes'];
		$fechai = $mes . "-01";
		$fechaf = ($mes == '02') ? $mes . "-28" : ((int) $mes % 2 == 0) ? $mes . "-31" : $mes . "-30";
		//echo $filas3['fecha'];

	} elseif (isset($_POST['ano'])) {
		$ano = $_POST['ano'];
		if ($ano >= substr($filas3['fecha'], 0, 4))
			$fechai = $filas3['fecha'];
		else
			$fechai = "errorano";
		$fechaf = $ano . "-12-31";
	} elseif (isset($_POST['fechai']) && isset($_POST['fechaf'])) {
		$fechai = $_POST['fechai'];
		$fechaf = $_POST['fechaf'];
	} elseif (isset($_POST['dia'])) {
		$dia = $_POST['dia'];
		if ($dia >= $filas3['fecha']) {
			$fechai = $_POST['dia'];
			$fechaf = $_POST['dia'];
		} else
			$fechai = "errorano";
	}

	if ($fechai == "errorano" || $fechai < $filas3['fecha']) //para AÑO o mes y 
	{
		echo "Error con la fecha debe ser mayor a mes de " . mesNum_Texto($filas3['fecha']);
	} else {
?>
		<page_header>
			<table style="width: 100%;">
				<tr>
					<td style="text-align: left;	width: 33%"><?php echo "Sistema " . $_SESSION["alias"] . " - " . $_SESSION["version"] ?></td>
					<td style="text-align: center;	width: 34%">Reporte Movimiento de Unidades</td>
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
<?php
		/////////////////////////////
		//	TABLA DE LA CONSULT6A
		///////////////////////////
		include_once($extra . 'modulos/invent/movUnidadTab.php');
	}
} else echo "NO SE HAN ENVIADO LAS VARIABLES DE FECHA";
?>