<?php


namespace App\Http\Controllers;

class controladorPostulacion extends Controller
{
	public function nuevo()
	{
		$titulo = "Nueva postulacion";
		
		return view("sistema.postulacion-nuevo", compact("titulo"));
	}
}