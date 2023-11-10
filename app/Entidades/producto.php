<?php

namespace App\Entidades\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;


class Producto extends Model
{
 protected $table = 'productos';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla productos en la base de datos
        'idproducto',
	  'nombre',
	  'precio',
	  'direccion',
	  'fk_tipoproducto'
    ];

    protected $hidden = [

    ];
        public function obtenerTodos()
    {
        $sql = "SELECT
                 idproducto,
		     nombre,
		     precio,
		     fk_tipoproducto
		  
                FROM productos A ORDER BY idproducto ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

     public function obtenerPorId($idproducto)
    {
        $sql = "SELECT
                idproducto,
                nombre,
                precio,
                fk_tipoproducto
                FROM productos WHERE idproducto = $idproducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->precio = $lstRetorno[0]->precio;
            $this->fk_tipoproducto = $lstRetorno[0]->fk_tipoproducto;
            return $this;
        }
        return null;
    }

        public function guardar() {
        $sql = "UPDATE productos SET
            idproducto='$this->idicliente',
            nombre='$this->nombre',
            precio=$this->precio,
            fk_tipoproducto='$this->fk_tipoproducto','
            WHERE idproducto=?";
        $affected = DB::update($sql, [$this->idproducto]);
    }

       public function eliminar()
    {
        $sql = "DELETE FROM productos WHERE
            idproducto=?";
        $affected = DB::delete($sql, [$this->idproducto]);
    }

     public function insertar()
    {
        $sql = "INSERT INTO productos (
               idproducto,
                nombre,
                precio,
                fk_tipoproducto
            ) VALUES (?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->idproducto,
            $this->nombre,
            $this->precio,
            $this->fk_tipoproducto,
        ]);
        return $this->idproducto = DB::getPdo()->lastInsertId();
    }

    

}
?>