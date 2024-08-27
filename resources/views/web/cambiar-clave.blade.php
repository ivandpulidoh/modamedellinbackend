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
			<h2>
			Cambio de clave
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
			<div class="form_container">
			<form action="" method="POST" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
			
					<div class="col-md-6">
						<label for="txtClave"></label>
						<input type="text" class="form-control" placeholder="Clave nueva" id="txtClave1" name="txtClave1" />
					</div>

					<div class="col-md-6">
						<label for="txtClave1"></label>
						<input type="text" class="form-control" placeholder="Repetir nueva clave" id="txtClave2" name="txtClave2"  />
					</div>
			

				<div class="row">
					<div class="col-12">
						<button type="submit" class="btn btn-primary">
							Aceptar
						</button>
					</div>
				</div>
			</form>

			
		</div>


	</div>
</section>

@endsection