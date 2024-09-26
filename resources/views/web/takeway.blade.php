@extends("web.plantilla")
@section("contenido")

<!-- food section -->
@if(isset($msg))
<div class="alert alert-{{ $msg['ESTADO'] }}" role="alert">
      {{ $msg['MSG'] }}
</div>
@endif

<section class="product-tabs section-padding position-relative wow fadeIn animated animated animated"
      style="visibility: visible;">
      <div class="bg-square"></div>
      <div class="container">
            <div class="tab-header">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab"
                                    data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one"
                                    aria-selected="true">Featured</button>
                        </li>
                        <li class="nav-item" role="presentation">
                              <button class="nav-link" id="nav-tab-two" data-bs-toggle="tab" data-bs-target="#tab-two"
                                    type="button" role="tab" aria-controls="tab-two"
                                    aria-selected="false">Popular</button>
                        </li>
                        <li class="nav-item" role="presentation">
                              <button class="nav-link" id="nav-tab-three" data-bs-toggle="tab"
                                    data-bs-target="#tab-three" type="button" role="tab" aria-controls="tab-three"
                                    aria-selected="false">New added</button>
                        </li>
                  </ul>
                  <a href="#" class="view-more d-none d-md-flex">View More<i
                              class="fi-rs-angle-double-small-right"></i></a>
            </div>
            <!--End nav-tabs-->
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                  <div class="row product-grid-4">
                        @foreach($aProductos as $producto)
                        <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                              <div class="product-cart-wrap mb-30">
                                    <div class="product-img-action-wrap">
                                          <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html">
                                                      <img class="default-img" src="files/{{ $producto->imagen }}"
                                                            alt="">
                                                      <img class="hover-img" src="files/{{ $producto->imagen }}" alt="">
                                                </a>
                                          </div>
                                          <div class="product-action-1">
                                                <a aria-label="Quick view" class="action-btn hover-up"
                                                      data-bs-toggle="modal" data-bs-target="#quickViewModal"><i
                                                            class="fi-rs-eye"></i></a>
                                                <a aria-label="Add To Wishlist" class="action-btn hover-up"
                                                      href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn hover-up"
                                                      href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                          </div>
                                          <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot">Hot</span>
                                          </div>
                                    </div>
                                    <div class="product-content-wrap">
                                          <div class="product-category">
                                                <a href="shop-grid-right.html">Clothing</a>
                                          </div>
                                          <h2><a href="shop-product-right.html">{{ $producto->nombre}}</a></h2>
                                          <div class="rating-result" title="90%">
                                                <span>
                                                      <span>90%</span>
                                                </span>
                                          </div>
                                          <div class="product-price">
                                                <span> ${{ number_format($producto->precio, 0, ",", ".") }}</span>
                                                <span class="old-price">
                                                      ${{ number_format($producto->precio, 0, ",", ".") }}</span>
                                          </div>
                                          <div class="product-action-1 show">                                                
                                                <form id="carritoForm" method="POST">
                                                      <input type="hidden" name="_token"
                                                            value="{{ csrf_token() }}"></input>
                                                      <input type="input" id="txtProducto" name="txtProducto"
                                                            class="form-control" style="width: 100px ;"
                                                            value="{{$producto->idproducto}}" />
                                                      <input type="hidden" id="txtCantidad" name="txtCantidad"
                                                            class="form-control" style="width: 100px ;" value="1" />
                                                      <a aria-label="Add To Cart" class="action-btn hover-up"
                                                            href="" 
                                                            onclick="document.getElementById('carritoForm').submit(); return false;"><i
                                                                  class="fi-rs-shopping-bag-add"></i></a>
                                                </form>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        @endforeach
                  </div>
            </div>
      </div>
      </div>
</section>

<section class="food_section layout_padding">
      <div class="container">
            <div class="heading_container heading_center">
                  <h2>
                        Nuestro Menu
                  </h2>
            </div>

            <ul class="filters_menu">
                  <li class="active" data-filter="*">Todos</li>
                  @foreach($aCategorias As $categoria)
                  <li data-filter=".{{ $categoria->nombre }}">{{ $categoria->nombre }}</li>
                  @endforeach

            </ul>

            <div class="filters-content">
                  <div class="row grid">
                        @foreach($aProductos as $producto)
                        <div class="col-sm-6 col-lg-4 all  {{  $producto->categoria }} ">

                              <div class="box">
                                    <div>
                                          <div class="img-box">
                                                <img src="files/{{ $producto->imagen }}" alt="">
                                          </div>
                                          <div class="detail-box">
                                                <h5>
                                                      {{ $producto->nombre}}
                                                </h5>
                                                <p>
                                                      {{ $producto->descripcion}}
                                                </p>
                                                <div class="options">
                                                      <h6>
                                                            ${{ number_format($producto->precio, 0, ",", ".") }}
                                                      </h6>
                                                      <form id="" method="POST">
                                                            <input type="hidden" name="_token"
                                                                  value="{{ csrf_token() }}"></input>

                                                            <div class="form-group d-flex align-items-center">
                                                                  <input type="hidden" id="txtProducto"
                                                                        name="txtProducto" class="form-control"
                                                                        style="width: 100px ;"
                                                                        value="{{$producto->idproducto}}" />
                                                                  <input type="text" id="txtCantidad" name="txtCantidad"
                                                                        class="form-control" style="width: 100px ;"
                                                                        value="0" />

                                                                  <button type="submit"
                                                                        class=" btn btn-carrito btn-link">
                                                                        <a href="">
                                                                              <svg version="1.1" id="Capa_1"
                                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                    x="0px" y="0px"
                                                                                    viewBox="0 0 456.029 456.029"
                                                                                    style="enable-background:new 0 0 456.029 456.029;"
                                                                                    xml:space="preserve">
                                                                                    <g>
                                                                                          <g>
                                                                                                <path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248
                         c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" />
                                                                                          </g>
                                                                                    </g>
                                                                                    <g>
                                                                                          <g>
                                                                                                <path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48
                         C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064
                         c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4
                         C457.728,97.71,450.56,86.958,439.296,84.91z" />
                                                                                          </g>
                                                                                    </g>
                                                                                    <g>
                                                                                          <g>
                                                                                                <path
                                                                                                      d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296
                         c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />
                                                                                          </g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                                    <g>
                                                                                    </g>
                                                                              </svg>
                                                                        </a>
                                                                  </button>
                                                            </div>
                                                      </form>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>


                        @endforeach

                  </div>

            </div>
            <div class="btn-box">
                  <a href="">
                        Ver mas
                  </a>
            </div>
      </div>
</section>

<!-- end food section -->

@endsection