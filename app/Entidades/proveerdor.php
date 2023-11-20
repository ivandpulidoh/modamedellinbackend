<?php

namespace App\Entidades\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;


class Proveedor extends Model
{
	protected $table = 'proveedores';
	public $timestamps = false; //insertar una marcas de tiempo osea fecha y hora

	protected $fillable = [ //son los campos de la tabla proveedores en la base de datos
		'idproveedor',
		'nombre',
		'domicilio',
		'cuit',
		'fk_idrubro'
	];

	protected $hidden = [];
	public function obtenerTodos()
	{
		$sql = "SELECT
      'idproveedor',
	  'nombre',
	  'domicilio',
	  'cuit',
	  'fk_idrubro'
                FROM proveedores A ORDER BY idproveedor ASC";
		$lstRetorno = DB::select($sql);
		return $lstRetorno;
	}

	public function obtenerPorId($idproveedor)
	{
		$sql = "SELECT
        'idproveedor',
	  'nombre',
	  'domicilio',
	  'cuit',
	  'fk_idrubro'
                FROM proveedores WHERE idproveedor = $idproveedor";
		$lstRetorno = DB::select($sql);

		if (count($lstRetorno) > 0) {
			$this->idproveedor = $lstRetorno[0]->idproveedor;
			$this->nombre = $lstRetorno[0]->nombre;
			$this->domicilio = $lstRetorno[0]->domicilio;
			$this->cuit = $lstRetorno[0]->cuit;
			$this->fk_idrubro = $lstRetorno[0]->fk_idrubro;
			
			return $this;
		}
		return null;
	}

	public function guardar()
	{
		$sql = "UPDATE proveedores SET
            idproveedor='$this->idproveedor',
            nombre='$this->nombre',
            domicilio=$this->domicilio,
            cuit='$this->cuit',
            fk_idrubro='$this->fk_idrubro',
            clave='$this->clave'
            WHERE idproveedor=?";
		$affected = DB::update($sql, [$this->idproveedor]);
	}

	public function eliminar()
	{
		$sql = "DELETE FROM proveedores WHERE
            idproveedor=?";
		$affected = DB::delete($sql, [$this->idproveedor]);
	}

	public function insertar()
	{
		$sql = "INSERT INTO proveedores (
                'idproveedor',
	  'nombre',
	  'domicilio',
	  'cuit',
	  'fk_idrubro'
            ) VALUES (?, ?, ?, ?, ?,?);";
		$result = DB::insert($sql, [
			$this->idproveedor,
			$this->nombre,
			$this->domicilio,
			$this->cuit,
			$this->fk_idrubro,
			
		]);
		return $this->idproveedor = DB::getPdo()->lastInsertId();
	}
}
