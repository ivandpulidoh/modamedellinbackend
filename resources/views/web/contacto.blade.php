@extends("web.plantilla")
@section("contenido")
  <?php
if (isset($msg)) {
	echo ' <div id =  "msg"></div>';
	echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div id="msg"></div>

<!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
         Reserva tu pedido
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
             <form action="" method="POST">
		  <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div>
                <input type="text" class="form-control" placeholder="Nombre" name="txtNombre" id="txtNombre" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Telefono" name="txtTelefono" id="txtTelefono" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Correo" name="txtCorreo" id="txtCorreo" />
              </div>
            <textarea name="txtComentario" id="txtComentario" class="form-control" placeholder="Escribe"></textarea>
              <div>
               
              </div>
              <div class="btn_box">
                <button>
                 ENVIAR
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
            <div id="googleMap"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->
@endsection

 