@extends("web.plantilla")
@section("contenido")

<section class="book_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <h2>Mi carrito</h2>
        </div>

        <div class="row">
            @if($aCarritos)
            <div class="col-md-9">
                <div class="row m-2-12">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table class="table shopping-summery text-center clean">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th colspan="2"></th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                ?>

                                @foreach($aCarritos AS $carrito)
                                <tr>
                                    <form action="" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <td stye="width: 0px;">
                                            <input type="hidden" name="txtCarrito" class="form-control" value="{{ $carrito->idcarrito }}" required>
                                        </td>
                                        <td style="width:100px;">
                                            <img src="/files/{{$carrito->imagen}}" class="img-thumbnail">
                                        </td>
                                        <td>
                                            <img src="" class="thumbnail">
                                        </td>
                                        <td>
                                            {{ $carrito->producto }}
                                        </td>
                                        <td>
                                            {{ number_format($carrito->precio, 0, ',', '.') }}
                                        </td>
                                        <td style="width: 15px;">
                                            <input class="form-control" value="{{ $carrito->cantidad }}" min="1" type="number" name="txtCantidad">
                                        </td>
                                        <td>
                                            {{ number_format($carrito->cantidad * $carrito->precio, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <div class="btn-group">
							                    <input type="hidden" name="txtCarrito" value="{{$carrito->idcarrito}}">
                                                <!--<button type="submit" class="btn btn-primary" name="btnActualizar">
                                                    <i class="fi-rs-shuffle mr-10" aria-hidden="true"></i>
                                                </button>-->
                                                <button type="hidden" class="btn  btn-sm" name="btnBorrar" id="btnBorrar">
                                                    <i class="fi-rs-trash"></i>
                                                </button>
                                                
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                                <?php
                                $subtotal = $carrito->precio * $carrito->cantidad;
                                $total += $subtotal;
                                ?>
                                @endforeach

                                <tr>
                                    <td colspan="4" style="text-align: right;">Te falto algo</td>
                                    <td colspan="2" style="text-align: right;">
                                        <a class="btn btn-primary" href="takeway">Continuar pedido</a>
                                    </td>
                                    <td>Total del carrito: ${{ number_format($total, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row mt-2 p-2">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>TOTAL: ${{ number_format($total, 0, ",", ".") }}</th>
                                </tr>
                            </thead>
                            <form action="" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <tbody>
						    <tr>
                                        <td>
                                            <label class="d-block">Sucursal:</label>
                                            <select name="txtSucursal" id="txtSucursal" class="form-select" required>
                                                <option value="" disabled selected>Seleccionar</option>
								@foreach($aSucursales as $sucursal)
                                                <option value="{{ $sucursal->idsucursal}}">{{ $sucursal->nombre}}</option>
                                               @endforeach
                                            </select>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <label class="d-block">Metodo de pago:</label>
                                            <select name="txtPago" class="form-select" required>
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="mercadoPago">Mercadopago</option>
                                                <option value="efectivo">Efectivo</option>
                                                <option value="nequi">Nequi</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: right;">
                                            <button type="submit" class="btn btn-primary" name="btnFinalizar">Finalizar compra</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </form>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-12">
                    <h4>No hay productos seleccionados</h4>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
