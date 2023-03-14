<?php
// Incluir la librería
echo '<!--/*';
include_once 'cURL_rif_SENIAT.php';

// Crear la instancia y pasar como parámetro el RIF a verificar
//$rif = new Rif('G200003030');
//$rif = new Rif('J090322108');
//$rif = new Rif('v241501449');
$rif = new Rif($_POST['campo']);

// Obtener los datos fiscales
$datosFiscales = json_decode($rif->getInfo());

var_dump($datosFiscales);

// Chequear el código resultante
switch ($datosFiscales->code_result) {
  case 1:
    $texto  = 
			  '
			   <input type="text" class="form-control" name="nom_cliente" id="nom_cliente" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();" lang="si-general" value="'.$datosFiscales->seniat->nombre.'" required>
			   ';
    break;

  default:
    $texto = '
			   <input type="text" class="form-control" name="nom_cliente" id="nom_cliente" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();" lang="si-general" placeholder="'.$datosFiscales->message.'" value="" required>
			   ';
  break;
}

echo '*/-->'.$texto."";