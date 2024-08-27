<?php

namespace App\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;


class Pedido extends Model
{
	protected $table = 'pedidos';
	public $timestamps = false; //insertar una marcas de tiempo osea fecha y hora

	protected $fillable = [ //son los campos de la tabla pedidos en la base de datos
		'idpedido',
		'fecha',
		'fk_idsucursal',
		'fk_idcliente',
		'fk_idestadoPedido',
		'precio ',
		'pago'
	];

	protected $hidden = [];

	public function cargarDesdeRequest($request)
	{
		$this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
		$this->fecha = $request->input('txtFecha');
		$this->fk_idsucursal = $request->input('txtSucursal');
		$this->fk_idcliente = $request->input('txtCliente');
		$this->fk_idestadoPedido = $request->input('txtEstadoPedido');
		$this->precio = $request->input('txtPrecio');
		$this->pago = $request->input('txtPago');
	}

	public function obtenerTodos()
	{
		$sql = "SELECT
                idpedido,
                fecha,
                fk_idsucursal,
                fk_idcliente,
                fk_idestadoPedido,
                precio,
		    pago
            FROM pedidos A ORDER BY idpedido ASC";
		$lstRetorno = DB::select($sql);
		return $lstRetorno;
	}

	public function obtenerPorId($idCliente)
	{
		$sql = "SELECT
                idpedido,
                fecha,
                fk_idsucursal,
                fk_idcliente,
                fk_idestadoPedido,
                precio,
		    pago
            FROM pedidos WHERE idpedido = :idpedido";
		$lstRetorno = DB::select($sql, ['idpedido' => $idCliente]);

		if (count($lstRetorno) > 0) {
			$this->idpedido = $lstRetorno[0]->idpedido;
			$this->fecha = $lstRetorno[0]->fecha;
			$this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
			$this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
			$this->fk_idestadoPedido = $lstRetorno[0]->fk_idestadoPedido;
			$this->precio = $lstRetorno[0]->precio;
			$this->pago = $lstRetorno[0]->pago;

			return $this;
		}
		return null;
	}
	public function guardar()
	{
		$sql = "UPDATE pedidos SET
            fk_idcliente = $this->fk_idcliente,
            fk_idsucursal = $this->fk_idsucursal,
            fk_idestadoPedido = $this->fk_idestadoPedido,
            fecha ='$this->fecha',
            precio = '$this->precio',
            pago ='$this->pago'
            WHERE idpedido = ?";

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
                    fecha,
                    fk_idsucursal,
                    fk_idcliente,
                    fk_idestadoPedido,
                    precio,
			  pago
                ) VALUES (?, ?, ?, ?, ?, ?);";

		$result = DB::insert($sql, [
			$this->fecha,
			$this->fk_idsucursal,
			$this->fk_idcliente,
			$this->fk_idestadoPedido,
			$this->precio,
			$this->pago
		]);

		return $this->idpedido = DB::getPdo()->lastInsertId();
	}



	public function obtenerFiltrado()
	{
		$request = $_REQUEST;
		$columns = array(
			0 => 'fecha',
			1 => 'fk_idsucursal',
			2 => 'fk_idcliente',
			3 => 'fk_idestadoPedido',
			4 => 'pago',
		);
		$sql = "SELECT DISTINCT
		A.idpedido,
		A.fecha,
		A.precio,
		A.pago,
		A.fk_idsucursal,
		A.fk_idcliente,
		A.fk_idestadoPedido,
		B.nombre AS sucursal,
		C.nombre AS cliente,
		D.nombre AS estadopedido
		FROM pedidos A
		INNER JOIN sucursales B ON A.fk_idsucursal = B.idsucursal
		INNER JOIN clientes C ON A.fk_idcliente = C.idcliente
		INNER JOIN estado_pedidos D ON A.fk_idestadoPedido = D.idestadopedido
		WHERE 1=1

                ";

		//Realiza el filtrado
		if (!empty($request['search']['value'])) {
			$sql .= " OR fecha LIKE '%" . $request['search']['value'] . "%' ";
			$sql .= " OR fk_idsucursal LIKE '%" . $request['search']['value'] . "%' ";
			$sql .= " OR fk_idcliente LIKE '%" . $request['search']['value'] . "%' ";
			$sql .= " OR fk_idestadoPedido LIKE '%" . $request['search']['value'] . "%' )";
			$sql .= " OR precio LIKE '%" . $request['search']['value'] . "%' )";	
		}
		$sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

		$lstRetorno = DB::select($sql);

		return $lstRetorno;
	}
	public function existePedidosPorCliente($idCliente)
	{
		$sql = "SELECT
                idpedido,
                fecha,
                fk_idsucursal,
                fk_idcliente,
                fk_idestadoPedido,
                precio,
		    pago
            FROM pedidos WHERE fk_idcliente =  $idCliente";
		$lstRetorno = DB::select($sql,);
		return (count($lstRetorno) > 0);
	}

	public function existePedidosPorProducto($idProducto)
	{
		$sql = "SELECT
                idpedidoproducto,
                fk_idproducto,
                fk_pedido,
		    pago
            FROM pedido_productos WHERE fk_idproducto =  $idProducto";
		$lstRetorno = DB::select($sql,);
		return (count($lstRetorno) > 0);
	}

	public function existePedidosPorPedido($idPedido)
	{
		$sql = "SELECT DISTINCT
                    P.idpedido,
                    P.fecha,
                    P.precio,
			  P.pago,
                    fk_idsucursal,
                    fk_idcliente,
                    fk_idestadoPedido
                FROM pedidos P
                JOIN sucursales S 
                ON P.fk_idsucursal = S.idsucursal 
                JOIN clientes C
                ON P.fk_idcliente = C.idcliente
   
                WHERE 1=1
                ";

		$lstRetorno = DB::select($sql);
		return (count($lstRetorno) > 0);
	}
	public function existePedidosPorProveedor($idrubro)
	{

		$sql = "SELECT
                idproveedor,
                nombre,
                domicilio,
                cuit,
                fk_idrubro
            FROM proveedores WHERE fk_idrubro =  $idrubro";
		$lstRetorno = DB::select($sql,);
		return (count($lstRetorno) > 0);
	}
	public function obtenerPedidosPorCliente($idCliente)
{
    $sql = "SELECT
               A.idpedido,
               A.fecha,
               A.fk_idsucursal,
               A.fk_idcliente,
               A.fk_idestadoPedido,
               A.precio,
               A.pago,
                B.nombre AS sucursal,
              C.nombre AS estatadopedido
           FROM pedidos A
           INNER JOIN sucursales B ON A.fk_idsucursal = B.idsucursal
           INNER JOIN estado_pedidos C ON A.fk_idestadoPedido = C.idestadopedido
           WHERE fk_idcliente = :idCliente AND A.fk_idestadoPedido <> 3";

    $resultados = DB::select($sql, ['idCliente' => $idCliente]);

    return $resultados;
}

}
