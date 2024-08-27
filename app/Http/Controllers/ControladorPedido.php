<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\pedido;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\estadoPedido;
use App\Entidades\PedidoProducto;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\TipoProducto;

require app_path() . '/start/constants.php';


class ControladorPedido extends Controller
{
	public function nuevo()
	{
		$titulo = "Nuevo pedido";
		$pedido = new Pedido();

		// Initialize the variable

		if (Usuario::autenticado() == true) {
			if (!Patente::autorizarOperacion("PEDIDOALTA")) {
				$codigo = "PEDIDOALTA";
				$mensaje = "No tiene permisos para la operacion";
				$estadoPedido = new  estadoPedido();
				$aEstadoPedidos = $estadoPedido->obtenerTodos();
				return view("sistema.pagina-error", compact('titulo', 'codigo', 'pedido', 'aEstadoPedidos')); // Pass $aEstadoPedidos to the view
			} else {
				$cliente = new Cliente();
				$aClientes = $cliente->obtenerTodos();
				$sucursal = new Sucursal();
				$aSucursales = $sucursal->obtenerTodos();
				$pedido = new pedido();
				$pedido->obtenerTodos();
				$categoria = new TipoProducto();
				$aCategorias = $sucursal->obtenerTodos();
				$estadoPedido = new  estadoPedido();
				$aEstadoPedidos = $estadoPedido->obtenerTodos();

				return view("sistema.pedido-nuevo", compact('titulo', 'aClientes', 'aSucursales', 'aCategorias', 'pedido', 'aEstadoPedidos'));
			}
		} else {
			return redirect('admin/login');
		}
	}

	public function index()
	{
		$titulo = "Listado de pedidos";
		$pedido = new pedido();
		$estadoPedido = new  estadoPedido();
		$aEstadoPedidos = $estadoPedido->obtenerTodos();
		return view("sistema.pedido-listar", compact("titulo", "pedido", 'aEstadoPedidos'));
	}

	public function guardar(Request $request)
	{
		try {
			//Define la entidad servicio
			$titulo = "Modificar pedido";
			$entidad = new pedido;
			$categoria = new Sucursal();

			$entidad->cargarDesdeRequest($request);
			$cliente = new Sucursal();
			$aClientes = $cliente->obtenerTodos();
			$sucursal = new Sucursal();
			$aSucursales = $sucursal->obtenerTodos();
			$estadoPedido = new estadoPedido();
			$aEstadoPedidos = $estadoPedido->obtenerTodos();




			//validaciones
			if ($entidad->fecha == "") {
				$msg["ESTADO"] = MSG_ERROR;
				$msg["MSG"] = "Complete todos los datos";
			} else {
				if ($_POST["id"] > 0) {
					//Es actualizacion
					$entidad->guardar();

					$msg["ESTADO"] = MSG_SUCCESS;
					$msg["MSG"] = OKINSERT;
				} else {
					//Es nuevo
					$entidad->insertar();

					$msg["ESTADO"] = MSG_SUCCESS;
					$msg["MSG"] = OKINSERT;
				}

				$_POST["id"] = $entidad->idpedido;
				$pedido = new pedido();
				$categoria = new Sucursal();
				$aCategorias = $categoria->obtenerTodos();
				$cliente = new Cliente();
				$aClientes = $cliente->obtenerTodos();


				return view('sistema.pedido-listar', compact('titulo', 'aClientes', 'aSucursales', 'aEstadoPedidos', "pedido"));
			}
		} catch (Exception $e) {
			$msg["ESTADO"] = MSG_ERROR;
			$msg["MSG"] = ERRORINSERT;
		}

		$id = $entidad->idpedido;
		$pedido = new pedido();
		$pedido->obtenerPorId($id);
		$categoria = new Sucursal();
		$aCategorias = $categoria->obtenerTodos();
		$cliente = new Cliente();
		$aClientes = $cliente->obtenerTodos();


		return view('sistema.pedido-nuevo', compact('msg', 'pedido', 'titulo', 'aClientes', 'aCategorias', 'aEstadoPedidos')) . '?id=' . $pedido->idpedido;
	}
	public function cargarGrilla(Request $request)
	{
		$request = $_REQUEST;

		$entidad = new pedido();
		$apedido = $entidad->obtenerFiltrado();

		$data = array();
		$cont = 0;

		$inicio = $request['start'];
		$registros_por_pagina = $request['length'];


		for ($i = $inicio; $i < count($apedido) && $cont < $registros_por_pagina; $i++) {
			$row = array();
			$row[] = "<a href='/admin/pedido/" . $apedido[$i]->idpedido . "'>" . $apedido[$i]->fecha . "</a>";
			$row[] = "<a href='/admin/sucursal/" . $apedido[$i]->fk_idsucursal . "'>" . $apedido[$i]->sucursal . "</a>";
			$row[] = "<a href='/admin/cliente/" . $apedido[$i]->fk_idcliente . "'>" . $apedido[$i]->cliente . "</a>";
			$row[] = "<a href='/admin/estado_pedido/" . $apedido[$i]->fk_idestadoPedido . "'>" . $apedido[$i]->estadopedido . "</a>";
			$row[] = number_format($apedido[$i]->precio, 0, ',', '.');
			$cont++;
			$data[] = $row;
		}


		$json_data = array(
			"draw" => intval($request['draw']),
			"recordsTotal" => count($apedido), //cantidad total de registros sin paginar
			"recordsFiltered" => count($apedido), //cantidad total de registros en la paginacion
			"data" => $data,
		);
		return json_encode($json_data);
	}

	public function editar($idPedido)
	{
		$titulo = "Edicion de Pedido";
		$pedido = new pedido();
		$pedido->obtenerPorId($idPedido);
		$categoria = new Sucursal();
		$aCategorias = $categoria->obtenerTodos();
		$cliente = new Cliente();
		$aClientes = $cliente->obtenerTodos();
		$estadoPedido = new  estadoPedido();
		$aEstadoPedidos = $estadoPedido->obtenerTodos();

		$entidadPedidoProducto = new PedidoProducto();
		$aPedidoProductos = $entidadPedidoProducto->obtenerPorPedido($idPedido);


		return view("sistema.pedido-nuevo", compact("titulo", "pedido", "aCategorias", "aClientes", "aEstadoPedidos", 'aPedidoProductos'));
	}

	public function eliminar(Request $request)
	{
		$idPedido  =  $request->input("id");
		$pedido = new Pedido();
		// si el cliente tiene un pedido asociado no se debo poder eliminar
		if ($pedido->existePedidosPorPedido($idPedido)) {
			$resultado["err"] = EXIT_FAILURE;
			$resultado["mensaje"] = "No se puede eliminar un cliente con pedidos asociados";
		} else {
			//sin o si
			$pedido = new pedido();
			$pedido->idpedido =  $idPedido;
			$pedido->eliminar();
			$resultado["err"] = EXIT_SUCCESS;
			$resultado["mensaje"] = "Registro eliminado exitosamente";
		}
		return json_encode($resultado);
	}
}
