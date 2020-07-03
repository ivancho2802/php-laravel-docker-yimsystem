<?php
    $extra = "../../";
    //llamando de modales el id es "addCuenta"
    include_once($extra."modales/cuentas/m_a_cuenta.php");
    include_once('../../includes_SISTEM/include_head.php');
    include_once('../../includes_SISTEM/include_login.php');
    //consulta de los datos de la empreas PARA SABE LA ACTIVA 
    $consulta = pg_query($conexion, sprintf("
                                        SELECT * FROM 
                                            cuenta c
                                        WHERE 
                                            c.fk_empre = '%s'", $_SESSION["id_usu"]));
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
        <!-- col-xs-12 col-md-12 col-lg-12 -->
        <div class="form-group row">

            <div class="col-xs-6 col-md-6 col-lg-6">
                <h1 class="bd-title">Cuentas </h1>
            </div>
              <form method="POST" class="col-xs-6 col-md-6 col-lg-6">
                  <label class="control-label">Consulta Por Numero, nombre y categorias</label>
                  <div class="input-group">  
                        <input type="text" class="form-control" name="cuenta" id="cuenta" required="required" lang="si-general">
                        <span class="input-group-btn">
                            <button  name="Consultar" id="Consultar" class="btn btn-primary" type="button"  value="">Buscar</button>
                        </span> 
                  </div>
              </form>
        </div>

</div><!--cuentas-->
<hr id="res_cuentas" class="featurette-divider"/>
  <form method="POST" action="listar_submit">
    <button type="button" class="btn btn-sm btn-primary col-xs-12 col-lg-12 glyphicon glyphicon-plus" onclick="modaladdcuenta()"></button>
    <!-- <button class="btn btn-primary" type="button" click="loadcrearcuenta()">Crear Cuenta!</button> -->
  </form>
<?php
    //validando que la fecha o ano que se introduzca no sea menor al menor del sistema
    $param = isset($_POST['cuenta']) ? $_POST['cuenta'] :'';
    $consulta = pg_query($conexion, sprintf("SELECT * FROM 
                                            cuenta c
                            WHERE 
                                c.id LIKE '%s%%' OR
                                c.nombre LIKE '%s%%' OR
                                c.descripcion LIKE '%s%%';", $param, $param, $param, $param ));
    /*cu, categ_cuenta cat_cu 
                            INNER JOIN categoria cat
                            ON cat_cu.fk_categoria = cat.id 

                            cat.id LIKE '%s%%' OR
                            cat.nombre LIKE '%s%%' OR
                            cat.descripcion LIKE '%s%%'  OR
                            cat.fk_empre = '%s' AND 

                            */
    // $filas = pg_fetch_assoc($consultaEmpre);
    $filas=pg_fetch_assoc($consulta);
    $total_consulta = pg_num_rows($consulta);
    
    if($total_consulta > 0){
        // TABLA DE CONSULTA 
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>Codigo</td>
                    <td>Nom Cuenta</td>
                    <td>Descrip</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 1;
                    do{
                        if($i>=3){
                ?>
                            <tr>
                                <td><?php echo $filas['id'];?></td>
                                <td><?php echo $filas['nombre'];?></td>
                                <td><?php echo $filas['descripcion'];?></td>
                            </tr>
                <?php
                        }else{
                ?>
                            <tr class="">
                                <td><?php echo $filas['id'];?></td>
                                <td><?php echo $filas['nombre'];?></td>
                                <td><?php echo $filas['descripcion'];?></td>
                            </tr>
                <?php
                        }
                        $i++;
                    }while($filas = pg_fetch_assoc($consulta)); 
                ?>
            </tbody>
        </table>
        <?php
    }else{
        ?>
        <p>no hay resultados</p>
        <?php
    } 