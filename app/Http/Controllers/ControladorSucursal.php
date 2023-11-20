<?php


namespace App\Http\Controllers;

class ControladorSucursal extends Controller
{
	public function nuevo()
	{
		$titulo = "Nuevo Sucursal";
		
		return view("sistema.sucursal-nuevo", compact("titulo"));
	}
}
