<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Rubro;
require app_path().'/start/constants.php'; // Asegúrate de que este archivo existe y contiene las constantes necesarias

class ControladorRubro extends Controller
{
    public function nuevo() {
        $titulo = "Nueva Rubro";
	     $rubro = new Rubro();
     return view("sistema.rubro-nuevo", compact("titulo", "rubro"));
    }

    public function index(){
        $titulo = "Listado de rubro";
        return view("sistema.rubro-listar", compact("titulo"));
    }

    public function guardar(Request $request) {
        try {
            $titulo = "Modificar Rubro";
            $entidad = new Rubro();
            $entidad->cargarDesdeRequest($request);

            if ($entidad->nombre == "" ) {
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
                return redirect()->route('sistema.rubro-listar')->with('msg', $msg);
            }
        } catch (\Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idrubro;
        $idrubro = new rubro();
        $idrubro->obtenerPorId($id);

        return view('sistema.rubro-nuevo', compact('msg', 'rubro', 'titulo'));
    }

    public function cargarGrilla(Request $request) {
        $request = $_REQUEST;

        $entidad = new Rubro();
        $rubro = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        for ($i = $inicio; $i < count($rubro) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = "<a href='/admin/rubro/" . $rubro[$i]->idrubro . "'>" . $rubro[$i]->nombre . "</a>";

            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($rubro),
            "recordsFiltered" => count($rubro),
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function editar($idRubro){
        $titulo = "Edicion de Rubro";
        $rubro = new rubro();
        $rubro->obtenerPorId($idRubro);
        return view("sistema.rubro-nuevo", compact("titulo", "rubro"));
    }
}

    
