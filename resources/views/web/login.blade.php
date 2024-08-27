@extends("web.plantilla")
@section("contenido")
<?php
if (isset($msg)) {
	echo ' <div id =  "msg"></div>';
	echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div id="msg"></div>

<section class="book_section layout_padding">
	<div class="container">
		<div class="heading_container">
			<h2>Ingresar al sistema</h2>
		</div>
		@if(isset($mensaje))
		<div class="row">
			<div class="col-md-6">
				<div class="alert alert-danger" role="alert">
					{{$mensaje}}
				</div>
				@endif
				<div class="form_container">
					<form action="" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>

						<div>
							<label for="">Correo</label>
							<input type="text" class="form-control" placeholder="" id="txtCorreo" name="txtCorreo">
						</div>
						<div>
							<label for="">Contraseña</label>
							<input type="password" class="form-control" placeholder="" id="txtClave" name="txtClave">
						</div>
						<div>
							<button type="submit" name="btnIngresar" class="order_online">Ingresar</button>
						</div>
					</form>
					<div class="">
						<a class="d-block small mt-3" href="/registrarse">Nuevo ¡No tienes cuenta? Registrar usuario</a>
						<a class="d-block small" href="/recuperarClave">¿Olvidaste tu clave?</a>
					</div>
				</div>
			</div>
		</div>
	</div>
				
</section>

@endsection