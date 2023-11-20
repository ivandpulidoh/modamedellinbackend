<?php


namespace App\Http\Controllers;

class controladorRubro extends Controller
{
	public function nuevo()
	{
		$titulo = "Nuevo rubro";
		
		return view("sistema.rubro-nuevo", compact("titulo"));
	}
}