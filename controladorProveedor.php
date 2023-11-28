<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\proveedor;
require app_path().'/start/constants.php';


class ControladorProveedor extends controller
{
 public function nuevo() {
        $titulo = "Nuevo Proveedor";
        return view("sistema.proveedor-nuevo", compact("titulo"));
    }

	public function index(){
	$titulo = "Listado de proveedor";
	return view ("sistema.proveedor-listar", compact("titulo"));
	}


		    public function guardar(Request $request) 
{
        try {
            //Define la entidad servicio
            $titulo = "Modificar proveedor";
            $entidad = new Proveedor();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "" || $entidad->domicilio == "" || $entidad->cuit == ""|| $entidad->fk_idrubro == ""  )  {
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
              
                $_POST["id"] = $entidad->idproveedor;
                return view('sistema.proveedor-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idproveedor;
        $proveedor = new Proveedor();
        $proveedor->obtenerPorId($id);

        

        return view('sistema.proveedor-nuevo', compact('msg', 'proveedor', 'titulo')) . '?id=' . $proveedor->idproveedor;

    }


  public function cargarGrilla(Request $request)
    {
        $request = $_REQUEST;

        $entidad = new Proveedor();
        $aproveedor = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aproveedor) && $cont < $registros_por_pagina; $i++) {
            $row = array();
        	 $row[] =  " <a href='/admin/cliente/ " .$aproveedor[$i]->idproveedor ." '> ".  $aproveedor[$i]->nombre . "</a>" ;
		 $row[] = $aproveedor[$i]->domicilio;			
            $row[] = $aproveedor[$i]->cuit;
            
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aproveedor), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aproveedor), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

}
