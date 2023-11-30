<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Producto;
use App\Entidades\Tipoproducto;
require app_path().'/start/constants.php';

class ControladorProducto extends Controller
{
  public function nuevo()
    {
        $titulo = "Nuevo Producto";
        $categoria = new Tipoproducto();
	$producto = new Producto();
$categoria = new Tipoproducto();
        $aCategorias = $categoria->obtenerTodos();

        return view('sistema.producto-nuevo', compact( 'producto', 'titulo', 'aCategorias'));
    }

    public function index()
    {
        $titulo = "Listado de producto";
        $producto = new Producto();
        return view("sistema.producto-listar", compact("titulo", "producto"));
    }

    public function guardar(Request $request)
    {
        try {
			//Define la entidad servicio
            $titulo = "Modificar Producto";
            $entidad = new Producto();
            $entidad->cargarDesdeRequest($request);

            if ($entidad->nombre == "" || $entidad->fk_tipoproducto == "" ||  $entidad->cantidad == ""  ||  $entidad->precio == "" ||  $entidad->descripcion == ""||  $entidad->imagen == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($request->input("id") > 0) {
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    $entidad->insertar();
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }

                return view('sistema.producto-listar', compact('titulo', 'msg'));
            }
        } catch (\Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idproducto;
        $producto = new Producto();
        $producto->obtenerPorId($id);
	$categoria = new Tipoproducto();
        $aCategorias = $categoria->obtenerTodos();

        return view('sistema.producto-nuevo', compact('msg', 'producto', 'titulo', 'aCategorias'));
    }

    public function cargarGrilla(Request $request)
    {
        $entidad = new Producto();
        $aCategorias = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request->input('start');
        $registros_por_pagina = $request->input('length');

        foreach ($aCategorias as $producto) {
            $row = array();
            $row[] = "<a href='/admin/producto/" . $producto->idproducto . "'>" . $producto->nombre . "</a>";
            $row[] = $producto->fk_tipoproducto;
            $row[] = $producto->precio;
            $row[] = $producto->descripcion;
           
            $data[] = $row;

            $cont++;
            if ($cont >= $registros_por_pagina) {
                break;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => count($aCategorias),
            "recordsFiltered" => count($aCategorias),
            "data" => $data,
        );

        return json_encode($json_data);
    }

    public function editar($idProducto){

     $titulo = "Edicion de Producto";
        $producto = new Producto();
        $producto->obtenerPorId($idProducto);
        $categoria = new Tipoproducto();
        $aCategorias = $categoria->obtenerTodos();

        return view("sistema.producto-nuevo", compact("titulo","aCategorias","producto"));
    }
}
