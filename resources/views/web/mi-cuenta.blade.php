@extends("web.plantilla")
@section("contenido")

<?php
if (isset($msg)) {
	echo ' <div id =  "msg"></div>';
	echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div id =  "msg"></div>

<section class="book_section layout_padding">
	<div class="container">
		<div class="heading_container">
			<h2>
				Datos del usuario
			</h2>
		</div>

		<div class="form_container">
			<form action="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
				<div class="row">
					<div class="col-md-6">
						<input type="text" class="form-control" placeholder="Nombre" id="txtNombre" name="txtNombre" value="{{ $cliente->nombre }}" />
					</div>
					<div class="col-md-6">
						<input type="text" class="form-control" placeholder="Apellido" id="txtApellido" name="txtApellido" value="{{ $cliente->apellido }}" />
					</div>
					<div class="col-md-6">
						<input type="text" class="form-control" placeholder="Telefono" id="txtTelefono" name="txtTelefono" value="{{ $cliente->telefono }}" />
					</div>

					<div class="col-md-6">
						<input type="text" class="form-control" placeholder="WhatsApp" id="txtWhatsApp" name="txtWhatsApp" value="{{ $cliente->telefono }}"/>
					</div>

					<div class="col-md-6">
						<input type="text" class="form-control" placeholder="E-mail"  id="txtCorreo" name="txtCorreo" value="{{ $cliente->correo }}" />
					</div>
				</div>

				<div class="btn_box  text-center">
					<button>
						Guardar
					</button>
				</div>
			</form>

			<div class="heading_container">
				<h2>
					Pedidos Activos
				</h2>
			</div>
		</div>
<div class="row">
		
		<div class="col-md-9">
			<div class="row m-2-12">
				<table class="table">
				<thead>
				<tr>
				<th>Usuario</th>
				<th >Pedido</th>
				
				</tr>
				</thead>
			
				</table>
			</div> 
		</div>

	</div>
	</div>


</section>

@endsection