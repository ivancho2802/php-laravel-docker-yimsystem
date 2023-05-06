@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h6 class="mb-0">{{ __('Aplicar Retencion - Compra') }}</h6>
    </div>
    <div class="card-body pt-4 p-3">
      <form id="formRetenAdd" name="formRetenAdd" method="POST" action="/book-shopping-reten">
        @csrf
        @method('PUT')

        <div class="grid form-group" id="form-group-nueRetenC">

          <div class="row">
            <label class="col" id="res_id_fact_compra">
              <input type="hidden" name="id_fact_compra" id="id_fact_compra" lang="si-general" required>
              Num. Documento:<br>

              <span class="input-group" id="cont_id_fact_compra">
                <input class="form-control list-group-item" id="num_fact_compra" name="num_fact_compra" readonly="readonly" lang="si-general" required="required">

                <button type="button" class="btn btn-primary m-0" title="Buscar Factura" data-bs-toggle="modal" data-bs-target="#busFact">
                  B <i class="glyphicon glyphicon-search"></i>
                </button>
                <button type="button" class="btn btn-info m-0" title="Detalles Factura" id="btn_nfact_afectada" onclick="modalConsulFact(document.getElementById('id_fact_compra').value)">
                  D <i class="glyphicon glyphicon-th-list"></i>
                </button>
              </span>

            </label>
            <label class="col">
              Serie Factura de Compra:<br />
              <input type="text" class="form-control" id="serie_fact_compra" data-bs-toggle="modal" data-bs-target="#busFact" readonly="readonly" lang="si-general" required="required">
            </label>
            <label class="col">
              Proveedor:<br />
              <input type="text" class="form-control" id="proveedor_fact_compra" data-bs-toggle="modal" data-bs-target="#busFact" readonly="readonly" lang="si-general" required="required">
            </label>
          </div>
          <div class="row">
            <label class="col">
              Fecha del Comp. de Retencion:<br>
              <input type="date" class="form-control" name="fecha_compro_reten" id="fecha_compro_reten" lang="si-general">
            </label>
            <label class="col" id="res_num_compro_reten">
              Num. Comp. de Retencion:<br>

              <span class="input-group" id="cont_num_compro_reten">
                <input type="text" class="form-control list-group-item" name="num_compro_reten" id="num_compro_reten" lang="si-num_compro_reten" onBlur="validar_repetidoM('fact_compra', 'num_compro_reten', this.value, 'num_compro_reten')" required>

                <button type="button" id="generateNumReten" onclick="generarNum()" class="btn btn-primary m-0">Generar</button>

              </span>

            </label>

            <label class="col">
              Mes de Aplicacion Retencion:<br>
              <input type="month" class="form-control" name="mes_apli_reten" id="mes_apli_reten" value="" lang="si-general">
            </label>
          </div>
          <div class="row">
            <label class="col ">
              Total I.V.A.:<br />
              <input type="text" class="form-control" id="tot_iva" data-bs-toggle="modal" data-bs-target="#busFact" readonly="readonly" lang="si-general" required="required">
            </label>
            <label class="col " id="res_m_iva_reten">
              I.V.A. Retenido:<br>
              <span class="input-group" id="cont_m_iva_reten">
                <input class="form-control" name="m_iva_reten" id="m_iva_reten" readonly="readonly" lang="si-general" required="required">
                <button type="button" class="btn btn-primary m-0">Calcular Retencion</button>
              </span>

            </label>
          </div>

          <div class="row">
            <button type="submit" class="btn btn-success">Aplicar Retenci&oacute;n</button>
          </div>

        </div>

      </form>
    </div>
  </div>
</div>

<div id="zoneModalExtra"></div>

<script>
  var formGroupNueRetenC = ''
  $(document).ready(function() {

    window.setTimeout(function() {

      $('#cont_m_iva_reten').on("click", function() {
        //alert();
        var tot_iva = document.getElementById('tot_iva').value;
        if (tot_iva == "") { //VALIDO
          alert('Debe Llenar el VALOR TOTAL IVA');
        } else {
          $('#calReten').modal('show');
          $(".modal-body #tot_iva").val(tot_iva);
        }
      });

      formGroupNueRetenC = document.getElementById('form-group-nueRetenC').innerHTML;

    }.bind(this), 100);

    $('#fecha_compro_reten').on('change', function() {
      if ($('#fecha_compro_reten').val() !== "") {
        var ano_mes = $('#fecha_compro_reten').val().substr(0, 7);
        document.getElementById('num_compro_reten').value = ano_mes + "-";
        document.getElementById('mes_apli_reten').value = ano_mes;
      }
    });

  });

  // funcion para generar numeros de algo mas uno
  function generarNum() {

    //validaciones
    //si la fecha no esta especificada solicitarla
    if ($('#fecha_compro_reten').val() == "") {
      $('#fecha_compro_reten').focus()
      alert("lo sentimos para generar este numero debe especificar la fecha")
      return
    }

    var ano_mes = $('#fecha_compro_reten').val().substr(0, 7);
    document.getElementById('num_compro_reten').value = ano_mes + "-";
    document.getElementById('mes_apli_reten').value = ano_mes;

    $.ajax({
      type: 'GET',
      url: '/book-shopping-reten-gen',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        const num_compro_reten = document.getElementById('num_compro_reten').value
        var num_compro_reten_ajust = num_compro_reten.substr(0, 8);
        sigNumero = JSON.stringify(data.siguienteNumero)
        pad = "00000000";
        ans = pad.substring(0, pad.length - sigNumero.length) + sigNumero;
        document.getElementById('num_compro_reten').value = num_compro_reten_ajust + ans;
      },
      beforeSend: function() {
        $('#generateNumReten').prop('disabled', true)
      },
      complete: function() {
        $('#generateNumReten').prop('disabled', false)
      },

    });

  }

  /** ver los detalle de una factura de compra */
  function modalConsulFact(factCompra) {

    $.ajax({
      type: 'GET',
      url: '/book-shopping-detail/' + factCompra,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        document.getElementById("zoneModalExtra").innerHTML = data;
        $('#mostrarFact').modal('show');

      },
      beforeSend: function() {
        $('#btn_nfact_afectada').prop('disabled', true)
      },
      complete: function() {
        $('#btn_nfact_afectada').prop('disabled', false)
      },

    });

  }

  /**
   * selector de facturas al agregar una factura de compras
   * @param {*} strI id_fact_compra
   * @param {*} strII num_fact_compra
   * @param {*} strIII serie_fact_compra
   * @param {*} strIV proveedor_fact_compra
   * @param {*} strV tot_iva
   * @param {*} strVI m_iva_reten
   * @param {*} strVII mes_apli_reten
   * @param {*} strVIII num_compro_reten
   * @param {*} strIX fecha_compro_reten
   */
  //para enviar el numero ID de fla factura a cargarcompra.php
  function selecFactCM(strI, strII, strIII, strIV, strV, strVI, strVII, strVIII, strIX) {
    if (strVIII !== "") {
      alert('Esta factura YA POSEE RETENCION Si continua se MODIFICARAN LOS DATOS' + strII);
    }
    document.getElementById("id_fact_compra").value = strI;
    document.getElementById("num_fact_compra").value = strII;
    document.getElementById("serie_fact_compra").value = strIII;
    document.getElementById("proveedor_fact_compra").value = strIV;
    document.getElementById("tot_iva").value = strV;
    if (strVI == "0.000")
      strVI = "";
    document.getElementById("m_iva_reten").value = strVI;
    document.getElementById("mes_apli_reten").value = strVII;
    document.getElementById("num_compro_reten").value = strVIII;
    if (strIX == "0000-00-00")
      strIX = "";
    document.getElementById("fecha_compro_reten").value = strIX;
  }

  //revisar eliminar 

  function modRReten(formulario) {
    //funcion de validacion
    document.getElementById("txtHintAPROV").innerHTML = "";
    var valido = validarFormulario(formulario);

    if (valido == 1) {
      //paramentros y funciones de registro AJAX	
      var xhttp;
      //variables contenidas en el formulariuo
      var id_fact_compra = $("input#id_fact_compra").val();
      var num_compro_reten = $("input#num_compro_reten").val();
      var fecha_compro_reten = $("input#fecha_compro_reten").val();
      var m_iva_reten = $("input#m_iva_reten").val();
      var mes_apli_reten = $("input#mes_apli_reten").val();

      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {

          document.getElementById('txtHintAPROV').innerHTML = xhttp.responseText;
          document.getElementById("id_fact_compra").value = "";
        }
      };
      //	MODIFICAR RETENCION
      url = '<?php echo $_SERVER['REQUEST_URI']; ?>';
      patronA = 'cargarRetenCompra'; //patronB = 'compra|venta'

      if (url.search(patronA) > 0) {
        xhttp.open("POST", "modales/retenC/m_retenC.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhttp.send("id_fact_compra=" + id_fact_compra +
          "&num_compro_reten=" + num_compro_reten +
          "&fecha_compro_reten=" + fecha_compro_reten +
          "&m_iva_reten=" + m_iva_reten +
          "&mes_apli_reten=" + mes_apli_reten
        );
        document.getElementById('form-group-nueRetenC').innerHTML = formGroupNueRetenC;
      }

    }

  }
</script>

<!-- modales -->
@include('modales.fact_c.m_b_fact_c')
@include('modales.reten_c.m_cal_reten')

@endsection