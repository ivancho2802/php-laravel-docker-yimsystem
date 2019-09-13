<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');
//CODIGO DE INSERCION
if(isset($_POST['ced_cliente_m_nue']) && isset($_POST['ced_cliente_m_vie']) && isset($_POST['nom_cliente_m']) && isset($_POST['email_cliente_m']) && isset($_POST['tel_cliente_m']) && isset($_POST['dir_cliente_m']) && isset($_POST['fech_i_cliente_m']) ){
	$modRCliente = sprintf("UPDATE cliente SET 
									ced_cliente = '%s',
									nom_cliente = '%s',
									contri_cliente = '%s',
									email_cliente = '%s',
									tel_cliente = '%s',
									dir_cliente = '%s',
									fech_i_cliente = '%s'
									WHERE ced_cliente = '%s'",
									$_POST['ced_cliente_m_nue'],
								   $_POST['nom_cliente_m'],
								   $_POST['contri_cliente_m'],
								   $_POST['email_cliente_m'],
								   $_POST['tel_cliente_m'],
								   $_POST['dir_cliente_m'],
								   $_POST['fech_i_cliente_m'],
								   $_POST['ced_cliente_m_vie']);

  //mysql_select_db($database_conexPana, $conexPana);
  //SI NO SE REGISTR RETORNA DIE O MUERE EL PROCESO Y MUESTRA
  $ResultmodRCliente = pg_query($conexion,$modRCliente) or die('
	<div class="alert alert-danger fade in" role="alert">
			<strong>Opps!</strong> Algo ha salido mal nuestras disculpas Pongase en contacto con el Programador!.
			Error para Desarrollador: '.pg_last_error().'
			<button type="button" class="close" data-dismiss="alert" aria-label="close">&times;</button>
	</div>');
//HASTA AQUI CODIGO DE INSERCION
  //si llega ha esta linea quiere decir que no ha arrojado error RIGISTRO EXITOSO
  ?>
  <div class="alert alert-success fade in" role="alert">
    <strong>Excelente</strong> Modificacion exitosa <strong>Click para Volver</strong>.
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  
  <?php
}else{
	echo "Error no se enviaron algunos parametros que se esperaban";
	}