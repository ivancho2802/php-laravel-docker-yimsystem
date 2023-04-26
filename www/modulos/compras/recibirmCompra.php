<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');
//asignacion de 			NEGATIVOS O NO
//echo $_POST['nfact_afectada'];

if ($_POST['tipo_fact_compra'] == "NC-DEVO" || $_POST['tipo_fact_compra'] == "NC-DESC") {
	$negativo = -1;
	$mtot_iva_compra = $_POST['mtot_iva_compra'] * $negativo;
	$tot_iva = $_POST['tot_iva'] * $negativo;
	$msubt_exento_compra = $_POST['msubt_exento_compra'] * $negativo;
	$msubt_tot_bi_compra = $_POST['msubt_tot_bi_compra'] * $negativo;
	$msubt_bi_iva_12 = $_POST['msubt_bi_iva_12'] * $negativo;
	$msubt_bi_iva_8 = $_POST['msubt_bi_iva_8'] * $negativo;
	$msubt_bi_iva_27 = $_POST['msubt_bi_iva_27'] * $negativo;
} else {
	$mtot_iva_compra = $_POST['mtot_iva_compra'];
	$tot_iva = $_POST['tot_iva'];
	$msubt_exento_compra = $_POST['msubt_exento_compra'];
	$msubt_tot_bi_compra = $_POST['msubt_tot_bi_compra'];
	$msubt_bi_iva_12 = $_POST['msubt_bi_iva_12'];
	$msubt_bi_iva_8 = $_POST['msubt_bi_iva_8'];
	$msubt_bi_iva_27 = $_POST['msubt_bi_iva_27'];
}
//insertar en FACT_COMPRA
$sql = sprintf(
	"UPDATE fact_compra SET 
									 id_fact_compra = '%s',
									 num_ctrl_factcompra = '%s', 
									 fecha_fact_compra = '%s', 
									 tipo_trans = '%s', 
									 nfact_afectada = '%s', 
									 tipo_fact_compra = '%s', 
									 
									 fk_usuariosC = '%s', 
									 empre_cod_empre = '%s', 
									 nplanilla_import ='%s', 
									 nexpe_import = '%s', 
									 naduana_import = '%s', 
									 fechaduana_import = '%s',  
									 mtot_iva_compra = '%s', 
									 tot_iva = '%s', 
									 msubt_exento_compra = '%s', 
									 msubt_tot_bi_compra = '%s', 
									 msubt_bi_iva_12 = '%s', 
									 msubt_bi_iva_8 = '%s', 
									 msubt_bi_iva_27 = '%s',
									 hora_fact_compra = '%s',
									 fecha_fact_compra_reg = '%s'
									 WHERE id_fact_compra = '%s'",
	//$_POST['serie_fact_compra'],//v
	//$_POST['num_fact_compra'],//v
	$_POST['id_fact_compra_old'],
	$_POST['num_ctrl_factcompra'], //v
	$_POST['fecha_fact_compra'], //v
	$_POST['tipo_trans'], //v

	$_POST['nfact_afectada'], //v
	$_POST['tipo_fact_compra'], //v tipo del documento

	//$_POST['fk_proveedor'],//v
	$_POST['fk_usuariosC'], //v
	$_POST['empre_cod_empre'], //v

	$_POST['nplanilla_import'], //v
	$_POST['nexpe_import'], //v
	$_POST['naduana_import'], //v
	$_POST['fechaduana_import'], //v
	$mtot_iva_compra, //v
	$tot_iva, //v
	$msubt_exento_compra, //v
	$msubt_tot_bi_compra, //v
	$msubt_bi_iva_12, //v
	$msubt_bi_iva_8, //v
	$msubt_bi_iva_27,
	date('H:i:s'),
	date('Y/m/d'),
	$_POST['id_fact_compra']
); //v
//ndebito_factcompra, ncredito_factcompra,// , %s, %s// $_POST['ndebito_factcompra'],$_POST['ncredito_factcompra'],

$res = pg_query($conexion, $sql) or die('Factura NO realizada con éxito<br />' . pg_last_error());
if ($res) {

	/////////////////////////////////////////////////////////////
	//
	//				REVERTIR LO QUE TENIA ANTES
	//
	/////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////
	//CONSULTA PARA SABER QUE COMPRAS PERTENECEN A ESTA FACTURA PARA RESTARLE ESAS COMPRAS AL INVENTARIO
	////////////////////////////////////////////////////////////

	$consulta = pg_query($conexion, sprintf(
		"SELECT * FROM compra WHERE compra.fk_fact_compra = '%s'",
		$_POST['id_fact_compra']
	));

	// $filas = $sql_compra->fetch_assoc();
	$filas = pg_fetch_assoc($consulta);

	if ($filas) {
		do {
			//CANTIDAD COMPRADA Y QUE PRODUCTO
			//////////////////////////////////////
			$cant_compra = $filas['cantidad'];
			$prod_compra = $filas['fk_inventario'];

			//CONSULTA DE LO QUE HAY ACTUALMENTE ES ESE PRODUCTO
			$consulta2 = pg_query($conexion, sprintf(
				"SELECT * FROM inventario WHERE 
													codigo = '%s'",
				$prod_compra
			));
			// $filas2 = $sqlInventActual->fetch_assoc();
			$filas2 = pg_fetch_assoc($consulta2);

			///////////////////////////////////////////////////////
			//REVERTIR ACTUALIZACION DEL INVENTARIO REVIRTIENDO LO QUE SE COMPRO SEGUN LA COMPRA
			////////////////////////////////////////////////////////			
			//RESTA DE LA CANTIDAD ACTUAL MENOS LA CANTIDAD QUE SE COMPRO
			$cant_final = $filas2['stock'] - $cant_compra;

			//ACTUALIZACION DEL INVENTARIO REVIRTIENDO LO QUE SE COMPRO SEGUN LA COMPRA
			$sqlUpdateRevetInven = sprintf(
				"UPDATE inventario SET stock ='%s' WHERE 
									codigo = '%s'",
				$cant_final,
				$prod_compra
			);
			$UpdateRevetInven = pg_query($conexion, $sqlUpdateRevetInven) or
				die('Error al actualizar inventario Revirtiendo cantidad<br />' . pg_last_error());
			///////////////////////////////////////////////////////
			//REVERTIR BORRAR COMPRAS Y REGISTRO DE COMPRAS
			////////////////////////////////////////////////////////
			//BORRADO DE LAS COMPRAS DE ESTA FACTURA
			$sqlDeleteRevetCompra = sprintf(
				"DELETE FROM compra WHERE  
									id_compra = '%s'",
				$filas['id_compra']
			);
			$DeleteRevetCompra = pg_query($conexion, $sqlDeleteRevetCompra) or
				die('Error al borrar compras de la factura Revirtiendo compra<br />' . pg_last_error());
		} while ($filas = pg_fetch_assoc($consulta));
	} // IF HAY RFESULTADOS D LA CONSULTA D LA COMPRA DE LA FACTURA

	///////////////////////////////////////////////////////
	//REVI¿ERTIR COSTO PROMEDIADO METER EL NUMERO DE FACTURA
	//////////////////////////////////////////////////////
	//BORRADO DE LAS reg_inventario DE ESTA FACTURA
	//EL PROMEDIADO SALE SOLO PUES AL AGREGAR LOS NUEVOS LOS REGISTROS EN LA TABLA REG_NVENTARIO YA NO ESTARAN

	$sqlDeleteRevetRegInv = sprintf(
		"DELETE FROM reg_inventario WHERE  
							fk_fact_cv = '%s' AND
							tipo = 'compra'",
		$_POST['id_fact_compra']
	);
	$DeleteRevetRegInv = pg_query($conexion, $sqlDeleteRevetRegInv) or
		die('Error al borrar registro inventario de la factura <br />' . pg_last_error());
	/////////////////////////////////////////////////////////////
	//
	//				AGREGAR AL INVENTARIO Y DEMAS
	//
	//////////////////////////////////////////////////////////// 
	$acumCamposN = "";
	for ($i = 1; $i <= $_POST['numCampos']; $i++) {
		if (isset($_POST["id_compra$i"])) { //IF ESTE CAMPO SE ENVIA procedo


			//funcion modificar inventario basado en la cantidad

			//consul de todos los costos de este producto
			$consulta3 = pg_query($conexion, sprintf("SELECT * FROM reg_inventario , inventario, compra ,fact_compra WHERE 
					reg_inventario.fk_fact_cv = fact_compra.id_fact_compra AND
					compra.fk_fact_compra = fact_compra.id_fact_compra AND
					compra.fk_inventario = inventario.codigo AND
					reg_inventario.fk_inventario = compra.fk_inventario AND
					inventario.codigo = '%s' AND
					reg_inventario.tipo = 'compra' ORDER BY reg_inventario.fecha_reg_inv DESC", $_POST["fk_inventario$i"]));
			// $filas3 = $sql_consul_costo->fetch_assoc();
			$filas3 = pg_fetch_assoc($consulta3);

			//consulta de la cantidad actual
			$consulta4 = pg_query($conexion, sprintf(
				"SELECT * FROM inventario WHERE
												inventario.codigo = '%s'",
				$_POST["fk_inventario$i"]
			));
			// $filas4 = $sql_consul_inven->fetch_assoc();
			$filas4 = pg_fetch_assoc($consulta4);

			//para el precio o costo este es el promediado de precios
			//OJO EL valor_unitario ES IGUAL A COSTO PROMEDIADO ACTUAL
			//EL VALOR PROMEDIADO ES ESTIMULADO MEDIANTE CADA COMPRA

			if ($sql_consul_inven["valor_unitario"] !== $_POST["costo$i"]) { //si costo del inventario viejo es diferente al del inventario nuevo

				//acumular costos * cantidades para promediar
				$monto_actual = 0;
				do {

					$monto_actual = $monto_actual + ($filas3['costo_reg_inv'] * $filas3['cantidad']);
				} while ($filas3 = pg_fetch_assoc($consulta3));

				$monto_actual = $monto_actual + ($_POST["costo$i"] * $_POST["cantidad$i"]);
				$tot_cant = $filas4["stock"] + $_POST["cantidad$i"];

				$costo_promediado = $monto_actual / $tot_cant;
			} else
				$costo_promediado = $_POST["costo$i"];


			//ACTUALIZA SUMA AL INVENTARIO//para la cantidad actual resultado de la compra
			//SI ES ND SUMO al inventario 
			//SI ES NC RESTO al inventario

			if ($_POST['tipo_fact_compra'] == "NC-DEVO")			//RESTO
				$stock_cantidad = $filas4['stock'] - $_POST["cantidad$i"];
			elseif ($_POST['tipo_fact_compra'] == "NC-DESC" || $_POST['tipo_fact_compra'] == "ND")
				$stock_cantidad = $filas4['stock']; //NO RESTO
			else // $_POST['tipo_fact_compra'] == "ND")		//SUMO NORMAL
				$stock_cantidad = $filas4['stock'] + $_POST["cantidad$i"];

			if ($res) {
				$sqlUpdateInven = sprintf(
					"UPDATE inventario SET stock = '%s', 
														valor_unitario = '%s',
														pmpvj_actual = '%s'	
														WHERE codigo = '%s' ",
					$stock_cantidad,
					$costo_promediado,
					$_POST["pmpvj$i"],
					$_POST["fk_inventario$i"]
				);

				$UpdateInven = pg_query($conexion, $sqlUpdateInven) or die('Error al actualizar inventario:<br />' . pg_last_error());
			}

			if ($UpdateInven && $res) {
				//INSERTAR PARA EL  REGISTRO DE INVENTARIO LO ACTUAL SEGUN LA FECHA PARA KARDEX
				$InsertRegInv = sprintf(
					"INSERT INTO reg_inventario( fecha_reg_inv, costo_reg_inv, cantidad_reg_inv, pmpvj, tipo, fk_inventario, fk_fact_cv, hora_registro, fecha_registro) VALUES
												('%s','%s','%s','%s','%s','%s','%s','%s','%s')",
					$_POST['fecha_fact_compra'],
					$costo_promediado, //costo actual para esta fecha
					$stock_cantidad, //cantidad actual para esta fecha
					$_POST["pmpvj$i"], //precio de ventas al publico
					"compra",
					$_POST["fk_inventario$i"],
					$_POST['id_fact_compra'],
					date('H:i:s'),
					date('Y/m/d')
				);
				$resInsertRegInv = pg_query($conexion, $InsertRegInv) or die('registro inventario NO realizada con éxito:<br />' . pg_last_error());
			}

			//insertar en productor ala compra del inventario tiene que existir en el inventarui sino
			/*
			$camposN = "('".$_POST["id_compra$i"]."','".$_POST["tipoCompra$i"]."','". $_POST["fk_inventario$i"]."','".$_POST["costo$i"]."','".$_POST["cantidad$i"]."','".$_POST["id_fact_compra"]."')";
			if($i == 1)
				$acumCamposN = $camposN;	
			else
				$acumCamposN = $acumCamposN .",". $camposN;
			*/

			if ($resInsertRegInv) {
				//insertando compra
				$sql2 = sprintf(
					"INSERT INTO compra
				(id_compra, tipoCompra, fk_inventario, costo, cantidad, fk_fact_compra) VALUES 			
				('%s', '%s', '%s', '%s', '%s', '%s')",
					$_POST["id_compra$i"],
					$_POST["tipoCompra$i"],
					$_POST["fk_inventario$i"],
					$_POST["costo$i"],
					$_POST["cantidad$i"],
					$_POST["id_fact_compra"]
				);

				$res2 = pg_query($conexion, $sql2) or die('Compra NO realizada con éxito:<br />' . pg_last_error());
			}
		} //IF ESTE CAMPO SE ENVIA procedo
	} //FOR	
?>

	<div class="container" align="center">
		<div class="page-header">
			<h1>Atencion en Compras</h1>
		</div>
		<div class="theme-showcase">
			<div class="row">
				<div class="alert alert-success fade in" role="alert">
					<strong>Excelente!</strong> Compra Modificada con Exito.
					<span class="glyphicon glyphicon-ok text-success"></span>
					<button type="button" class="close" data-dismiss="alert" aria-label="close">×</button>
				</div>
			</div>
			<div class="row">
				<!--
       		<div class="col-xs-12 col-md-4 col-lg-4">
                <form name="form1" method="post" action="libroCompra.php">
                    <button class="btn btn-danger" type="submit">
                        <span class="fa fa-file-pdf-o" style="font-size:40px;" title="PDF"></span>
                    </button>
                    <br>
                    <label>Ver Libro de Compras</label>
                </form>
            </div>
            -->
				<div class="col-xs-12 col-md-12 col-lg-12">
					<form name="form2" method="post" action="modificarCompra.php">
						<button class="btn btn-success glyphicon glyphicon-plus" title="NUEVO" type="submit">

						</button>
						<br>
						<label>Modificar Otra Compra</label>
					</form>
				</div>
				<!--
            <div class="col-xs-12 col-md-4 col-lg-4">
                <form name="form3" method="post" action="../home/status.php">
                    <button class="btn btn-success glyphicon glyphicon-home" title="HOME" type="submit">
                    </button> 
                    <br>
                    <label>Volver a Home</label>
                </form>	
            </div>
            -->
			</div><!--ROW-->
		</div><!--theme-showcase-->
	</div><!--CONTAINER-->
<?php
} else {
	echo 'Error al Modificar Factura Compra';
}
?>