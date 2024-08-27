<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
	protected $table = 'sucursales';
	public $timestamps = false;

	protected $fillable = [
		'idsucursal',
		'nombre',
		'telefono',
		'direccion',
		'horario'
	];

	protected $hidden = [];

	public function cargarDesdeRequest($request)
	{
		$this->idsucursal = $request->input('id') != "0" ? $request->input('id') : $this->idsucursal;
		$this->nombre = $request->input('txtNombre');
		$this->telefono = $request->input('txtTelefono');
		$this->direccion = $request->input('txtDireccion');
		$this->horario = $request->input('txtHorario');
	}

	public function obtenerTodos()
	{
		$sql = "SELECT
                    idsucursal,
                    nombre,
                    telefono,
                    direccion,
                    horario
                FROM sucursales
                ORDER BY idsucursal ASC";
		$lstRetorno = DB::select($sql);
		return $lstRetorno;
	}

	public function obtenerPorId($idsucursal)
	{
		$sql = "SELECT
                    idsucursal,
                    nombre,
                    telefono,
                    direccion,
                    horario
                FROM sucursales WHERE idsucursal = ?";
		$lstRetorno = DB::select($sql, [$idsucursal]);

		if (count($lstRetorno) > 0) {
			$this->idsucursal = $lstRetorno[0]->idsucursal;
			$this->nombre = $lstRetorno[0]->nombre;
			$this->telefono = $lstRetorno[0]->telefono;
			$this->direccion = $lstRetorno[0]->direccion;
			$this->horario = $lstRetorno[0]->horario;
			return $this;
		}
		return null;
	}

	public function guardar()
	{
		$sql = "UPDATE sucursales SET
                    nombre=?,
                    telefono=?,
                    direccion=?,
                    horario=?
                WHERE idsucursal=?";
		$affected = DB::update($sql, [
			$this->nombre,
			$this->telefono,
			$this->direccion,
			$this->horario,
			$this->idsucursal
		]);
	}

	public function eliminar()
	{
		$sql = "DELETE FROM sucursales WHERE
                    idsucursal=?";
		$affected = DB::delete($sql, [$this->idsucursal]);
	}

	public function insertar()
	{
		try {
			$sql = "INSERT INTO sucursales (
                        nombre,
                        telefono,
                        direccion,
                        horario
                    ) VALUES (?, ?, ?, ?)";
			$result = DB::insert($sql, [
				$this->nombre,
				$this->telefono,
				$this->direccion,
				$this->horario
			]);
			return $this->idsucursal = DB::getPdo()->lastInsertId();
		} catch (\Exception $e) {
			// Manejar el error
			echo "Error al insertar: " . $e->getMessage();
		}
	}

	public function obtenerFiltrado()
	{
		$request = $_REQUEST;
		$columns = array(
			0 => 'nombre',
			1 => 'telefono',
			2 => 'direccion',
			3 => 'horario',
		);
		$sql = "SELECT
                    idsucursal,
                    nombre,
                    telefono,
                    direccion,
                    horario
                FROM sucursales
                WHERE 1=1";

		// Realiza el filtrado
		if (!empty($request['search']['value'])) {
			$sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
			$sql .= " OR telefono LIKE '%" . $request['search']['value'] . "%' ";
			$sql .= " OR direccion LIKE '%" . $request['search']['value'] . "%' ";
			$sql .= " OR horario LIKE '%" . $request['search']['value'] . "%' )";
		}
		$sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];

		$lstRetorno = DB::select($sql);

		return $lstRetorno;
	}

	public function existeSucursursalPorCliente($idsucursal)
	{
		$sql = "SELECT
                idsucursal,
                nombre,
                direccion,
                telefono,
                horario
            FROM sucursales WHERE idsucursal = ?";

		$lstRetorno = DB::select($sql, [$idsucursal]);
		return (count($lstRetorno) > 0);
	}

	public function eliminarSucursal($idsucursal)
	{
		$sql = "SELECT
                idsucursal,
                nombre,
                direccion,
                telefono,
                horario
            FROM sucursales WHERE idsucursal = ?";

		$lstRetorno = DB::select($sql, [$idsucursal]);
		return (count($lstRetorno) > 0);
	}
}
