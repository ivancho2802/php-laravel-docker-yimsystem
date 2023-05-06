<!-- Modal nueProv-->
<div id="nueProv" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleProviderLabel">Modificar del Proveedor (Raz&oacute;n Social)</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form name="formEditProvider" id="formEditProvider">

        <!-- campos ocultos -->
        <input name="id" id="id" type="hidden" />
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <!--para mostrar resultado de acciones de insercion y demas-->
              <label class="col-md-12 col-lg-12" id="txtHintNueProv"></label>
            </div>
            <div class="row">
              <!--con el rif se manda a validar si existe con la funcino buscar_dato, y con cURLrif obtener el nombre-->
              <div class="col-md-6 col-lg-6" id="res_rif">
                <span id="cont_rif">
                  R.I.F. / Cedula<br>
                  <input type="text" class="form-control" name="rif" id="rif" pattern="[JVEGP][0-9]{8}" onBlur="javascript:this.value=this.value.toUpperCase();" lang="si-rif" required />
                  <span class="help-block">Formato: V012223334</span>
                </span>
              </div>
              <div class="col-md-6 col-lg-6">
                Nombre o Raz&oacute;n Social:<br />
                <span class="input-group">
                  <input type="text" class="form-control" name="nombre" id="nombre" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();" lang="si-general" required>
                  <button id="btnFindProvider" type="button" class="btn btn-primary m-0">Buscar (INTERNET)</button>
                </span>
              </div>


            </div>
            <div class="row">
              <div class="col-md-6 col-lg-6">
                Telefono:<br>
                <input type="text" class="form-control" name="telefono" id="telefono" min="999999999" max="999999999999" pattern="[0][42][127][246][0-9]{7}" lang="no-telf" required>
                <span class="help-block">Formato: 04161234567</span>
              </div>
              <div class="col-md-6 col-lg-6">
                Direcci&oacute;n:<br />
                <input class="form-control" type="text" name="direccion" id="direccion" required>
              </div>
            </div><!--row-->
          </div><!--form-group-->
        </div><!--modal-bosy-->

        <div class="modal-footer">
          <button id="btnFormAddProvider" type="button" class="btn btn-success" onclick="agreRProv(this.form);">Agregar y Seleccionar</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form><!--maprov-->
    </div>

  </div>
</div>
<script>
  $(window.document).on('shown.bs.modal', '#nueProv', function() {
    $('#rif', this).focus();

    validarFormularioAddProvider()

    setFormAddProviderData(providerToUpdate)

  });

  $('#nueProv').on('hidden.bs.modal', function(e) {
    $("#txtHintNueProv").innerText = ""
    document.onkeypress = !stopRKey;
    consulProv();
    providerToUpdate = null
  });

  function setFormAddProviderData() {

    document.getElementById("modalTitleProviderLabel").innerHTML = 'Agregar del Proveedor'
    document.getElementById("btnFormAddProvider").innerText = 'Agregar del Proveedor'
    document.getElementById("btnFormAddProvider").removeAttribute("onclick");
    document.getElementById("btnFormAddProvider").setAttribute("onclick", "agreRProv(this.form);")

    if (providerToUpdate?.id) {

      document.getElementById("btnFormAddProvider").innerText = 'Modificar del Proveedor'
      document.getElementById("btnFormAddProvider").setAttribute("onclick", "modRProv(this.form);")
      document.getElementById("modalTitleProviderLabel").innerHTML = 'Modificar del Proveedor'

      document.formEditProvider.id.value = providerToUpdate.id
      document.formEditProvider.rif.value = providerToUpdate.rif
      document.formEditProvider.nombre.value = providerToUpdate.nombre
      document.formEditProvider.telefono.value = providerToUpdate.telefono
      document.formEditProvider.direccion.value = providerToUpdate.direccion

    }

  }

  function validarFormularioAddProvider() {

    document.getElementById("btnFindProvider").addEventListener("click", (event) => {

      var numero = document.formEditProvider.rif.value;

      if (numero.length == 0) {
        document.formEditProvider.rif.focus();
        return;
      }

      $.ajax({
        type: 'GET',
        url: '/clienteVzla/' + numero,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {

          if (!data?.data?.nombre) {
            let html = `
            <div id="validationNumFactVentaFeedback" class="invalid-feedback">
              No se encontraron reultado por el Cne y el Seniat
            </div>
            `;
            $("#txtHintNueProv").append(html)
          }

          document.formEditProvider.nombre.value = data.data.nombre;

        },
        beforeSend: function() {
          $('#btnFindProvider').prop('disabled', true)
        },
        complete: function() {
          $('#btnFindProvider').prop('disabled', false)
        },
        error: function() {
          $('#btnFindProvider').prop('disabled', false)
        },

      });

    })
  }

  function agreRProv(formulario) {
    //funcion de validacion
    var valido = validarFormulario(formulario);

    if (valido == 1) {

      const data = new FormData(document.formEditProvider);
      const values = Object.fromEntries(data.entries());
      let body = values;

      $.ajax({
        type: 'POST',
        url: '/provider',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: body,
        success: function(data) {

          if (data.data) {
            let html = `
            <div class="alert alert-success">
              Proveedor creado con exito
            </div>
            `;
            $("#txtHintNueProv").append(html)

          }

        },
        beforeSend: function(data) {
          $('#btnFormAddProvider').prop('disabled', true)
        },
        complete: function() {
          $('#btnFormAddProvider').prop('disabled', false)
        },
        error: function(data) {

          console.log("error al agregar proveedor", data)

          let html = `
          <div class="alert alert-danger">
            Lo sentimos No fue posible realzar la operacion Proveedor
            ${data.responseJSON.message}
          </div>
          `;
          $("#txtHintNueProv").append(html)
          $('#btnFormAddProvider').prop('disabled', false)
        },

      });
      //si esto compila se puede insertar y seleccionar
      //selecProv(rif, nombre, ' echo $_SERVER['REQUEST_URI']; ?>');
    }

  }


  //estas lineas estan en la funcion mmProv
  function modRProv(formulario) {
    //funcion de validacion
    //alert(formulario);
    var valido = validarFormulario(formulario);

    if (valido == 1) {

      const data = new FormData(document.formEditProvider);
      const values = Object.fromEntries(data.entries());
      let body = values;

      $.ajax({
        type: 'PUT',
        url: '/provider/' + values.id,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: body,
        success: function(data) {

          if (data.data) {
            let html = `
            <div class="alert alert-success">
              Proveedor actualizado con exito
            </div>
            `;
            $("#txtHintNueProv").append(html)

          }

        },
        beforeSend: function(data) {
          $('#btnFormAddProvider').prop('disabled', true)
        },
        complete: function() {
          $('#btnFormAddProvider').prop('disabled', false)
        },
        error: function(data) {

          let html = `
          <div class="alert alert-danger">
            Lo sentimos No fue posible realizar la operacion Proveedor
            ${data.responseJSON.message}
          </div>
          `;
          $("#txtHintNueProv").append(html)
          $('#btnFormAddProvider').prop('disabled', false)
        },

      });

    }

  }
</script>