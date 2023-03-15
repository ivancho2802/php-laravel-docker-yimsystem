<?php
/*
	DATOS DE RETOTRNO
				nombre" => $datosFiscales->nombres.' '.utf8_decode($datosFiscales->apellidos)
				, "nacionalidad" => $datosFiscales->nacionalidad
				, "cedula" => $datosFiscales->cedula
				, "cvestado" => $datosFiscales->cvestado
				, "cvmunicipio" => $datosFiscales->cvmunicipio
				, "cvparroquia" => $datosFiscales->cvparroquia
				, "direccion" => $datosFiscales->direccion
*/
///////////////////////////////////////
//	CAMPOS DE RETORNO
/*	 
*/	 
///////////////////////////////////////
// Incluir la librería
include_once 'cURL_CNE.php';
$curls = new SearchCurl();
// VALIDACION






	// Obtener los datos fiscales
	$datosFiscales = json_decode($curls-> SearchCNE("V", "24150144"));
	
	
				

//$datosFiscales = json_decode($datoJson);
 var_dump($datosFiscales);
//echo ;

/*
// Chequear el código resultante
switch ($datosFiscales->code_result) {
  case 1:
    $texto  = array(  "nombre" => $datosFiscales->seniat->nombre
					, "agenteretencioniva" => $datosFiscales->seniat->agenteretencioniva
					, "contribuyenteiva" => $datosFiscales->seniat->contribuyenteiva
					, "tasa" => $datosFiscales->seniat->tasa);
	echo utf8_decode($texto[$_POST['posVec']]);
    break;

  default:
    $texto = $datosFiscales->message;
	echo $texto;
  break;
}
*/