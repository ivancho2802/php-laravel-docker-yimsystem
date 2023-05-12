<?php

///////////////////////////////////////
//	CAMPOS DE RETORNO
/*	 * [code_result] = -2: Formato de rif inválido
     *                 -1: No hay soporte a curl
     *                  0: No hay conexion a internet
     *                  1: Consulta satisfactoria
     *      Otherwise:
     *                450: Formato de rif invalido
     *                452: Rif no existe
     *
     * [seniat]      =  nombre: [CADENA CON EL NOMBRE]
     *                  agenteretensioniva: [SI|NO]
     *                  contribuyenteiva: [SI|NO]
     *                  tasa: [VACIO|ENTERO MONTO TASA]
*/	 
///////////////////////////////////////
// Incluir la librería
//echo '<!--/*';
include_once 'cURL_rif_SENIAT.php';

// Crear la instancia y pasar como parámetro el RIF a verificar
//$rif = new Rif('G200003030');
//$rif = new Rif('J090322108');
//$rif = new Rif('v241501449');
$rif = new Rif($_POST['campo']);

// Obtener los datos fiscales
$datosFiscales = json_decode($rif->getInfo());

//var_dump($datosFiscales);

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
    echo $datosFiscales->message;
  break;
}