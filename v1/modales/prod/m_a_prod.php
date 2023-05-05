<?php
include_once('../../includes_SISTEM/include_head.php');

$consulta = pg_query($conexion, "SELECT * FROM reg_inventario WHERE tipo = 'inv_ini' ORDER BY fecha_reg_inv ASC");
$filas = pg_fetch_assoc($consulta);
$total_consulta = pg_num_rows($consulta);

if ($filas) {
  $mes_inventario = substr($filas['fecha_reg_inv'], 0, 7);
} else {
  $mes_inventario = sprintf("%d-%02d", date('Y'), date('m') - 1);
}
?>
<!--<script type="text/javascript" src="js/jquery.min.js"></script>-->
<script>
  $(document).ready(function() {
    $(window.document).on('shown.bs.modal', '#nueProd', function() {
      window.setTimeout(function() {
        <?php include_once('../../includes_SISTEM/include_login.php'); ?>


        $('#codigo', this).focus();
        $('#nueProd').modal({
          keyboard: false
        });
        document.onkeypress = stopRKey;

        url = '<?php echo $_SERVER['REQUEST_URI']; ?>';
        //alert(url);
        patron1 = 'cargarInvent';
        //alert(url.search(patron1));
        if (url.search(patron1) > 0) {

          document.forms["formModal"].elements["stock"].readOnly = null;
          document.forms["formModal"].elements["stock"].lang = "si-number";
          document.forms["formModal"].elements["fecha"].readOnly = null;
          document.forms["formModal"].elements["fecha"].lang = "si-general";

          document.forms["formModal"].elements["pmpvj"].lang = "si-general";
          document.forms["formModal"].elements["bpmpvj"].disabled = null;
          ///////////////// SI HAGO CLIC EN EL BOTON 
          $(document).on("click", ".bpmpvj_open_modal", function() {
            var inputPU = document.getElementById('valor_unitario').value;
            if (inputPU == "") { //VALIDO
              alert('VALOR UNITARIO NECESARIO');
              document.getElementById('valor_unitario').focus();
            } else {
              $('#calPMPVJ').modal('show');
              $(".modal-body #costoActual").val(inputPU);
            }
          });
        } else { //MENOS EN CARGAR INVENTARIO
          // me traigo lo que ingrese en buscar
          document.getElementById('nombre_i').value = document.getElementById('b_prod').value;
        }
      }.bind(this), 100);
    });
  });

  function agreRProd(formulario) {
    //funcion de validacion
    document.getElementById("txtHintAPROV").innerHTML = "";
    var valido = validarFormulario(formulario);

    if (valido == 1) {
      //paramentros y funciones de registro AJAX	
      var xhttp;
      //variables contenidas en el formulariuo
      var codigo = $("input#codigo").val();
      var nombre_i = $("input#nombre_i").val();

      var stock = $("input#stock").val();
      var valor_unitario = $("input#valor_unitario").val();
      var pmpvj = $("input#pmpvj").val();
      var fecha = $("input#fecha").val();
      var cant_min = $("input#cant_min").val();
      var cant_max = $("input#cant_max").val();
      var descripcion = $("input#descripcion").val();

      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {

          document.getElementById('txtHintAPROV').innerHTML = xhttp.responseText;
          document.getElementById("codigo").value = "";
          document.getElementById("nombre_i").value = "";
        }
      };
      xhttp.open("POST", "<?php echo $extra ?>modales/prod/a_prod.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      //INVENTARIO
      url = '<?php echo $_SERVER['REQUEST_URI']; ?>';
      patronA = 'cargarInvent';
      patronB = 'compra|venta'

      if (url.search(patronA) >= 0) {
        tipo = "inv_ini";
        xhttp.send("codigo=" + codigo + "&nombre_i=" + nombre_i + "&cant_min=" + cant_min + "&cant_max=" + cant_max + "&stock=" + stock + "&valor_unitario=" + valor_unitario + "&pmpvj=" + pmpvj + "&fecha=" + fecha + "&tipo=" + tipo + "&descripcion=" + descripcion);
        //COMPRA		si esto compila se puede insertar y seleccionar
      } else if ((url.search(patronB) >= 0)) {
        xhttp.send("codigo=" + codigo + "&nombre_i=" + nombre_i + "&cant_min=" + cant_min + "&cant_max=" + cant_max + "&stock=" + stock + "&valor_unitario=" + valor_unitario + "&fecha=" + fecha + "&descripcion=" + descripcion);
        selecProd(codigo, nombre_i, valor_unitario, stock, document.form1.numCampoActual.value);
        fcalculo();
      }
    }

  }
</script>

<!-- Modal nueProd-->
<div id="nueProd" class="modal fade" data-backdrop="static" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id="close_m_x">&times;</button>
        <h4 class="modal-title">Agregar Nuevo Producto</h4>
      </div>

      <form name="formModal">
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <!--para mostrar resultado de acciones de insercion y demas-->
              <label class="col-md-12 col-lg-12" id="txtHintAPROV" data-dismiss="modal"></label>
            </div>
            <div class="row">
              <!--con el rif se manda a validar si existe con la funcino , y con cURLrif obtener el nombre-->
              <label class="col-md-4 col-lg-4" id="res_codigo">
                Codigo:<br>
                <span class="input-group" id="cont_codigo">
                  <input type="text" class="form-control" name="codigo" id="codigo" onBlur="validar_repetidoM('inventario', 'codigo', this.value, 'codigo')" onKeyUp="" lang="si-general" required>
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary" onclick="genCodRand('codigo','<?php echo $_SESSION["alias"] . $_SESSION["version"] . "-"; ?>')">Generar Codigo</button>
                  </span>
                </span>
              </label>
              <label class="col-md-4 col-lg-4" id="res_nombre_i">
                <span id="cont_nombre_i">
                  Nombre:<br>
                  <input type="text" class="form-control" name="nombre_i" id="nombre_i" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();validar_repetidoM('inventario', 'nombre_i', this.value, 'nombre_i');" lang="si-general" required>
                </span>
              </label>

              <label class="col-md-4 col-lg-4">
                Stock &oacute; Existencia:<br>
                <input type="number" min="0" class="form-control" name="stock" id="stock" lang="no-number" readonly="readonly">
              </label>
            </div>
            <div class="row">
              <label class="col-md-4 col-lg-4">
                Valor Unitario:<br>
                <input type="number" min="0" step="0.01" class="form-control" name="valor_unitario" id="valor_unitario" lang="si-number" required>
              </label>
              <label class="col-md-4 col-lg-4">
                Precio de Venta<br>
                <span class="input-group bpmpvj_open_modal">
                  <input class="form-control" name="pmpvj" id="pmpvj" type="number" min="0" step="0.01" value="" placeholder="0.00" readonly="readonly" />
                  <span class="input-group-btn">
                    <button class="btn btn-primary" name="bpmpvj" type="button" disabled="disabled">P. Venta</button>
                  </span>
                </span>
              </label>
              <label class="col-md-4 col-lg-4">
                Fecha de Inventario Inicial:<br>
                <input type="month" class="form-control" name="fecha" id="fecha" value="<?php echo $mes_inventario; ?>" lang="si-general" />
              </label>
            </div><!--row-->
            <div class="row">
              <label class="col-md-4 col-lg-4">
                Descripcion:<br>
                <input type="text" class="form-control" name="descripcion" id="descripcion" lang="no-general">
              </label>
              <label class="col-md-4 col-lg-4">
                Cantidad Minima:<br>
                <input type="number" min="0" class="form-control" name="cant_min" id="cant_min" lang="no-number">
              </label>
              <label class="col-md-4 col-lg-4">
                Cantidad Maxima:<br />
                <input type="number" min="0" class="form-control" name="cant_max" id="cant_max" lang="no-number">
              </label>
            </div><!--row-->
          </div><!--form-group-->
        </div><!--modal-bosy-->

        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="agreRProd(this.form);">Agregar y Seleccionar</button>
          <button type="button" class="btn btn-danger" id="close_m" data-dismiss="modal">Cancelar</button>
        </div>
      </form><!--maprov-->
    </div>

  </div>
</div>
<?php
ob_end_flush();
?>