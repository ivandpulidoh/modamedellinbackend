@extends("web.plantilla")
@section("contenido")

<section class="book_section layout_padding">
    <div class="container">
	<div class="heading_container">
	
        <h2>¿Olvidaste la clave?</h2>
        <p>Ingresa la dirección de correo con la que registraste y te enviaremos las instrucciones para cambiar la clave</p>
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

        <form action="" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>

            <div>
                <input type="text" class="form-control" placeholder="Ingresu su correo electronico" id="txtCorreo" name="txtCorreo">
            </div>
            
            <div>
                <button type="submit" name="btnIngresar" class="order_online">Recuperar</button>
            </div>
        </form>
    </div>
    </div>
    </div>
</section>

@endsection
