<?php

namespace App\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
 protected $table = 'clientes';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla clientes en la base de datos
        'idcliente',
	  'nombre',
	  'telefono',
	  'direccion',
	  'dni',
	  'correo',
	  'clave'
    ];

    protected $hidden = [

    ];

    public function cargarDesdeRequest($request) {
        $this->idcliente = $request->input('id') != "0" ? $request->input('id') : $this->idmenu;
        $this->nombre = $request->input('txtNombre');
        $this->telefono = $request->input('txtTelefono');
        $this->direccion = $request->input('txtDireccion');
        $this->dni = $request->input('txtDni');
        $this->correo = $request->input('txtCorreo');
        $this->clave = $request->input('txtClave');
    }

        public function obtenerTodos()
    {
        $sql = "SELECT
                 idcliente,
		     nombre,
		     telefono,
		     direccion,
		     dni,
		     correo,
		     clave 
                FROM clientes A ORDER BY idcliente ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

     public function obtenerPorId($idcliente)
    {
        $sql = "SELECT
                idcliente,
                nombre,
                telefono,
                direccion,
                dni,
                correo,
                clave
                FROM clientes WHERE idcliente = $idcliente";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idcliente = $lstRetorno[0]->idcliente;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->direccion = $lstRetorno[0]->direccion;
            $this->dni = $lstRetorno[0]->dni;
            $this->correo = $lstRetorno[0]->correo;
            $this->clave = $lstRetorno[0]->clave;
            return $this;
        }
        return null;
    }

public function guardar() {
    $sql = "UPDATE clientes SET
        nombre='$this->nombre',
        telefono=$this->telefono,
        direccion='$this->direccion',
        dni='$this->dni',
        clave='$this->clave'
        WHERE idcliente=?";
    $affected = DB::update($sql, [$this->idcliente]);
}

       public function eliminar()
    {
        $sql = "DELETE FROM clientes WHERE
            idcliente=?";
        $affected = DB::delete($sql, [$this->idcliente]);
    }

public function insertar()
{
    try {
        $sql = "INSERT INTO clientes (
               nombre,
                telefono,
                direccion,
                dni,
		    correo,
                clave
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [

            $this->nombre,
            $this->telefono,
            $this->direccion,
            $this->dni,
            $this->correo,
            $this->clave
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
            0 => 'nombre',
            1 => 'dni',
            2 => 'correo',
            3 => 'telefono',
        );
        $sql = "SELECT DISTINCT
                 idcliente,
		     nombre,
		     telefono,
		     direccion,
		     dni,
		     correo,
		     clave 
                FROM clientes
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR telefono LIKE '%" . $request['search']['value'] . "%' ";
		 $sql .= " OR dni LIKE '%" . $request['search']['value'] . "%' ";	
            $sql .= " OR correo LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


}


?>