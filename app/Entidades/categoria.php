<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    public $timestamps = false; // Insertar una marca de tiempo, es decir, fecha y hora

    protected $fillable = [
        'idcategoria',
        'nombre'
    ];

    protected $hidden = [];

    public function cargarDesdeRequest($request)
    {
        $this->idcategoria = $request->input('id') != "0" ? $request->input('id') : $this->idcategoria;
        $this->nombre = $request->input('txtNombreCategoria');
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                    idcategoria,
                    nombre
                FROM categorias
                ORDER BY idcategoria ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

 public function obtenerPorId($idcategoria)
{
    $sql = "SELECT
                idcategoria,
                nombre
            FROM categorias WHERE idcategoria = ?";
    $lstRetorno = DB::select($sql, [$idcategoria]);

    if (count($lstRetorno) > 0) {
        $this->idcategoria = $lstRetorno[0]->idcategoria;
        $this->nombre = $lstRetorno[0]->nombre;
        return $this;
    }
    return null;
}

    public function guardar()
    {
        $sql = "UPDATE categorias SET
                    nombre=?
                WHERE idcategoria=?";
        $affected = DB::update($sql, [
            $this->nombre,
            $this->idcategoria
        ]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM categorias WHERE
                    idcategoria=?";
        $affected = DB::delete($sql, [$this->idcategoria]);
    }

    public function insertar()
    {
        try {
            $sql = "INSERT INTO categorias (nombre) VALUES (?)";
            $result = DB::insert($sql, [$this->nombre]);
            return $this->idcategoria = DB::getPdo()->lastInsertId();
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
            0 => 'idcategoria',
            1 => 'nombre',
        );
        $sql = "SELECT
                    idcategoria,
                    nombre
                FROM categorias
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
