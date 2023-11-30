<?php

namespace App\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;


class Pedido extends Model
{
 protected $table = 'pedidos';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla pedidos en la base de datos
        'idpedido',
	  'fecha',
	  'sucursal',
	  'cliente',
	  'estadoPedido',
	  'precio '
    ];

    protected $hidden = [

    ];

    public function cargarDesdeRequest($request) {
        $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
        $this->fecha = $request->input('txtFecha');
        $this->sucursal = $request->input('txtSucursal');
        $this->cliente = $request->input('txtCliente');
        $this->estadoPedido = $request->input('txtEstadoPedido');
        $this->precio = $request->input('txtPrecio');
      
    }

        public function obtenerTodos()
    {
        $sql = "SELECT
                        'idpedido',
				'fecha',
				'sucursal',
				'cliente',
				'estadoPedido',
				'precio'
                FROM pedidos A ORDER BY idpedido ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

public function obtenerPorId($idpedido)
{
    $sql = "SELECT
                idpedido,
                fecha,
                fk_idsucursal,
                fk_idcliente,
                estadoPedido,
                precio
            FROM pedidos WHERE idpedido = ?";
    $lstRetorno = DB::select($sql, [$idpedido]);

    if (count($lstRetorno) > 0) {
        $this->idpedido = $lstRetorno[0]->idpedido;
        $this->fecha = $lstRetorno[0]->fecha;
        $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
        $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
        $this->estadoPedido = $lstRetorno[0]->estadoPedido;
        $this->precio = $lstRetorno[0]->precio;
      
        return $this;
    }
    return null;
}

        public function guardar()
 {
        $sql = "UPDATE pedidos SET
            idpedido='$this->idpedido',
            fecha='$this->fecha',
            sucursal=$this->sucursal,
            cliente='$this->cliente',
            estadoPedido='$this->estadoPedido'
		precio='$this->precio'
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
    try {
        $sql = "INSERT INTO pedidos (
				fecha,
				sucursal,
				cliente,
				estadoPedido,
				precio
            ) VALUES (?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->fecha,
            $this->sucursal,
            $this->cliente,
            $this->estadoPedido,
            $this->precio
        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    } catch (\Exception $e) {
        // Manejar el error
        echo "Error al insertar: " . $e->getMessage();
    }
}

   public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'P.fecha',
            1 => 'S.nombre',
            2 => 'C.nombre',
            3 => 'P.estadoPedido',
        );
        $sql = "SELECT DISTINCT
                    P.idpedido,
                    P.fecha,
                    P.precio,
                    S.nombre AS nombre_sucursal,
                    C.nombre AS nombre_cliente,
                    estadoPedido
                FROM pedidos P
                JOIN sucursales S 
                ON P.fk_idsucursal = S.idsucursal 
                JOIN clientes C
                ON P.fk_idcliente = C.idcliente
   
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( P.fecha LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR S.nombre LIKE '%" . $request['search']['value'] . "%' ";
		 $sql .= " OR C.nombre LIKE '%" . $request['search']['value'] . "%' ";	
            $sql .= " OR P.estadoPedido LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


}


?>