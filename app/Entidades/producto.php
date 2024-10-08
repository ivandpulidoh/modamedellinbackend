<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
	protected $table = 'productos';
	public $timestamps = false;

	protected $fillable = [
		'idproducto',
		'nombre',
		'fk_tipoproducto',
		'cantidad',
		'precio',
		'descripcion',
		'imagen',
		'tallas',
		'colores',
		'nombre_marca',
		'fecha_descripcion'
	];

	protected $hidden = [];

	public function cargarDesdeRequest($request)
	{
		$this->idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
		$this->nombre = $request->input('txtNombre');
		$this->fk_tipoproducto = $request->input('txtTipoProducto');
		$this->cantidad = $request->input('txtCantidad');
		$this->precio = $request->input('txtPrecio');
		$this->descripcion = $request->input('txtDescripcion');
		$this->imagen = $request->input('archivo');
		$this->tallas = $request->input('txtTallas');
		$this->colores = $request->input('txtColores');
		$this->nombre_marca = $request->input('txtMarca');
		$this->fecha_descripcion = $request->input('txtFechaCreacion');
	}

	public function obtenerTodos()
	{
		$sql = "SELECT
                    A.idproducto,
                    A.nombre,
                   A.fk_tipoproducto,
                    A.cantidad,
                    A.precio,
                    A.descripcion,
                    A.imagen,
			  A.tallas,
                    A.colores,
                    A.nombre_marca,
                    A.fecha_descripcion,
			B.nombre AS categoria		
                FROM productos A
	INNER JOIN tipoproductos B ON A.fk_tipoproducto = B.idtipoproducto
 ORDER BY idproducto ASC";
		$lstRetorno = DB::select($sql);
		return $lstRetorno;
	}

	public function obtenerPorId($idproducto)
	{
		$sql = "SELECT
            idproducto,
            nombre,
            fk_tipoproducto,
            cantidad,
            precio,
            descripcion,
            imagen,
		tallas,
		colores,
		nombre_marca,
		fecha_descripcion
        FROM productos WHERE idproducto = ?";
		$lstRetorno = DB::select($sql, [$idproducto]);

		if (count($lstRetorno) > 0) {
			$this->idproducto = $lstRetorno[0]->idproducto;
			$this->nombre = $lstRetorno[0]->nombre;
			$this->fk_tipoproducto = $lstRetorno[0]->fk_tipoproducto;
			$this->cantidad = $lstRetorno[0]->cantidad;
			$this->precio = $lstRetorno[0]->precio;
			$this->descripcion = $lstRetorno[0]->descripcion;
			$this->imagen = $lstRetorno[0]->imagen;
			$this->tallas = $lstRetorno[0]->tallas;
			$this->colores = $lstRetorno[0]->colores;
			$this->nombre_marca = $lstRetorno[0]->nombre_marca;
			$this->fecha_descripcion = $lstRetorno[0]->fecha_descripcion;
			return $this;
		}
		return null;
	}

	public function guardar()
	{
		$sql = "UPDATE productos SET
                    nombre=?,
                    fk_tipoproducto=?,
                    cantidad=?,
                    precio=?,
                    descripcion=?,
                    imagen=?,
			  colores=?,
			  tallas=?,
			  nombre_marca=?,
			  fecha_descripcion=?
                WHERE idproducto=?";
		$affected = DB::update($sql, [
			$this->nombre,
			$this->fk_tipoproducto,
			$this->cantidad,
			$this->precio,
			$this->descripcion,
			$this->imagen,
			$this->idproducto,
			$this->tallas,
			$this->colores,
			$this->nombre_marca,
			$this->fecha_descripcion
		]);
	}

	public function eliminar()
	{
		$sql = "DELETE FROM productos WHERE
                    idproducto=?";
		$affected = DB::delete($sql, [$this->idproducto]);
	}

	public function insertar()
	{
		try {
			$sql = "INSERT INTO productos (nombre, fk_tipoproducto, cantidad, precio, descripcion, imagen, tallas, colores, nombre_marca, fecha_descripcion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$result = DB::insert($sql, [
				$this->nombre,
				$this->fk_tipoproducto,
				$this->cantidad,
				$this->precio,
				$this->descripcion,
				$this->imagen,
				$this->tallas,
				$this->colores,
				$this->nombre_marca,
				$this->fecha_descripcion
			]);
			return $this->idproducto = DB::getPdo()->lastInsertId();
		} catch (\Exception $e) {
			// Handle the error appropriately
			\Log::error("Error al insertar: " . $e->getMessage());
		}
	}

	public function obtenerFiltrado()
	{
		$request = $_REQUEST;
		$columns = [
			0 => 'nombre',
			1 => 'cantidad',
			2 => 'precio',
			3 => 'descripcion',
			4 => 'imagen',
		];
		$sql = "SELECT
            idproducto,
            nombre,
            fk_tipoproducto,
            cantidad,
            precio,
            descripcion,
            imagen
        FROM productos WHERE 1=1";

		// Filtering
		if (!empty($request['search']['value'])) {
			$sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
			$sql .= " OR cantidad LIKE '%" . $request['search']['value'] . "%' ";
			$sql .= " OR precio LIKE '%" . $request['search']['value'] . "%' ";
			$sql .= " OR descripcion LIKE '%" . $request['search']['value'] . "%' ";
			$sql .= " OR imagen LIKE '%" . $request['search']['value'] . "%' )";
		}
		$sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];

		$lstRetorno = DB::select($sql);

		return $lstRetorno;
	}

	public function existeProductoCategoria($idcategoria)
	{
		$sql = "SELECT
            idproducto,
            nombre,
            fk_tipoproducto,
            cantidad,
            precio,
            descripcion,
            imagen
        FROM productos WHERE fk_tipoproducto = ?";
		$lstRetorno = DB::select($sql, [$idcategoria]);
		return (count($lstRetorno) > 0);
	}
}
