<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;

class ControladorWebLogin extends Controller
{
    public function index(Request $request)
    {
	$sucursal = new Sucursal();
	$aSucursales = $sucursal->obtenerTodos();

	
            return view("web.login", compact('aSucursales'));
    }

	public function ingresar(Request $request)

	{
	$sucursal= new Sucursal();
	$aSucursales=$sucursal->obtenerTodos();
	$clave = $request->input();

	$cliente = new Cliente();

	return view('web.index', compact('aSucursales'));

	}
}
