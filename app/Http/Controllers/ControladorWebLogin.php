<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;

class ControladorWebLogin extends Controller
{
    public function index()
    {
	$sucursal = new Sucursal();
	$aSucursales = $sucursal->obtenerTodos();

	$titulo ="ingresar al sistema";
            return view("web.login", compact('titulo','aSucursales'));
    }

	public function ingresar(Request $request)

	{
	$sucursal= new Sucursal();
	$aSucursales=$sucursal->obtenerTodos();
	$clave = $request->input();

	$cliente = new Cliente();

	//return view('web.index', compact('aSucursales'));

	}
}
