<?php


namespace App\Http\Controllers;

class controladorProveedor extends Controller
{
	public function nuevo()
	{
		$titulo = "Nuevo proveedor";
		
		return view("sistema.proveedor-nuevo", compact("titulo"));
	}
}
