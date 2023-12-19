<?php

namespace App\Http\Controllers;



class ControladorWebTakeway extends Controller
{
    public function index()
    {
            return view("web.takeway");
    }
}