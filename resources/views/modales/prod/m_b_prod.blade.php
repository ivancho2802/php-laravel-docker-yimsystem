<!-- Modal nueCargo-->
<div id="busProd" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="busProdLabel">Consulta del Producto</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" name="formProd" id="formProd">
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6 col-lg-6">
                Nombre &oacute; Codigo:<br />
                <input type="text" class="form-control" name="b_prod" id="b_prod" autocomplete="off" required>
                <br /><span>Presione Espacio para mostrar todos</span>
              </div>
            </div>
            <div class="row">

              <div class="col-md-6 col-lg-6 mt-4">
                <button id="btnConsulProd" class="btn btn-primary" onclick="consulProd($('#b_prod').val());" type="button">
                  Buscar
                </button>
              </div>

              <div class="col-md-6 col-lg-6">
                <button class="btn btn-info" id="btnFormProd" type="button" data-bs-toggle="modal" data-bs-target="#nueProd">
                  Agregar
                </button>
              </div>

              <div class="col-md-12 col-lg-12" id="resProd">

              </div>
            </div><!--row-->
          </div><!--form-group-->
        </div><!--modal-bosy-->
      </form><!--mbprod-->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>
<script>
  var myModalbusProd = document.getElementById('busProd')
  var prodToUpdate = null
  myModalbusProd.addEventListener('hidden.bs.modal', function(event) {
    // do something...
  })
  myModalbusProd.addEventListener('show.bs.modal', function(e) {
    document.onkeypress = stopRKey;

  });

  /**
   * para ver si existe el rif en el sistema
   */
  function consulProd(str) {

    const factcompraadd = '<?php echo \App\Models\FactCompra::FCOMPRAADD; ?>'
    const factventaadd = '<?php echo \App\Models\FactVenta::FVENTAADD; ?>'

    let body = {
      prod: str
    }
    //origen
    let urlCurrent = window.location.href
    let origin = urlCurrent.split('/')
    const urlActual = origin[origin.length - 1]
    var tipoDoc;
    var nfact_afectada


    //VALIDACIONES
    //si vengo de cargar compra y el tipo de documento es nota de credito el sql
    //  va a cambiar
    //solo para compra
    if (urlActual.includes(factcompraadd)) {
      nfact_afectada = document.form1.nfact_afectada.value;
      tipoDoc = document.form1.tipo_fact_compra.value;
      if ((tipoDoc == 'NC-DESC' || tipoDoc == 'NC-DEVO') && nfact_afectada == "") {
        alert("Debe seleccionar un Documento para afectar Debido a la NOTA DE CREDITO");
        return;
      }
    } else if (urlActual.includes(factventaadd)) {
      nfact_afectada = document.form1.nfact_afectada.value;
      tipoDoc = document.form1.tipo_fact_venta.value;
      if ((tipoDoc == 'NC-DESC' || tipoDoc == 'NC-DEVO') && nfact_afectada == "") {
        alert("Debe seleccionar un Documento para afectar Debido a la NOTA DE CREDITO");
        return;
      }
    }

    //otromodal
    var otroModal
    if (document.getElementById('otroModal')) {
      otroModal = document.getElementById('otroModal').value;
      body.otroModal = otroModal
    }
    body.origin = urlActual
    body.origin = urlActual
    body.nfact_afectada = nfact_afectada
    body.tipoDoc = tipoDoc
    body.simple = true

    $.ajax({
      type: 'POST',
      url: '/productos',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: body,
      success: function(data) {
        document.getElementById("resProd").innerHTML = data;
      },
      beforeSend: function() {
        document.getElementById("btnConsulProd").disabled = true
      },
      complete: function() {
        document.getElementById("btnConsulProd").disabled = false
      },

    });
  }
  //para desactivar el enter envie y cierre el modal
  /**
   * control del seleccionador del producto
   * @param {*} event
   */

  function ctrlSelecProd(inputOrigin) {
    formProdCurrent = $('div.formProdContent').index(inputOrigin.parents('.formProdContent'))
    console.log("ctrlSelecProd formProdCurrent", formProdCurrent)
    $('#busProd').modal('show');
  }

  /**
   * selector de producto
   * para enviar el codigo del producto y nombre a cargarcompra.php
   * strI codigo
   * strII nombre_i
   * strIII valor_unitario
   * strIV stock
   * formProdCurrent
   */
  function selecProd(idinventary, strI, strII, strIII, strIV) {

    //console.log("selecProd formProdCurrent", formProdCurrent)

    var error = 0;
    var item_existen = "";

    //validacion
    if (!$("input[name='fk_inventario']")) {
      alert("Debe agregar productos para continuar")
      return
    }

    if ($("input[name='fk_inventario']")[0]) {
      $("input[name='fk_inventario']")[0].name = "fk_inventario[" + formProdCurrent + "]"
    }
    if ($("input[name='pmpvj']")[0]) {
      $("input[name='pmpvj']")[0].name = "pmpvj[" + formProdCurrent + "]"
    }
    if ($("input[name='codigo']")[0]) {
      $("input[name='codigo']")[0].name = "codigo[" + formProdCurrent + "]"
    }
    if ($("input[name='nom_fk_inventario']")[0]) {
      $("input[name='nom_fk_inventario']")[0].name = "nom_fk_inventario[" + formProdCurrent + "]"
    }
    if ($("input[name='costo']")[0]) {
      $("input[name='costo']")[0].name = "costo[" + formProdCurrent + "]"
    }
    if ($("input[name='stock']")[0]) {
      $("input[name='stock']")[0].name = "stock[" + formProdCurrent + "]"
    }
    if ($("input[name='cantidad']")[0]) {
      $("input[name='cantidad']")[0].name = "cantidad[" + formProdCurrent + "]"
    }
    if ($("select[name='tipoCompra']")[0]) {
      $("select[name='tipoCompra']")[0].name = "tipoCompra[" + formProdCurrent + "]"
    }
    if ($("select[name='tipoVenta']")[0]) {
      $("select[name='tipoVenta']")[0].name = "tipoVenta[" + formProdCurrent + "]"
    }

    //validar repetido
    var n = 0
    n = $(".formProdContent").length

    for (var j = 1; j <= n; j++) {
      //SI ITEM NO EXISTE
      if (
        $("input[name='fk_inventario[" + j + "]']").value == idinventary
      ) {
        item_existen = $("input[name='nom_fk_inventario[" + j + "]']").val();
        alert("Ya exise este item: " + item_existen);
        return
      }
    }

    //vacion antes de seleccionrar los datos que no se leccionan para este producto
    $("input[name='pmpvj[" + formProdCurrent + "]']").val("")
    //ahora si paso el resro de los valores
    $("input[name='fk_inventario[" + formProdCurrent + "]']").val(idinventary);
    $("input[name='codigo[" + formProdCurrent + "]']").val(strI);
    $("input[name='nom_fk_inventario[" + formProdCurrent + "]']").val(strII);
    $("input[name='costo[" + formProdCurrent + "]']").val(Math.round(strIII * 10000000) / 10000000);
    $("input[name='stock[" + formProdCurrent + "]']").val(strIV);

    //SOLO PARA COMPRAS EN NOTAS DE CREDITO DESCUENTOS
    if ($('#tipoDoc').length) {
      if (document.getElementById('tipoDoc').value == 'NC-DESC') {
        $("input[name='cantidad[" + formProdCurrent + "]']").attr("readonly", true);
        $("input[name='cantidad[" + formProdCurrent + "]']").val(strIV);
      } else {
        $("input[name='cantidad[" + formProdCurrent + "]']").val("")
        //document.form1.elements["cantidad"+formProdCurrent].removeAttribute("readonly");
      }
    }

    const factcompraadd = '<?php echo \App\Models\FactCompra::FCOMPRAADD; ?>'
    const factventaadd = '<?php echo \App\Models\FactVenta::FVENTAADD; ?>'

    let urlCurrent = window.location.href
    let origin = urlCurrent.split('/')
    const urlActual = origin[origin.length - 1]

    if (urlActual.includes(factcompraadd) || urlActual.includes(factventaadd)) {
      fcalculo();
    }
  }

  function showModalEditProd(btn) {

    console.log("btn", btn)
    prodToUpdate = $(btn).data('id');
    console.log("prodToUpdate", prodToUpdate)

    var modalEditProd = new bootstrap.Modal(document.getElementById('nueProd'), {
      keyboard: false
    })
    modalEditProd.show()
 
  }
</script>