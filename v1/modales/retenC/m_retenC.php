<?php
	include_once('../../includes_SISTEM/include_head.php');
	include_once('../../includes_SISTEM/include_login.php');

//CODIGO DE MODIFICACION
$updateSQL = sprintf("UPDATE fact_compra SET fact_compra.num_compro_reten = '%s', fact_compra.fecha_compro_reten = '%s', fact_compra.m_iva_reten = '%s', fact_compra.mes_apli_reten = '%s', fk_usuariosC = '%s' WHERE fact_compra.id_fact_compra = '%s'",
                       $_POST['num_compro_reten'],
                       $_POST['fecha_compro_reten'],
                       $_POST['m_iva_reten'],
					   $_POST['mes_apli_reten'],
					   $_SESSION['id_usu'],
                       $_POST['id_fact_compra']);

  //SI NO SE REGISTR RETORNA DIE O MUERE EL PROCESO Y MUESTRA
  $Result1 = pg_query($conexion,$updateSQL) or die('
	<div class="alert alert-danger in" role="alert">
			<strong>Opps!</strong> Codigo Existente.
			Error para RETENCION: '.pg_last_error().'
			<button type="button" class="close" data-dismiss="alert" aria-label="close">&times;</button>
	</div>');
//HASTA AQUI CODIGO DE INSERCION

//PARA INSERTAR EN REGISTRO PARA INV INICIAL
if($Result1)//&& isset($_POST['tipo']) && $_POST['tipo']=="inv_ini"
	{
  ?> 
  <div class="alert alert-success" role="alert">
    <strong>Excelente!</strong> Registro exitoso <strong>Click para Volver</strong>.
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <?php		
	}
  //si llega ha esta linea quiere decir que no ha arrojado error RIGISTRO EXITOSO