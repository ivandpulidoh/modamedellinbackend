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
	<li class="breadcrumb-item"><a href="/admin/producto">producto</a></li>
	<li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
	<li class="btn-item"><a title="Nuevo" href="/admin/sistema/producto/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
	<li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
	</li>
	@if($globalId > 0)
	<li class="btn-item"><a title="eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
	@endif
	<li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
	function salir() {
		location.href = "/admin/producto";
	}
</script>
@endsection

@section('contenido')

<?php
if (isset($msg)) {
	echo ' <div id =  "msg"></div>';
	echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div id =  "msg"></div>
<form id="form1" method="POST" enctype="multipart/form-data">
    <div class="row">
        @csrf <!-- Añade el campo CSRF fuera del input -->
        <input type="hidden" id="id" name="id" class="form-control" value="{{ $globalId }}" required>
        
        <div class="form-group col-lg-6">
            <label>Nombre: *</label>
            <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{ $producto->nombre }}" required>
        </div>

        <div class="form-group col-lg-6">
            <label for="txtTipoProducto">Tipo producto *</label>
            <select name="txtTipoProducto" id="txtTipoProducto" class="form-control selectpicker" required>
                <option value="" disabled selected>Seleccionar</option>
                @foreach($aCategorias as $categoria)
                    @if($categoria->idtipoproducto == $producto->fk_tipoproducto)
                        <option value="{{ $categoria->idtipoproducto }}" selected>{{ $categoria->nombre }}</option>
                    @else
                        <option value="{{ $categoria->idtipoproducto }}">{{ $categoria->nombre }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-6">
            <label>Cantidad: *</label>
            <input type="number" id="txtCantidad" name="txtCantidad" class="form-control" value="{{ $producto->cantidad }}" required>
        </div>

        <div class="form-group col-lg-6">
            <label>Precio: *</label>
            <input type="text" id="txtPrecio" name="txtPrecio" class="form-control" value="{{ $producto->precio }}" required>
        </div>

        <div class="form-group col-lg-6">
            <label>Descripcion: *</label>
            <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control" value="{{ $producto->descripcion }}" required>
        </div>

        <div class="form-group col-lg-6">
            <label for="txtImagen">Imagen</label>
            <input type="file" name="archivo" id="archivo" class="form-control-file">
            <img src="" alt="">
        </div>
        <div class="form-group col-lg-6">
            <label>Tallas: *</label>
            <input type="text" id="txtTallas" name="txtTallas" class="form-control" value="{{ $producto->tallas }}" required>
        </div>
        <div class="form-group col-lg-6">
            <label>Colores: *</label>
            <input type="text" id="txtColores" name="txtColores" class="form-control" value="{{ $producto->colores }}" required>
        </div>
        <div class="form-group col-lg-6">
            <label>Nombre Marca: *</label>
            <input type="text" id="txtMarca" name="txtMarca" class="form-control" value="{{ $producto->nombre_marca }}" required>
        </div>

        <div class="form-group col-lg-6">
            <label>Fecha Creación: *</label>
            <input type="date" id="txtFechaCreacion" name="txtFechaCreacion" class="form-control" value="{{ $producto->fecha_descripcion }}" required readonly>
        </div>
    </div>

</form>


<script>
    function previewImage(event) {
        var image = document.getElementById('imagenPreview');
        image.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
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
            url: "{{ asset('admin/producto/eliminar') }}",
            data: { id:globalId },
            async: true,
            dataType: "json",
            success: function (data) {
                if (data.err = 0) {
                    msgShow(data.mensaje ,"success");
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
<script>
        // Obtener la fecha actual
        const hoy = new Date();
        const año = hoy.getFullYear();
        const mes = ('0' + (hoy.getMonth() + 1)).slice(-2); // Añadir cero si es necesario
        const dia = ('0' + hoy.getDate()).slice(-2); // Añadir cero si es necesario

        // Formatear la fecha en formato YYYY-MM-DD
        const fechaActual = `${año}-${mes}-${dia}`;

        // Establecer el valor del campo de fecha
        document.getElementById('txtFechaCreacion').value = fechaActual;
</script>


@endsection