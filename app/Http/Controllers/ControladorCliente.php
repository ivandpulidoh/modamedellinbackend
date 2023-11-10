<?php


namespace App\Http\Controllers;

class controladorCliente extends Controller
{
	public function nuevo()
	{
		$titulo = "Nuevo clientes";
		
		return view("sistema.cliente-nuevo", compact("titulo"));
	}
}
