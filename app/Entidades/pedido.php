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
		'estadoPedido',
		'precio '
	];

	protected $hidden = [];

	public function cargarDesdeRequest($request)
	{
		$this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
		$this->fecha = $request->input('txtFecha');
		$this->fk_idsucursal = $request->input('txtSucursal');
		$this->fk_idcliente = $request->input('txtCliente');
		$this->estadoPedido = $request->input('txtEstadoPedido');
		$this->precio = $request->input('txtPrecio');
	}

	public function obtenerTodos()
	{
		$sql = "SELECT
                idpedido,
                fecha,
                fk_idsucursal,
                fk_idcliente,
                estadoPedido,
                precio
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
                fecha = ?,
                fk_idsucursal = ?,
                fk_idcliente = ?,
                estadoPedido = ?,
                precio = ?
            WHERE idpedido = ?";

		$affected = DB::update($sql, [
			$this->fecha,
			$this->fk_idsucursal,
			$this->fk_idcliente,
			$this->estadoPedido,
			$this->precio,
			$this->idpedido
		]);
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
                    fk_idsucursal, 
                    fk_idcliente, 
                    estadoPedido,
                    precio
                ) VALUES (?, ?, ?, ?, ?);";

			// Verifica si fk_idsucursal es nulo y, si lo es, asigna un valor por defecto
			$fkIdsucursal = $this->fk_idsucursal ?? 0;

			$result = DB::insert($sql, [
				$this->fecha,
				$this->fk_idsucursal,
				$this->fk_idcliente,
				$this->estadoPedido,
				$this->precio
			]);

			return $this->idpedido = DB::getPdo()->lastInsertId();
		} catch (\Exception $e) {
			// Manejar el error
			echo "Error al insertar el pedido: " . $e->getMessage();
		}
	}



	public function obtenerFiltrado()
	{
		$request = $_REQUEST;
		$columns = array(
			0 => 'P.fecha',
			1 => 'fk_idsucursal',
			2 => 'fk_idcliente',
			3 => 'P.estadoPedido',
		);
		$sql = "SELECT DISTINCT
                    P.idpedido,
                    P.fecha,
                    P.precio,
                    fk_idsucursal,
                    fk_idcliente,
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
	public function existePedidosPorCliente($idCliente)
	{
		$sql = "SELECT
                idpedido,
                fecha,
                fk_idsucursal,
                fk_idcliente,
                estadoPedido,
                precio
            FROM pedidos WHERE fk_idcliente =  $idCliente";
	 	$lstRetorno = DB::select($sql,);
		return (count($lstRetorno) > 0);
	}

	public function existePedidosPorProducto($idProducto)
	{
		$sql = "SELECT
                idpedidoproducto,
                fk_idproducto,
                fk_pedido
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
                    fk_idsucursal,
                    fk_idcliente,
                    estadoPedido
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
public function existePedidosPorProveedor($idrubro){

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

public function existeProductoCategoria($idcategoria){

$sql = "SELECT
                idproducto,
                nombre,
                fk_tipoproducto,
                cantidad,
                precio,
		    descripcion,
		    imagen
            FROM productos WHERE fk_tipoproducto =  $idcategoria";
	 	$lstRetorno = DB::select($sql,);
		return (count($lstRetorno) > 0);

}


}
