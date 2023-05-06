<!-- Modal nueProd-->
<div id="nueProd" class="modal fade" role="dialog" aria-labelledby="nueProdLabel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleProdsLabel">Agregar Nuevo Producto</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form name="formProds" id="formProds">
        <!-- campos ocultos -->
        <input id="id" name="id" type="hidden" />

        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <!--para mostrar resultado de acciones de insercion y demas-->
              <label class="col-md-12 col-lg-12" id="txtHintAPROD" data-bs-dismiss="modal"></label>
            </div>
            <div class="row">
              <!--con el rif se manda a validar si existe con la funcino , y con cURLrif obtener el nombre-->
              <div class="col-md-4 col-lg-4" id="res_codigo">
                Codigo:<br>
                <span class="input-group" id="cont_codigo">
                  <input type="text" class="form-control" name="codigo" id="codigo" onKeyUp="" lang="si-general" required>
                  <button type="button" class="btn btn-primary m-0" onclick="genCodRand()">Generar Codigo</button>
                </span>
              </div>
              <div class="col-md-4 col-lg-4" id="res_nombre_i">
                <span id="cont_nombre_i">
                  Nombre:<br>
                  <input type="text" class="form-control" name="nombre_i" id="nombre_i" pattern="[A-Za-z ñáéíóú ÑÁÉÍÓÚ 0-9]*" onBlur="javascript:this.value=this.value.toUpperCase();" lang="si-general" required>
                </span>
              </div>

              <div class="col-md-4 col-lg-4">
                Stock &oacute; Existencia:<br>
                <input type="number" min="0" class="form-control" name="stock" id="stock" lang="no-number" readonly="readonly">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-lg-4">
                Valor Unitario:<br>
                <input type="number" min="0" step="0.01" class="form-control" name="valor_unitario" id="valor_unitario" lang="si-number" required>
              </div>
              <div class="col-md-4 col-lg-4">
                Precio de Venta<br>
                <span class="input-group bpmpvj_open_modal">
                  <input class="form-control" name="pmpvj[0]" id="pmpvj[0]" type="number" min="0" step="0.01" value="" placeholder="0.00" readonly="readonly" />
                  <button class="btn btn-primary m-0" name="bpmpvj" type="button" data-bs-target="#calPMPVJ" data-bs-toggle="modal" data-bs-dismiss="modal">P. Venta</button>
                </span>
              </div>
              <div class="col-md-4 col-lg-4">
                Fecha de Inventario Inicial:<br>
                <input type="month" class="form-control" name="fecha" id="fecha" value="" lang="si-general" />
              </div>
            </div><!--row-->
            <div class="row">
              <div class="col-md-4 col-lg-4">
                Descripcion:<br>
                <input type="text" class="form-control" name="descripcion" id="descripcion" lang="no-general">
              </div>
              <div class="col-md-4 col-lg-4">
                Cantidad Minima:<br>
                <input type="number" min="0" class="form-control" name="cant_min" id="cant_min" lang="no-number">
              </div>
              <div class="col-md-4 col-lg-4">
                Cantidad Maxima:<br />
                <input type="number" min="0" class="form-control" name="cant_max" id="cant_max" lang="no-number">
              </div>
            </div><!--row-->
          </div><!--form-group-->
        </div><!--modal-bosy-->

        <div class="modal-footer">
          <button type="button" id="btnAddInventory" class="btn btn-success" onclick="agreRProd(this.form);">Agregar y Seleccionar</button>
          <button type="button" class="btn btn-danger" id="close_m" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>

  </div>
</div>

<script>
  $(document).ready(function() {

    document.getElementById("nueProd").addEventListener('shown.bs.modal', function() {
      window.setTimeout(function() {

        $('#codigo', this).focus();
        $('#nueProd').modal({
          keyboard: false
        });
        document.onkeypress = stopRKey;

        validarFormularioAgreInventario();

        getDateInventarioInicial();

        setFormAddProdData(prodToUpdate)

      }.bind(this), 100);
    });

    document.getElementById("nueProd").addEventListener('hidden.bs.modal', function(event) {
      //rset form
      console.log("nueProd hidden")
      document.formProds.reset();
      prodToUpdate = null
    })

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

    document.getElementById("calPMPVJ").addEventListener('dismiss.bs.modal', function() {});

  });

  function validarFormularioAgreInventario() {

    //origen
    let urlCurrent = window.location.href
    let origin = urlCurrent.split('/')
    const urlActual = origin[origin.length - 1]

    const inventarylist = '<?php echo \App\Models\Inventario::INVENTARYLIST; ?>'

    if (urlActual.includes(inventarylist)) {

      document.forms["formProds"].elements["stock"].readOnly = null;
      document.forms["formProds"].elements["fecha"].readOnly = null;

      document.forms["formProds"].elements["bpmpvj"].disabled = null;
    } else { //MENOS EN CARGAR INVENTARIO
      // me traigo lo que ingrese en buscar
      document.getElementById('nombre_i').value = document.getElementById('b_prod').value;
    }
  }

  function getDateInventarioInicial() {

    $.ajax({
      type: 'GET',
      url: '/inventario-config',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {

        document.getElementById("fecha").value = data.mesInventario;
      }

    });

  }

  function agreRProd(formulario) {
    //funcion de validacion
    document.getElementById("txtHintAPROD").innerHTML = "";
    var valido = validarFormulario(formulario);
    if (!valido) {
      console.log("invalid")
      return
    }

    //INVENTARIO

    //origen
    let urlFull = window.location.href
    let origin = urlFull.split('/')
    const urlActual = origin[origin.length - 1]

    const patronA = '<?php echo \App\Models\Inventario::INVENTARYLIST; ?>';
    const patronB = '<?php echo \App\Models\FactCompra::FCOMPRAADD; ?>';
    const patronC = '<?php echo \App\Models\FactVenta::FVENTAADD; ?>';

    //variables contenidas en el formulariuo
    let body = {
      "codigo": $("input#codigo").val(),
      "nombre_i": $("input#nombre_i").val(),
      "stock": $("input#stock").val(),
      "valor_unitario": $("input#valor_unitario").val(),
      "pmpvj": $("input[name='pmpvj[0]']").val(),
      "fecha": $("input#fecha").val(),
      "cant_min": $("input#cant_min").val(),
      "cant_max": $("input#cant_max").val(),
      "descripcion": $("input#descripcion").val(),
    }

    if (urlActual.includes(patronA)) {
      body.tipo = "inv_ini";
      //COMPRA		si esto compila se puede insertar y seleccionar
    }

    $.ajax({
      type: 'POST',
      url: '/inventario-add',
      data: body,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        console.log("inventario-add", data)

        let htmlalert = ''

        htmlalert = `<div class="alert alert-success">
              Elemento agregado con exito
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        document.getElementById("codigo").value = "";
        document.getElementById("nombre_i").value = "";
        document.getElementById('txtHintAPROD').innerHTML = htmlalert;

        if (urlActual.includes(patronB) || urlActual.includes(patronC)) {
          selecProd(
            data.data.inventario.id,
            body.codigo,
            body.nombre_i,
            body.valor_unitario,
            body.stock
          );
          fcalculo();
          setTimeout(() => {
            $("#nueProd").modal('hide')

            setTimeout(() => {
              $("#busProd").modal('hide')
            }, 1000);
          }, 1000);

          return
        }

      },
      error: function(data) {
        console.log("error ", data)

        let htmlalert = `<div class="alert alert-danger">
          ${data.responseJSON.message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        document.getElementById('txtHintAPROD').innerHTML = htmlalert;
      },
      beforeSend: function() {
        $('#btnAddInventory').prop('disabled', true)
      },
      complete: function() {
        $('#btnAddInventory').prop('disabled', false)
      },

    }).fail(function(data) {
      console.log("error ", data)
      let htmlalert = `<div class="alert alert-danger">
          ${data.responseJSON.data.message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
      document.getElementById('txtHintAPROD').innerHTML = htmlalert;
    });

  }

  function setFormAddProdData() {

    document.getElementById("modalTitleProdsLabel").innerHTML = 'Agregar'
    document.getElementById("btnAddInventory").innerText = 'Agregar'
    document.getElementById("btnAddInventory").removeAttribute("onclick");
    document.formProds.stock.removeAttribute("readonly")
    document.formProds.elements['pmpvj[0]'].removeAttribute("readonly")
    document.getElementById("btnAddInventory").setAttribute("onclick", "agreRProd(this.form);")

    if (prodToUpdate?.id) {

      document.getElementById("modalTitleProdsLabel").innerHTML = 'Modificar'
      document.getElementById("btnAddInventory").innerText = 'Modificar'
      document.getElementById("btnAddInventory").setAttribute("onclick", "modRProd(this.form);")

      document.formProds.id.value = prodToUpdate.id
      document.formProds.codigo.value = prodToUpdate.codigo
      document.formProds.nombre_i.value = prodToUpdate.nombre_i
      document.formProds.descripcion.value = prodToUpdate.descripcion
      document.formProds.cant_min.value = prodToUpdate.cant_min
      document.formProds.cant_max.value = prodToUpdate.cant_max
      document.formProds.valor_unitario.value = prodToUpdate.valor_unitario
      document.formProds.elements['pmpvj[0]'].value = prodToUpdate.pmpvj_actual
      document.formProds.elements['pmpvj[0]'].readOnly = 'readOnly'
      document.formProds.fecha.value = prodToUpdate.fecha.substr(0, 7)
      document.formProds.stock.value = prodToUpdate.stock
      document.formProds.stock.readOnly = 'readOnly'
    }

  }

  //estas lineas estan en la funcion mmProd
  function modRProd(formulario) {
    //funcion de validacion
    //alert(formulario);
    var valido = validarFormulario(formulario);

    if (valido == 1) {

      const data = new FormData(document.formProds);
      const values = Object.fromEntries(data.entries());
      let body = values;

      $.ajax({
        type: 'PUT',
        url: '/inventario/' + values.id,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: body,
        success: function(data) {

          if (data.data) {
            let html = `
            <div class="alert alert-success">
              Producto actualizado con exito
            </div>
            `;
            $("#txtHintAPROD").append(html)

          }

        },
        beforeSend: function(data) {
          $('#btnAddInventory').prop('disabled', true)
        },
        complete: function() {
          $('#btnAddInventory').prop('disabled', false)
        },
        error: function(data) {

          let html = `
          <div class="alert alert-danger">
            Lo sentimos No fue posible realizar la operacion Productos
            ${data.responseJSON.message}
          </div>
          `;
          $("#txtHintAPROD").append(html)
          $('#btnAddInventory').prop('disabled', false)
        },

      });
      //si esto compila se puede insertar y seleccionar
      //selecProv(rif,nombre);
    }

  }
</script>