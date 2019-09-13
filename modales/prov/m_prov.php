<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');
//CODIGO DE INSERCION
if(isset($_POST['rif_nue']) && isset($_POST['rif_vie']) && isset($_POST['nombre']) && isset($_POST['telefono']) && isset($_POST['direccion'])){
	$modRProv = sprintf("UPDATE proveedor SET 
									rif = '%s',
									nombre = '%s',
									telefono = '%s',
									direccion = '%s'
									WHERE rif = '%s'",
									$_POST['rif_nue'],
									$_POST['nombre'],
									$_POST['telefono'],
									$_POST['direccion'],
									$_POST['rif_vie']);

  //mysql_select_db($database_conexPana, $conexPana);
  //SI NO SE REGISTR RETORNA DIE O MUERE EL PROCESO Y MUESTRA
  $Result1 = pg_query($conexion,$modRProv) or die('
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