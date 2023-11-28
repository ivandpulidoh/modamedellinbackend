<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Entidades\pedido;
require app_path().'/start/constants.php';


class controladorpedido extends Controller
{
	public function nuevo()
	{
		  $titulo = "Nuevo pedido";
		return view("sistema.pedido-nuevo", compact("titulo"));
	}

	public function index(){
		$titulo = "Listado de pedidos";
		return view ("sistema.pedido-listar", compact("titulo"));
	}

			    public function guardar(Request $request) 
{
        try {
            //Define la entidad servicio
            $titulo = "Modificar pedido";
            $entidad = new pedido;
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->fecha == "" ||  $entidad->sucursal == ""|| $entidad->cliente == ""|| $entidad->estadoPedido == ""  )  {
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
                return view('sistema.pedido-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idpedido;
        $pedido = new pedido();
        $pedido->obtenerPorId($id);

        

        return view('sistema.pedido-nuevo', compact('msg', 'pedido', 'titulo')) . '?id=' . $pedido->idpedido;

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
        	 $row[] =  " <a href='/admin/pedido/ " .$apedido[$i]->idpedido ." '> ".  $apedido[$i]->fecha . "</a>" ;		
            $row[] = $apedido[$i]->nombre_sucursal;
		$row[] = $apedido[$i]->nombre_cliente;
		$row[] = $apedido[$i]->estadoPedido;
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

}