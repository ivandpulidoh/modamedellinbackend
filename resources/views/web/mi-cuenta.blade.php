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
				Datos del usuario
			</h2>
		</div>

		<div class="form_container">
			<form action="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
				<div class="row">
					<div class="col-md-6">
						Usuario
						<input type="text" class="form-control" placeholder="Nombre" id="txtNombre" name="txtNombre" value="{{ $cliente->nombre }}" />
					</div>

					<div class="col-md-6">
						Telefono
						<input type="text" class="form-control" placeholder="Telefono" id="txtTelefono" name="txtTelefono" value="{{ $cliente->telefono }}" />
					</div>

					<div class="col-md-6">
						WhatsApp
						<input type="text" class="form-control" placeholder="WhatsApp" id="txtWhatsApp" name="txtWhatsApp" value="{{ $cliente->telefono }}" />
					</div>

					<div class="col-md-6">
						correo
						<input type="text" class="form-control" placeholder="E-mail" id="txtCorreo" name="txtCorreo" value="{{ $cliente->correo }}" />
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<button type="submit" name="btbGuardar" id="btnGuardar">
							Guardar
						</button>
					</div>
				</div>
			</form>

			<div class="row">
				<div class="col-12">
					<a href="cambiar-clave">Cambiar clave</a>
				</div>
			</div>

			<div class="row">
				<h2 class="mt-4"> Pedidos Activos</h2>
			</div>
			<div class="row">

				<div class="col-md-9">
					<div class="row m-2-12">
						<table class="table">
							<thead>
								<tr>
									<th>Sucursal</th>
									<th>Pedido</th>
									<th>Estado Pedido</th>
									<th> Fecha</th>
									<th> total</th>
								</tr>

								@foreach ($aPedidoProductos as $pedido)
								<tr>
									<td>{{$pedido->sucursal}}</td>
									<td>{{$pedido->idpedido}}</td>
									<td>{{$pedido->fk_idestadoPedido}}</td>
									<td>{{$pedido->fecha}}</td>
									<td>{{ number_format($pedido->precio, 0, ',', '.') }}</td>

								</tr>
								@endforeach
							</thead>

						</table>
					</div>
				</div>

			</div>
		</div>


</section>

@endsection