<!-- Modal nueCargo-->
<div id="busFact" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="busFactLabel">Consulta Documento de Venta</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form name="form_modal_fact_venta" method="post">
        <div class="modal-body">
          <div class="form-group">
            <div id="row1" class="row">
              <div id="colum1" class="col-md-12 col-lg-12">
                Numero de Factura:<br />
                <input type="text" class="form-control" name="b_fact" id="b_fact" autocomplete="off" required>
              </div>

              <div class="col-xs-12 col-md-4 col-lg-4">
                <button type="button" id="btnConsulFact" class="btn btn-primary form-control mt-4" onClick="consulFact()">
                  Buscar
                </button>
              </div>

            </div><!--row-->
            <div class="row">
              <br /><span>Presione Espacio para mostrar todos</span>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12" id="resFact">

              </div>
            </div>
          </div><!--form-group-->
        </div><!--modal-bosy-->
      </form><!--mbprov-->
      <div class="modal-footer">
        <button type="button" id="close_m" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>

<script>
  //para ver si existe el rif en el sistema

  function consulFact() {

    let b_fact = document.form_modal_fact_venta.b_fact.value,

      body = {}

    if (b_fact.trim()) {
      body = {
        query: {
          num_fact_venta: b_fact
        }
      }
    }

    //origen
    let urlCurrent = window.location.href
    let origin = urlCurrent.split('/')
    body.origin = origin[origin.length - 1]

    $.ajax({
      type: 'POST',
      url: '/book-sales',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: body,
      success: function(data) {
        document.getElementById("resFact").innerHTML = data;
      },
      beforeSend: function() {
        document.getElementById("btnConsulFact").disabled = true
      },
      complete: function() {
        document.getElementById("btnConsulFact").disabled = false
      },

    });
  }

  $(document).ready(function() {

    $('#busFact').on('hidden.bs.modal', function(e) {
      document.onkeypress = !stopRKey;
    });
    $('#busFact').on('shown.bs.modal', function() {
      document.onkeypress = stopRKey;
      $('#b_fact', this).focus();
    });
    /*
    $(window.document).on('shown.bs.modal', '#busFact', function() {
      window.setTimeout(function() {
        //para desactivar el enter envie y cierre el modal
        //edicion de los campos de busqueda
        patron3 = 'factVenta';
        inputTipoDocu = null;
        try {
          inputTipoDocu = document.getElementById('tipo_docu');
        } catch (err) {
          alert(err.message);
        }

        if (url.search(patron3) > 0 && inputTipoDocu == null) {

          document.getElementById('colum1').className = 'col-md-6 col-lg-6';
          var div_id_row1 = document.getElementById("row1");
          var div_c_colum2 = document.createElement("div");
          var select_tipo_docu = document.createElement("select");
          var array_tipo_docu = ["F", "RDV", "FNULL", "ND", "NC-DEVO", "NC-DESC", "NE",
            "Factura", "Resumen Diario de Ventas", "Factura Anulada", "Nota de Débito", "Nota de Crédito - Devoluciones", "Nota de Crédito - Descuentos", "Nota de Entrega"
          ];
          var option_tipo_docu = document.createElement("option");

          div_c_colum2.setAttribute("class", "col-md-6 col-lg-6");
          div_c_colum2.setAttribute("align", "center");
          div_c_colum2.innerHTML = "Tipo de Documento<br />";
          div_id_row1.appendChild(div_c_colum2); //introduzco el div_c_colum2 en el div_id_row1

          select_tipo_docu.setAttribute("class", "form-control");
          select_tipo_docu.setAttribute("name", "tipo_docu");
          select_tipo_docu.setAttribute("id", "tipo_docu");
          select_tipo_docu.setAttribute("required", "required");
          select_tipo_docu.setAttribute("onchange", "consulFact(document.form_modal_fact_venta.b_fact.value)");

          /////////////////////
          for (j = 0; j < array_tipo_docu.length / 2; j++) {
            var option_tipo_docu = document.createElement("option");

            option_tipo_docu.value = array_tipo_docu[j]; //
            option_tipo_docu.text = array_tipo_docu[j + 7]; //
            select_tipo_docu.appendChild(option_tipo_docu); //introduzco el option_tipo_docu en el select_tipo_docu
          }
          div_c_colum2.appendChild(select_tipo_docu); //introduzco el select_tipo_docu en el div_c_colum2

        }
      }.bind(this), 100);
    });*/
  });
</script>