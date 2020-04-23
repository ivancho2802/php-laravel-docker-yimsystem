<?php
    include_once('../../includes_SISTEM/include_head.php');
    include_once('../../includes_SISTEM/include_login.php');
    //consulta de los datos de la empreas PARA SABE LA ACTIVA 
    $consulta = pg_query($conexion, sprintf("
                                        SELECT * FROM 
                                            cuenta cu, categ_cuenta cat_cu 
                                        INNER JOIN 
                                            categoria cat
                                        ON 
                                            cat_cu.fk_categoria = cat.id 
                                        WHERE 
                                            cu.fk_empre = '%s'", $_SESSION["id_usu"]));

    // $filas = pg_fetch_assoc($consultaEmpre);
    $filas=pg_fetch_assoc($consulta);
    $total_consulta = pg_num_rows($consulta);
    if ( !isset($_POST['operation'])) {
?>
<div id="cuentas"  class="bs-example">
    <div class="">
        <h1 class="bd-title">Cuentas <?php echo $_POST['operation']?></h1>
    </div>
        <!-- col-xs-12 col-md-4 col-lg-4 -->
        <div class="form-group">
          <form method="POST">
                <label class="control-label">Consulta Por Numero, nombre y categorias</label>
                <input type="text" class="form-control" name="cuenta" id="cuenta" > 
                <button type="submit" class="list-group-item active" >Buscar</button>
          </form>
          <form method="POST" action="listar_submit">
            <input type="hidden" name="operation" value="crear">
            <button class="list-group-item list-group-item-secondary" type="submit"  value="">Crear Cuenta!</button>
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
                                cu.id = '%s' OR
                                cat.id = '%s' OR
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
            <table>
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
                            <td><?php $filas['cat.id'];?></td>
                            <td><?php $filas['cat.nombre'];?></td>
                            <td><?php $filas['cu.id'];?></td>
                            <td><?php $filas['cu.nombre'];?></td>
                            <td><?php $filas['cu.descripcion'];?></td>
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
            <h1 class="bd-title">Crear Cuentas</h1>
        </div>
        <form action="listar_submit" method="post" accept-charset="utf-8">
            <div class="row">
                  <div class="col-xs-4 col-md-4 col-lg-4">
                    <label>N° Cuenta:</label><br />
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
            <div class="row">
                  <div class="col-xs-12 col-md-12 col-lg-12">
                    <label>Categoria:</label><br />
                    <div class="list-group">

                        <?php 
                        $consulta2 = pg_query($conexion, sprintf("SELECT * FROM categoria 
                                                WHERE 
                                                fk_empre = '%s';", $_SESSION["id_usu"] ));
                        // $filas = pg_fetch_assoc($consultaEmpre);
                        $filas2=pg_fetch_assoc($consulta2);
                        $total_consulta2 = pg_num_rows($consulta2);
                        if($total_consulta2>0){?>
                            <select name="categoria" class="form-control" required="required"  >
                                <?php do{ ?>
                                <option value="<?php echo $filas['id']?>"><?php echo $filas['nombre'];?></option>
                                <?php }while($filas2 = pg_fetch_assoc($consulta2)); ?>
                            </select>    
                        <?php }else{?>
                            <div class="alert alert-warning">
                              <strong>Warning!</strong> no hay categorias..
                            </div>
                        <?php }?>
                    </div>

                    <input name="formcreatecuenta" type="hidden">
                    <button type="submit" class="list-group-item active" disabled="<?php if($total_consulta2>0)echo 'true'?>">Crear Cuenta</button>
                  </div>
            </div> 
        </form>
        <form action="listar_submit" method="post" accept-charset="utf-8">
            <button type="submit" class="list-group-item" >volver</button>
        </form>
        <?php
    }

    if(isset($_POST['formcreatecuenta'])){
        echo $_POST['formcreatecuenta'];
    }