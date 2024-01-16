<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use Illuminate\Http\Client\Request;


class ControladorWebMiCuenta extends Controller
{
    public function index()
    {	
		$idCliente = 1;
		$cliente = new Cliente();
		$cliente->obtenerPorId($idCliente);
            return view("web.mi-cuenta", compact("cliente"));
    }

	public function guardar(Request $request){
}
}
