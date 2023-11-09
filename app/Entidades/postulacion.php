<?php

namespace App\Entidades\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;


class Postulacion extends Model{
 protected $table = 'postulaciones';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla clientes en la base de datos
        'idpostulacion',
	  'nombre',
	  'apellido',
	  'whatsapp',
	  'correo'
    ];

    protected $hidden = [

    ];
        public function obtenerTodos()
    {
        $sql = "SELECT
                 idpostulacion,
		     nombre,
		     apellido,
		     whatsapp,
		     correo
                FROM postulaciones A ORDER BY idpostulacion ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
     public function obtenerPorId($idpostulacion)
    {
        $sql = "SELECT
                idpostulacion,
                nombre,
                apellido,
                whatsapp,
                correo
                FROM postulaciones WHERE idpostulacion = $idpostulacion";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpostulacion = $lstRetorno[0]->idpostulacion;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->whatsapp = $lstRetorno[0]->whatsapp;
            $this->correo = $lstRetorno[0]->correo;
            return $this;
        }
        return null;
    }

        public function guardar() {
        $sql = "UPDATE postulaciones SET
            idpostulacion='$this->idpostulacion',
            nombre='$this->nombre',
            apellido=$this->telefono,
            whatsapp='$this->direccion',
            clave='$this->clave'
            WHERE idpostulacion=?";
        $affected = DB::update($sql, [$this->idcliente]);
    }
       public function eliminar()
    {
        $sql = "DELETE FROM postulaciones WHERE
            idpostulacion=?";
        $affected = DB::delete($sql, [$this->idpostulacion]);
    }

 public function insertar()
    {
        $sql = "INSERT INTO postulaciones (
               idpostulacion,
                nombre,
                apellido,
                whatsapp,
                clave
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->idpostulacion,
            $this->nombre,
            $this->apellido,
            $this->whatsapp,
            $this->clave,
        ]);
        return $this->idcliente = DB::getPdo()->lastInsertId();
    }

    

}