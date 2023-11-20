<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Entidades\producto;
use App\Entidades\tipoproducto;
require app_path().'/start/constants.php';


class controladorProducto extends Controller
{
	public function nuevo()
	{
		$titulo = "Nuevo Producto";
		$categoria = new tipoproducto();
		$aCategorias = $categoria->obtenerTodos();

		return view("sistema.producto-nuevo", compact("titulo", "aCategorias"));
	}

			    public function guardar(Request $request) 
{
        try {
            //Define la entidad servicio
            $titulo = "Modificar producto";
            $entidad = new Producto;
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "" ||  $entidad->fk_tipoproducto == ""|| $entidad->cantidad == ""|| $entidad->precio == ""  )  {
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
              
                $_POST["id"] = $entidad->idproducto;
                return view('sistema.producto-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idproducto;
        $producto = new producto();
        $producto->obtenerPorId($id);

        

        return view('sistema.producto-nuevo', compact('msg', 'producto', 'titulo')) . '?id=' . $producto->idproducto;

    }

}