<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Pedido;
use App\Entidades\Sucursal;
use Illuminate\Http\Request; // Importa la clase Request correcta
use Session;

class ControladorWebMiCuenta extends Controller
{
	public function index(Request $request)
	{
		$idCliente = Session::get("idCliente");
		$cliente = new Cliente();
		$cliente->obtenerPorId($idCliente);

		$sucursal = new Sucursal();
		$aSucursales = $sucursal->obtenerTodos();

		$pedido = new Pedido();
		$aPedidoProductos = $pedido->obtenerPedidosPorCliente($idCliente); // Corrige el nombre del método
		$pedido = $pedido->obtenerPedidosPorCliente($idCliente);

		return view("web.mi-cuenta", compact("cliente", "aSucursales", "aPedidoProductos", "pedido"));
	}

	public function guardar(Request $request) // Ajusta el tipo de hinting para la clase Request
	{
		$cliente = new Cliente();
		$idCliente = Session::get("idCliente");
		$cliente->idCliente = $idCliente;
		$cliente->nombre = $request->input("txtNombre");
		$cliente->telefono = $request->input("txtTelefono"); // Corrige los nombres de las propiedades
		$cliente->correo = $request->input("txtCorreo");
		$cliente->dni = $request->input("txtDni");
		$cliente->direccion = $request->input("txtDireccion");
		$cliente->guardar();

		$sucursal = new Sucursal();
		$aSucursales = $sucursal->obtenerTodos();

		$pedido = new Pedido();
		$aPedidos = $pedido->obtenerPedidosPorCliente($idCliente);

		return view("web.mi-cuenta", compact("cliente", "aSucursales", "aPedidos"));
	}
}
