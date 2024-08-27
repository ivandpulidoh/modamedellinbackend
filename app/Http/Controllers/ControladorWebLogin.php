<?php

namespace App\Http\Controllers;


use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use Session;

class ControladorWebLogin extends Controller
{
	public function index(Request $request)
	{

		$sucursal = new Sucursal();
		$aSucursales = $sucursal->obtenerTodos();
		return view('web.login', compact('aSucursales'));
	}

public function ingresar(Request $request)
{
    $sucursal = new Sucursal();
    $aSucursales = $sucursal->obtenerTodos();
    $correo = $request->input("txtCorreo");
    $clave = $request->input("txtClave");

    $cliente = new Cliente();
    $cliente->obtenerPorCorreo($correo);

    if ($cliente->idcliente != null) { // Verificar si el cliente fue encontrado
        if (password_verify($clave, $cliente->clave)) {
            Session::put("idCliente", $cliente->idcliente);
            return view('web.index', compact('aSucursales'));
        } else {
            $mensaje = "Credenciales incorrectas";
            return view("web.login", compact('aSucursales', 'mensaje'));
        }
    } else {
        $mensaje = "Cliente no encontrado";
        return view("web.login", compact('aSucursales', 'mensaje'));
    }
}


	public function logout()
	{
		Session::put("idCliente", "");
		return redirect("/");
	}
}
