<?php

namespace App\Http\Controllers;
use app\Entidades\Sucursal;
use App\Entidades\Cliente;
use Illuminate\Http\Client\Request;

class ControladorWebRegistrarse extends Controller
{
	public function index()
	{
		$sucursal = new Sucursal;
		$aSucursales = $sucursal->odtenerTodos();
		return view("web.registrarse", compact("aSucursales"));
	}

	public function registrarse(Request $request)
	{
		$titulo = "Nuevo Registro";
		$entidad = new Cliente;
		$entidad->nombre = $request->input("txtNombre");
		$entidad->clave = password_hash($request->input("txtClave"), PASSWORD_DEFAULT);

		if ($entidad->nombre == "" || $entidad->telefono == "" || $entidad->direccion == "") {
			$msg["ESTADO"] = MSG_ERROR;
			$msg["MSG"] = "Complete todos los datos";
		} else {

			if ($_POST) {
				$entidad->guardar();

				$msg["ESTADO"] = MSG_SUCCESS;
				$msg["MSG"] = "Registro Exitoso";
			}

			// Aquí deberías realizar alguna acción con $nombre y $contrasena, ya que hasta ahora solo los has obtenido.
		}
	}
}
