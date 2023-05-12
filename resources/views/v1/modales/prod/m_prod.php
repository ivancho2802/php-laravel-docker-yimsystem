<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

//CODIGO DE INSERCION
if(isset($_POST['codigo_m_m_prod_vie']) && isset($_POST['codigo_m_m_prod_nue']) && isset($_POST['nombre_i_m_m_prod']) && isset($_POST['cant_min_m_m_prod']) && isset($_POST['cant_max_m_m_prod']) && isset($_POST['descripcion_m_m_prod'])  ){

$modRProd = sprintf("UPDATE inventario SET 
									codigo = '%s',
									nombre_i = '%s',
									cant_min = '%s',
									cant_max = '%s',
									descripcion = '%s'
									WHERE codigo = '%s'",
									$_POST['codigo_m_m_prod_nue'],
									$_POST['nombre_i_m_m_prod'],
									$_POST['cant_min_m_m_prod'],
									$_POST['cant_max_m_m_prod'],
									$_POST['descripcion_m_m_prod'],
									$_POST['codigo_m_m_prod_vie']);

  //mysql_select_db($database_conexion);
  //SI NO SE REGISTR RETORNA DIE O MUERE EL PROCESO Y MUESTRA
  $ResultmodRProd = pg_query($conexion,$modRProd) or die('
	<div class="alert alert-danger in" role="alert">
			<strong>Opps!</strong> Codigo Existente.
			Error para PRODUCTO: '.pg_last_error().'
			<button type="button" class="close" data-dismiss="alert" aria-label="close">&times;</button>
	</div>');
//HASTA AQUI CODIGO DE INSERCION
  ?>
  <div class="alert alert-success" role="alert">
    <strong>Excelente&grave;</strong> Modificaci&oacute;n exitosa <strong>Click para Volver</strong>.
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  
  <?php
}else{
	echo "Error no se enviaron algunos parametros que se esperaban";
}