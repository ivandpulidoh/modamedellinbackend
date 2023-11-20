@extends("plantilla")
@section('titulo', "$titulo")
@section('scripts')
<script>
	globalId = '<?php echo isset($producto->idproducto) && $producto->idproducto > 0 ? $producto->idproducto : 0; ?>';
	<?php $globalId = isset($producto->idproducto) ? $producto->idproducto : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
	<li class="breadcrumb-item"><a href="/admin/productos">producto</a></li>
	<li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
	<li class="btn-item"><a title="Nuevo" href="/admin/sistema/menu/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
	<li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
	</li>
	@if($globalId > 0)
	<li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
	@endif
	<li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
	function fsalir() {
		location.href = "/admin/sistema/producto";
	}
</script>
@endsection

@section('contenido')

<?php
if (isset($msg)) {
	echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<form id="form1" method="POST">
	<div class="row">
		<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
		<input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
		<div class="form-group col-lg-6">
			<label>Nombre: *</label>
			<input type="text" id="txtNombre" name="txtNombre" class="form-control" value="" required>
		</div>

		<div class="form-group col-lg-6">
			<label for="txtNombre">Tipo de producto: *</label>
			<select name="txtTipoProducto" id="txtTipoProducto" class="form-control selectpicker">
			<option value="" disabled selected>Seleccionar</option>
			@foreach($aCategorias as $categoria)
				<option value=" {{ $categoria->idtipoproducto  }} ">{{  $categoria->nombre}}</option>


			@endforeach
		</select>
		</div>

		<div class="form-group col-lg-6">
			<label>Cantidad: *</label>
			<input type="id" id="lstCantidad" name="lstCantidad" class="form-control" value="" required>
		</div>

		<div class="form-group col-lg-6">
			<label>Precio *</label>
			<input type="text" id="txtPrecio" name="txtPrecio" class="form-control" value="" required>
		</div>

		<div class="form-group col-lg-6">
			<label>Descripcion *</label>
			<input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" value="" required>
		</div>

		<div>
			<label for="">Archivo adjunto</label>
			<input type="file" name="txtArchivo" id="txtArchivo"  accept=".jpg, .jpeg, .png">
			<small class="d-block">Archivos admitidos: .jpg, .jpeg, .png</small>
		</div>

	</div>
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
</script>


@endsection