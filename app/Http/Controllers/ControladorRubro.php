<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Entidades\rubro;
use App\Entidades\tipoproducto;
require app_path().'/start/constants.php';


class controladorRubro extends Controller
{
	public function nuevo()
	{
		$titulo = "Nuevo rubro";
		$categoria = new tipoproducto();
		$aCategorias = $categoria->obtenerTodos();

		return view("sistema.rubro-nuevo", compact("titulo", "aCategorias"));
	}

	public function index(){
		$titulo = "Listado de Rubros";
		return view ("sistema.rubro-listar", compact("titulo"));
	}

		    public function guardar(Request $request) 
{
        try {
            //Define la entidad servicio
            $titulo = "Modificar rubro";
            $entidad = new rubro();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "" )  {
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
              
                $_POST["id"] = $entidad->idrubro;
                return view('sistema.rubro-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idrubro;
        $rubro = new rubro();
        $rubro->obtenerPorId($id);

        

        return view('sistema.rubro-nuevo', compact('msg', 'rubro', 'titulo')) . '?id=' . $rubro->idrubro;

    }


  public function cargarGrilla(Request $request)
    {
        $request = $_REQUEST;

        $entidad = new rubro();
        $rubro = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($rubro) && $cont < $registros_por_pagina; $i++) {
            $row = array();
        	 $row[] =  " <a href='/admin/rubro/ " .$rubro[$i]->idrubro ." '> ".  $rubro[$i]->nombre . "</a>" ;		
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($rubro), //cantidad total de registros sin paginar
            "recordsFiltered" => count($rubro), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

}