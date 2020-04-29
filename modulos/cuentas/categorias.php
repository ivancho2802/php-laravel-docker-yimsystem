<?php
    $extra = "../../";
    //llamando de modales el id es "addCate"
    include_once($extra."modales/cuentas/m_a_cate.php");

    include_once('../../includes_SISTEM/include_head.php');
    include_once('../../includes_SISTEM/include_login.php');
    //consulta de los datos de la empreas PARA SABE LA ACTIVA 
    $consulta = pg_query($conexion, sprintf("
                                        SELECT * FROM 
                                            categoria cat
                                        WHERE 
                                            cat.fk_empre = '%s'", $_SESSION["id_usu"]));
    // $filas = pg_fetch_assoc($consultaEmpre);
    $filas=pg_fetch_assoc($consulta);
    $total_consulta = pg_num_rows($consulta);
 
    // if ( !isset($_POST['operation']) || isset($_POST['operation'])=="") {
        ?>
        <div id="cuentas"  class="bs-example">
            <div class="">
                <h1 class="bd-title">Cuentas - Categorias </h1>
            </div>
            <!-- col-xs-12 col-md-4 col-lg-4 -->
            <div class="form-group">
              <form method="POST">
                    <label class="control-label">Consulta Por Numero, nombre</label>
                    <input type="text" class="form-control" name="cate" id="cate" > 
                    <button type="submit" class="list-group-item active" >Buscar</button>
              </form>  
              <button class="list-group-item list-group-item-secondary" type="button" onclick="modaladdcate()">
                Crear Categoria!
              </button>  
            </div>
        </div><!--cuentas-->
        <hr id="res_cuentas" class="featurette-divider"/>
        <?php
        //validando que la fecha o ano que se introduzca no sea menor al menor del sistema
        $param = isset($_POST['cate']) ? $_POST['cate'] :'';
        $consulta = pg_query($conexion, sprintf("SELECT * FROM 
                                    categoria 
                                WHERE 
                                    fk_empre = '%s' AND 
                                    id = '%s' OR
                                    nombre LIKE '%s%%' OR
                                    descripcion LIKE '%s%%';", 
                                        $_SESSION["id_usu"], 
                                        $param, 
                                        $param, 
                                        $param));
        // $filas = pg_fetch_assoc($consultaEmpre);
        $filas=pg_fetch_assoc($consulta);
        $total_consulta = pg_num_rows($consulta);
        
        if($total_consulta > 0){
            // TABLA DE CONSULTA 
            ?>
            <table>
                <thead>
                    <tr>
                        <td>N° Categoria</td>
                        <td>Nombre Categoria</td>
                        <td>Descrip</td>
                        <td>Categoria</td>
                    </tr>
                </thead>
                <tbody>
                    <?php do{?>
                        <tr>
                            <td><?php $filas['id'];?></td>
                            <td><?php $filas['nombre'];?></td>
                            <td><?php $filas['descripcion'];?></td>
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
    ?>