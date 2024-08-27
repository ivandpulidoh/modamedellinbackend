<?php

namespace App\Http\Controllers;

use Adldap\Laravel\Facades\Adldap;
use App\Entidades\Cliente;
use Illuminate\Http\Request;
use App\Entidades\Sucursal;
use App\Entidades\Sistema\Grupo;
use App\Entidades\Legajo\Legajo;
use App\Entidades\Sistema\Usuario;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Session;

require app_path() . '/start/constants.php'; // Asegúrate de que este archivo existe y contiene las constantes necesarias
class ControladorWebRecuperarClave extends Controller
{

	public function index(Request $request)
	{
		$sucursal = new Sucursal();
		$aSucursales = $sucursal->obtenerTodos();

		return view('web.recuperarClave', compact('aSucursales'));
	}

	public function recuperar(Request $request)
	{

		$sucursal = new Sucursal();
		$aSucursales = $sucursal->obtenerTodos();

		$titulo = 'Recupero clave';
		$correo = $request->input('txtCorreo');
		$clave = rand(1000, 9999);

		$cliente = new Cliente();
		$cliente->obtenerPorCorreo($correo);



		if ($cliente->correo) {
			$data = "Instrucciones";



			$cliente->clave = password_hash($clave, PASSWORD_DEFAULT);
			$cliente->guardar();

			$msg["ESTADO"] = MSG_SUCCESS;
			$msg["MSG"] = "La nueva clave es $clave, y te la hemos enviado al correo";
		} else {
			$msg["ESTADO"] = MSG_ERROR;
			$msg["MSG"] =  "El email no existe";
		}

		return view('web.recuperarClave', compact('titulo', 'msg', 'aSucursales'));
	}
}
