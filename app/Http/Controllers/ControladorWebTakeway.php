<?php

namespace App\Http\Controllers;

use App\Entidades\Carrito;
use Illuminate\Http\Request;
use App\Entidades\Categoria;
use App\Entidades\Producto;
use App\Entidades\Sistema\Usuario;
use App\Entidades\TipoProducto;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sucursal;
use Illuminate\Support\Facades\Session; // Importar la clase Session desde el namespace correcto

require app_path() . '/start/constants.php';

class ControladorWebTakeway extends Controller
{
    public function index()
    {
        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();
        $categoria = new TipoProducto();
        $aCategorias = $categoria->obtenerTodos();
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
        return view("web.takeway", compact('aCategorias', 'aProductos', 'aSucursales'));
    }

    public function insertar(Request $request)
    {

        $idCliente = Session::get("idCliente");

        $idProducto = $request->input("txtProducto"); // Ajustar el nombre del campo según tu formulario
        $cantidad = $request->input("txtCantidad");

        $categoria = new TipoProducto();
        $aCategorias = $categoria->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
	
	$producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        if (isset($idCliente) && $idCliente > 0) {

            if ( $cantidad > 0) {

                // Agregamos al carrito
                $carrito = new Carrito();
		   $carrito->cantidad = $cantidad;
                $carrito->fk_idcliente= $idCliente;
                $carrito->fk_idproducto = $idProducto; // Corregir el nombre del campo según tu formulario
		    $carrito->insertar();
                // Y damos un mensaje success
                $msg["ESTADO"] = MSG_SUCCESS; // Corregir el estado a MSG_SUCCESS
                $msg["MSG"] = "El producto se ha guardado en el carrito"; // Corregir el mensaje
                return view('web.takeway', compact('msg', 'aCategorias', 'aSucursales','aProductos'));
            } else {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "No se agregó ningún producto al carrito";

                return view('web.takeway', compact('msg', 'aCategorias', 'aSucursales','aProductos')); // Corregir el nombre de la vista
            }
        } else {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Debe iniciar sesión para realizar un pedido.";
            return view('web.takeway', compact('msg', 'aCategorias', 'aSucursales','aProductos')); // Corregir el nombre de la vista
        }
    }
}
