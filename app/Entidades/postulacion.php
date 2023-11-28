<?php

namespace App\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;


class Postulacion extends Model
{
 protected $table = 'postulaciones';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla pedidos en la base de datos
        'idpostulacion',
	  'nombre',
	  'apellido',
	  'whatsapp',
	  'correo'
    ];

    protected $hidden = [

    ];

    public function cargarDesdeRequest($request) {
        $this->idpostulacion = $request->input('id') != "0" ? $request->input('id') : $this->idpostulacion;
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->whatsapp = $request->input('txtWhatsapp');
        $this->correo = $request->input('txtCorreo');
       
      
    }

        public function obtenerTodos()
    {
        $sql = "SELECT
                        'idpostulacion',
				'nombre',
				'apellido',
				'whatsapp',
				'correo'
                FROM postulaciones A ORDER BY idpostulacion ASC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

public function obtenerPorId($idpostulacion)
{
    $sql = "SELECT
                idpostulacion,
                nombre,
                apellido,
                whatsapp,
                correo
            FROM postulaciones WHERE idpostulacion = ?";
    $lstRetorno = DB::select($sql, [$idpostulacion]);

    if (count($lstRetorno) > 0) {
        $this->idpostulacion = $lstRetorno[0]->idpostulacion;
        $this->nombre = $lstRetorno[0]->nombre;
        $this->apellido = $lstRetorno[0]->apellido;
        $this->whatsapp = $lstRetorno[0]->whatsapp;
        $this->correo = $lstRetorno[0]->correo;
      
        return $this;
    }
    return null;
}

        public function guardar()
 {
        $sql = "UPDATE pedidos SET
            idpostulacion='$this->idpostulacion',
            nombre='$this->nombre',
            apellido=$this->apellido,
            whatsapp='$this->whatsapp',
            correo='$this->correo'
		
            WHERE idpostulacion=?";
        $affected = DB::update($sql, [$this->idpostulacion]);
    }

       public function eliminar()
    {
        $sql = "DELETE FROM postulaciones WHERE
            idpostulacion=?";
        $affected = DB::delete($sql, [$this->idpostulacion]);
    }
public function insertar()
{
    try {
        $sql = "INSERT INTO postulaciones (
				nombre,
				apellido,
				whatsapp,
				correo
            ) VALUES (?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->apellido,
            $this->whatsapp,
            $this->correo
        ]);
        return $this->idpostulacion = DB::getPdo()->lastInsertId();
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
            1 => 'whatsapp',
            2 => 'correo',
        );
        $sql = "SELECT DISTINCT
                    idpostulacion,
                    nombre,
                    apellido,
                    whatsapp,
                  correo
                FROM postulaciones
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
		 $sql .= " OR whatsapp LIKE '%" . $request['search']['value'] . "%' ";	
            $sql .= " OR correo LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


}


?>