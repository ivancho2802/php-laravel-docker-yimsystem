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

    // lectura de pdf y carga de elementos
    if (isset($_POST["import"])) {
        $_SESSION["msmsus"] = '';
        $_SESSION["msmerr"] = '';
        
        $fileName = $_FILES["customFile"]["tmp_name"];
        
        if ($_FILES["customFile"]["size"] > 0) {
            
            $file = fopen($fileName, "r");

            $sqlInsert = "INSERT into cuenta (id,nombre,descripcion,fk_empre) VALUES ";
            $i = 0;
            while (($column = fgetcsv($file, 1000000, ",")) !== FALSE) {

                if($i>0){
                    $id = addslashes('');
                    if (isset($column[0])) {
                        $id = addslashes($column[0]);
                    }
                    $nombre = addslashes('');
                    if (isset($column[1])) {
                        $nombre = addslashes($column[1]);
                    }
                    $descripcion = addslashes('');
                    if (isset($column[2])) {
                        $descripcion = addslashes($column[2]);
                    } 
                    $fk_empre = addslashes($_SESSION["id_usu"]);
                    
                    if($column[0]  && $column[1])
                        $sqlInsert .= "('".$id."', '".$nombre."', '".$descripcion."', '".$fk_empre."'),";
                    
                    if (! empty($insertId)) {
                        $type = "success";
                        $message = "CSV Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing CSV Data";
                    }
                }
                $i++;
            }

            $Result1 = pg_query($conexion, rtrim($sqlInsert,','));

            if($resultado = pg_fetch_assoc($Result1)){
                $_SESSION["msmsus"] = '<strong>Operacion hecha con exito!</strong>';
            }else{
                $_SESSION["msmerr"] = '<strong>Opps!</strong> Vuelva ha intentarlo algo ha salido mal nuestras disculpas!. Error CLIENTE: '.pg_last_error();
            }

        }
    }

?>
<script type="text/javascript">
$(document).ready(function() {
    $("#frmCSVImport").on("submit", function () {

        $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
                $("#response").addClass("error");
                $("#response").addClass("display-block");
            $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
            return false;
        }
        return true;
    });

    <?php
    if(isset($_POST["msmsus"]) || isset($_SESSION["msmsus"]) || isset($_POST["msmerr"]) || isset($_SESSION["msmerr"])){//osea cuando cierro session por admin
    ?>
        $( document ).ready(function() {
            document.getElementById('msm_register').setAttribute("class", "alert alert-danger alert-dismissible fade in");
        });
    <?php
    }
    ?>
});
</script>
<div id="cuentas"  class="bs-example">
        <!-- col-xs-12 col-md-12 col-lg-12 -->
            <div id="msm_register" class="alert <?php if(isset($_SESSION['msmerr']) && $_SESSION['msmerr'] !== '') echo 'alert-danger'; else echo 'alert-success';?> alert-dismissible fade" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php if(isset($_SESSION["msmerr"]) && $_SESSION["msmerr"] !== "")
                    echo $_SESSION["msmerr"];
                elseif(isset($_POST["msmerr"]))
                    echo $_POST["msmerr"];
                elseif(isset($_SESSION["msmsus"]) && $_SESSION["msmsus"] !== "")
                    echo $_SESSION["msmsus"];
                elseif(isset($_POST["msmsus"]))
                    echo $_POST["msmsus"];
                ?>
            </div>
        <div class="form-group row">

            <form method="POST" class="col-xs-4 col-md-4 col-lg-4">
                  <label class="control-label">Consulta de Cuentas</label>
                  <div class="input-group">  
                        <input type="text" class="form-control" name="cuenta" id="cuenta" required="required" lang="si-general">
                        <span class="input-group-btn">
                            <button  name="Consultar" id="Consultar" class="btn btn-primary" type="button"  value="">Buscar</button>
                        </span> 
                  </div>
            </form>
            <div class="col-xs-4 col-md-4 col-lg-4">
                <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport"
                enctype="multipart/form-data">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="customFile" name="customFile" accept=".csv">
                      <label class="custom-file-label" for="customFile">Cargar Archivo CSV</label>
                    </div>
                    <button type="submit" id="submit" name="import"  class="btn-submit">Import</button>
                </form>
            </div>
        </div>

</div><!--cuentas-->
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