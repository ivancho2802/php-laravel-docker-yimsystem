<?php
    $extra = "../../";
    //llamando de modales el id es "addCuenta"
    include_once($extra."modales/cuentas/m_a_cuenta.php");
    include_once('../../includes_SISTEM/include_head.php');
    include_once('../../includes_SISTEM/include_login.php');
    //consulta de los datos de la empreas PARA SABE LA ACTIVA 
    $consulta = pg_query($conexion, sprintf("
                                        SELECT * FROM 
                                            cuenta
                                        WHERE 
                                            cuenta.fk_empre = '%s'", $_SESSION["id_usu"]));
    /* cu, categ_cuenta cat_cu 
                                        INNER JOIN 
                                            categoria cat
                                        ON 
                                            cat_cu.fk_categoria = cat.id */

    // $filas = pg_fetch_assoc($consultaEmpre);
    $filas=pg_fetch_assoc($consulta);
    $total_consulta = pg_num_rows($consulta);
?>
<div id="cuentas"  class="bs-example">
    <div class="">
        <h1 class="bd-title">Cuentas </h1>
    </div>
        <!-- col-xs-12 col-md-4 col-lg-4 -->
        <div class="form-group">
          <form method="POST">
                <label class="control-label">Consulta Por Numero, nombre y categorias</label>
                <input type="text" class="form-control" name="cuenta" id="cuenta" > 
                <button type="submit" class="list-group-item active" >Buscar</button>
          </form>
          <form method="POST" action="listar_submit">
            <button class="list-group-item list-group-item-secondary" type="button" onclick="modaladdcuenta()">Crear Cuenta!</button>
            <!-- <button class="btn btn-primary" type="button" click="loadcrearcuenta()">Crear Cuenta!</button> -->
          </form>
        </div>

</div><!--cuentas-->
<hr id="res_cuentas" class="featurette-divider"/>
<?php
    //validando que la fecha o ano que se introduzca no sea menor al menor del sistema
    $param = isset($_POST['cuenta']) ? $_POST['cuenta'] :'';
    $consulta = pg_query($conexion, sprintf("SELECT * FROM cuenta cu, categ_cuenta cat_cu 
                            INNER JOIN categoria cat
                            ON cat_cu.fk_categoria = cat.id 
                            WHERE 
                            cat.fk_empre = '%s' AND 
                            cu.id LIKE '%s%%' OR
                            cat.id LIKE '%s%%' OR
                            cat.nombre LIKE '%s%%' OR
                            cat.descripcion LIKE '%s%%'  OR
                            cu.nombre LIKE '%s%%' OR
                            cu.descripcion LIKE '%s%%';", $_SESSION["id_usu"], $param, $param, $param, $param, $param, $param));
    // $filas = pg_fetch_assoc($consultaEmpre);
    $filas=pg_fetch_assoc($consulta);
    $total_consulta = pg_num_rows($consulta);
    
    if($total_consulta > 0){
        // TABLA DE CONSULTA 
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>N° Categoria</td>
                    <td>Nombre Categoria</td>
                    <td>N° Cuenta</td>
                    <td>Nom Cuenta</td>
                    <td>Descrip</td>
                    <td>Categoria</td>
                </tr>
            </thead>
            <tbody>
                <?php do{?>
                    <tr>
                        <td><?php echo $filas['cat.id'];?></td>
                        <td><?php echo $filas['cat.nombre'];?></td>
                        <td><?php echo $filas['cu.id'];?></td>
                        <td><?php echo $filas['cu.nombre'];?></td>
                        <td><?php echo $filas['cu.descripcion'];?></td>
                    </tr>
                <?php }while($filas = pg_fetch_assoc($consulta)); ?>
            </tbody>
        </table>
        <?php
    }else{
        ?>
        <p>no hay resultados</p>
        <?php
    } 