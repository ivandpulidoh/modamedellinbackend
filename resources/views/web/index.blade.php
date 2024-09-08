@extends("web.plantilla")
@section("banner")
<!-- slider section -->
<main class="main">
      <section class="home-slider position-relative mb-30">
            <div class="container">
                  <div class="home-slide-cover bg-grey-10 mt-30">
                        <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1">
                              <div class="single-hero-slider single-animation-wrap">
                                    <div class="container">
                                          <div class="row align-items-center slider-animated-1">
                                                <div class="col-lg-5 col-md-6">
                                                      <div class="hero-slider-content-2">
                                                            <h4 class="animated">Trade-In Offer</h4>
                                                            <h3 class="animated fw-900">Supper Value Deals</h3>
                                                            <h2 class="animated fw-900 text-brand">On All Products</h2>
                                                            <p class="animated">Save more with coupons & up to 70% off
                                                            </p>
                                                            <a class="animated btn btn-brush btn-brush-3"
                                                                  href="shop-product-right.html" tabindex="0"> Shop Now
                                                            </a>
                                                      </div>
                                                </div>
                                                <div class="col-lg-7 col-md-6">
                                                      <div class="single-slider-img single-slider-img-1">
                                                            <img class="animated" src="web/images/slider/slider-6.png"
                                                                  alt="">
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <div class="single-hero-slider single-animation-wrap">
                                    <div class="container">
                                          <div class="row align-items-center slider-animated-1">
                                                <div class="col-lg-5 col-md-6">
                                                      <div class="hero-slider-content-2">
                                                            <h4 class="animated">Hot promotions</h4>
                                                            <h3 class="animated fw-900">Fashion Trending</h3>
                                                            <h2 class="animated fw-900 text-brand">Great Collection</h2>
                                                            <p class="animated">Save more with coupons & up to 20% off
                                                            </p>
                                                            <a class="animated btn btn-brush btn-brush-1"
                                                                  href="shop-product-right.html" tabindex="0"> Get It
                                                                  Now </a>
                                                      </div>
                                                </div>
                                                <div class="col-lg-7 col-md-6">
                                                      <div class="single-slider-img single-slider-img-1">
                                                            <img class="animated" src="web/images/slider/slider-7.png"
                                                                  alt="">
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <div class="slider-arrow hero-slider-1-arrow"></div>
                  </div>
            </div>
      </section>
</main>
<!-- end slider section -->
@endsection

<!-- offer section -->
@section("contenido")

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
                        <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                              <div class="product-cart-wrap mb-30">
                                    <div class="product-img-action-wrap">
                                          <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html">
                                                      <img class="default-img" src="web/images/shop/product-1-1.jpg"
                                                            alt="">
                                                      <img class="hover-img" src="web/images/shop/product-1-2.jpg"
                                                            alt="">
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
                                          <h2><a href="shop-product-right.html">Colorful Pattern Shirts</a></h2>
                                          <div class="rating-result" title="90%">
                                                <span>
                                                      <span>90%</span>
                                                </span>
                                          </div>
                                          <div class="product-price">
                                                <span>$238.85 </span>
                                                <span class="old-price">$245.8</span>
                                          </div>
                                          <div class="product-action-1 show">
                                                <a aria-label="Add To Cart" class="action-btn hover-up"
                                                      href="shop-cart.html"><i class="fi-rs-shopping-bag-add"></i></a>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                              <div class="product-cart-wrap mb-30">
                                    <div class="product-img-action-wrap">
                                          <div class="product-img product-img-zoom">
                                                <a href="shop-product-right.html">
                                                      <img class="default-img" src="web/images/shop/product-2-1.jpg"
                                                            alt="">
                                                      <img class="hover-img" src="web/images/shop/product-2-2.jpg"
                                                            alt="">
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
                                                <span class="new">New</span>
                                          </div>
                                    </div>
                                    <div class="product-content-wrap">
                                          <div class="product-category">
                                                <a href="shop-grid-right.html">Clothing</a>
                                          </div>
                                          <h2><a href="shop-product-right.html">Plain Color Pocket Shirts</a></h2>
                                          <div class="rating-result" title="90%">
                                                <span>
                                                      <span>50%</span>
                                                </span>
                                          </div>
                                          <div class="product-price">
                                                <span>$138.85 </span>
                                                <span class="old-price">$255.8</span>
                                          </div>
                                          <div class="product-action-1 show">
                                                <a aria-label="Add To Cart" class="action-btn hover-up"
                                                      href="shop-cart.html"><i class="fi-rs-shopping-bag-add"></i></a>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>


            </div>
      </div>
</section>
@endsection