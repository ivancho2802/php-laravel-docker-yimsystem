<!-- Modal nueProd-->
<div id="retriveProd" class="modal fade" role="dialog" aria-labelledby="retriveProdLabel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="busProdLabel">Aplicar Retiro al Inventario</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form name="form1" id="form1">

        <!-- campos ocultos -->
        <!--CAMPOS QUE PUSE PARA QUE NO ME DE ERROR YA QUE EN COMPRAS VACIO CANTIDAD Y PVPMVJ-->
        <input name="cantidad" type="hidden" />
        <input name="pmpvj" type="hidden" />
        <input name="fk_inventario" id="fk_inventario" type="hidden" />


        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <!--para mostrar resultado de acciones de insercion y demas-->
              <label class="col-md-12 col-lg-12" id="zona_dinamica" ></label>
            </div>

            <legend>Datos actuales</legend>

            <div class="row">
              <!--con el rif se manda a validar si existe con la funcino , y con cURLrif obtener el nombre-->
              <div class="col-md-4 col-lg-4" id="res_codigo">
                Codigo:<br>
                <span class="input-group" id="cont_codigo">
                  <input type="text" class="form-control" name="codigo" id="codigo" onKeyUp="" lang="si-general" required readonly="readonly">
                  <button type="button" class="btn btn-primary m-0" data-bs-toggle="modal" href="#busProd">Seleccionar Producto</button>
                </span>
              </div>
              <div class="col-md-4 col-lg-4" id="res_nom_fk_inventario">
                Nombre:<br>
                <span class="input-group" id="cont_nom_fk_inventario">
                  <input type="text" class="form-control" name="nom_fk_inventario" id="nom_fk_inventario" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();" lang="si-general" required readonly="readonly">
                  <button type="button" class="btn btn-primary m-0" data-bs-toggle="modal" href="#busProd">Seleccionar Producto</button>
                </span>
              </div>

              <div class="col-md-4 col-lg-4">
                Cantidad Actual:<br>
                <input type="number" min="0" class="form-control" name="stock" id="stock" lang="no-number" readonly="readonly">
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4 col-md-4 col-lg-4">
                <label>Costo Actual</label>
                <div class="list-group">
                  <input type="number" min="0" step="0.01" name="costo" id="costo" class="form-control list-group-item" placeholder="Seleccionar Producto" readonly>
                </div>
                <!--costo actual en la bd es costo_a-->
              </div>
            </div>


            <legend>Datos Retiro</legend>

            <div class="row">

              <div class="col-xs-4 col-md-4 col-lg-4" id="res_fecha_inv_retiros">
                <span id="cont_fecha_inv_retiros">
                  <label>Fecha de Retiro</label>
                  <input type="date" name="fecha_inv_retiros" id="fecha_inv_retiros" class="form-control" required />
                </span>
                <span id="dateInventario"></span>
              </div>

              <div class="col-xs-4 col-md-4 col-lg-4">
                <label>Cantidad a Retirar</label>
                <input type="number" min="0" name="cant_inv_retiros" id="cant_inv_retiros" class="form-control" required />
              </div>

              <div class="col-xs-4 col-md-4 col-lg-4">
                <label>Numero de Orden</label>
                <input type="text" name="orden_inv_retiros" id="orden_inv_retiros" class="form-control" required="required" />
              </div>

            </div><!--row-->

            <div class="row">

              <div class="col-xs-4 col-md-4 col-lg-4">
                <label>Observaci&oacute;n</label>
                <input type="text" name="obs_inv_retiros" id="obs_inv_retiros" class="form-control" />
              </div>

            </div>

          </div><!--form-group-->
        </div><!--modal-bosy-->

        <div class="modal-footer">
          <button type="button" id="btnRetiroInventory" class="btn btn-success" onclick="agreRetiro(this.form);">Aplicar Retiro</button>
          <button type="button" class="btn btn-danger" id="close_m" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form><!--maprov-->
    </div>

  </div>
</div>

<script>
  let formProdCurrent = 0;
  $(document).ready(function() {

    //menor fecha registrada en nventario
    let dateInventario = ''

    document.getElementById("retriveProd").addEventListener('shown.bs.modal', function() {
      window.setTimeout(function() {

        $('#codigo', this).focus();
        $('#retriveProd').modal({
          keyboard: false
        });
        document.onkeypress = stopRKey;

        validarFormularioRetiroInventario();

        getDateInventarioInicial();

      }.bind(this), 100);
    });

  });

  function getDateInventarioInicial() {

    $.ajax({
      type: 'GET',
      url: '/inventario-config',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {

        document.getElementById("fecha").value = data.data.mesInventario;
        dateInventario = data.data.dateInventario
        document.getElementById("dateInventario").innerHTML = dateInventario;
      }

    });

  }

  function validarFormularioRetiroInventario() {

    //cuando carge la fecha validar si si las fecha es valida
    document.getElementById("fecha_inv_retiros").addEventListener("load", (event) => {
      let currentDate = document.getElementById("fecha_inv_retiros").value;
      let inputFecha = event.target

      //la fecha esta incorrecta
      if (!dateInventario) {
        var opcion = confirm(
          "Disculpe las molestias INVENTARIO INICIAL vacio " +
          " \nSera redireccionado en cuanto pulce Aceptar"
        );
        if (opcion == true) {
          document.getElementById("retriveProd").modal('hide')
          inputFecha.value = ""
          inputFecha.focus();
        }

      } else if (currentDate < dateInventario) {
        var opcion = confirm(
          "Disculpe las molestias" +
          "La Fecha que ingreso debe ser mayor a la FECHA de INVENTARIO INICIAL: " +
          dateInventario
        );
        if (opcion == true) {
          document.getElementById("retriveProd").modal('hide')
          inputFecha.value = ""
          inputFecha.focus();
        }
      } else {
        let iconCheck = '<i class="fa fa-check text-success" ></i>';

        document.getElementById('dateInventario').innerHTML += iconCheck;
      }

    })

    //si se quiere cacuar precio de venta y no estan las condiciones
    document.getElementById("calPMPVJ").addEventListener('shown.bs.modal', function() {
      var inputPU = document.getElementById('valor_unitario').value;
      if (inputPU == "") { //VALIDO
        alert('VALOR UNITARIO NECESARIO');
        $('#calPMPVJ').modal('hide');
        document.getElementById('valor_unitario').focus();
        return
      }

      $(".modal-body #costoActual").val(inputPU);

    });

    //	FUNCION PARA VALIDAR QUE LA CANTIDAD SEA MENOR AL STOCK O LA EXISTENCIA
    document.getElementById("cant_inv_retiros").addEventListener("keypress", (event) => {
      let cantidadA = event.target.value
      let stockA = document.getElementById("cant_inv_retiros").value

      if (parseInt(cantidadA) !== "" && parseInt(stockA) !== "") {
        if (parseInt(cantidadA) > parseInt(stockA)) {
          alert("la cantidad supera la existencia");
          document.getElementById("cant_inv_retiros").value = "";
          document.getElementById("cant_inv_retiros").focus();
        }
      }
    })

  }

  function agreRetiro(formulario) {
    //funcion de validacion
    document.getElementById("zona_dinamica").innerHTML = "";
    var valido = validarFormulario(formulario);
    if (!valido) {
      console.log("invalid")
      return
    }

    //INVENTARIO RETIRO
    //variables contenidas en el formulariuo
    let body = {
      "stock": $("input#stock").val(),
      "costo": $("input#costo").val(),
      "fecha_inv_retiros": $("input#fecha_inv_retiros").val(),
      "cant_inv_retiros": $("input#cant_inv_retiros").val(),
      "orden_inv_retiros": $("input#orden_inv_retiros").val(),
      "obs_inv_retiros": $("input#obs_inv_retiros").val(),
      "fk_inventario": $("input#fk_inventario").val(),
    }

    $.ajax({
      type: 'POST',
      url: '/inventario-withdraw',
      data: body,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {

        let htmlalert = ''
        htmlalert = `<div class="alert alert-success">
              Elemento retirado con exito
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        document.getElementById("codigo").value = "";
        document.getElementById("nom_fk_inventario").value = "";
        document.getElementById('zona_dinamica').innerHTML = htmlalert;

      },
      error: function(data) {
        console.log("error ", data)

        let htmlalert = `<div class="alert alert-danger">
          ${data.responseJSON.message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        document.getElementById('zona_dinamica').innerHTML = htmlalert;
      },
      beforeSend: function() {
        $('#btnRetiroInventory').prop('disabled', true)
      },
      complete: function() {
        $('#btnRetiroInventory').prop('disabled', false)
      },

    }).fail(function(data) {
      $('#btnRetiroInventory').prop('disabled', false)
      console.log("error ", data)
      let htmlalert = `<div class="alert alert-danger">
          ${data.responseJSON.data.message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
      document.getElementById('zona_dinamica').innerHTML = htmlalert;
    });

  }
</script>