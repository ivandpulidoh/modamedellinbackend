@extends("web.plantilla")
@section("contenido")

<section class="book_section layout_padding">
	<div class="container">
		<div class="heading_container">
			<h2>
				Registrarse
			</h2>
		</div>
	@if(isset($msg))
    <div class="row">
        <div class="col-md-6">
            <div class="alert alert-{{ $msg['ESTADO'] }}" role="alert">
                {{ $msg['MSG'] }}
            </div>
        </div>
    </div>
@endif


	<div class="row">
		<div class="col-md-6">
			<div class="form_container">
				<form method="POST" action="">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<div>
						<input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder="nombre" />

					</div>
					<div>
						<input type="text" id="txtTelefono" name="txtTelefono" class="form-control" placeholder="Telefono" />

					</div>
					<div>
						<input type="text" id="txtDni" name="txtDni" class="form-control" placeholder="Dni" />

					</div>
					<div>
						<input type="text" id="txtDireccion" name="txtDireccion" class="form-control" placeholder="Direccion" />

					</div>
					<div>
						<input type="text" id="txtCorreo" name="txtCorreo" class="form-control" placeholder="correo" />

					</div>
					
					<div>
						<input type="text" id="txtClave" name="txtClave" class="form-control" placeholder="Clave" />

					</div>

					<div class="btn_box">
						<button>
						ENVIAR
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
</section>
@endsection