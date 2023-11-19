<script src="../assets/js/plugins/ajax-excel/xlsx.full.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Modal addCuenta-->
<div id="addCuenta" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-xl">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleCuentaLabel">Agregar Cuenta</h5>
        <button type="button" class="btn-close bg-primary" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Registro Normal</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Registro Masivo</button>
          </li>
        </ul>

        <div class="grid">
          <div class="row">
            <!--para mostrar resultado de acciones de insercion y demas-->
            <label class="col-md-12 col-lg-12" id="txtEdomodaddCuenta" data-bs-dismiss="modal"></label>
          </div>
        </div>

        <div class="tab-content" id="myTabContent">

          <!-- regitro normal -->
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <form name="formaddCuenta" id="formaddCuenta">
              @csrf
              <!--QUE AL PRECIONAR EFNTER ENVIE EL FORTMULARIUO-->

              <div class="form-group">
                <div class="grid">
                  <div class="row">
                    <div for="campo" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                      Codigo del Plancuenta:
                      <input type="number" min="0" name="id_plancuenta" id="id_plancuenta" value="" size="32" class="form-control" lang="si-general" required>
                    </div>

                    <div for="campo" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                      Nombre del Plan de Cuenta:
                      <input type="text" name="nom_plancuenta" id="nom_plancuenta" value="" size="32" class="form-control" lang="si-general" required>
                    </div>
                    <div for="tabla" class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                      TSC:
                      <select name="tsc" id="tsc" class="form-select" lang="si-general" required>
                        <option value="">Seleccione</option>
                        <option value="S">SI</option>
                        <option value="N">NO</option>
                      </select>
                    </div>
                    <div for="tabla" class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                      Naturaleza:
                      <select name="natu" id="natu" class="form-select" lang="si-general" required>
                        <option value="">Seleccione</option>
                        <option value="Debe">DEBE +</option>
                        <option value="Haber">HABER -</option>
                      </select>
                    </div>
                    <div for="tabla" class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                      Axuliar:
                      <select name="aux" id="aux" class="form-select" lang="si-general" required>
                        <option value="">Seleccione</option>
                        <option value="S">SI</option>
                        <option value="N">NO</option>
                      </select>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-auto">
                      <br>
                    </div>
                    <div class="col">
                      <button id="btnaddCuenta" type="button" class="btn btn-primary" onclick="agreCuenta(this.form);">Agregar</button>
                    </div>
                  </div>

                  <hr>
                </div><!--form-group-->
              </div><!--modal-bosy-->
            </form>
          </div>
          <!-- registro masivo -->
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-body">

                    <div class="row">
                      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label for="formFile" class="form-label">Descargar Excel Para registro masivo con Excel </label>
                        <br>
                        <a class="btn btn-success" target="_blank" href="{{__('yimsystem.fileexamplecuentas')}}">
                          <i class="fa fa-excel"></i>
                          Descargar Formato de carga con Excel
                        </a>
                      </div>

                      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label for="formFile" class="form-label">Cargar Excel</label>
                        <br>
                        <input class="form-control" type="file" id="fileexamplecuentas">
                      </div>

                      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                      </div>


                    </div>

                    <div class="row mt-3">
                      <div class="col-10">
                        <br>
                        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 30%;display: none">
                          <div id="loadingManyInsert" class="progress-bar" style="width: 25%;height: 100%">25%</div>
                        </div>
                      </div>
                      <div class="col">
                        <button class="btn btn-primary" id="btnPreview" type="button">
                          <i class="fa fa-excel"></i>
                          Procesar Vista Previa
                        </button>
                      </div>
                    </div>

                    <div class="row" id="zoneCuentasUploaded">

                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </div>

      </div>


      <div class="modal-footer">

        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>

<script>
  $('#addCuenta').on('hidden.bs.modal', function(e) {
    $("#txtEdomodaddCuenta").innerText = ""
    document.onkeypress = !stopRKey;
    consulCuentas();
    cuentaToUpdate = null
  });

  $(window.document).on('shown.bs.modal', '#addCuenta', function() {
    $('#id_plancuenta', this).focus();

    setFormAddCuentaData(cuentaToUpdate);

  });

  function setFormAddCuentaData() {

    document.getElementById("modalTitleCuentaLabel").innerHTML = 'Agregar Cuenta'
    document.getElementById("btnaddCuenta").innerText = 'Agregar Cuenta';

    document.getElementById("btnaddCuenta").removeAttribute("onclick");
    document.getElementById("btnaddCuenta").setAttribute("onclick", "agreCuenta(this.form);")

    if (cuentaToUpdate?.id) {

      $("#profile-tab").prop('disabled', true);

      document.getElementById("btnaddCuenta").innerText = 'Modificar del Cuenta'
      document.getElementById("btnaddCuenta").setAttribute("onclick", "editCuenta(this.form);")
      document.getElementById("modalTitleCuentaLabel").innerHTML = 'Modificar del Cuenta'

      document.formaddCuenta.id_plancuenta.value = cuentaToUpdate.id_plancuenta
      document.formaddCuenta.nom_plancuenta.value = cuentaToUpdate.nom_plancuenta
      document.formaddCuenta.tsc.value = cuentaToUpdate.tsc
      document.formaddCuenta.natu.value = cuentaToUpdate.natu
      document.formaddCuenta.aux.value = cuentaToUpdate.aux

    } else {
      $("#profile-tab").prop('disabled', false);
      document.getElementById("formaddCuenta").reset();
    }

  }

  function consulCuentas() {
    //redireccionar a cuentas /cuentas-list
    if(document.getElementById('txtEdomodaddCuenta').innerText.includes('exito')){
      let origin = window.location.origin
      window.location.replace(origin + '/cuentas-list');
    }
    
  }

  //estas lineas estan en la funcion mmCuentas
  function editCuenta(formulario) {
    //funcion de validacion
    //alert(formulario);
    var valido = validarFormulario(formulario);

    if (valido == 1) {

      const data = new FormData(document.formaddCuenta);
      const values = Object.fromEntries(data.entries());
      let body = values;

      body.id_plancuenta = cuentaToUpdate.id_plancuenta
      body.id = cuentaToUpdate.id

      $.ajax({
        type: 'POST',
        url: '/cuentas-edit/' + values.id_plancuenta,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: body,
        success: function(data) {

          if (data.data) {
            let html = `
        <div class="alert alert-success">
          Cuenta actualizada con exito
        </div>
        `;
            $("#txtEdomodaddCuenta").append(html)

          }

        },
        beforeSend: function(data) {
          $('#btnaddCuenta').prop('disabled', true)
        },
        complete: function() {
          $('#btnaddCuenta').prop('disabled', false)
        },
        error: function(data) {

          let html = `
      <div class="alert alert-danger">
        Lo sentimos No fue posible realizar la operacion Cuentas
        ${data.responseJSON.message}
      </div>
      `;
          $("#txtEdomodaddCuenta").append(html)
          $('#btnaddCuenta').prop('disabled', false)
        },

      });

    }

  }



  function agreCuenta(formulario) {
    console.log("formulario", formulario.length)
    //funcion de validacion
    var valido = validarFormulario(formulario);

    if (valido == 1) {

      const data = new FormData(document.formaddCuenta);
      const values = Object.fromEntries(data.entries());
      let body = values;

      $.ajax({
        type: 'POST',
        url: '/cuentas-add',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: body,
        success: function(data) {

          let html = `
            <div class="alert alert-success">
              Operacion hecha con exito
            </div>
            `;
          $("#txtEdomodaddCuenta").append(html)

        },
        beforeSend: function(data) {
          $('#btnaddCuenta').prop('disabled', true)
        },
        complete: function() {
          $('#btnaddCuenta').prop('disabled', false)
        },
        error: function(data) {

          let html = `
          <div class="alert alert-danger">
            Lo sentimos No fue posible realizar la operacion Cliente
            ${data.responseJSON.message}
          </div>
          `;
          $("#txtEdomodaddCuenta").append(html)
          $('#btnaddCuenta').prop('disabled', false)
        },

      });
    }
  }

  function previewCuentas(jsonCuentas) {
    let html = convertJsonToTable(jsonCuentas);
    document.getElementById("zoneCuentasUploaded").innerHTML = html;
  }

  function saveCuentas(jsonCuentasSplit) {


    if (cuentasInProceced === jsonCuentasSplit.length) {
      document.getElementById("btnPreview").innerText = "Datos Enviados";
      $('#btnPreview').prop('disabled', false)

      /* let percent = cuentasInProceced / cuentasToProceced.length;
      console.log("percent", cuentasToProceced.length)
      console.log("percent", cuentasInProceced)
      console.log("percent", percent)
      setPercentLoading("loadingManyInsert", percent * 100 + "%"); */
      //$('#addCuenta').modal('hide');
      return
    }

    document.getElementById("btnPreview").innerText = preview ? "Enviar Datos" : 'Procesar Vista Previa';
    $('#btnPreview').prop('disabled', true)

    let jsonCuentaSplit = jsonCuentasSplit[cuentasInProceced];


    /* msg = "Ajustamos los datos y se dividieron en " + jsonCuentasSplit.length 
    + " Partes quieres continuar con el proceso"; */

    let body = {
      cuentas: jsonCuentaSplit
    };

    setData(body);
    cuentasInProceced++;

  }

  function setData(body) {
    loading(true);

    $.ajax({
      type: 'POST',
      url: '/cuentas-list',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: body,
      success: function(data) {
        let percent = cuentasInProceced / cuentasToProceced.length;
        console.log("percent", percent)
        setPercentLoading("loadingManyInsert", percent * 100 + "%");

        document.getElementById("btnPreview").innerText = "Continuar Enviando";

        msg = "Quieres continuar enviando mas datos " + cuentasInProceced + "/" + cuentasToProceced.length;

        if (confirm(msg) == true) {
          saveCuentas(cuentasToProceced);
        }

      },
      complete: function() {
        loading(false);
        $('#btnPreview').prop('disabled', false)
      },
      error: function(data) {
        let percent = cuentasInProceced / cuentasToProceced.length;
        console.log("percent", percent)
        setPercentLoading("loadingManyInsert", percent * 100 + "%");
        let html = `
              <div class="alert alert-danger">
                Lo sentimos No fue posible realizar la operacion Cliente
                ${data.responseJSON.message}
              </div>
          `;
        $("#txtEdomodaddCuenta").append(html)
        msg = "Quieres continuar enviando mas datos " + cuentasInProceced + "/" + cuentasToProceced.length;

        if (confirm(msg) == true) {
          saveCuentas(cuentasToProceced);
        }
      },
    });

  }

  function setPercentLoading(idprogress, mount) {
    $('#' + idprogress).css("width", mount)
    $('#' + idprogress).text(mount)
  }

  /* function formatToServer(){
    jsonCuentasOriginal.map(el=>{


      return el;
    })
  } */

  $(window.document).on('shown.bs.modal', '#addCuenta', function() {
    window.setTimeout(function() {
      $('#id_plancuenta', this).focus();

      document.onkeypress = function() {
        var tecla;
        tecla = (document.all) ? event.keyCode : event.which;
        if (tecla == 13) {
          agreCuenta(formaddCuenta.formModal);
        }
      }

    }.bind(this), 100);

    let fileSelected, preview = false,
      cuentasToProceced = [],
      cuentasInProceced = 0;

    document.getElementById("fileexamplecuentas").addEventListener("change", (event) => {
      fileSelected = event.target.files[0];
    });

    document.getElementById("btnPreview").addEventListener("click", async () => {

      console.log("fileSelected", fileSelected)

      if (fileSelected) {
        let jsonCuentas = await convertExcelToJson(fileSelected);
        //let jsonCuentas = await formatToServer(jsonCuentasOriginal);
        preview = !preview;

        console.log("json", jsonCuentas);
        if (preview) {

          document.getElementById("btnPreview").innerText = preview ? "Enviar Datos" : 'Procesar Vista Previa';
          previewCuentas(jsonCuentas);
          return true

        } else {

          let jsonCuentasSplit = split(jsonCuentas, 200);
          cuentasToProceced = jsonCuentasSplit;

          document.getElementById("btnPreview").innerText = preview ? "Enviar Datos" : 'Procesar Vista Previa';

          $("#loadingManyInsert").parent().show()
          setPercentLoading("loadingManyInsert", "0%");

          saveCuentas(cuentasToProceced);
          return true

        }
      } else {
        return true
      }
    });

  });
</script>