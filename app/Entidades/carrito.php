<?php

namespace App\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;



class Carrito extends Model
{
	protected $table = 'carritos';
	public $timestamps = false; //insertar una marcas de tiempo osea fecha y hora

	protected $fillable = [ //son los campos de la tabla clientes en la base de datos
		'idcarrito',
		'fk_idcliente',
		'fk_idproducto'

	];

	protected $hidden = [];
	private $producto;
	private $precio;
	private $cantidad;
	public function obtenerTodos()
	{
		$sql = "SELECT
                 idcarrito,
		     fk_idcliente,
		     fk_idproducto 
                FROM carritos A ORDER BY idcarrito ASC";
		$lstRetorno = DB::select($sql);
		return $lstRetorno;
	}

	public function obtenerPorId($idcarrito)
	{
		$sql = "SELECT
            idcarrito,
            fk_idcliente,
            fk_idproducto
            FROM carritos WHERE idcarrito = ?";

		$lstRetorno = DB::select($sql, [$idcarrito]);

		if (count($lstRetorno) > 0) {
			$this->idcarrito = $lstRetorno[0]->idcarrito;
			$this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
			$this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
			return $this;
		}

		return null;
	}


	public function guardar()
	{
		$sql = "UPDATE carritos SET
            idcarrito='$this->idcarrito',
            fk_idcliente='$this->fk_idcliente',
            fk_idproducto=$this->fk_idproducto,
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
                fk_idcliente,
                fk_idproducto
            ) VALUES (?, ?, ?);";
		$result = DB::insert($sql, [
			$this->idcarrito,
			$this->fk_idcliente,
			$this->fk_idproducto

		]);
		return $this->idcarrito = DB::getPdo()->lastInsertId();
	}

public function obtenerPorCliente($idCliente)
{
    $sql = "SELECT
        A.idcarrito,
        A.fk_idcliente,
        A.fk_idproducto,
        B.nombre AS producto,  -- Update the alias to use 'nombre'
        B.cantidad AS precio,
        B.cantidad AS cantidad
    FROM carritos A
    INNER JOIN productos B ON A.fk_idproducto = B.idproducto
    WHERE A.fk_idcliente = $idCliente";

    $lstRetorno = DB::select($sql);
return $lstRetorno;
   
}


}
