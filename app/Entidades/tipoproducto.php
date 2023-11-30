<?php

namespace App\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;


class TipoProducto extends Model
{
 protected $table = 'idtipoproducto';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla clientes en la base de datos
        'idtipoproducto',
	  'nombre'
    ];

    protected $hidden = [

    ];

    public function cargarDesdeRequest($request) {
        $this->idtipoproducto = $request->input('id') != "0" ? $request->input('id') : $this->idtipoproducto;
        $this->nombre = $request->input('txtTipoproducto');
  
    }

        public function obtenerTodos()
    {
        $sql = "SELECT
                 idtipoproducto,
		     nombre
                FROM tipoproductos  A ORDER BY idtipoproducto ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

     public function obtenerPorId($idcliente)
    {
        $sql = "SELECT
                idtipoproducto,
                nombre
                FROM tipoproductos WHERE idtipoproducto = $idcliente";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idtipoproducto = $lstRetorno[0]->idtipoproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }

public function guardar() {
    $sql = "UPDATE tipoproductos SET
        nombre='$this->nombre'
        WHERE idtipoproducto=?";
    $affected = DB::update($sql, [$this->idtipoproducto]);
}

       public function eliminar()
    {
        $sql = "DELETE FROM tipoproductos WHERE
            idtipoproducto=?";
        $affected = DB::delete($sql, [$this->idtipoproducto]);
    }

public function insertar()
{
    try {
        $sql = "INSERT INTO tipoproductos (
               nombre
            ) VALUES (?);";
        $result = DB::insert($sql, [

            $this->nombre,
   
        ]);
        return $this->idcliente = DB::getPdo()->lastInsertId();
    } catch (\Exception $e) {
        // Manejar el error
        echo "Error al insertar: " . $e->getMessage();
    }
}

   public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'nombre'
,
        );
        $sql = "SELECT DISTINCT
                 idtipoproducto,
		     nombre,
	
                FROM tipoproductos
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
           
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


}


?>