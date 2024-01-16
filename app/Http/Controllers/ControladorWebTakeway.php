<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Categoria;
use App\Entidades\Producto;
use App\Entidades\Sistema\Usuario;
use App\Entidades\TipoProducto;
use App\Entidades\Sistema\Patente;
require app_path().'/start/constants.php';

class ControladorWebTakeway extends Controller
{
    public function index()
    {
    $titulo = "Nueva Categoria";
    $aCategorias = Categoria::all(); // Obtener todas las categorías (asumiendo que 'Categoria' es tu modelo)
    $producto = Producto::first(); // Obtener el primer producto (cambia esta lógica según tus necesidades)
    
    return view("web.takeway", compact('titulo', 'aCategorias', 'producto'));
    }



	

}