<!-- Modal nueCargo-->
<div id="busCliente" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="busFactLabel">Consulta del Cliente</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" name="formCliente">
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                Nombre &oacute; Documento:<br />
                <input type="text" class="form-control" name="b_cliente" id="b_cliente" autocomplete="off" required>
              </div>
              <div class="col-md-12 col-lg-12">
                <button class="btn btn-primary" id="btnFormCliente" type="button" onclick="consulCliente();">
                  Buscar
                </button>
                <button class="btn btn-primary" id="btnFormCliente" type="button" data-bs-toggle="modal" data-bs-target="#mmCliente">
                  Agregar
                </button>
              </div>
              <br /><span>Presione Espacio para mostrar todos</span>

              <div class="col-md-12 col-lg-12" id="resCliente">

              </div>
            </div><!--row-->
          </div><!--form-group-->
        </div><!--modal-bosy-->
      </form><!--mbprov-->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>

<script>
  //para desactivar el enter envie y cierre el modal

  var clienteToUpdate

  $(document).ready(function() {

    $(window.document).on('shown.bs.modal', '#busCliente', function() {
      document.onkeypress = stopRKey;
      $('#b_Cliente', this).focus();
    });
    $('#busCliente').on('hidden.bs.modal', function(e) {
      document.onkeypress = !stopRKey;
      clienteToUpdate = null
    });
  });
  //para ver si existe el rif en el sistema
  function consulCliente() {
    document.getElementById("resCliente").innerHTML = "";

    let b_fact = document.formCliente.b_cliente.value,
      body = {}

    if (b_fact.trim()) {
      body = {
        cliente: b_fact
      }
    }

    //origen
    let urlCurrent = window.location.href
    let origin = urlCurrent.split('/')
    body.origin = origin[origin.length - 1]

    $.ajax({
      type: 'POST',
      url: '/clientes',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: body,
      success: function(data) {
        document.getElementById("resCliente").innerHTML = data;
      },
      beforeSend: function() {
        document.getElementById("btnFormCliente").disabled = true
      },
      complete: function() {
        document.getElementById("btnFormCliente").disabled = false
      },

    });

  }
  //selector de proveedor
  //para enviar el rif del proveedor y nombre a cargarcompra.ph
  function selecCliente(strI, strII, strIII, strIV) {
    document.form1.elements["fk_cliente"].value = strI;
    document.form1.elements["ced_cliente"].value = strII;
    document.form1.elements["nom_cliente_ajax"].value = strIII;
    document.form1.elements["tipo_contri"].value = strIV;
  }

  function showModalEditCliente(btn) {

    console.log("btn", btn)
    clienteToUpdate = $(btn).data('id');
    console.log("clienteToUpdate", clienteToUpdate)

    var modalEditCliente = new bootstrap.Modal(document.getElementById('mmCliente'), {
      keyboard: false
    })
    modalEditCliente.show()
  }

</script>