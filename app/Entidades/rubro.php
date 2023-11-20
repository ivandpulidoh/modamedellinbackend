<?php

namespace App\Entidades\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;



class rubro extends Model{
	 protected $table = 'rubros';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla clientes en la base de datos
        'idrubro',
	  'nombre',
	
	  
    ];

    protected $hidden = [

    ];

      public function obtenerTodos()
    {
        $sql = "SELECT
                 idrubro,
		     nombre
		   
                FROM rubros A ORDER BY idrubro ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

     public function obtenerPorId($idrubro)
    {
        $sql = "SELECT
                idrubro,
                nombre
             
                FROM clientes WHERE idcliente = $idrubro";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idrubro = $lstRetorno[0]->idrubro;
            $this->nombre = $lstRetorno[0]->nombre;
            
            return $this;
        }
        return null;
    }

       public function guardar() {
        $sql = "UPDATE rubros SET
            idrubro='$this->idrubro',
            nombre='$this->nombre',
            f
            WHERE idrubro=?";
        $affected = DB::update($sql, [$this->idrubro]);
    }

          public function eliminar()
    {
        $sql = "DELETE FROM rubros WHERE
            idrubro=?";
        $affected = DB::delete($sql, [$this->idrubro]);
    }


     public function insertar()
    {
        $sql = "INSERT INTO rubros (
               idrubro,
                nombre
             
            ) VALUES (?, ?,);";
        $result = DB::insert($sql, [
            $this->idrubro,
            $this->nombre,
       
            
        ]);
        return $this->idrubro = DB::getPdo()->lastInsertId();
    }


}

?>