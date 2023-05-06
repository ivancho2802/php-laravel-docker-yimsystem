<!-- Modal nueCargo-->
<div id="busProv" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="busFactLabel">Consulta del Proveedor</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" name="formProv" id="formProv">
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6 col-lg-6">

                <input type="hidden" id="otroModal" value="" />

                Nombre &oacute; R.I.F.:<br />
                <input type="text" class="form-control" name="b_prov" id="b_prov" autocomplete="off" required>
                <br /><span>Presione solo buscar para mostrar todos</span>
              </div>
            </div>
            <div class="row">

              <div class="col-xs-12 col-md-12 col-lg-12  mt-4">
                <button type="button" id="btnConsulProv" class="btn btn-primary " onClick="consulProv();">
                  Buscar
                </button>
                <button class="btn btn-info" id="btnFormProvider" type="button" data-bs-toggle="modal" data-bs-target="#nueProv">
                  Agregar
                </button>
              </div>
              <div class="col-md-12 col-lg-12" id="resProv">

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
<!-- END Modal nueCargo-->

<script>
  //para desactivar el enter envie y cierre el modal
  var providerToUpdate
  $(document).ready(function() {

    $('#busProv').on('hidden.bs.modal', function(e) {
      document.onkeypress = !stopRKey;
      //loseFocus('b_prov');
      providerToUpdate = null

    });
  });
  //para ver si existe el rif en el sistema
  function consulProv() {

    document.getElementById("resProv").innerHTML = "";
    let str = $('#b_prov').val()

    let body = {}

    if (str.trim()) {
      body.prov = str
    }
    //origen
    let urlCurrent = window.location.href
    let origin = urlCurrent.split('/')
    body.origin = origin[origin.length - 1]

    //otromodal
    var otroModal = document.getElementById('otroModal').value;
    body.otroModal = otroModal

    $.ajax({
      type: 'POST',
      url: '/providers',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: body,
      success: function(data) {
        document.getElementById("resProv").innerHTML = data;
      },
      beforeSend: function() {
        document.getElementById("btnConsulProv").disabled = true
      },
      complete: function() {
        document.getElementById("btnConsulProv").disabled = false
      },

    });
  }

  /**
   * selector de proveedor
   * @param {*} strI para enviar el rif del proveedor
   * @param {*} strII nombre a cargarcompra.php
   * @param {*} url origin
   */
  function selecProv(strI, strII, strIII, url) {
    var patron1 = "book-shopping-reten-add";
    var patron2 = "book-shopping-add";
    var patron3 = "book-shopping-edit";
    var otroModal = document.getElementById('otroModal').value;

    if (url.includes(patron1)) {
      document.formMbf.elements["fk_proveedor"].value = strI;
      document.formMbf.elements["rif"].value = strII;
      document.formMbf.elements["nom_prov_ajax"].value = strIII;

      consulFact();
    } else if (url.includes(patron2) || url.includes(patron3)) {
      if (otroModal == "") {
        document.form1.elements["fk_proveedor"].value = strI;
        document.form1.elements["rif"].value = strII;
        document.form1.elements["nom_prov_ajax"].value = strIII;
      } else if (otroModal == "formMbf") {
        document.forms[otroModal].elements["fk_proveedor"].value = strI;
        document.forms[otroModal].elements["rif"].value = strII;
        document.forms[otroModal].elements["nom_prov_ajax"].value = strII;
        consulFact();
      }
    } else
      alert("No existe este la url en la toma de deciciones patron en la funcion SelecProv()");
  }

  function showModalEditProv(btn) {

    console.log("btn", btn)
    providerToUpdate = $(btn).data('id');
    console.log("providerToUpdate", providerToUpdate)

    var modalEditProvider = new bootstrap.Modal(document.getElementById('nueProv'), {
      keyboard: false
    })
    modalEditProvider.show()

  }
</script>