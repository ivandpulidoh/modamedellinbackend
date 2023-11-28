<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Proveedor;
use App\Entidades\Rubro;

class ControladorProveedor extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo proveedor";
        $rubro = new Rubro();
        $aRubros = $rubro->obtenerTodos();

        return view("sistema.proveedor-nuevo", compact("titulo", "aRubros"));
    }

    public function index()
    {
        $titulo = "Listado de Proveedores";
        return view("sistema.proveedor-listar", compact("titulo"));
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
            $row[] = "<a href='/admin/Proveedor/" . $proveedor->idproveedor . "'>" . $proveedor->nombre . "</a>";
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
}
