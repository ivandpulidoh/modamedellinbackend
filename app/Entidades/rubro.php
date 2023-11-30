<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    protected $table = 'rubros';
    public $timestamps = false; // Insertar una marca de tiempo, es decir, fecha y hora

    protected $fillable = [
        'idrubro',
        'nombre'
    ];

    protected $hidden = [];

    public function cargarDesdeRequest($request)
    {
        $this->idrubro = $request->input('id') != "0" ? $request->input('id') : $this->idrubro;
        $this->nombre = $request->input('txtNombre');
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                    idrubro,
                    nombre
                FROM rubros
                ORDER BY idrubro ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idrubro)
    {
        $sql = "SELECT
                    idrubro,
                    nombre
                FROM rubros WHERE idrubro = ?";
        $lstRetorno = DB::select($sql, [$idrubro]);

        if (count($lstRetorno) > 0) {
            $this->idrubro = $lstRetorno[0]->idrubro;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE rubros SET
                    nombre=?
                WHERE idrubro=?";
        $affected = DB::update($sql, [
            $this->nombre,
            $this->idrubro
        ]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM rubros WHERE
                    idrubro=?";
        $affected = DB::delete($sql, [$this->idrubro]);
    }

    public function insertar()
    {
        try {
            $sql = "INSERT INTO rubros
			 (nombre)
			 VALUES (?)";
            $resut = DB::insert($sql, [$this->nombre]);
            return $this->idrubro = DB::getPdo()->lastInsertId();
        } catch (\Exception $e) {
            // Manejar el error de manera específica
            echo "Error al insertar: " . $e->getMessage();
            // O bien, puedes lanzar la excepción nuevamente para manejarla en otro lugar
            throw $e;
        }
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'idrubro',
            1 => 'nombre',
        );
        $sql = "SELECT
                    idrubro,
                    nombre
                FROM rubros
                WHERE 1=1";

        // Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}

?>
