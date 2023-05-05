@extends('layouts.user_type.auth')

@section('content')

<div>
  <div class="alert alert-secondary mx-4" role="alert">
    <span class="text-white">
      <strong>Agrega, Edita, Elimina caracteristicas</strong>
    </span>
  </div>


  @if(session('success'))
  <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
    <span class="alert-text text-white">
      {{ session('success') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      <i class="fa fa-close" aria-hidden="true"></i>
    </button>
  </div>
  @endif

  @if(session('destroy'))
  <div class="m-3  alert alert-danger alert-dismissible fade show" id="alert-danger" role="alert">
    <span class="alert-text text-white">
      {{ session('destroy') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      <i class="fa fa-close" aria-hidden="true"></i>
    </button>
  </div>
  @endif


  @if(session('update'))
  <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
    <span class="alert-text text-white">
      {{ session('update') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      <i class="fa fa-close" aria-hidden="true"></i>
    </button>
  </div>
  @endif
  
  @if(session('warning'))
  <div class="m-3  alert alert-warning alert-dismissible fade show" id="alert-warning" role="alert">
    <span class="alert-text text-white">
      {{ session('warning') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      <i class="fa fa-close" aria-hidden="true"></i>
    </button>
  </div>
  @endif

  <div class="row">
    <div class="col-12">
      <div class="card mb-4 mx-4">
        <div class="card-header pb-0">
          <div class="d-flex flex-row justify-content-between">
            <div>
              <h5 class="mb-0">Todas las Compras [{{ $date_from }} - {{ $date_to }}] </h5>
            </div>
            <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; Agregar Compra</a>
          </div>

          <div class="d-flex flex-row justify-content-between">
            <div class="row">
              <div class="col">

                <div>{{ $empre->titular_rif_empre }} - {{ $empre->nom_empre }}</div>
                <div>{{ $empre->rif_empre }}</div>
                <div>Direcci&oacute;n: &nbsp;{{ $empre->dir_empre }}</div>
                <div>Contribuyente {{ $empre->contri_empre }}</div>
                <?php //funcion para convertir la fechaa mes en letras y ano
                ?>
                <div>
                  LIBRO DE COMPRAS CORRESPONDIENTE AL MES DE {{ date('F', strtotime($date_from)) }}
                </div>

              </div>
            </div>
          </div>

        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table table-bordered align-items-center mb-0">

              <thead>
                <tr>
                  <td colspan="18"></td>
                  <th colspan="6">IMPORTACIONES</th>
                  <th colspan="9">INTERNAS</th>
                  <td colspan="2"><b></b></td>
                  <!--<th colspan="3" rowspan="2"><b>ACCIONES</b></th>-->
                </tr>
                <tr class="titulo">
                  <!--ACCIONES-->
                  <th>
                    <div class="verticalText">Acciones</div>
                  </th>

                  <th class="content-verticalText">
                    <div class="verticalText">Nro. Op</div>
                  </th>
                  <td><b>Fecha del Documento</b></td>

                  <td><b>N° R.I.F. &oacute; de Identidad</b></td>
                  <td><b>Nombre &oacute; Raz&oacute;n Social</b></td>
                  <th class="content-verticalText">
                    <div class="verticalText">Tipo de Proveedor</div>
                  </th>

                  <th>
                    <div class="verticalText">
                      <p>Nro. de Comprobante <br>de Retenci&oacute;n</p>
                    </div>
                  </th>
                  <td><b>Fecha de Aplicaci&oacute;n de Retenci&oacute;n</b></td>

                  <th>
                    <div class="verticalText">Nro. de Planilla<br> de Importaci&oacute;n</div>
                  </th>
                  <th>
                    <div class="verticalText">Nro. del Expediente<br> de Importaci&oacute;n</div>
                  </th>
                  <th>
                    <div class="verticalText">Nro. de Declaraci&oacute;n<br> de Aduana</div>
                  </th>
                  <td><b>Fecha de Declaraci&oacute;n de Aduana</b></td>

                  <th>
                    <div class="verticalText">Serie del Documento</div>
                  </th>
                  <td><b>Nro. del Documento</b></td>
                  <td><b>Nro. de Control</b></td>
                  <td><b>Nro. de Nota de Debito</b></td>
                  <td><b>Nro. de Nota de Credito</b></td>
                  <th>
                    <div class="verticalText">Tipo de Transacci&oacute;n</div>
                  </th><!--tipo Compra-->

                  <td><b>Nro. de Documento <br>afectado</b></td>
                  <!--IMPORTACIONES-->
                  <th>
                    <div class="verticalText">Total de Importaciones <br> incluyendo el IVA</div>
                  </th>
                  <th>
                    <div class="verticalText">Importaciones<br> Exentas /Exoneradas</div>
                  </th>
                  <th>
                    <div class="verticalText">Total Base Imponible</div>
                  </th>
                  <th>
                    <div class="verticalText">Subtotal B.I. al 12%</div>
                  </th>
                  <th>
                    <div class="verticalText">Subtotal B.I. al 8%</div>
                  </th>
                  <th>
                    <div class="verticalText">Subtotal B.I. al 27%</div>
                  </th>
                  <!--INTERNAS-->
                  <th>
                    <div class="verticalText">Total de Compra <br> internas incluyendo IVA</div>
                  </th>
                  <th>
                    <div class="verticalText">Compras sin derecho <br>a credito IVA</div>
                  </th>
                  <th>
                    <div class="verticalText">Compras Exentas</div>
                  </th>
                  <th>
                    <div class="verticalText">Compras Exoneradas</div>
                  </th>
                  <th>
                    <div class="verticalText">Compras no Sujetas</div>
                  </th>
                  <th>
                    <div class="verticalText">Base Imponible</div>
                  </th>
                  <th>
                    <div class="verticalText">Subtotal B.I. al 12%</div>
                  </th>
                  <th>
                    <div class="verticalText">Subtotal B.I. al 8%</div>
                  </th>
                  <th>
                    <div class="verticalText">Subtotal B.I. al 27%</div>
                  </th>
                  <th>
                    <div class="verticalText">Impuesto IVA</div>
                  </th>
                  <th>
                    <div class="verticalText">I.V.A. Retenido</div>
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($fact_compras as $fact_compra)
                <tr>
                  <td class="text-center">

                    <!--  action="{{route('book-shopping.edit', $fact_compra->id )}}" method="POST" -->
                    <form id="formUpdate">
                      @csrf @method('GET')

                      <button class="btn btn-warning" type="submit" disabled>
                        <i class="fas fa-edit" description="Editar compra"></i>
                      </button>
                    </form>

                    <!-- Eliminar Factura de Compras -->
                    <!--  data-bs-target="#confirmDeleteModal" data-bs-id="{{$fact_compra->id}}" -->
                    <button class="btn btn-danger" data-bs-toggle="modal" disabled>
                      <i class="cursor-pointer fas fa-trash"></i>
                    </button>

                  </td>
                  <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">{{ $fact_compra->id }}</p>
                  </td>
                  <td class="text-center">

                    <p class="text-xs font-weight-bold mb-0">
                      {{ date('j F, Y', strtotime($fact_compra->fecha_fact_compra)) }}
                    </p>
                  </td>
                  <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">{{ $fact_compra->rif }}</p>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ $fact_compra->nombre }}</span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @if(
                      preg_replace('/[0-9]+/', '', $fact_compra->rif) == 'J' ||
                      preg_replace('/[0-9]+/', '', $fact_compra->rif) == 'G'
                      )
                      {{ 'PJ' }}
                      @else
                      {{ 'PN' }}
                      @endif
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->num_compro_reten }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->fecha_compro_reten }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->nplanilla_import }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->nexpe_import }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->naduana_import }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->fechaduana_import }}
                    </span>
                  </td>
                  <!--FACTURA-->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->serie_fact_compra }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->num_fact_compra }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->num_ctrl_factcompra }}
                    </span>
                  </td>
                  <!--FACTURA NOTA-->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @foreach ($fact_compra->notacd as $notacd)
                      @if($notacd->tipo_notas_cd == 'NC')
                      $notacd->num_notas_cd
                      @endif
                      @endforeach
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @foreach ($fact_compra->notacd as $notacd)
                      @if($notacd->tipo_notas_cd == 'ND')
                      $notacd->num_notas_cd
                      @endif
                      @endforeach
                    </span>
                  </td>

                  <!--FACTURA RETENCION QUE Y A QUIEN-->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->tipo_trans }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->nfact_afectada }}
                    </span>
                  </td>
                  <!--FACTURA TOTALES IMPORTACIONES-->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @if (isset($fact_compra->nplanilla_import))
                      {{ number_format((float)$fact_compra->mtot_iva_compra, 2)}}
                      @else
                      0
                      @endif
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @if (isset($fact_compra->nplanilla_import))
                      {{ number_format((float)$fact_compra->msubt_exento_compra, 2)}}
                      @else
                      0
                      @endif
                    </span>
                  </td>

                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @if (isset($fact_compra->nplanilla_import))
                      {{ number_format((float)$fact_compra->msubt_tot_bi_compra, 2)}}
                      @else
                      0
                      @endif
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @if (isset($fact_compra->nplanilla_import))
                      {{ number_format((float)$fact_compra->msubt_bi_iva_12, 2)}}
                      @else
                      0
                      @endif
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @if (isset($fact_compra->nplanilla_import))
                      {{ number_format((float)$fact_compra->msubt_bi_iva_8, 2)}}
                      @else
                      0
                      @endif
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @if (isset($fact_compra->nplanilla_import))
                      {{ number_format((float)$fact_compra->msubt_bi_iva_27, 2)}}
                      @else
                      0
                      @endif
                    </span>
                  </td>

                  <!--FACTURA TOTALES INTERNAS-->

                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @if (isset($fact_compra->nplanilla_import))
                      0
                      @else
                      {{ number_format((float)$fact_compra->mtot_iva_compra, 2)}}
                      @endif
                    </span>
                  </td>

                  <!-- las excentas ya estan hechas por una funcion ya que estas son desglozadas -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ optional($fact_compra->importations_without_iva)->SDCF }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->importations_without_iva['EX'] }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->importations_without_iva['EXO'] }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ $fact_compra->importations_without_iva['NS'] }}
                    </span>
                  </td>

                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @if (isset($fact_compra->nplanilla_import))
                      0
                      @else
                      {{ number_format((float)$fact_compra->msubt_tot_bi_compra, 2)}}
                      @endif
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @if (isset($fact_compra->nplanilla_import))
                      0
                      @else
                      {{ number_format((float)$fact_compra->msubt_bi_iva_12, 2)}}
                      @endif
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @if (isset($fact_compra->nplanilla_import))
                      0
                      @else
                      {{ number_format((float)$fact_compra->msubt_bi_iva_8, 2)}}
                      @endif
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      @if (isset($fact_compra->nplanilla_import))
                      0
                      @else
                      {{ number_format((float)$fact_compra->msubt_bi_iva_27, 2)}}
                      @endif
                    </span>
                  </td>

                  <!--monto total de impuesto IVA-->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compra->tot_iva, 2)}}
                    </span>
                  </td>
                  <!--FACTURA TOTALES DE RETENCIONES-->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compra->m_iva_reten, 2)}}
                    </span>
                  </td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="18">Totales</td>
                  <!-- IMPORTACIONES -->
                  <!-- TOTAL DE IMPORTACIONEES INCLUYENDO EL IVA-->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_mtot_iva_compra_import'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL DE IMPORTACIONES EXENTAS O EXONERADAS	 -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_msubt_exento_compra_import'], 2)}}
                    </span>
                  </td>
                  <!--TOTALES DE LAS BASES IMPONIBLES -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_msubt_tot_bi_compra_import'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL BI 12 IMPORT -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_msubt_bi_iva_12_import'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL BI 8 IMPORT -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_msubt_bi_iva_8_import'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL BI 27 IMPORT -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_msubt_bi_iva_27_import'], 2)}}
                    </span>
                  </td>
                  <!-- INTERNAS -->
                  <!--total compras incluyendo el iva -->

                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_mtot_iva_compra_inter'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL DE IMPORTACIONES EXENTAS O EXONERADAS	 -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_IN_SDCF_compra_inter'], 2)}}
                    </span>
                  </td>
                  <!--TOTALES DE LAS BASES IMPONIBLES -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_IN_EX_compra_inter'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL BI 12 IMPORT -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_IN_EXO_compra_inter'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL BI 8 IMPORT -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_IN_NS_compra_inter'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL BI 27 IMPORT -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_msubt_tot_bi_compra_inter'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL BI 27 IMPORT -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_msubt_bi_iva_12_inter'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL BI 27 IMPORT -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_msubt_bi_iva_8_inter'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL BI 27 IMPORT -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_msubt_bi_iva_27_inter'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL BI 27 IMPORT -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_tot_iva'], 2)}}
                    </span>
                  </td>
                  <!--TOTAL BI 27 IMPORT -->
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                      {{ number_format((float)$fact_compras_acum['acum_m_iva_reten'], 2)}}
                    </span>
                  </td>
                </tr>

              </tbody>
            </table>
            {{$fact_compras->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL FOR CONFIRMATION DELETE -->

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminar Factura de Compras </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Confirmas que deseas eliminar la factura de compra?.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        <form id="formDelete" action="{{route('book-shopping.destroy', 1)}}" method="POST">
          @csrf @method('DELETE')
          <button class="btn btn-danger" type="submit">
            <i class="cursor-pointer fas fa-trash text-text-white"></i> Confirmar y Eliminar
          </button>

        </form>

      </div>
    </div>
  </div>
</div>

<script>
  const exampleModal = document.getElementById('confirmDeleteModal')
  if (exampleModal) {
    exampleModal.addEventListener('show.bs.modal', event => {
      // Button that triggered the modal
      const button = event.relatedTarget
      // Extract info from data-bs-* attributes
      const recipient = button.getAttribute('data-bs-id')
      // If necessary, you could initiate an Ajax request here
      // and then do the updating in a callback.

      let acionOld = document.getElementById("formDelete").action

      let action = acionOld.slice(0, acionOld.lastIndexOf('/') + 1)
      action += recipient

      document.getElementById("formDelete").action = action

      // Update the modal's content.
      const modalTitle = exampleModal.querySelector('.modal-title')
      const modalBodyInput = exampleModal.querySelector('.modal-body input')

      modalTitle.textContent = `Se eliminara la Factura de Compras con id ${recipient}`
      //modalBodyInput.value = recipient
    })
  }
</script>
<!-- FIN MODAL FOR CONFIRMATION DELETE -->

@endsection