<?php

namespace App\Entidades\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;


class Sucursal extends Model
{
 protected $table = 'sucursales';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla idsucursal en la base de datos
        'idsucursal',
	  'nombre',
	  'direccion',
	  'telefono'
    ];

    protected $hidden = [

    ];
        public function obtenerTodos()
    {
        $sql = "SELECT
                 idsucursal,
		     nombre,
		     direccion,
		     telefono,
                FROM sucursales A ORDER BY idsucursal ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

     public function obtenerPorId($idsucursal)
    {
        $sql = "SELECT
                idsucursal,
                nombre,
                direccion,
                telefono
                FROM sucursales WHERE idsucursal = $idsucursal";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idsucursal = $lstRetorno[0]->idsucursal;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->direccion = $lstRetorno[0]->direccion;
		 $this->telefono = $lstRetorno[0]->telefono;
        
            return $this;
        }
        return null;
    }

        public function guardar() {
        $sql = "UPDATE sucursales SET
            idsucursal='$this->idicliente',
            nombre='$this->nombre',
            telefono=$this->telefono,
            direccion='$this->direccion',
            dni='$this->dni',
            clave='$this->clave'
            WHERE idsucursal=?";
        $affected = DB::update($sql, [$this->idsucursal]);
    }

       public function eliminar()
    {
        $sql = "DELETE FROM sucursales WHERE
            idsucursal=?";
        $affected = DB::delete($sql, [$this->idsucursal]);
    }

     public function insertar()
    {
        $sql = "INSERT INTO sucursales (
               idsucursal,
                nombre,
                telefono,
                direccion,
                dni,
                clave
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->idsucursal,
            $this->nombre,
            $this->telefono,
            $this->direccion,
            $this->dni,
            $this->clave,
        ]);
        return $this->idsucursal = DB::getPdo()->lastInsertId();
    }

    

}
?>