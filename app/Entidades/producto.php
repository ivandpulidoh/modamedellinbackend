<?php

namespace App\Entidades;


use DB;
use Illuminate\Database\Eloquent\Model;


class Producto extends Model
{
 protected $table = 'productos';
    public $timestamps = false;//insertar una marcas de tiempo osea fecha y hora

    protected $fillable = [//son los campos de la tabla productos en la base de datos
        'idproducto',
	  'nombre',
	  'fk_tipoproducto',
	  'cantidad',
	  'precio',
	  'descripcion',
	  'imagen'
    ];

    protected $hidden = [

    ];

 public function cargarDesdeRequest($request) {
    $this->idproducto = $request->input('id');
    $this->nombre = $request->input('txtNombre');
    $this->fk_tipoproducto = $request->input('txtTipoProducto');
    $this->cantidad = $request->input('txtCantidad');
    $this->precio = $request->input('txtPrecio');
    $this->descripcion = $request->input('txtDescripcion');
    $this->imagen = $request->input('txtImagen');
}

public function obtenerTodos()
{
    $sql = "SELECT
                idproducto,
                nombre,
                fk_tipoproducto,
                cantidad,
                precio,
                descripcion,
                imagen
            FROM productos A ORDER BY idproducto ASC";
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
		imagen
                FROM productos WHERE idproducto = $idproducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->fk_tipoproducto = $lstRetorno[0]->fk_tipoproducto;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->precio = $lstRetorno[0]->precio;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->imagen = $lstRetorno[0]->imagen;
            return $this;
        }
        return null;
    }

 public function guardar() {
    $sql = "UPDATE productos SET
        nombre='$this->nombre,
        fk_idtipoproducto=$this->fk_idtipoproducto,
        cantidad='$this->cantidad,
        precio='$this->precio,
        descripcion='$this->descripcion,
	imagen='$this->imagen
        WHERE idproducto=?";
    $affected = DB::update($sql, [$this->idproducto]);
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
        $sql = "INSERT INTO productos (
            nombre,
            fk_tipoproducto,
            cantidad,
            precio,
            descripcion,
            imagen
        ) VALUES (?, ?, ?, ?, ?, ?)";
        $result = DB::insert($sql, [
            $this->nombre,
            $this->fk_tipoproducto,
            $this->cantidad,
            $this->precio,
            $this->descripcion,
            $this->imagen
        ]);
        return $this->idproducto = DB::getPdo()->lastInsertId();
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
            1 => 'fk_tipoproducto',
            2 => 'cantidad',
            3 => 'precio',
		4 => 'descripcion'
        );
        $sql = "SELECT DISTINCT
                 idproducto,
		     nombre,
		     fk_tipoproducto,
		     cantidad,
		     precio,
		     descripcion,
		     imagen 
                FROM productos
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR cantidad LIKE '%" . $request['search']['value'] . "%' ";
		 $sql .= " OR precio LIKE '%" . $request['search']['value'] . "%' ";	
            $sql .= " OR descripcion LIKE '%" . $request['search']['value'] . "%' )";
		
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


}


?>