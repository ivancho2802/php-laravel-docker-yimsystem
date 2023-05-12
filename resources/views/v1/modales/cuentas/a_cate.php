<?php
include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');

//CODIGO DE INSERCION
if(isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['descripcion'])  ){
  $insertSQL = sprintf("INSERT INTO categoria (id, nombre, descripcion, fk_empre) VALUES ('%s', '%s', '%s', '%s' )",
                       $_POST['id'], 
                       $_POST['nombre'], 
                       $_POST['descripcion'],
                       $_SESSION["id_usu"]);

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