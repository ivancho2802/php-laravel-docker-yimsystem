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
															
function c_cv_inventario($codigoInv, $fechai, $fechaf, $accion){
	////////////////////			COMPRA
	$conexion = new mysqli("localhost", "root", "", "panaderia");
	$c_inventario = $conexion->query(sprintf("SELECT * FROM compra, fact_compra, inventario WHERE
								fact_compra.id_fact_compra = compra.fk_fact_compra AND 
								compra.fk_inventario = inventario.codigo AND 
								inventario.codigo = '%s' AND
								fact_compra.tipo_fact_compra = 'F' AND
								fact_compra.fecha_fact_compra BETWEEN '%s' AND '%s'", $codigoInv, $fechai,$fechaf));
	$filas_c_inventario = $c_inventario->fetch_assoc();
	$total_c_inventario = mysqli_num_rows($c_inventario);
	//	DEVOLUCIONES			NC-DEVO		mcdc
	$cd_inventario = $conexion->query(sprintf("SELECT * FROM compra, fact_compra, inventario WHERE
								fact_compra.id_fact_compra = compra.fk_fact_compra AND 
								compra.fk_inventario = inventario.codigo AND 
								inventario.codigo = '%s' AND
								fact_compra.tipo_fact_compra = 'NC-DEVO' AND
								fact_compra.fecha_fact_compra BETWEEN '%s' AND '%s'", 
								$codigoInv, $fechai,$fechaf));
	$filas_cd_inventario = $cd_inventario->fetch_assoc();
	$total_cd_inventario = mysqli_num_rows($cd_inventario);
	
	///////////////////// 			VENTA
	$v_inventario = $conexion->query(sprintf("SELECT * FROM venta, fact_venta, inventario WHERE
										fact_venta.id_fact_venta = venta.fk_fact_venta AND 
										venta.fk_inventario = inventario.codigo AND 
										inventario.codigo = '%s' AND
										fact_venta.fecha_fact_venta BETWEEN '%s' AND '%s'", 
										$codigoInv, $fechai,$fechaf));
	$filas_v_inventario = $v_inventario->fetch_assoc();
	$total_v_inventario = mysqli_num_rows($v_inventario);
	////////////////////			INVENTARIO INICIAL
	$inv_ini = $conexion->query(sprintf("SELECT * FROM inventario, reg_inventario WHERE 
								reg_inventario.fk_inventario = inventario.codigo AND
																				inventario.codigo = '%s' AND
																				reg_inventario.fecha_reg_inv < '%s'
																				ORDER BY reg_inventario.fecha_reg_inv DESC", 
																				$codigoInv, $fechai));//asi la menor o la mas cercana
	$filas_inv_ini = $inv_ini->fetch_assoc();
	$total_inv_ini = mysqli_num_rows($inv_ini);
	
	////////////////////			INVENTARIO FINAL
	$inv_fin = $conexion->query(sprintf("SELECT * FROM inventario, reg_inventario WHERE 
											reg_inventario.fk_inventario = inventario.codigo AND
											inventario.codigo = '%s' AND
											reg_inventario.fecha_reg_inv <= '%s'
											ORDER BY reg_inventario.fecha_reg_inv DESC, reg_inventario.hora_registro DESC", 
											$codigoInv, $fechaf));
	$filas_inv_fin = $inv_fin->fetch_assoc();
	$total_inv_fin = mysqli_num_rows($inv_fin);
	////////////////////			INVENTARIO RETIROS
	$ir = $conexion->query(sprintf("SELECT * FROM inventario, inventario_retiros WHERE 
							inventario_retiros.fk_inventario = inventario.codigo AND
							inventario.codigo = '%s' AND
							inventario_retiros.fecha_inv_retiros BETWEEN '%s' AND '%s'", 
							$codigoInv, $fechai, $fechaf));
	$filas_ir = $ir->fetch_assoc();
	$total_ir = mysqli_num_rows($ir);
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////7
	if($accion == "mcc"){//mostrar compra cantidad
		$acum_cc = 0;
		do{
			$acum_cc += $filas_c_inventario["cantidad"];
		}while($filas_c_inventario = $c_inventario->fetch_assoc());
		return $acum_cc;
	}elseif($accion == "mcm"){//mostrar compras monto (o costo)
		$acum_cm = 0;
		do{
			$acum_cm += $filas_c_inventario["cantidad"] * $filas_c_inventario["costo"];//este costo es unitario se pide el monto total
		}while($filas_c_inventario = $c_inventario->fetch_assoc());
		return round($acum_cm,2);
	///////////////////////////////////////////////////////////	
	}elseif($accion == "mvc"){//mostrar ventas cantidad
		$acum_vc = 0;
		do{
			$acum_vc += $filas_v_inventario["cantidad"];
			//echo $acum_vc;
		}while($filas_v_inventario = $v_inventario->fetch_assoc());
		return $acum_vc;
	}elseif($accion == "mvm"){//mostrar ventas monto
		$acum_vm = 0;
		do{
			$acum_vm += $filas_v_inventario["cantidad"] * $filas_v_inventario["costo"];
		}while($filas_v_inventario = $v_inventario->fetch_assoc());
		return round($acum_vm,2);
	}elseif($accion == "mcdc"){//mostrar compras devoluciones cantidad
		$acum_cdc = 0;
		do{
			$acum_cdc += $filas_cd_inventario["cantidad"];
			//echo $acum_vc;
		}while($filas_cd_inventario = $cd_inventario->fetch_assoc());
		return $acum_cdc;
	}elseif($accion == "mcdm"){//mostrar compras devoluciones monto
		$acum_cdm = 0;
		do{
			$acum_cdm += $filas_cd_inventario["cantidad"] * $filas_cd_inventario["costo"];
		}while($filas_cd_inventario = $cd_inventario->fetch_assoc());
		return round($acum_cdm,2);
	}elseif($accion == "mirc"){//mostrar retiros cantidad
		$acum_irc = 0;
		do{
			$acum_irc += $filas_ir["cant_inv_retiros"];
		}while($filas_ir = $ir->fetch_assoc());
		return $acum_irc;
	}elseif($accion == "mirm"){//mostrar retiros monto
		$acum_irm = 0;
		do{
			$acum_irm += $filas_ir["cant_inv_retiros"] * $filas_ir["costo_a"];
		}while($filas_ir = $ir->fetch_assoc());
		return round($acum_irm,2);
	}elseif($accion == "miicu"){
		return round($filas_inv_ini["costo_reg_inv"],2);
	}elseif($accion == "miic"){
		return $filas_inv_ini["cantidad_reg_inv"];
	}elseif($accion == "miim"){
		return round($filas_inv_ini["cantidad_reg_inv"] * $filas_inv_ini["costo_reg_inv"],2);
	}elseif($accion == "mifc"){
		return $filas_inv_fin["cantidad_reg_inv"];
	}elseif($accion == "mifm"){
		return round($filas_inv_fin["cantidad_reg_inv"] * $filas_inv_fin["costo_reg_inv"],2);
	}
}


//function sumSiniva()
function sumSinIVA($numdocu, $tipo){
	$sumSinIVA = 0;
	$conexion = new mysqli("localhost", "root", "", "panaderia");
	//consulta de las compras exentas
	$consultaExen = $conexion->query(sprintf("SELECT * FROM compra, fact_compra WHERE fact_compra.id_fact_compra = compra.fk_fact_compra AND compra.fk_fact_compra = '%s' AND compra.tipoCompra = '%s'", $numdocu, $tipo));
	$filas_consultaExen = $consultaExen->fetch_assoc();
	$total_consultaExen = mysqli_num_rows($consultaExen);
	
	do{
		$sumSinIVA += ($filas_consultaExen['costo'] * $filas_consultaExen['cantidad']);
	}while($filas_consultaExen=$consultaExen->fetch_assoc());
	
	return round($sumSinIVA,2);
}
//function sumSiniva()
function sumSinIVAventas($numdocu, $tipo){
	$sumSinIVA = 0;
	$conexion = new mysqli("localhost", "root", "", "panaderia");
	//consulta de las compras exentas
	$consultaExen = $conexion->query(sprintf("SELECT * FROM venta, fact_venta WHERE fact_venta.id_fact_venta = venta.fk_fact_venta AND venta.fk_fact_venta = '%s' AND venta.tipoVenta = '%s'", $numdocu, $tipo));
	$filas_consultaExen = $consultaExen->fetch_assoc();
	$total_consultaExen = mysqli_num_rows($consultaExen);
	
	do{
		$sumSinIVA += ($filas_consultaExen['costo'] * $filas_consultaExen['cantidad']);
	}while($filas_consultaExen=$consultaExen->fetch_assoc());

	return round($sumSinIVA,2);
}

function mesNum_Texto_solo($num_mes){
		switch ($num_mes) {
		
		case "01":
			$mes="Enero";
		  break;
		case "02":
			$mes="Febrero";
		  break;
		case "03":
			$mes="Marzo";
		  break;
		case "04":
			$mes="Abril";
		  break;
		case "05":
			$mes="Mayo";
		  break;
		case "06":
			$mes="Junio";
		  break;
		case "07":
			$mes="Julio";
		  break;
		case "08":
			$mes="Agosto";
		  break;
		case "09":
			$mes="Septiembre";
		  break;
		case "10":
			$mes="Octubre";
		  break;
		case "11":
			$mes="Noviembre";
		  break;
		case "12":
			$mes="Diciembre";
		  break;
	
		default:
		  break;
	  }
	  return $mes;
}

//mesNum_Texto
function mesNum_Texto($fecha_mes){
 if ($fecha_mes !== '0000-00-00'){
  $fecha_separada=explode("-", $fecha_mes);
  //echo $fecha_separada[1];
	
  $mes = mesNum_Texto_solo($fecha_separada[1]);
  //convierte a mayusculas con el año
  $mesMayus = strtoupper($mes);
  return $mesMayus." DE ".$fecha_separada[0];
 }
}
//funcion para invertir las fechas al mostrar
function fechaInver($fecha_mes){
	
	if($fecha_mes == "0000-00-00" || $fecha_mes == "")
	{
		return "-";
	}else{
		$fechaformat = date_create($fecha_mes); 
		return date_format($fechaformat, 'd-m-Y');	
	}
}
//funciuon para obtener si es condicion
function condRif($rif){
	
	$letraRif = substr($rif,0 ,1);
	
	if($letraRif == 'J' || $letraRif == 'G')
		$condRif = 'PJ';
	else
		$condRif = 'PN';
	
	return $condRif;
	}
?>