<?php

namespace App\Entidades\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;


class Venta extends Model
{
 protected $table = 'ventas';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla ventas en la base de datos
        'idventa',
	  'fk_cliente',
	  'fk_producto',
	  'fecha',
	  'precio',
	  'cantidad'
    ];

    protected $hidden = [

    ];
        public function obtenerTodos()
    {
        $sql = "SELECT
            'idventa',
		  'fk_cliente',
		  'fk_producto',
		  'fecha',
		  'precio',
	  	  'cantidad'
                FROM ventas A ORDER BY idventa ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

     public function obtenerPorId($idventa)
    {
        $sql = "SELECT
         'idventa',
	  'fk_cliente',
	  'fk_producto',
	  'fecha',
	  'precio',
	  'cantidad'
                FROM ventas WHERE idventa = $idventa";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idventa = $lstRetorno[0]->idventa;
            $this->fk_cliente = $lstRetorno[0]->fk_cliente;
            $this->fk_producto = $lstRetorno[0]->fk_producto;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->precio = $lstRetorno[0]->precio;
            $this->cantidad = $lstRetorno[0]->cantidad;
         
            return $this;
        }
        return null;
    }

        public function guardar() {
        $sql = "UPDATE ventas SET
            idventa='$this->idicliente',
            nombre='$this->nombre',
            telefono=$this->telefono,
            direccion='$this->direccion',
            dni='$this->dni',
            clave='$this->clave'
            WHERE idventa=?";
        $affected = DB::update($sql, [$this->idventa]);
    }

       public function eliminar()
    {
        $sql = "DELETE FROM ventas WHERE
            idventa=?";
        $affected = DB::delete($sql, [$this->idventa]);
    }

     public function insertar()
    {
        $sql = "INSERT INTO ventas (
               idventa,
                nombre,
                telefono,
                direccion,
                dni,
                clave
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->idventa,
            $this->nombre,
            $this->telefono,
            $this->direccion,
            $this->dni,
            $this->clave,
        ]);
        return $this->idventa = DB::getPdo()->lastInsertId();
    }

    

}
?>