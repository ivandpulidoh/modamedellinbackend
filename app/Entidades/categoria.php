<?php

namespace App\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;



class Categoria extends Model{
	 protected $table = 'categorias';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla clientes en la base de datos
        'idcategoria',
	  'nombre'
	 
	  
    ];

    protected $hidden = [

    ];

      public function obtenerTodos()
    {
        $sql = "SELECT
                 idcategoria,
		     nombre,
                FROM categorias A ORDER BY idcategoria ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

     public function obtenerPorId($idcategoria)
    {
        $sql = "SELECT
                idcategoria,
                nombre
                FROM clientes WHERE idcliente = $idcategoria";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcategoria = $lstRetorno[0]->idcategoria;
            $this->nombre = $lstRetorno[0]->nombre;
           ;
            return $this;
        }
        return null;
    }

       public function guardar() {
        $sql = "UPDATE categorias SET
            idcategoria='$this->idcategoria',
            fk_cliente='$this->fk_cliente',
            fk_producto=$this->fk_producto,
            WHERE idcategoria=?";
        $affected = DB::update($sql, [$this->idcategoria]);
    }

          public function eliminar()
    {
        $sql = "DELETE FROM categorias WHERE
            idcategoria=?";
        $affected = DB::delete($sql, [$this->idcategoria]);
    }


     public function insertar()
    {
        $sql = "INSERT INTO categorias (
               idcategoria,
                fk_cliente,
                fk_producto
            ) VALUES (?, ?, ?);";
        $result = DB::insert($sql, [
            $this->idcategoria,
            $this->fk_cliente,
            $this->fk_producto
            
        ]);
        return $this->idcategoria = DB::getPdo()->lastInsertId();
    }


}
