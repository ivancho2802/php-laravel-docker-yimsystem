<?php
//funcion consulta campra venta para este inventario si no pues muestro en inventario inicial y inventario salida que es el mismo salida
/* c_cv_inventario(docigo inventario, mes inicial,mes final ,accion
															/miicu"mostrar inventario inicial costo unitario"
															/miic"mostrar inventario inicial cantidad"
															/miim"mostrar inventario inicial monto"
															
															/mcc"mostrar compras cantidad"
															/mcm"mostrar compras monto"
															
															/mvc"mostrar ventas cantidad"
															/mvm"mostrar ventas monto"
															
															/mcdc"mostrar compras devoluciones cantidad"
															/mcdm"mostrar compras devoluciones monto"
																														
															/mirc"mostrar inventario retiros cantidad"
															/mirm"mostrar inventario retiros monto"
															
															/mifc"mostrar inventario final cantidad"
															/mifm"mostrar inventario final monto"
															
															*/

function c_cv_inventario($codigoInv, $fechai, $fechaf, $accion)
{
  ////////////////////			COMPRA
  $conexion =  pg_connect("host=ec2-3-222-30-53.compute-1.amazonaws.com port=5432 dbname=d8dgaqfecs81l5 user=bbefneimvprfqo password=fdd8bcae207b03ec7f030d1f42b3c3b7234743f3208a3a022a6f523f35163c94");
  $consulta = pg_query($conexion, sprintf("SELECT * FROM compra, fact_compra, inventario WHERE
								fact_compra.id_fact_compra = compra.fk_fact_compra AND 
								compra.fk_inventario = inventario.codigo AND 
								inventario.codigo = '%s' AND
								fact_compra.tipo_fact_compra = 'F' AND
								fact_compra.fecha_fact_compra BETWEEN '%s' AND '%s'", $codigoInv, $fechai, $fechaf));

  // $filas_c_inventario = pg_fetch_assoc($consulta);
  $filas = pg_fetch_assoc($consulta);

  $total_c_inventario = pg_num_rows($consulta);
  //	DEVOLUCIONES			NC-DEVO		mcdc
  $consulta2 = pg_query($conexion, sprintf(
    "SELECT * FROM compra, fact_compra, inventario WHERE
								fact_compra.id_fact_compra = compra.fk_fact_compra AND 
								compra.fk_inventario = inventario.codigo AND 
								inventario.codigo = '%s' AND
								fact_compra.tipo_fact_compra = 'NC-DEVO' AND
								fact_compra.fecha_fact_compra BETWEEN '%s' AND '%s';",
    $codigoInv,
    $fechai,
    $fechaf
  ));
  // $filas_cd_inventario = $cd_inventario->fetch_assoc();
  $filas2 = pg_fetch_assoc($consulta2);
  $total_cd_inventario = pg_num_rows($consulta2);

  ///////////////////// 			VENTA
  $consulta3 = pg_query($conexion, sprintf(
    "SELECT * FROM venta, fact_venta, inventario WHERE
										fact_venta.id_fact_venta = venta.fk_fact_venta AND 
										venta.fk_inventario = inventario.codigo AND 
										inventario.codigo = '%s' AND
										fact_venta.fecha_fact_venta BETWEEN '%s' AND '%s'",
    $codigoInv,
    $fechai,
    $fechaf
  ));
  // $filas_v_inventario = $v_inventario->fetch_assoc();
  $filas3 = pg_fetch_assoc($consulta3);
  $total_v_inventario = pg_num_rows($consulta3);
  ////////////////////			INVENTARIO INICIAL
  $consulta5 = pg_query($conexion, sprintf(
    "SELECT * FROM inventario, reg_inventario WHERE 
								reg_inventario.fk_inventario = inventario.codigo AND
																				inventario.codigo = '%s' AND
																				reg_inventario.fecha_reg_inv < '%s'
																				ORDER BY reg_inventario.fecha_reg_inv DESC",
    $codigoInv,
    $fechai
  )); //asi la menor o la mas cercana
  // $filas_inv_ini = $inv_ini->fetch_assoc();
  $filas5 = pg_fetch_assoc($consulta5);
  $total_inv_ini = pg_num_rows($consulta5);

  ////////////////////			INVENTARIO FINAL
  $consulta6 = pg_query($conexion, sprintf(
    "SELECT * FROM inventario, reg_inventario WHERE 
											reg_inventario.fk_inventario = inventario.codigo AND
											inventario.codigo = '%s' AND
											reg_inventario.fecha_reg_inv <= '%s'
											ORDER BY reg_inventario.fecha_reg_inv DESC, reg_inventario.hora_registro DESC",
    $codigoInv,
    $fechaf
  ));
  // $filas_inv_fin = $inv_fin->fetch_assoc();
  $filas6 = pg_fetch_assoc($consulta6);
  $total_inv_fin = pg_num_rows($consulta6);
  ////////////////////			INVENTARIO RETIROS
  $consulta4 = pg_query($conexion, sprintf(
    "SELECT * FROM inventario, inventario_retiros WHERE 
							inventario_retiros.fk_inventario = inventario.codigo AND
							inventario.codigo = '%s' AND
							inventario_retiros.fecha_inv_retiros BETWEEN '%s' AND '%s'",
    $codigoInv,
    $fechai,
    $fechaf
  ));
  // $filas_ir = $ir->fetch_assoc();
  $filas4 = pg_fetch_assoc($consulta4);
  $total_ir = pg_num_rows($consulta4);
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////7
  if ($accion == "mcc") { //mostrar compra cantidad
    $acum_cc = 0;
    do {
      $acum_cc += $filas["cantidad"];
    } while ($filas = pg_fetch_assoc($consulta));
    return $acum_cc;
  } elseif ($accion == "mcm") { //mostrar compras monto (o costo)
    $acum_cm = 0;
    do {
      $acum_cm += $filas["cantidad"] * $filas["costo"]; //este costo es unitario se pide el monto total
    } while ($filas = pg_fetch_assoc($consulta));
    return round($acum_cm, 2);
    ///////////////////////////////////////////////////////////	
  } elseif ($accion == "mvc") { //mostrar ventas cantidad
    $acum_vc = 0;
    do {
      $acum_vc += $filas3["cantidad"];
      //echo $acum_vc;
    } while ($filas3 = pg_fetch_assoc($consulta3));
    return $acum_vc;
  } elseif ($accion == "mvm") { //mostrar ventas monto
    $acum_vm = 0;
    do {
      $acum_vm += $filas3["cantidad"] * $filas3["costo"];
    } while ($filas3 = pg_fetch_assoc($consulta3));
    return round($acum_vm, 2);
  } elseif ($accion == "mcdc") { //mostrar compras devoluciones cantidad
    $acum_cdc = 0;
    do {
      $acum_cdc += $filas2["cantidad"];
      //echo $acum_vc;
    } while ($filas2 = pg_fetch_assoc($consulta2));
    return $acum_cdc;
  } elseif ($accion == "mcdm") { //mostrar compras devoluciones monto
    $acum_cdm = 0;
    do {
      $acum_cdm += $filas2["cantidad"] * $filas2["costo"];
    } while ($filas2 = pg_fetch_assoc($consulta2));
    return round($acum_cdm, 2);
  } elseif ($accion == "mirc") { //mostrar retiros cantidad
    $acum_irc = 0;
    do {
      $acum_irc += $filas4["cant_inv_retiros"];
    } while ($filas4 = pg_fetch_assoc($consulta4));
    return $acum_irc;
  } elseif ($accion == "mirm") { //mostrar retiros monto
    $acum_irm = 0;
    do {
      $acum_irm += $filas4["cant_inv_retiros"] * $filas4["costo_a"];
    } while ($filas4 = pg_fetch_assoc($consulta4));
    return round($acum_irm, 2);
  } elseif ($accion == "miicu") {
    return round($filas5["costo_reg_inv"], 2);
  } elseif ($accion == "miic") {
    return $filas5["cantidad_reg_inv"];
  } elseif ($accion == "miim") {
    return round($filas5["cantidad_reg_inv"] * $filas5["costo_reg_inv"], 2);
  } elseif ($accion == "mifc") {
    return $filas6["cantidad_reg_inv"];
  } elseif ($accion == "mifm") {
    return round($filas6["cantidad_reg_inv"] * $filas6["costo_reg_inv"], 2);
  }
}


//function sumSiniva()
function sumSinIVA($numdocu, $tipo)
{
  $sumSinIVA = 0;
  $conexion =  pg_connect("host=ec2-3-222-30-53.compute-1.amazonaws.com port=5432 dbname=d8dgaqfecs81l5 user=bbefneimvprfqo password=fdd8bcae207b03ec7f030d1f42b3c3b7234743f3208a3a022a6f523f35163c94");
  //consulta de las compras exentas
  $consulta7 = pg_query($conexion, sprintf("SELECT * FROM compra, fact_compra WHERE fact_compra.id_fact_compra = compra.fk_fact_compra AND compra.fk_fact_compra = '%s' AND compra.tipoCompra = '%s'", $numdocu, $tipo));
  // $filas_consultaExen = $consultaExen->fetch_assoc();
  $filas7 = pg_fetch_assoc($consulta7);
  $total_consultaExen = pg_num_rows($consulta7);

  do {
    $sumSinIVA += ($filas7['costo'] * $filas7['cantidad']);
  } while ($filas7 = pg_fetch_assoc($consulta7));

  return round($sumSinIVA, 2);
}
//function sumSiniva()
function sumSinIVAventas($numdocu, $tipo)
{
  $sumSinIVA = 0;
  $conexion =  pg_connect("host=ec2-3-222-30-53.compute-1.amazonaws.com port=5432 dbname=d8dgaqfecs81l5 user=bbefneimvprfqo password=fdd8bcae207b03ec7f030d1f42b3c3b7234743f3208a3a022a6f523f35163c94");
  //consulta de las compras exentas
  $consulta = pg_query($conexion, sprintf("SELECT * FROM venta, fact_venta WHERE fact_venta.id_fact_venta = venta.fk_fact_venta AND venta.fk_fact_venta = '%s' AND venta.tipoVenta = '%s'", $numdocu, $tipo));
  $filas = pg_fetch_assoc($consulta);
  $total_consultaExen = pg_num_rows($consulta);

  do {
    $sumSinIVA += ($filas['costo'] * $filas['cantidad']);
  } while ($filas = pg_fetch_assoc($consulta));

  return round($sumSinIVA, 2);
}

function mesNum_Texto_solo($num_mes)
{
  // switch ($num_mes) {
  $mes = "";
  if ($num_mes ==  "01")
    $mes = "Enero";
  else if ($num_mes ==  "02")
    $mes = "Febrero";
  else if ($num_mes ==  "03")
    $mes = "Marzo";
  else if ($num_mes ==  "04")
    $mes = "Abril";
  else if ($num_mes ==  "05")
    $mes = "Mayo";
  else if ($num_mes ==  "06")
    $mes = "Junio";
  else if ($num_mes ==  "07")
    $mes = "Julio";
  else if ($num_mes ==  "08")
    $mes = "Agosto";
  else if ($num_mes ==  "09")
    $mes = "Septiembre";
  else if ($num_mes ==  "10")
    $mes = "Octubre";
  else if ($num_mes ==  "11")
    $mes = "Noviembre";
  else if ($num_mes ==  "12")
    $mes = "Diciembre";
  return $mes;
}

//mesNum_Texto
function mesNum_Texto($fecha_mes)
{
  if ($fecha_mes !== '0000-00-00') {
    $fecha_separada = explode("-", $fecha_mes);
    //echo $fecha_separada[1];

    $mes = mesNum_Texto_solo($fecha_separada[1]);
    //convierte a mayusculas con el año
    $mesMayus = strtoupper($mes);
    return $mesMayus . " DE " . $fecha_separada[0];
  }
}
//funcion para invertir las fechas al mostrar
function fechaInver($fecha_mes)
{

  if ($fecha_mes == "0000-00-00" || $fecha_mes == "") {
    return "-";
  } else {
    $fechaformat = date_create($fecha_mes);
    return date_format($fechaformat, 'd-m-Y');
  }
}
//funciuon para obtener si es condicion
function condRif($rif)
{

  $letraRif = substr($rif, 0, 1);

  if ($letraRif == 'J' || $letraRif == 'G')
    $condRif = 'PJ';
  else
    $condRif = 'PN';

  return $condRif;
}
