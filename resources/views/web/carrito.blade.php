@extends("web.plantilla")
@section("contenido")

<section class="book_section layout_padding">
	<div class="container">
		<div class="heading_container">
			<h2>
				Mi carrito
			</h2>
		</div>
	</div>

	<div class="row">
		@if($aCarritos)
		<div class="col-md-9">
			<div class="row m-2-12">
				<div class="col-md-12">
				<table class="table">
					<thead>
						<tr>
							<th></th>
							<th colspan="2"></th>
							<th>Precio</th>
							<th>Cantidad</th>
							<th>Subtotal</th>
						</tr>
					</thead>
					<tbody>
					@foreach($aCarritos AS $carrito)
						<tr>
							<th>
								<img src="" class="thumbnail">
							</th>
							<td>
								{{$carrito->producto}}
							</td>
							<td>
								{{$carrito->precio}}
							</td>
							<td>
								{{$carrito->cantidad}}
							</td>
							<td>
								{{$carrito->producto}}
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@else
	<div class="col-md-12">
		<h4>No hay productos seleccionados</h4>
	</div>
	@endif
	<button><a href="takeway.blade.php" class="btn-box">Continuar pedido</a></button>
</div>
</section>

@endsection
