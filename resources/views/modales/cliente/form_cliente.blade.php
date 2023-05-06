<div id="mmCliente" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleLabel">Modificar del Cliente</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form id="formEditCliente" name="formEditCliente">

          <!-- campos ocultos -->
          <input name="id" id="id" type="hidden" />
          <div class="row">
            <!--para mostrar resultado de acciones de insercion y demas-->
            <label class="col-md-12 col-lg-12" id="txtEdomodRCliente" data-bs-dismiss="modal"></label>
          </div>
          <div class="row">
            <!--con el rif se manda a validar si existe con la funcino buscar_dato, y con cURLrif obtener el nombre-->
            <div class="col-12" id="res_modif_ced_cliente">
              Documento del Cliente<br>
              <span id="cont_ced_cliente">
                <input type="text" class="form-control" name="ced_cliente" id="ced_cliente" pattern="[JVEGP][0-9]{9}" onKeyUp="javascript:this.value=this.value.toUpperCase();" lang="si-general" value="" required>
                <span class="help-block">Formato: V012223334</span>
              </span>
            </div>
            
            <div class="col-12">
              Nombre o Raz&oacute;n Social:<br />
              <span class="input-group">
                <input type="text" class="form-control" name="nom_cliente" id="nom_cliente" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onKeyUp="javascript:this.value=this.value.toUpperCase();" lang="si-general" value="" required>

                <button id="btnFindUser" type="button" class="form-control btn btn-primary m-0">
                  Buscar(INTERNET)
                </button>
              </span>
            </div>

          </div>
          <div class="row">
            <div class="col-md-4 col-lg-4">
              Tipo de Contribuyente
              <select class="form-control" name="contri_cliente" id="contri_cliente" lang="si-general" required>
                <option value="CONTRI_ORD">Contribuyente Ordinario</option>
                <option value="CONTRI_ESP">Contribuyente Especial</option>
                <option value="NO_CONTRI">No Contribuyente</option>
              </select>
            </div>
            <div class="col-md-4 col-lg-4">
              Fecha de Registro:<br>
              <input type="date" class="form-control" name="fech_i_cliente" id="fech_i_cliente" value="" />
            </div>

            <div class="col-md-4 col-lg-4">
              Telefono:<br>
              <input type="text" class="form-control" name="tel_cliente" id="tel_cliente" min="999999999" max="999999999999" pattern="[0][42][127][246][0-9]{7}" lang="no-telf" value="">
              <span class="help-block">Formato: 04161234567</span>
            </div>

          </div><!--row-->
          <div class="row">
            <div class="col-md-4 col-lg-4">
              E-mail:<br>
              <input type="text" class="form-control" name="email_cliente" id="email_cliente" lang="no-email" value="">
            </div>
            <div class="col-md-4 col-lg-4">
              Direcci&oacute;n:<br />
              <input class="form-control" type="text" name="dir_cliente" id="dir_cliente" value="" required>
            </div>
          </div><!--row-->


          <div class="modal-footer">
            <button id="btnFormEditCliente" type="button" class="btn btn-success" onclick="modRCliente(this.form);">Modificar</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>

      </div>
    </div>

  </div><!--row-->
</div><!--row-->

<script>
  $(document).ready(function() {

    $(window.document).on('shown.bs.modal', '#mmCliente', function() {
      document.onkeypress = stopRKey;
      $('#ced_cliente', this).focus();

      validarFormularioAddClientes()

      setFormAddClienteData(clienteToUpdate)

    });
    $('#mmCliente').on('hidden.bs.modal', function(e) {
      $("#txtEdomodRCliente").innerText = ""
      document.onkeypress = !stopRKey;
      consulCliente();
      clienteToUpdate = null
    });
  });

  /**
   * autos_tipo_contri(this.value,'contri_cliente');"
   * funcion para autoseleccionar el tipod e contribuyente
   */
  function validarFormularioAddClientes() {
    document.getElementById("ced_cliente").addEventListener("KeyUp", (event) => {

      const docu_cliente = event.target.value
      var aguja = new RegExp(/[A-Za-z.]/);
      pajar = docu_cliente;

      if (pajar != "") {
        if (aguja.test(pajar) && pajar.length == 10) //esto es un rif y contribuyente
          document.getElementById('contri_cliente').value = "CONTRI_ORD";
        else //esto es un cedula NO contribuyente
          document.getElementById('contri_cliente').value = "NO_CONTRI";
      } else {
        document.getElementById('contri_cliente').value = "";
      }
    })

    document.getElementById("btnFindUser").addEventListener("click", (event) => {

      var numero = document.getElementById("ced_cliente").value;

      if (numero.length == 0) {
        document.getElementById("ced_cliente").focus();
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
            $("#res_modif_ced_cliente").append(html)
          }

          document.forms["formEditCliente"].elements["nom_cliente"].value = data.data.nombre;

        },
        beforeSend: function() {
          $('#btnFindUser').prop('disabled', true)
        },
        complete: function() {
          $('#btnFindUser').prop('disabled', false)
        },
        error: function() {
          $('#btnFindUser').prop('disabled', false)
        },

      });

    })

  }

  function setFormAddClienteData() {

    document.getElementById("modalTitleLabel").innerHTML = 'Agregar del Cliente'
    document.getElementById("btnFormEditCliente").innerText = 'Agregar del Cliente'
    document.getElementById("btnFormEditCliente").onclick = "agreRCliente(this.form);"

    if (clienteToUpdate) {

      document.getElementById("btnFormEditCliente").innerText = 'Modificar del Cliente'
      document.getElementById("btnFormEditCliente").onclick = "modRCliente(this.form);"
      document.getElementById("modalTitleLabel").innerHTML = 'Modificar del Cliente'

      document.formEditCliente.id.value = clienteToUpdate.id
      document.formEditCliente.ced_cliente.value = clienteToUpdate.ced_cliente
      document.formEditCliente.nom_cliente.value = clienteToUpdate.nom_cliente
      document.formEditCliente.contri_cliente.value = clienteToUpdate.contri_cliente
      document.formEditCliente.tel_cliente.value = clienteToUpdate.tel_cliente
      document.formEditCliente.email_cliente.value = clienteToUpdate.email_cliente
      document.formEditCliente.dir_cliente.value = clienteToUpdate.dir_cliente
      document.formEditCliente.fech_i_cliente.value = clienteToUpdate.fech_i_cliente.substr(0, 10)

    }

  }

  //estas lineas estan en la funcion mmProv
  function modRCliente(formulario) {
    //funcion de validacion
    //alert(formulario);
    var valido = validarFormulario(formulario);

    if (valido == 1) {

      const data = new FormData(document.formEditCliente);
      const values = Object.fromEntries(data.entries());
      let body = values;

      $.ajax({
        type: 'PUT',
        url: '/cliente/' + values.id,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: body,
        success: function(data) {

          if (data.data) {
            let html = `
            <div class="alert alert-success">
              Cliente actualizado con exito
            </div>
            `;
            $("#txtEdomodRCliente").append(html)

          }

        },
        beforeSend: function(data) {
          $('#btnFormEditCliente').prop('disabled', true)
        },
        complete: function() {
          $('#btnFormEditCliente').prop('disabled', false)
        },
        error: function(data) {

          let html = `
          <div class="alert alert-danger">
            Lo sentimos No fue posible realizar la operacion Cliente
            ${data.responseJSON.message}
          </div>
          `;
          $("#txtEdomodRCliente").append(html)
          $('#btnFormEditCliente').prop('disabled', false)
        },

      });

    }

  }


  function agreRCliente(formulario) {

    //funcion de validacion
    var valido = validarFormulario(formulario);

    if (valido == 1) {

      const data = new FormData(document.formEditCliente);
      const values = Object.fromEntries(data.entries());
      let body = values;

      $.ajax({
        type: 'POST',
        url: '/cliente',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: body,
        success: function(data) {

          let html = `
            <div class="alert alert-success">
              Cliente actualizado con exito
            </div>
            `;
          $("#txtEdomodRCliente").append(html)

        },
        beforeSend: function(data) {
          $('#btnFormEditCliente').prop('disabled', true)
        },
        complete: function() {
          $('#btnFormEditCliente').prop('disabled', false)
        },
        error: function(data) {

          let html = `
          <div class="alert alert-danger">
            Lo sentimos No fue posible realizar la operacion Cliente
            ${data.responseJSON.message}
          </div>
          `;
          $("#txtEdomodRCliente").append(html)
          $('#btnFormEditCliente').prop('disabled', false)
        },

      });

      //si esto compila se puede insertar y seleccionar
      //selecCliente(ced_cliente, nom_cliente, contri_cliente);
    }

  }
</script>