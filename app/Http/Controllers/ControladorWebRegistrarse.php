<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ControladorWebRegistrarse extends Controller
{
    const MSG_ERROR = "error"; // Define la constante MSG_ERROR

    public function index()
    {
        $sucursal = new Sucursal;
        $aSucursales = $sucursal->obtenerTodos();
        return view("web.registrarse", compact("aSucursales"));
    }

    public function registrarse(Request $request)
    {
        $titulo = "Nuevo Registro";
        $entidad = new Cliente();
        $entidad->nombre = $request->input("txtNombre");
        $entidad->clave = password_hash($request->input("txtClave"), PASSWORD_DEFAULT);
        $entidad->direccion = $request->input("txtDireccion");
        $entidad->telefono = $request->input("txtTelefono");
	  $entidad->dni = $request->input("txtDni");
        $entidad->correo = $request->input("txtCorreo");

        $sucursal = new Sucursal;
        $aSucursales = $sucursal->obtenerTodos();

        if ($entidad->nombre == "" || $entidad->telefono == "" || $entidad->direccion == "") {
            $msg["ESTADO"] =  MSG_ERROR;
            $msg["MSG"] = "Complete todos los datos";
            return view("web.registrarse", compact('titulo', 'msg', 'aSucursales'));
        } else {
		$entidad->insertar();
           return redirect("/login");
        }
    }
}
