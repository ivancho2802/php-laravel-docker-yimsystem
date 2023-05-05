<div class="row alert formProdContent">

  <div class="col-2">
    <label class="list-group" role="group" aria-label="Vertical button group">
      <input name="fk_inventario" type="hidden" value="{{$fkInventario}}" />
      <input name="codigo" class="form-control list-group-item" onclick="ctrlSelecProd($(this))" type="text" required="required" value="{{$codigo}}" />
      <button type="button" class="list-group-item active" onclick="ctrlSelecProd($(this))">
        Seleccionar Producto
      </button>
    </label>
  </div>
  <div class="col-2">
    <label class="list-group" role="group" aria-label="Vertical button group">
      <input name="nom_fk_inventario" class="form-control list-group-item" onclick="ctrlSelecProd($(this))" value="{{$nomFkInventario}}" type="text" required="required">
      <button type="button" class="list-group-item active" onclick="ctrlSelecProd($(this))">
        Seleccionar Producto
      </button>
    </label>
  </div>
  <div class="col-2">
    <input class="form-control" name="costo" required="" type="number" min="0" step="0.0000001" value="{{$costo}}" onblur="fcalculo()" placeholder="0.00" />
    <br>

    <label class="list-group" role="group" aria-label="Vertical button group">
      <input class="form-control list-group-item" name="pmpvj" type="number" min="0" step="0.0000001" value="{{$pmpvj}}" placeholder="0.00" required="required" readonly="readonly" />
      <button class="list-group-item active" type="button" onclick="ctrlSelecPMPVJ($(this))">P. Venta</button>
    </label>

  </div>
  <div class="col-2">
    <span class="input-group">
      <input class="form-control" name="cantidad" required="" type="number" min="1" onblur="fcalculo()" value="{{$cantidad}}" />
      <span class="input-group-addon">
        /
      </span>
      <input class="form-control" name="stock" type="text" value="{{$stock}}" readonly="readonly">
    </span>
  </div>
  <div class="col-2">

    @if($type == 'venta')
    <select name="tipoVenta" class="selectpicker form-select" value="{{$tipoCompra}}" data-style="btn-primary" onchange="fcalculo(1)" required>
      <option value="">Seleccione</option>
      @foreach (\App\Models\FactVenta::TYPEVENTA as $key => $group)
      <optgroup label="{{$key}}">
        @foreach ($group as $key2 => $value)
        <option value="{{$key2}}" {{ ($tipoCompra)==$key2 ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
      </optgroup>
      @endforeach
    </select>
    @else
    <select name="tipoCompra" class="selectpicker form-select" value="{{$tipoCompra}}" data-style="btn-primary" onchange="fcalculo(1)" required>
      <option value="">Seleccione</option>
      @foreach (\App\Models\FactCompra::TYPECOMPRA as $key => $group)
      <optgroup label="{{$key}}">
        @foreach ($group as $key2 => $value)
        <option value="{{$key2}}" {{ ($tipoCompra)==$key2 ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
      </optgroup>
      @endforeach
    </select>
    @endif
  </div>
  <div class="col-2">
    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="alert" aria.label="close" onclick="elimInput()">
      <span class="fa fa-minus"></span>
    </button>
  </div>
</div>