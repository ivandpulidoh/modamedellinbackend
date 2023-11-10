<?php
namespace App\Entidades\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model{
 protected $table = 'pedidos';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla clientes en la base de datos
        'idpedido',
	  'fk_cliente',
	  'fk_sucursal',
	  'estado'
    ];

    protected $hidden = [

    ];


    public function obtenerTodos()
    {
        $sql = "SELECT
                 idpedido,
		     fk_cliente,
		     fk_sucursal,
		     estado
                FROM pedidos A ORDER BY idpedidos ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

 public function obtenerPorId($idpedido)
    {
        $sql = "SELECT
                idpedido,
                fk_cliente,
                fk_sucursal,
                estado
                FROM clientes WHERE idcliente = $idpedido";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->fk_cliente = $lstRetorno[0]->fk_cliente;
            $this->fk_sucursal = $lstRetorno[0]->fk_sucursal;
            $this->estado = $lstRetorno[0]->estado;
            return $this;
        }
        return null;
    }

        public function guardar() {
        $sql = "UPDATE pedidos SET
            idpedido='$this->idpedido',
            fk_cliente='$this->fk_cliente',
            fk_sucursal=$this->fk_sucursal,
            estado='$this->estado',
            
            WHERE idpedido=?";
        $affected = DB::update($sql, [$this->idpedido]);
    }

     public function eliminar()
    {
        $sql = "DELETE FROM pedidos WHERE
            idpedido=?";
        $affected = DB::delete($sql, [$this->idpedido]);
    }

 public function insertar()
    {
        $sql = "INSERT INTO pedidos (
               idpedido,
                fk_cliente,
                fk_sucursal,
                estado
            ) VALUES (?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->idpedido,
            $this->fk_cliente,
            $this->fk_sucursal,
            $this->estado,
        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    }

    
}
?>