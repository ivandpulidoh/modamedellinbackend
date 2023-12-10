<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;
use Illuminate\Http\Request;
use App\Entidades\Sucursal;
require app_path().'/start/constants.php'; // Asegúrate de que este archivo existe y contiene las constantes necesarias

class ControladorSucursal extends Controller
{
    public function nuevo() {
        $titulo = "Nueva Sucursal";
	     $sucursal = new Sucursal();
     return view("sistema.sucursal-nuevo", compact("titulo", "sucursal"));
    }

    public function index(){
        $titulo = "Listado de Sucursales";
        return view("sistema.sucursal-listar", compact("titulo"));
    }

    public function guardar(Request $request) {
        try {
            $titulo = "Modificar sucursal";
            $entidad = new Sucursal();
            $entidad->cargarDesdeRequest($request);

            if ($entidad->nombre == "" || $entidad->telefono == "" || $entidad->direccion == "" || $entidad->horario == "") {
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
                    $titulo = "Listado de Sucursales";
        return view("sistema.sucursal-listar", compact("titulo"));
            }
        } catch (\Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idsucursal;
        $sucursal = new Sucursal();
        $sucursal->obtenerPorId($id);

        return view('sistema.sucursal-nuevo', compact('msg', 'sucursal', 'titulo'));
    }

    public function cargarGrilla(Request $request) {
        $request = $_REQUEST;

        $entidad = new Sucursal();
        $asucursal = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        for ($i = $inicio; $i < count($asucursal) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = "<a href='/admin/sucursal/" . $asucursal[$i]->idsucursal . "'>" . $asucursal[$i]->nombre . "</a>";
            $row[] = $asucursal[$i]->telefono;
            $row[] = $asucursal[$i]->direccion;
            $row[] = $asucursal[$i]->horario;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($asucursal),
            "recordsFiltered" => count($asucursal),
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function editar($idSucursal){
        $titulo = "Edicion de Sucursal";
        $sucursal = new Sucursal();
        $sucursal->obtenerPorId($idSucursal);
        return view("sistema.sucursal-nuevo", compact("titulo", "sucursal"));
    }
public function eliminar(Request $request){
		$idSucursal  =  $request->input("id");
	     $pedido = new Pedido();
		// si el cliente tiene un pedido asociado no se debo poder eliminar
		if($pedido->existePedidosPorSucursal($idSucursal)){	
		$resultado["err"] = EXIT_FAILURE;	
		$resultado["mensaje"] = "No se puede eliminar un cliente con pedidos asociados";
		}else {   
	//sin o si
	     $sucursal = new Sucursal();
		$sucursal->idsucursal =  $idSucursal;
		$sucursal->eliminar();
		$resultado["err"] = EXIT_SUCCESS;
		$resultado["mensaje"] = "Registro eliminado exitosamente";
			}
		return json_encode($resultado);

		}
	
}

    
