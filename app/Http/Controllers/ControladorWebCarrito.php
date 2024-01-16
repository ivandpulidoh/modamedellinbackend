<?php

namespace App\Http\Controllers;


use App\Entidades\Producto;
use App\Entidades\Sucursal;
use App\Entidades\Carrito;
use Illuminate\Http\Client\Request;

class ControladorWebCarrito extends Controller
{
	public function index()
	{
		$idCliente = 1;
		$carrito = new Carrito();
		$aCarritos = $carrito->obtenerPorCliente($idCliente);
		$sucursal = new Sucursal();
		$aSucursal = $sucursal->obtenerTodos();
		

		return view("web.carrito", compact("aSucursal", "carrito", "aCarritos"));
	}

	public function guardar(Request $request)

	{
		$titulo = "Nuevo carrito";
		$carrito = new Carrito();
		$carrito->cargarDesdeRequest($request);
	}
}
