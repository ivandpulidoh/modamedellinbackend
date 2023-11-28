<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sucursal;
require app_path().'/start/constants.php';


class ControladorSucursal extends controller
{
 public function nuevo() {
        $titulo = "Nueva Sucursal";
        return view("sistema.sucursal-nuevo", compact("titulo"));
    }

	public function index(){
	$titulo = "Listado de Sucursales";
	return view ("sistema.sucursal-listar", compact("titulo"));
	}


		    public function guardar(Request $request) 
{
        try {
            //Define la entidad servicio
            $titulo = "Modificar sucursal";
            $entidad = new sucursal();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "" || $entidad->telefono == "" || $entidad->direccion == ""|| $entidad->horario == "" )  {
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
              
                $_POST["id"] = $entidad->idsucursal;
                return view('sistema.sucursal-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idsucursal;
        $sucursal = new Sucursal();
        $sucursal->obtenerPorId($id);

        

        return view('sistema.sucursal-nuevo', compact('msg', 'sucursal', 'titulo')) . '?id=' . $sucursal->idsucursal;

    }


  public function cargarGrilla(Request $request)
    {
        $request = $_REQUEST;

        $entidad = new Sucursal();
        $asucursal = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($asucursal) && $cont < $registros_por_pagina; $i++) {
            $row = array();
        	 $row[] =  " <a href='/admin/sucursal/ " .$asucursal[$i]->idsucursal ." '> ".  $asucursal[$i]->nombre . "</a>" ;		
            $row[] = $asucursal[$i]->telefono;
	      $row[] = $asucursal[$i]->direccion;
	      $row[] = $asucursal[$i]->horario;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($asucursal), //cantidad total de registros sin paginar
            "recordsFiltered" => count($asucursal), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

}
