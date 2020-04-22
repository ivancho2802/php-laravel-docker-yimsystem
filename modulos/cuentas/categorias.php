<?php
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
    if ( !isset($_POST['operation'])) {
?>
<div id="cuentas"  class="bs-example">
    <div class="">
        <h1 class="bd-title">Cuentas -Categorias</h1>
    </div>
        <!-- col-xs-12 col-md-4 col-lg-4 -->
        <div class="form-group">
          <form method="POST">
                <label class="control-label">Consulta Por Numero, nombre</label>
                <input type="text" class="form-control" name="cate" id="cate" > 
                <button type="submit" class="list-group-item active" >Buscar</button>
          </form>
          <form method="POST">
            <input type="hidden" name="operation" value="crear">
            <button class="list-group-item list-group-item-secondary" type="submit"  value="">Crear Categoria!</button>
            <!-- <button class="btn btn-primary" type="button" click="loadcrearcuenta()">Crear Cuenta!</button> -->
          </form>
        </div>

</div><!--cuentas-->
<hr id="res_cuentas" class="featurette-divider"/>
<?php
        //validando que la fecha o ano que se introduzca no sea menor al menor del sistema

        

        $param = isset($_POST['cate']) ? $_POST['cate'] :'';

        $consulta = pg_query($conexion, sprintf("SELECT * FROM 
                                    categoria cat 
                                WHERE 
                                    cat.fk_empre = '%s' AND 
                                    cat.id = '%s' OR
                                    cat.nombre LIKE '%s%%' OR
                                    cat.descripcion LIKE '%s%%';", 
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
                            <td><?php $filas['cat.id'];?></td>
                            <td><?php $filas['cat.nombre'];?></td>
                            <td><?php $filas['cat.descripcion'];?></td>
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
    }else{// si es crear
        ?>
        <div class="">
            <h1 class="bd-title">Crear Categoria</h1>
        </div>
        <form action="listar_submit" method="post" accept-charset="utf-8">
            <div class="row">
                  <div class="col-xs-4 col-md-4 col-lg-4">
                    <label>N° Categoria:</label><br />
                    <div class="list-group">
                        <input id="id" name="id" class="form-control" required="required"   placeholder="Clic aqui para buscar" />
                    </div>
                  </div>
                  <div class="col-xs-4 col-md-4 col-lg-4">
                    <label>Nombre:</label><br />
                    <div class="list-group">
                        <input id="nombre" name="nombre" class="form-control" required="required"   placeholder="Clic aqui para buscar" />
                    </div>
                  </div>
                  <div class="col-xs-4 col-md-4 col-lg-4">
                    <label>Descripcion:</label><br />
                    <div class="list-group">
                        <input id="descripcion" name="descripcion" class="form-control" required="required"   placeholder="Clic aqui para buscar" />
                    </div>
                  </div>
            </div> 
            <input name="formcreatecuenta" type="hidden">
            <button type="submit" class="list-group-item active" >Crear Categoria</button>
        </form>
        <form action="listar_submit" method="post" accept-charset="utf-8">
            <button type="submit" class="list-group-item" >volver</button>
        </form>
        <?php
    }

    if(isset($_POST['formcreatecuenta'])){
        echo $_POST['formcreatecategoria'];
    }