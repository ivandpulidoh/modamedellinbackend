<?php

namespace App\Http\Controllers;

use App\Entidades\Carrito;
use App\Entidades\Pedido;
use App\Entidades\PedidoProducto;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ControladorWebCarrito extends Controller
{
    public function index()
    {
        $idCliente = Session::get("idCliente");
        $carrito = new Carrito();
        $aCarritos = $carrito->obtenerPorCliente($idCliente);
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        return view("web.carrito", compact("aSucursales", "carrito", "aCarritos"));
    }

    public function procesar(Request $request)
    {
        if (isset($_POST["btnBorrar"])) {
            return $this->eliminar($request);
        } else if (isset($_POST["btnActualizar"])) {
            return $this->actualizar($request);
        } else if (isset($_POST["btnFinalizar"])) {
           return $this->finalizar($request);

        }
    }

    public function actualizar(Request $request)
    {

        $cantidad = $request->input("txtCantidad");
        $idCarrito = $request->input("txtCarrito");
        $idProducto = $request->input("txtProducto");
        $idCliente = Session::get("idCliente");

        $carrito = new Carrito();
        $aCarritos = $carrito->obtenerPorCliente($idCliente);
        $sucursal = new Sucursal;
        $aSucursales = $sucursal->obtenerTodos();

        $carrito->idcarrito = $idCarrito;
        $carrito->cantidad = $cantidad;
        $carrito->fk_idcliente = $idCliente;
        $carrito->fk_idproducto = $idProducto;
        $carrito->guardar();

        $msg["err"] = 0;
        $msg["mensaje"] = "Producto actualizado exitosamente";

        return view('web.carrito', compact('msg', 'aSucursales', 'aCarritos'));
    }

    public function guardar(Request $request)
    {
        $idCliente = Session::get("idCliente"); // Add this line
        $cantidad = $request->input("txtCantidad");
        $idCarrito = $request->input("txtCarrito");

        $carrito = Carrito::find($idCarrito);
        $carrito->cantidad = $cantidad;
        $carrito->guardar();

        $resultado["err"] = 0;
        $resultado["mensaje"] = "Producto actualizado exitosamente";

        $carrito = new Carrito();
        $aCarritos = $carrito->obtenerPorCliente($idCliente);
        $sucursal = new Sucursal();
        $aSucursal = $sucursal->obtenerTodos();

        return view('web.carrito', compact('resultado', 'aSucursal', 'aCarritos'));
    }

    public function eliminar(Request $request)
    {
        $idCliente = Session::get("idCliente");
        $idCarrito = $request->input("txtCarrito");
        $carrito = new Carrito();
        $carrito->idcarrito = $idCarrito;
        $carrito->eliminar();
        $aCarritos = $carrito->obtenerPorCliente($idCliente);
        $sucursal = new Sucursal;
        $aSucursales = $sucursal->obtenerTodos();

        $msg["err"] = 0;
        $msg["mensaje"] = "Producto eliminado exitosamente";

        return view("web.carrito", compact("aSucursales", "carrito", "aCarritos", "msg"));
    }

    public function finalizar(Request $request)
    {
        $idCliente = Session::get("idCliente");
        $carrito = new Carrito();
        $aCarritos = $carrito->obtenerPorCliente($idCliente);
        $sucursal = new Sucursal;
        $aSucursales = $sucursal->obtenerTodos();

        $precio = 0;

        foreach ($aCarritos as $productoCarrito) {
            $precio += $productoCarrito->cantidad * $productoCarrito->precio;
        }

        $sucursalPedido = $request->input('txtSucursal');
        $pago = $request->input('txtPago');
        $fecha = date("Y-m-d");

        $pedido = new Pedido();
        $pedido->fk_idsucursal = $sucursalPedido;
        $pedido->fk_idcliente = $idCliente;
        $pedido->fk_idestadoPedido = 1;
        $pedido->fecha = $fecha;
        $pedido->precio = $precio;
	 $pedido->pago = $pago;
        $pedido->insertar();

        $pedidoProducto = new PedidoProducto();
        foreach ($aCarritos as $item) {
            $pedidoProducto->fk_idproducto = $item->fk_idproducto;
            $pedidoProducto->fk_pedido = $pedido->idpedido;
		 $pedidoProducto->cantidad = $item->cantidad;
            $pedidoProducto->insertar();
        }

        $carrito->eliminarPorCliente($idCliente);

        $msg["err"] = 0;
        $msg["mensaje"] = "El pedido se ha confirmado correctamente";
        return view('web.carrito', compact('msg', 'aSucursales', 'aCarritos'));
    }
}
