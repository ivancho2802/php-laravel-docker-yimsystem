<!-- Modal nueCargo-->
<div id="busFact" class="modal fade" role="dialog" aria-hidden="true" aria-labelledby="busFactLabel" tabindex="-1">
  <div class="modal-dialog  modal-xl">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="busFactLabel">Consulta del Documento a Afectar</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" name="formMbf">
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-xs-12 col-md-4 col-lg-4">
                N° Documento:<br />
                <input type="text" class="form-control" name="num_fact_compra" id="num_fact_compra" autocomplete="off">
              </div>
              <div class="col-xs-12 col-md-4 col-lg-4">
                Serie de Documento<br>
                <input type="text" class="form-control" name="serie_fact_compra" id="serie_fact_compra" autocomplete="off">
              </div>

              <div class="col-xs-12 col-md-4 col-lg-4">
                <label for="tipodocumnto">Tipo de Documento:</label><br />
                <select id="tipo_fact_compra" class="form-control" name="tipo_fact_compra" autocomplete="off">
                  <option value="">Seleccione</option>
                  <option value="F">Factura</option>
                  <option value="ND">Nota de D&eacute;bito</option>
                  <option value="NC-DESC">Nota de Cr&eacute;dito - Descuento</option>
                  <option value="NC-DEVO">Nota de Cr&eacute;dito - Devoluciones</option>
                  <option value="C">Certificaci&oacute;n</option>
                  <option value="NE">Nota de Entrega</option>
                  <!--
                        <optgroup label="Existencia Inicial">
                            <option value="II">Inventario Inicial</option>
                        </optgroup>
                        -->
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-md-4 col-lg-4">
                <label>Rif Proveedor:</label><br />
                <div class="input-group">
                  <input name="fk_proveedor" id="fk_proveedor" class="form-control" onclick="modalbusProv('formMbf')" onfocus="modalbusProv('formMbf')" placeholder="Clic aqui" type="text" />
                  <button class="btn btn-primary m-0" type="button" onclick="vaciar('fk_proveedor'); consulFact();">
                    &times;
                  </button>
                </div>
              </div>


              <div class="col-xs-12 col-md-4 col-lg-4">
                <label>Nombre Proveedor:</label><br />
                <div class="input-group">
                  <input type="button" name="nom_prov_ajax" id="nom_prov_ajax" class="form-control" onclick="modalbusProv('formMbf')" onfocus="modalbusProv('formMbf')" placeholder="Clic aqui">
                  <button class="btn btn-primary m-0" type="button" onclick="vaciar('nom_prov_ajax'); consulFact();">
                    &times;
                  </button>

                </div>
              </div>


              <div class="col-xs-12 col-md-4 col-lg-4">
                <label>Fecha de Emisi&oacute;n:</label><br><!--de la Compra-->
                <input type="date" class="form-control" name="fecha_fact_compra" id="fecha_fact_compra" />
              </div>

            </div><!--row-->
            <div class="row">
              <div class="col-xs-12 col-md-4 col-lg-4">
                <label>Mes y A&ntilde;o de Emisi&oacute;n:</label><br><!--de la Compra-->
                <input type="month" class="form-control" name="mes_fact_compra" id="mes_fact_compra" />
              </div>

              <div class="col-xs-12 col-md-4 col-lg-4">
                Ordenado Por:
                <select class="form-control" name="ord" id="ord">
                  <option value="">Seleccione</option>
                  <option value="tipo_fact_compra">Tipo de Documento</option>
                  <option value="num_fact_compra">Numero de Documento</option>
                  <option value="fk_proveedor">Nombre de Proveedor</option>
                  <option value="fecha_fact_compra">Fecha</option>
                  <!--
                        <optgroup label="Existencia Inicial">
                            
                        <option value="">Nota de Cr&eacute;dito - Devoluciones</option>
                        <option value="C">Certificaci&oacute;n</option>
                        <option value="NE">Nota de Entrega</option>
                        
                        <option value="II">Inventario Inicial</option>
                        </optgroup>
                        -->
                </select>
              </div>

              <div class="col-xs-12 col-md-4 col-lg-4">
                <button type="button" id="btnConsulFact" class="btn btn-primary form-control mt-4" onClick="consulFact();">
                  Buscar
                </button>
              </div>
            </div><!--row-->
            <hr id="" class="featurette-divider" />
            <div class="row">
              <div class="col-md-12 col-lg-12 text-center">
                <br /><span>Presione Espacio para mostrar todos</span>
              </div>
              <div class="col-md-12 col-lg-12" id="resFact">

              </div>
            </div><!--row-->
          </div><!--form-group-->
        </div><!--modal-bosy-->
      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-target="#busFact" data-bs-toggle="modal" data-bs-dismiss="modal">
          Cancelar
        </button>
      </div>
    </div>

  </div>
</div>
<script>
  //para desactivar el enter envie y cierre el modal
  document.getElementById("busFact")
    .addEventListener('hidden.bs.modal', function(e) {
      document.onkeypress = !stopRKey;
    })

  function consulFact() {

    let monthyear = document.getElementById('mes_fact_compra').value,
      fecha_fact_compra = document.formMbf.fecha_fact_compra.value,
      num_fact_compra = document.formMbf.num_fact_compra.value,
      serie_fact_compra = document.formMbf.serie_fact_compra.value,
      tipo_fact_compra = document.formMbf.tipo_fact_compra.value,
      fk_proveedor = document.formMbf.fk_proveedor.value,
      nom_prov_ajax = document.formMbf.nom_prov_ajax.value,
      ord = document.formMbf.ord.value

    body = {}

    if (num_fact_compra) {
      body.num_fact_compra = num_fact_compra
    }
    if (serie_fact_compra) {
      body.serie_fact_compra = serie_fact_compra
    }
    if (tipo_fact_compra) {
      body.tipo_fact_compra = tipo_fact_compra
    }
    if (fk_proveedor) {
      body.fk_proveedor = fk_proveedor
    }
    if (nom_prov_ajax) {
      body.nom_prov_ajax = nom_prov_ajax
    }
    if (fecha_fact_compra) {
      body.queryBetween = [fecha_fact_compra, fecha_fact_compra]
    }
    if (ord) {
      body.queryBetween = ord
    }
    if (monthyear) {
      let queryBetween = [monthyear + '01', monthyear + '31']
      body.queryBetween = queryBetween
    }

    //origen
    let urlCurrent = window.location.href
    let origin = urlCurrent.split('/')
    body.origin = origin[origin.length - 1]

    $.ajax({
      type: 'POST',
      url: '/book-shopping',
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
</script>