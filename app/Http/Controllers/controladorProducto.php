<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;
use Illuminate\Http\Request;
use App\Entidades\Producto;
use App\Entidades\TipoProducto;
require app_path().'/start/constants.php';
class ControladorProducto extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo Producto";
        $categoria = new TipoProducto();
        $aCategorias = $categoria->obtenerTodos();
	$producto = new Producto();

        return view("sistema.producto-nuevo", compact("titulo", "aCategorias", "producto"));
    }

    public function index()
    {
        $titulo = "Listado de Producto";
	$producto = new Producto();
	
        return view("sistema.producto-listar", compact("titulo", "producto"));
    }

   public function guardar(Request $request)
{
    try {
        $titulo = "Modificar Producto";
        $entidad = new Producto();
        $entidad->cargarDesdeRequest($request);

        if ($request->hasFile('archivo') && $request->file('archivo')->isValid()) {
            $imagen = $request->file('archivo');
            $extension = $imagen->getClientOriginalExtension();
            $nombre = date("Ymdhmsi") . ".$extension";
            $rutaAlmacenamiento = env('APP_PATH') . "/public/files/";
            $imagen->move($rutaAlmacenamiento, $nombre);
            $entidad->imagen = $nombre;
        }

        if ($entidad->nombre == "") {
            // Mensaje de error si el nombre está vacío
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Complete todos los datos";
        } else {
            if ($request->input("id") > 0) {
                $productAnt = new Producto();
                $productAnt->obtenerPorId($entidad->idproducto);

                if ($request->hasFile('archivo') && $request->file('archivo')->isValid()) {
                    @unlink(env('APP_PATH') . "/public/files/{$productAnt->imagen}");
                } else {
                    $entidad->imagen = $productAnt->imagen;
                }
                $entidad->guardar();

                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = "Producto actualizado exitosamente";
            } else {
                $entidad->insertar();

                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = "Producto creado exitosamente";
            }
        }
    } catch (\Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = "Error al guardar el producto: " . $e->getMessage();
    }

    return view('sistema.producto-listar', compact('msg', 'titulo'));
}

    public function cargarGrilla(Request $request)
    {
        $entidad = new Producto();
        $aProducto = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request->input('start');
        $registros_por_pagina = $request->input('length');

        foreach ($aProducto as $producto) {
            $row = array();
            $row[] = "<a href='/admin/producto/" . $producto->idproducto . "'>" . $producto->nombre . "</a>";
            $row[] = $producto->cantidad;
            $row[] = number_format($producto->precio, 0, ",", ".") ;
		$row[] = $producto->descripcion;
		$row[] =  " <img src='/files/" . $producto->imagen ."' class='img-thumbnail'>";
            $data[] = $row;

            $cont++;
            if ($cont >= $registros_por_pagina) {
                break;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => count($aProducto),
            "recordsFiltered" => count($aProducto),
            "data" => $data,
        );

        return json_encode($json_data);
    }
	public function editar($idProducto){
		$titulo = "Edicion de Producto";
		$producto = new producto();
		$producto->obtenerPorId($idProducto);
		   $categoria = new TipoProducto();
		   $aCategorias = $categoria->obtenerTodos();

	  return view("sistema.producto-nuevo", compact("titulo", "aCategorias", "producto"));
	
}

	public function eliminar(Request $request){
		$idProducto  =  $request->input("id");
	      $pedido = new Pedido();
		// si el cliente tiene un pedido asociado no se debo poder eliminar
		if($pedido->existePedidosPorProducto($idProducto)){	
		$resultado["err"] = EXIT_FAILURE;	
		$resultado["mensaje"] = "No se puede eliminar un cliente con pedidos asociados";
		}else {   
	//sin o si
	     $producto = new Producto();
		$producto->idproducto =  $idProducto;
		$producto->eliminar();
		$resultado["err"] = EXIT_SUCCESS;
		$resultado["mensaje"] = "Registro eliminado exitosamente";
			}
		return json_encode($resultado);

		}

}
