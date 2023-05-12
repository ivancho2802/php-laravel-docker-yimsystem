<?php
/**
*   OBTENER CUENAT PARA EL PROVEEDOR
*/

include_once('../../includes_SISTEM/include_head.php');
include_once('../../includes_SISTEM/include_login.php');
//CODIGO DE CONAULTA
if(isset($_GET['cuenta']) ){
    $consulta=pg_query($conexion,sprintf("SELECT * FROM cuenta cu, categ_cuenta cat_cu 
                                        INNER JOIN categoria cat
                                        ON cat_cu.fk_categoria = cat.id
                                        WHERE
                                            cu.id = '%s' OR
                                            cat.id = '%s' OR
                                            cat.nombre LIKE '%s%%' OR
                                            cat.descripcion LIKE '%s%%'  OR
                                            cu.nombre LIKE '%s%%' OR
                                            cu.descripcion LIKE '%s%%';",
                                            
                                            $_GET['cuenta'], $_GET['cuenta'], $_GET['cuenta'], $_GET['cuenta'], $_GET['cuenta'], $_GET['cuenta'], $_GET['cuenta']));
  //mysql_select_db($database_conexPana, $conexPana);
  //SI NO SE REGISTR RETORNA DIE O MUERE EL PROCESO Y MUESTRA
  $consulta or die('
    <div class="alert alert-danger fade in" role="alert">
            <strong>Opps!</strong> Vuelva ha intentarlo algo ha salido mal nuestras disculpas!.
            Error para PROVEEDOR: '.pg_last_error().'
            <button type="button" class="close" data-dismiss="alert" aria-label="close">&times;</button>
    </div>');
    //HASTA AQUI CODIGO DE CONAULTA
    //si llega ha esta linea quiere decir que no ha arrojado error RIGISTRO EXITOSO
    $filas=pg_fetch_assoc($consulta);
    $total_consulta = pg_num_rows($consulta);
    
    if($total_consulta<=0){
        ?>
        <div class="alert alert-danger fade in" role="alert">
            <strong>Opps!</strong> Vuelva ha intentarlo algo ha salido mal nuestras disculpas!.
            Error para PROVEEDOR: '.pg_last_error().'
            <button type="button" class="close" data-dismiss="alert" aria-label="close">&times;</button>
        </div>
        <?php
    }else{
        do{
            ?>
            <div class="input-group">
              <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" class="form-control" name="cuentaasoc"  onChange="selectcuenta($event)" aria-label="Radio button for following text input" required>
                </div>
              </div>
              <!-- <input type="text" class="form-control" aria-label="Text input with radio button"> -->
              <label ><?php echo  $filas['categ_cuenta.id'] .' '. $filas['categoria.nombre'] .' '. $filas['cuenta.nombre'].' '. $filas['cuenta.descripcion']?></label>
            </div>
            <?php
        }while($filas=pg_fetch_assoc($consulta)); 
    }

}else{
    echo "Error no se enviaron algunos parametros que se esperaban";
}