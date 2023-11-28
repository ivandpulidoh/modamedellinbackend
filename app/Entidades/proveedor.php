<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';
    public $timestamps = false;

    protected $fillable = [
        'idproveedor',
        'nombre',
        'domicilio',
        'cuit',
        'fk_idrubro'
    ];

    protected $hidden = [];

    public function cargarDesdeRequest($request)
    {
        $this->idproveedor = $request->input('id') != "0" ? $request->input('id') : $this->idproveedor;
        $this->nombre = $request->input('txtNombre');
        $this->domicilio = $request->input('txtDomicilio');
        $this->cuit = $request->input('txtCuit');
        $this->fk_idrubro = $request->input('txtRubro');
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                    idproveedor,
                    nombre,
                    domicilio,
                    cuit,
                    fk_idrubro
                FROM proveedores A ORDER BY idproveedor ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

   public function obtenerPorId($idproveedor)
{
    $sql = "SELECT idproveedor, nombre, domicilio, cuit, fk_idrubro FROM proveedores WHERE idproveedor = ?";
    $lstRetorno = DB::select($sql, [$idproveedor]);

    if (count($lstRetorno) > 0) {
        $this->idproveedor = $lstRetorno[0]->idproveedor; // Asegúrate de que la columna 'idproveedor' esté presente en la consulta
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
                    nombre=?,
                    domicilio=?,
                    cuit=?,
                    fk_idrubro=?
                WHERE idproveedor=?";
        $affected = DB::update($sql, [
            $this->nombre,
            $this->domicilio,
            $this->cuit,
            $this->fk_idrubro,
            $this->idproveedor
        ]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM proveedores WHERE
                    idproveedor=?";
        $affected = DB::delete($sql, [$this->idproveedor]);
    }

    public function insertar()
    {
        try {
            $sql = "INSERT INTO proveedores (
                        nombre,
                        domicilio,
                        cuit,
                        fk_idrubro
                    ) VALUES (?, ?, ?, ?)";
            $result = DB::insert($sql, [
                $this->nombre,
                $this->domicilio,
                $this->cuit,
                $this->fk_idrubro
            ]);
            return $this->idproveedor = DB::getPdo()->lastInsertId();
        } catch (\Exception $e) {
            // Manejar el error de alguna manera
            echo "Error al insertar: " . $e->getMessage();
        }
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'nombre',
            1 => 'domicilio',
            2 => 'cuit',
            3 => 'fk_idrubro',
        );
        $sql = "SELECT	
				idproveedor,
				nombre,
				domicilio,
				cuit,
				fk_idrubro
                FROM proveedores 
                WHERE 1=1";

        // Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR domicilio LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR cuit LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fk_idrubro LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}	