<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sucursal;

class ControladorWebHome extends Controller
{
    public function index()
    {
		
		$sucursal = new Sucursal();
            return view("web.index", compact("sucursal"));
    }
public function guardar(Request $request)
	{
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
				return view("web.index", compact("titulo"));
			}
		} catch (\Exception $e) {
			$msg["ESTADO"] = MSG_ERROR;
			$msg["MSG"] = ERRORINSERT;
		}

		$id = $entidad->idsucursal;
		$sucursal = new Sucursal();
		$sucursal->obtenerPorId($id);

		return view('.web.inddex', compact('msg', 'sucursal', 'titulo'));
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

	public function editar($idSucursal)
	{
		$titulo = "Edicion de Sucursal";
		$sucursal = new Sucursal();
		$sucursal->obtenerPorId($idSucursal);
		return view("web.index", compact("titulo", "sucursal"));
	}
	public function eliminar(Request $request)
{
    $idSucursal = $request->input("id");
    $sucursal = new Sucursal();

    if ($sucursal->existeSucursursalPorCliente($idSucursal)) {
        // Aquí podrías agregar la lógica para eliminar la sucursal
        // Ejemplo: $sucursal->eliminarSucursal($idSucursal);

        // Simulación de eliminación
        // Se supone que existe un método eliminarSucursal en la clase Sucursal
        // Y este método realiza la operación de eliminación en la base de datos
        $sucursal->eliminarSucursal($idSucursal);
	$sucursal->idsucursal = $idSucursal;
	$sucursal->eliminar();
        $resultado["err"] = EXIT_SUCCESS;
        $resultado["mensaje"] = "Registro eliminado exitosamente";
    } else {
        $resultado["err"] = EXIT_FAILURE;
        $resultado["mensaje"] = "No se encontró la sucursal";
    }

    return json_encode($resultado);
}

}
