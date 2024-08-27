<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class PedidoProducto extends Model
{
    protected $table = 'PedidoProductos';
    public $timestamps = false; // No insertar marcas de tiempo

    protected $fillable = [
        'idpedidoproducto',
        'fk_idproducto',
        'fk_pedido',
	  'cantidad'
    ];

    protected $hidden = [];

    public function cargarDesdeRequest($request)
    {
        $this->idpedidoproducto = $request->input('id') != "0" ? $request->input('id') : $this->idpedidoproducto;
        $this->fk_idproducto = $request->input('txtProducto');
        $this->fk_pedido = $request->input('txtPedido');
	    $this->fk_pedido = $request->input('txtCantidad');
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                idpedidoproducto,
                fk_idproducto,
                fk_pedido,
		    cantidad
            FROM PedidoProductos ORDER BY idpedidoproducto ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

public function obtenerPorPedido($idPedido)
{

    $sql = "SELECT
         A.idpedidoproducto,
         A.fk_idproducto,
         A.fk_pedido,  
         B.cantidad,
         B.nombre,
         B.imagen
        FROM PedidoProductos A
    INNER JOIN productos B ON A.fk_idproducto = B.idproducto
    WHERE A.fk_pedido = $idPedido
    ORDER BY idpedidoproducto ASC";
    
    $lstRetorno = DB::select($sql);
    return $lstRetorno;


}


    public function obtenerPorId($idpedidoproducto)
    {
        $sql = "SELECT
                idpedidoproducto,
                fk_idproducto,
                fk_pedido,
		    cantidad
            FROM PedidoProductos WHERE idpedidoproducto = :idpedidoproducto";
        $lstRetorno = DB::select($sql, ['idpedidoproducto' => $idpedidoproducto]);

        if (count($lstRetorno) > 0) {
            $this->idpedidoproducto = $lstRetorno[0]->idpedidoproducto;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            $this->fk_pedido = $lstRetorno[0]->fk_pedido;
	      $this->cantidad = $lstRetorno[0]->cantidad;

            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE PedidoProductos SET
                fk_idproducto = ?,
                fk_pedido = ?,
		    cantidad
            WHERE idpedidoproducto = ?";

        $affected = DB::update($sql, [
            $this->fk_idproducto,
            $this->fk_pedido,
            $this->idpedidoproducto.
		 $this->cantidad
        ]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM PedidoProductos WHERE
            idpedidoproducto=?";
        $affected = DB::delete($sql, [$this->idpedidoproducto]);
    }

    public function insertar()
    {
        try {
            $sql = "INSERT INTO PedidoProductos (
                    fk_idproducto,
                    fk_pedido,
			  cantidad
                ) VALUES (?, ?, ?)";

            $result = DB::insert($sql, [
                $this->fk_idproducto,
                $this->fk_pedido,
		    $this->cantidad
            ]);

            return $this->idpedidoproducto = DB::getPdo()->lastInsertId();
        } catch (\Exception $e) {
            // Manejar el error
            echo "Error al insertar el pedido: " . $e->getMessage();
        }
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'idpedidoproducto',
            1 => 'fk_idproducto',
            2 => 'fk_pedido',
		3 => 'fk_pedido'
        );
        $sql = "SELECT
                idpedidoproducto,
                fk_idproducto,
                fk_pedido,
		    cantidad
            FROM PedidoProductos
            WHERE 1=1";

        // Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( idpedidoproducto LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fk_idproducto LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fk_pedido LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}









