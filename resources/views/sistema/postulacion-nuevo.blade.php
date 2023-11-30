@extends("plantilla")
@section('titulo', "$titulo")
@section('scripts')
<script>
	globalId = '<?php echo isset($postulaciones->idpostulacion) && $postulaciones->idpostulacion > 0 ? $postulaciones->idcategoria : 0; ?>';
	<?php $globalId = isset($postulaciones->idpostulacion) ? $postulaciones->idpostulacion : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
	<li class="breadcrumb-item"><a href="/admin/postulacion">Postulacion</a></li>
	<li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
	<li class="btn-item"><a title="Nuevo" href="/admin/sistema/postulacion/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
	<li class="btn-item"><a title="Guardar" href="#" class="fas fa-save" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a></li>
	@if($globalId > 0)
	<li class="btn-item"><a title="Eliminar" href="#" class="fas fa-trash" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
	@endif
	<li class="btn-item"><a title="Salir" href="#" class="fas fa-sign-out-alt" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>

<script>
	function fsalir() {
		location.href = "/admin/postulacion";
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
			<input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{ $postulacion->nombre }}" required>
		</div>

		<div class="form-group col-lg-6">
			<label>Apellido: *</label>
			<input type="text" id="txtApellido" name="txtApellido" class="form-control" value="{{ $postulacion->apellido }}" required>
		</div>

		<div class="form-group col-lg-6">
			<label>whatsapp: *</label>
			<input type="text" id="txtWhatsapp" name="txtWhatsapp" class="form-control" value="{{ $postulacion->whatsapp }}" required>
		</div>

		<div class="form-group col-lg-6">
			<label>Correo: *</label>
			<input type="text" id="txtCorreo" name="txtCorreo" class="form-control" value="{{ $postulacion->correo }}" required>
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