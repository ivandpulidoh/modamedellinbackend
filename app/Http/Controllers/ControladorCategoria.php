<?php


namespace App\Http\Controllers;

class controladorCategoria extends Controller
{
	public function nuevo()
	{
		$titulo = "Nueva Categoria";
		
		return view("sistema.categoria-nuevo", compact("titulo"));
	}
}
