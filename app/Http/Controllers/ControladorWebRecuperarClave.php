<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sucursal;
use Illuminate\Http\Client\Request;
use PHPMailer\PHPMailer\PHPMailer;

class ControladorWebRecuperarClave extends Controller
{
	public function index(Request $request)
	{
		$sucursal = new Sucursal;
		$aSucursal = $sucursal->obtenerTodos();

		return view('web-recuperarclave',compact('aSucursales'));
	}
	

	public function recuperar(Request $request)
	{
		$titulo = 'Recupero clave';
		$email =$request->input('txtCorreo');

		$cliente = new Cliente();

	$data = "Instrucciones";

	$email = new PHPMailer(true);
	try {

}


	}
}
