<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Categoria;
use App\Entidades\Producto;
use App\Entidades\Sistema\Usuario;
use App\Entidades\TipoProducto;
use App\Entidades\Sistema\Patente;


require app_path() . '/start/constants.php';


class ControladorCategoria extends controller
{
	public function nuevo()
	{
		$titulo = "Nueva Categoria";
		$categoria = new Categoria();
		return view("sistema.categoria-nuevo", compact("titulo", "categoria"));
	}

	public function index()
	{
		$titulo = "Listado de categorias";
		return view("sistema.categoria-listar", compact("titulo"));
	}


	public function guardar(Request $request)
	{
		try {
			//Define la entidad servicio
			$titulo = "Modificar categoria";
			$entidad = new categoria();
			$entidad->cargarDesdeRequest($request);

			//validaciones
			if ($entidad->nombre == "") {
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

				$_POST["id"] = $entidad->idcategoria;
				return view('sistema.categoria-listar', compact('titulo', 'msg'));
			}
		} catch (Exception $e) {
			$msg["ESTADO"] = MSG_ERROR;
			$msg["MSG"] = ERRORINSERT;
		}

		$id = $entidad->idcategoria;
		$categoria = new Categoria();
		$categoria->obtenerPorId($id);



		return view('sistema.categoria-nuevo', compact('msg', 'categoria', 'titulo')) . '?id=' . $categoria->idcategoria;
	}


	public function cargarGrilla(Request $request)
	{
		$request = $_REQUEST;

		$entidad = new categoria();
		$categoria = $entidad->obtenerFiltrado();

		$data = array();
		$cont = 0;

		$inicio = $request['start'];
		$registros_por_pagina = $request['length'];


		for ($i = $inicio; $i < count($categoria) && $cont < $registros_por_pagina; $i++) {
			$row = array();
			$row[] =  " <a href='/admin/categoria/ " . $categoria[$i]->idcategoria . " '> " .  $categoria[$i]->nombre . "</a>";
			$cont++;
			$data[] = $row;
		}

		$json_data = array(
			"draw" => intval($request['draw']),
			"recordsTotal" => count($categoria), //cantidad total de registros sin paginar
			"recordsFiltered" => count($categoria), //cantidad total de registros en la paginacion
			"data" => $data,
		);
		return json_encode($json_data);
	}
	public function editar($idCategoria)
	{
		$titulo = "Edicion de Categoria";
		$categoria = new Categoria();
		$categoria->obtenerPorId($idCategoria);
		return view("sistema.categoria-nuevo", compact("titulo", "categoria"));
	}
	public function eliminar(Request $request)
	{
		if (Usuario::autenticado()) {
			if (!Patente::autorizarOperacion("MENUCONSULTA")) {
				$resultado["err"] = EXIT_FAILURE;
				$resultado["mensaje"] = "No tiene permiso para ejecutar la operacion";
			} else {
				$idCategoria = $request->input("id");
				$producto = new Producto();

				// Si la categoria tiene un producto asociado no se tiene que poder eliminar
				if ($producto->existeProductoCategoria($idCategoria)) {
					$resultado["err"] = EXIT_FAILURE;
					$resultado["mensaje"] = "No se puede eliminar una categoria con un producto asociado";
				} else {
					//sino si
					$categoria = new TipoProducto();
					$categoria->idtipoproducto = $idCategoria;
					$categoria->eliminar();
					$resultado["err"] = EXIT_SUCCESS;
					$resultado["mensaje"] = "Categoría eliminada correctamente";
				}
				
			}
			return json_encode($resultado);
		}
	}
}
