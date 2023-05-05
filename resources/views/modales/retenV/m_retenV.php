<?php
	include_once('../../includes_SISTEM/include_head.php');
	include_once('../../includes_SISTEM/include_login.php');

//CODIGO DE MODIFICACION
$updateSQL = sprintf("UPDATE fact_venta SET fact_venta.num_compro_reten = '%s', fact_venta.fecha_compro_reten = '%s', fact_venta.m_iva_reten = '%s', fact_venta.mes_apli_reten = '%s', fk_usuariosV = '%s' WHERE fact_venta.id_fact_venta = '%s'",
                       $_POST['num_compro_reten'],
                       $_POST['fecha_compro_reten'],
                       $_POST['m_iva_reten'],
					   $_POST['mes_apli_reten'],
					   $_SESSION['id_usu'],
                       $_POST['id_fact_venta']);

  //SI NO SE REGISTR RETORNA DIE O MUERE EL PROCESO Y MUESTRA
  $Result1 = pg_query($conexion,$updateSQL) or die('
	<div class="alert alert-danger in" role="alert">
			<strong>Opps!</strong> Codigo Existente.
			Error para RETENCION: '.pg_last_error().'
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>');
//HASTA AQUI CODIGO DE INSERCION

//PARA INSERTAR EN REGISTRO PARA INV INICIAL
if($Result1)//&& isset($_POST['tipo']) && $_POST['tipo']=="inv_ini"
	{
  ?> 
  <div class="alert alert-success" role="alert">
    <strong>Excelente&grave;</strong> Registro exitoso <strong>Click para Volver</strong>.
    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
  </div>
  <?php		
	}
  //si llega ha esta linea quiere decir que no ha arrojado error RIGISTRO EXITOSO