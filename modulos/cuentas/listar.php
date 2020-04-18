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
    if (isset($_POST['crear'])) {
        # code...
?>
<div id="cuentas"  class="bs-example">
    <div class="">
        <h1 class="bd-title">Cuentas</h1>
    </div>
    <div class="row">
      <div class="col-xs-12 col-md-4 col-lg-4">
        <div class="form-group">
          <form method="POST">
                <label class="control-label">Consulta Por Numero, nombre y categorias</label>
                <div class="input-group">
                  <!-- <input type="date" class="form-control" name="dia" value="<?php //if(isset($_POST['dia']))echo $_POST['dia'];?>" required="required"/> -->
                    <span class="input-group">
                        <input type="text" class="form-control" name="cuenta" id="cuenta"required> 
                    </span>  
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit" name="" value="">Buscar Cuenta!</button>
                  </span>
                </div>
          </form>
        </div>
      </div><!--col--> 
    </div><!--row-->

</div><!--cuentas-->
<hr id="res_cuentas" class="featurette-divider"/>
<?php
        //validando que la fecha o ano que se introduzca no sea menor al menor del sistema

        /*$consulta3=pg_query($conexion,sprintf("SELECT fact_compra.fecha_fact_compra AS fecha FROM fact_compra
        UNION
        SELECT fact_venta.fecha_fact_venta AS fecha FROM fact_venta
        UNION
        SELECT inventario_retiros.fecha_inv_retiros AS fecha FROM inventario_retiros
        UNION
        SELECT reg_inventario.fecha_reg_inv AS fecha FROM reg_inventario
        ORDER BY fecha ASC")); 
        $filas3=pg_fetch_assoc($consulta3);
        $total_fecha_menor = pg_num_rows($consulta3);*/
        $consulta = pg_query($conexion, sprintf("SELECT * FROM cuenta cu, categ_cuenta cat_cu 
                                INNER JOIN categoria cat
                                ON cat_cu.fk_categoria = cat.id 
                                WHERE 
                                
                                fk_empre = '%s' AND 
                                cu.id = '%s' OR
                                cat.id = '%s' OR
                                cat.nombre LIKE '%s%%' OR
                                cat.descripcion LIKE '%s%%'  OR
                                cu.nombre LIKE '%s%%' OR
                                cu.descripcion LIKE '%s%%';", $_SESSION["id_usu"], $_POST['cuenta'], $_POST['cuenta'], $_POST['cuenta'], $_POST['cuenta'], $_POST['cuenta'], $_POST['cuenta']));
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
            <div class="row">
                <div class="col-12">
                    <form  method="post" accept-charset="utf-8">
                        <input type="hidden" name="create"/>
                        <button type="submit" name="create"  class="primary"></button>
                    </form>
                </div>
            </div>
            <?php
        }
    }else{// si es crear
        ?>
        <form action="listar_submit" method="post" accept-charset="utf-8">
            listar_submit
            get
        </form>
        <?php
    }