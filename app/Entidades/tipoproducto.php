<?php

namespace App\Entidades\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;


class Tipoproducto extends Model
{
 protected $table = 'tipoproductos';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla tipoproductos en la base de datos
        'idtipoproducto',
	  'nombre',

    ];

    protected $hidden = [

    ];
        public function obtenerTodos()
    {
        $sql = "SELECT
                 idtipoproducto,
		     nombre
                FROM tipoproductos A ORDER BY idtipoproducto ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

     public function obtenerPorId($idtipoproducto)
    {
        $sql = "SELECT
                idtipoproducto,
                nombre
                FROM tipoproductos WHERE idtipoproducto = $idtipoproducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idtipoproducto = $lstRetorno[0]->idtipoproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }

        public function guardar() {
        $sql = "UPDATE tipoproductos SET
            idtipoproducto='$this->idicliente',
            nombre='$this->nombre',
            WHERE idtipoproducto=?";
        $affected = DB::update($sql, [$this->idtipoproducto]);
    }

       public function eliminar()
    {
        $sql = "DELETE FROM tipoproductos WHERE
            idtipoproducto=?";
        $affected = DB::delete($sql, [$this->idtipoproducto]);
    }

     public function insertar()
    {
        $sql = "INSERT INTO tipoproductos (
               idtipoproducto,
                nombre,
           
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->idtipoproducto,
            $this->nombre,
            
        ]);
        return $this->idtipoproducto = DB::getPdo()->lastInsertId();
    }

    

}
?>