<?php

namespace App\Entidades\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;



class Carrito extends Model{
	 protected $table = 'carritos';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla clientes en la base de datos
        'idcarrito',
	  'fk_cliente',
	  'fk_producto'
	  
    ];

    protected $hidden = [

    ];

      public function obtenerTodos()
    {
        $sql = "SELECT
                 idcarrito,
		     fk_cliente,
		     fk_producto 
                FROM carritos A ORDER BY idcarrito ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

     public function obtenerPorId($idcarrito)
    {
        $sql = "SELECT
                idcarrito,
                fk_cliente,
                fk_producto
                FROM clientes WHERE idcliente = $idcarrito";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcarrito = $lstRetorno[0]->idcarrito;
            $this->fk_cliente = $lstRetorno[0]->fk_cliente;
            $this->fk_producto = $lstRetorno[0]->fk_producto;
            return $this;
        }
        return null;
    }

       public function guardar() {
        $sql = "UPDATE carritos SET
            idcarrito='$this->idcarrito',
            fk_cliente='$this->fk_cliente',
            fk_producto=$this->fk_producto,
            WHERE idcarrito=?";
        $affected = DB::update($sql, [$this->idcarrito]);
    }

          public function eliminar()
    {
        $sql = "DELETE FROM carritos WHERE
            idcarrito=?";
        $affected = DB::delete($sql, [$this->idcarrito]);
    }


     public function insertar()
    {
        $sql = "INSERT INTO carritos (
               idcarrito,
                fk_cliente,
                fk_producto
            ) VALUES (?, ?, ?);";
        $result = DB::insert($sql, [
            $this->idcarrito,
            $this->fk_cliente,
            $this->fk_producto
            
        ]);
        return $this->idcarrito = DB::getPdo()->lastInsertId();
    }


}

?>