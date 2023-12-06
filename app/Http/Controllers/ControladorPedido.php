<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\pedido;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
require app_path().'/start/constants.php';


class ControladorPedido extends Controller
{
	public function nuevo()
	{
	$titulo = "Nuevo pedido";
	$pedido = new Pedido(); // Asumiendo que 'Pedido' es la clase de los pedidos
	$sucursal = new Sucursal();
	$aCategorias = $sucursal->obtenerTodos();
	$cliente = new Cliente();
	$aClientes = $cliente->obtenerTodos();
	return view("sistema.pedido-nuevo", compact("titulo", "pedido", "aCategorias", "aClientes"));
	}

	public function index(){
		$titulo = "Listado de pedidos";
		   $pedido = new pedido();
		return view ("sistema.pedido-listar", compact("titulo","pedido"));
	}

	    public function guardar(Request $request) 
{
        try 
{
            //Define la entidad servicio
            $titulo = "Modificar pedido";
            $entidad = new pedido;
		$categoria = new Sucursal();
 	     $aCategorias = $categoria->obtenerTodos();
		$cliente = new Sucursal();
		$aClientes = $cliente->obtenerTodos();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->fecha == ""   )  {
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
			$pedido = new pedido();
			$categoria = new Sucursal();
 	    		 $aCategorias = $categoria->obtenerTodos();
			$cliente = new Cliente();
	$aClientes = $cliente->obtenerTodos();
                return view('sistema.pedido-listar', compact('titulo', 'msg','aCategorias','aClientes'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idpedido;
        $pedido = new pedido();
        $pedido->obtenerPorId($id);
	$categoria = new Sucursal();
	$aCategorias = $categoria->obtenerTodos();
	$cliente = new Cliente();
	$aClientes = $cliente->obtenerTodos();
        

        return view('sistema.pedido-nuevo', compact('msg', 'pedido', 'titulo','aClientes','aCategorias')) . '?id=' . $pedido->idpedido;

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
            $row[] = $apedido[$i]->fk_idsucursal;
		$row[] = $apedido[$i]->fk_idcliente;
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

 		public function editar($idPedido){
		$titulo = "Edicion de Pedido";
		$pedido = new pedido();
		$pedido->obtenerPorId($idPedido);
		$categoria = new Sucursal();
		$aCategorias = $categoria->obtenerTodos();
		$cliente = new Cliente();
		$aClientes = $cliente->obtenerTodos();
		return view("sistema.pedido-nuevo", compact("titulo","pedido","aCategorias","aClientes"));

}

	

}


