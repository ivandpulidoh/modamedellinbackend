@extends("web.plantilla")
@section("contenido")

<section class="book_section layout_padding">
	<div class="container">
		<div class="heading_container">
			<h2>
				Ingresar al sistema
			</h2>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<form action="" method="POST">
				<input type="hidden" name="_token" value="{{ cskf_token() }}"></input>
			<div>
				<label for="">Usuario</label>
				<input type="text" class="form-control" placeholder="Ingresar usuario" />
			</div>

			<div>
				<label for="">Contraseña</label>
				<input type="password" class="form-control" placeholder="Ingresar clave" />
			</div>	

			<div>
				<button type="submit">Ingresar</button>
			</div>
			</form>
		</div>
	</div>

</section>
@endsection