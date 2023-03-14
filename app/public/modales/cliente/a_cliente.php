<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

//CODIGO DE INSERCION
if(isset($_POST['ced_cliente']) && isset($_POST['nom_cliente']) && isset($_POST['email_cliente']) && 
   isset($_POST['tel_cliente']) && isset($_POST['dir_cliente']) && isset($_POST['fech_i_cliente']) ){
$insertSQL = sprintf("INSERT INTO cliente (ced_cliente, nom_cliente, contri_cliente, email_cliente, tel_cliente, dir_cliente, fech_i_cliente) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                       $_POST['ced_cliente'],
                       $_POST['nom_cliente'],
					   $_POST['contri_cliente'],
                       $_POST['email_cliente'],
					   $_POST['tel_cliente'],
					   $_POST['dir_cliente'],
					   $_POST['fech_i_cliente']);

  //SI NO SE REGISTR RETORNA DIE O MUERE EL PROCESO Y MUESTRA
  $Result1 = pg_query($conexion,$insertSQL) or die('
	<div class="alert alert-danger fade in" role="alert">
			<strong>Opps!</strong> Vuelva ha intentarlo algo ha salido mal nuestras disculpas!.
			Error CLIENTE: '.pg_last_error().'
			<button type="button" class="close" data-dismiss="alert" aria-label="close">&times;</button>
	</div>');
//HASTA AQUI CODIGO DE INSERCION
  //si llega ha esta linea quiere decir que no ha arrojado error RIGISTRO EXITOSO
  ?>
  <div class="alert alert-success fade in" role="alert">
    <strong>Excelente</strong> Registro y seleccion exitosa <strong>Click para Volver</strong>.
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  
  <?php
}else{
	echo "Error no se enviaron algunos parametros que se esperaban";
	}