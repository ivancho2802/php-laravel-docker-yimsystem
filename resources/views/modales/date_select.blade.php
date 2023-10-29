<div id="setFechaOp" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleLabel">Fecha de Operaciones </h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form id="formEditCliente" name="formEditCliente">

          <!-- campos ocultos -->
          <input name="id" id="id" type="hidden" />
          <div class="row">
            <!--para mostrar resultado de acciones de insercion y demas-->
            <label class="col-md-12 col-lg-12" id="txtEdosetFechaOp" data-bs-dismiss="modal"></label>
          </div>
          <div class="row">
            <!--con el rif se manda a validar si existe con la funcino buscar_dato, y con cURLrif obtener el nombre-->
            <div class="col-6" id="res_modif_ced_cliente">
              Desde:<br>

              <span id="cont_ced_cliente">
                <input type="date" class="form-control" placeholder="From" name="from" id="from" value="{{ Cookie::get('date_op_from') ? Cookie::get('date_op_from') : '' }}" />
              </span>
            </div>

            <div class="col-6">
              Hasta:<br />
              <span class="input-group">
                <input type="date" class="form-control" placeholder="to" name="to" id="to" value="{{ Cookie::get('date_op_to') ? Cookie::get('date_op_to') : date('Y-m-d') }}" />
              </span>
            </div>

            <div class="col-6">
              Tipo Intervalo:<br />
              <span class="input-group">
                <select class="form-select" placeholder="intervalo" name="t_intervalo" id="t_intervalo">
                  <option value="days"> dias</option>
                  <option value="months"> meses</option>
                  <option value="years"> año</option>
                </select>
              </span>

            </div>

            <div class="col-6">
              Cantidad del Intervalo:<br />
              <span class="input-group">
                <input type="number" class="form-control" placeholder="Cantidad inervalo" name="c_intervalo" id="c_intervalo" />
              </span>

            </div>

          </div>

          <div class="modal-footer">
            <button id="btnFormEditCliente" type="button" class="btn btn-success" onclick="setFechaOp(this.form);">Buscar y Guardar</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>

      </div>
    </div>

  </div><!--row-->
</div><!--row-->

<script>
  $(document).ready(function() {

    $(window.document).on('shown.bs.modal', '#setFechaOp', function() {
      document.onkeypress = stopRKey;
      $('#from', this).focus();

      validarFormularioFechaOp()
    });
    $('#setFechaOp').on('hidden.bs.modal', function(e) {
      $("#txtEdosetFechaOp").innerText = ""
      document.onkeypress = !stopRKey;

      //redireccionar 
    });

    $('#t_intervalo').on('change', function(e) {
      calcularFechas(null, null);
    });
    $('#c_intervalo').on('input', function(e) {
      calcularFechas(null, null);
    });
    $('#c_intervalo').on('change', function(e) {
      calcularFechas(null, null);
    });

  });

  /**
   * para vlidar y calcular fecha to
   * days
      months
      years
   */
  function validarFormularioFechaOp() {

    let from = document.getElementById("from").value;
    let to = document.getElementById("to").value;
    let t_intervalo = document.getElementById("t_intervalo").value;
    let c_intervalo = document.getElementById("c_intervalo").value;

    let from_moment = moment(from);
    let to_moment = moment(to);

    // si no esta es por que no ha cockie
    if (from == "" || to == "") {
      calcularFechas('months', 3)
    } else {
      //years, months, weeks, days, hours, minutes, and seconds

      let monthsDiff = to_moment.diff(from_moment, 'months');
      let yearsDiff = to_moment.diff(from_moment, 'years');
      let daysDiff = to_moment.diff(from_moment, 'days');
      console.log("from_moment.diff(b, 'days')", monthsDiff);
      console.log("from_moment.diff(b, 'days')", yearsDiff);
      console.log("from_moment.diff(b, 'days')", daysDiff);

      //cacular la difrencia entre las fechas y set id a t_intervalo c_intervalo
      if (monthsDiff > 0 && yearsDiff <= 0) {
        document.getElementById("t_intervalo").value = "months";
        document.getElementById("c_intervalo").value = monthsDiff;
      } else if (yearsDiff > 0) {
        document.getElementById("t_intervalo").value = "years";
        document.getElementById("c_intervalo").value = yearsDiff;
      } else {
        document.getElementById("t_intervalo").value = "days";
        document.getElementById("c_intervalo").value = daysDiff;
      }

    }

  }

  function calcularFechas(t_intervalo, c_intervalo) {

    console.log("calcularFechas: ", document.getElementById("from").value + 
document.getElementById("to").value)
    console.log("calcularFechas: ", $('#from').val() +  $('#to').val())

    let to = $('#to').val();
    //days,      months,      years
    if (t_intervalo) {
      $('#t_intervalo').val(t_intervalo);
    }

    if (c_intervalo) {
      $('#c_intervalo').val(c_intervalo);
    }

    if (!$('#c_intervalo').val() || !$('#t_intervalo').val()) {
      return;
    }

    console.log("to", to);
    let from = calcDate(to, false, $('#t_intervalo').val(), $('#c_intervalo').val());
    console.log("from", from);

    from = formatDate(new Date(from));
    console.log("from", from);

    document.getElementById("from").value = from;
  }

  //estas lineas estan en la funcion mmProv
  function setFechaOp(formulario) {
    //funcion de validacion
    var valido = validarFormulario(formulario);

    if (valido == 1) {
      const data = new FormData(document.formEditCliente);
      const values = Object.fromEntries(data.entries());
      let body = values;
      console.log("formulario", body);

      body.origin = '<?php

                      use Illuminate\Support\Facades\Route;

                      $route = Route::current();
                      $name = $route->getName();

                      echo $name;
                      ?>';

      $.ajax({
        type: 'POST',
        url: '/config',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: body,
        success: function(data) {
          console.log("data", data);

          if (data.status) {

            let html = `
            <div class="alert alert-success">
              Configuracion actualizada con exito
            </div>
            `;
            $("#txtEdosetFechaOp").append(html)
            $('#setFechaOp').modal('hide');
            location.href = data.data;

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
            Lo sentimos No fue posible realizar la operacion 
            ${data.responseJSON.message}
          </div>
          `;
          $("#txtEdosetFechaOp").append(html)
          $('#btnFormEditCliente').prop('disabled', false)
        },

      });

    }

  }
</script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script> -->