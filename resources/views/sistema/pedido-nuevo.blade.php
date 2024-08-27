@extends("plantilla")
@section('titulo', "$titulo")
@section('scripts')
<script>
	globalId = '<?php

use App\Entidades\Producto;

 echo isset($pedido->idpedido) && $pedido->idpedido > 0 ? $pedido->idpedido : 0; ?>';
	<?php $globalId = isset($pedido->idpedido) ? $pedido->idpedido : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
	<li class="breadcrumb-item"><a href="/admin/pedido">Pedido</a></li>
	<li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
	<li class="btn-item"><a title="Nuevo" href="/admin/sistema/pedido/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
	<li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
	</li>
	@if($globalId > 0)
	<li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
	@endif
	<li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
	function fsalir() {
		location.href = "/admin/pedido";
	}
</script>
@endsection

@section('contenido')

<?php
if (isset($msg)) {
	echo '<div id =  "msg"></div>  ';
	echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div id="msg"></div>
<form id="form1" method="POST">
	<div class="row">
		<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
		<input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
		<div class="form-group col-lg-6">
			<label for="txtFecha">Fecha: *</label>
			<input type="date" id="txtFecha" name="txtFecha" class="form-control" value="{{ $pedido->fecha }}" required>
		</div>


		<div class="form-group col-lg-6">
			<label for="txtCliente">Cliente</label>
			<select name="txtCliente" id="txtCliente" class="form-control">
				<option value="{{ $aClientes[0]->nombre }}" disabled selected>Seleccionar</option>
				@foreach($aClientes as $cliente)
				<option value="{{ $cliente->idcliente }}">{{ $cliente->nombre }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group col-lg-6">
			<label for="txtSucursal">Sucursal *</label>
			<select name="txtSucursal" id="txtSucursal" class="form-control">
				<option value="{{ $aCategorias[0]->nombre }}" disabled selected>Seleccionar</option>
				@foreach($aCategorias as $categoria)

				<option value="{{ $categoria->idsucursal }}">{{ $categoria->nombre }}</option>

				@endforeach
			</select>
		</div>



		<div class="form-group col-lg-6">
			<label for="txtEstadoPedido">Estado Pedido: *</label>
			<select id="txtEstadoPedido" name="txtEstadoPedido" class="form-control">
				@foreach($aEstadoPedidos as $estadoPedido)
				@if($estadoPedido->idestadopedido == $pedido->fk_idestadoPedido)
				<option selected value="{{ $estadoPedido->idestadopedido }}">{{ $estadoPedido->idestadopedido }}</option>
				@else
				<option value="{{ $estadoPedido->idestadopedido }}">{{ $estadoPedido->nombre }}</option>
				@endif
				@endforeach
			</select>
		</div>


		<div class="form-group col-lg-6">
			<label for="txtPrecio">Precio: *</label>
			<input type="text" text="txtPrecio" name="txtPrecio" class="form-control" value="{{ $pedido->precio }}" required>
		</div>


		<div class="form-group col-lg-6">
			<label for="txtPego">Estado Pedido: *</label>
			<select id="txtPago" name="txtPago" class="form-control " require>
				<option value="" disabled selected>Seleccionar</option>

				<option <?php echo $pedido->pago == "Mercadopago" ? "selected" : "";  ?> value="MercadoPago">Mercado pago</option>

				<option <?php echo $pedido->pago == "Efectivo" ? "selected" : "";  ?> value="Efectivo">Efectivo</option>

			</select>
		</div>

	</div>
		@if($pedido->idpedido > 0)
		<div class="row">
			<div class="col-12">
				<label>Listado de productos</label>
			</div>
				<div class="col-12">
				<table class="table table-hover border">
				<tr>
					<th>Imagen</th>
					<th>Producto</th>
					<th>Cantidad</th>
				</tr>
			@foreach ($aPedidoProductos as $producto);
				<tr>
					<td><img src="/files/<?php  echo  $producto->imagen;   ?>" 	stye="width:50px"></td>
					<td>{{$pedido->nombre}}</td>
					<td>{{$producto->cantidad}}</td>
				</tr>
			@endforeach
			
				</table>
			</div>
		</div>
		@endif
</form>

<script>
	$("#form1").validate();

	function guardar() {
		if ($("#form1").valid()) {
			modificado = false;
			form1.submit();
		} else {
			$("#modalGuardar").modal('toggle');
			msgShow("Corrija los errores e intente nuevamente.", "danger");
			return false;
		}
	}

	function eliminar() {
		$.ajax({
			type: "GET",
			url: "{{ asset('admin/pedido/eliminar') }}",
			data: {
				id: globalId
			},
			async: true,
			dataType: "json",
			success: function(data) {
				if (data.err = 0) {
					msgShow(data.mensaje, "success");
					$("#btnEnviar").hide();
					$("#btnEliminar").hide();
					$("#mdlEliminar").modal('toggle');
				} else {
					msgShow(data.mensaje, "danger");
					$("#mdlEliminar").modal('toggle');
				}

			}
		});
	}
</script>


@endsection