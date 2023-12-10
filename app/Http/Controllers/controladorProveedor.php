<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;
use Illuminate\Http\Request;
use App\Entidades\Proveedor;
use App\Entidades\Rubro;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;

require app_path().'/start/constants.php';
class ControladorProveedor extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo proveedor";
        $rubro = new Rubro();
        $aRubros = $rubro->obtenerTodos();
	$proveedor = new proveedor();

        return view("sistema.proveedor-nuevo", compact("titulo", "aRubros", "proveedor"));
    }

    public function index()
    {
        $titulo = "Listado de Proveedores";
$proveedor = new Proveedor();
        return view("sistema.proveedor-listar", compact("titulo", "proveedor"));
    }

    public function guardar(Request $request)
    {
        try {
            $titulo = "Modificar proveedor";
            $entidad = new Proveedor();
            $entidad->cargarDesdeRequest($request);

            if ($entidad->nombre == "") {
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

                return view('sistema.proveedor-listar', compact('titulo', 'msg'));
            }
        } catch (\Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idproveedor;
        $proveedor = new Proveedor();
        $proveedor->obtenerPorId($id);

        return view('sistema.proveedor-nuevo', compact('msg', 'proveedor', 'titulo'));
    }

    public function cargarGrilla(Request $request)
    {
        $entidad = new Proveedor();
        $aProveedor = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request->input('start');
        $registros_por_pagina = $request->input('length');

        foreach ($aProveedor as $proveedor) {
            $row = array();
            $row[] = "<a href='/admin/proveedor/" . $proveedor->idproveedor . "'>" . $proveedor->nombre . "</a>";
            $row[] = $proveedor->domicilio;
            $row[] = $proveedor->cuit;
            $row[] = $proveedor->fk_idrubro;
            $data[] = $row;

            $cont++;
            if ($cont >= $registros_por_pagina) {
                break;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => count($aProveedor),
            "recordsFiltered" => count($aProveedor),
            "data" => $data,
        );

        return json_encode($json_data);
    }
	public function editar($idProveedor){
		$titulo = "Edicion de Proveedor";
		$proveedor = new proveedor();
		$proveedor->obtenerPorId($idProveedor);
		   $rubro = new Rubro();
		   $aRubros = $rubro->obtenerTodos();

	  return view("sistema.proveedor-nuevo", compact("titulo", "aRubros", "proveedor"));
	
}

		public function eliminar(Request $request){
		if(!Usuario::autenticado()== true){
		if(!Patente::autorizacicon("PROVEDORBAJA")){
			$resultado["err"] = EXIT_FAILURE;
			$resultado["mensaje"] = "No tiene permiso para ejecutar la operacion";
		} else{
			$proveedor = new Proveedor();
			$proveedor->idproveedor = $request->input("id");
			$proveedor->eliminar();
			$resultado["err"] =EXIT_SUCCESS;
			$resultado["mensaje"] = "Registro eliminado exitosamente";
		}
		
	}   else{
			$resultado["err"] = EXIT_FAILURE;
			$resultado["mensaje"]= "Usuario no autenticado";
		}
		return json_encode($resultado);


{			

	}
		}



