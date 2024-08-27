<?php

namespace App\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;

class EstadoPedido extends Model
{

protected $table = 'estado_pedidos';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla clientes en la base de datos
        'idestadopedido',
	  'nombre' 
    ];

    protected $hidden = [
   ];
    public function obtenerTodos()
    {
        $sql = "SELECT
                 idestadopedido,
		     nombre
                FROM estado_pedidos A ORDER BY idestadopedido ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

 public function obtenerPorId($idcliente)
    {
        $sql = "SELECT
                idestadopedido,
                nombre
                FROM estado_pedidos WHERE idestadopedido = $idcliente";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idestadopedido = $lstRetorno[0]->idestadopedido;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }

     public function guardar() {
        $sql = "UPDATE estado_pedidos SET
            idestadopedido='$this->idestadopedido',
            nombre='$this->nombre'
            WHERE idestadopedido=?";
        $affected = DB::update($sql, [$this->idestadopedido]);
    }

     public function eliminar()
    {
        $sql = "DELETE FROM estado_pedidos WHERE
            idestadopedido=?";
        $affected = DB::delete($sql, [$this->idestadopedido]);
    }

  public function insertar()
    {
        $sql = "INSERT INTO estado_pedidos (
               idestadopedido,
                nombre,
              +
            ) VALUES (?, ?);";
        $result = DB::insert($sql, [
            $this->idestadopedido,
            $this->nombre,
        
        ]);
        return $this->idestadopedido = DB::getPdo()->lastInsertId();
    }



}



?>