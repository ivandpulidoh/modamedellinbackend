<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'idproducto',
        'nombre',
        'fk_tipoproducto',
        'cantidad',
        'precio',
	  'descripcion',	
	  'imagen'
    ];

    protected $hidden = [];

    public function cargarDesdeRequest($request)
    {
        $this->idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
        $this->nombre = $request->input('txtNombre');
        $this->fk_tipoproducto = $request->input('txtTipoProducto');
        $this->cantidad = $request->input('txtCantidad');
        $this->precio = $request->input('txtPrecio');
	  $this->descripcion = $request->input('txtDescripcion');
	  $this->imagen = $request->input('archivo');
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
 FROM productos WHERE idproducto = ?";
    $lstRetorno = DB::select($sql, [$idproducto]);

    if (count($lstRetorno) > 0) {
        $this->idproducto = $lstRetorno[0]->idproducto; // Asegúrate de que la columna 'idproveedor' esté presente en la consulta
        $this->nombre = $lstRetorno[0]->nombre;
        $this->fk_tipoproducto = $lstRetorno[0]->fk_tipoproducto;
        $this->cantidad = $lstRetorno[0]->cantidad;
        $this->precio = $lstRetorno[0]->precio;
	  $this->descripcion = $lstRetorno[0]->descripcion;
        $this->imagen = $lstRetorno[0]->precio;

        return $this;
    }
    return null;
}

    public function guardar()
    {
        $sql = "UPDATE productos SET
                    nombre=?,
                    fk_tipoproducto=?,
                    cantidad=?,
                    precio=?,
			  descripcion=?,
			  imagen=?,
                WHERE idproducto=?";
        $affected = DB::update($sql, [
            $this->nombre,
            $this->fk_tipoproducto,
            $this->cantidad,
            $this->precio,
		$this->descripcion,
		$this->imagen,
            $this->idproducto
        ]);
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
		    $this->imagen,
               
            ]);
            return $this->idproducto = DB::getPdo()->lastInsertId();
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
            1 => 'cantidad',
            2 => 'precio',
            3 => 'descripcion',
		4 => 'imagen',
        );
        $sql = "SELECT	
			idproducto, 
			nombre, 
			fk_tipoproducto, 
			cantidad,
			precio,
			descripcion,
			imagen
                FROM productos 
                WHERE 1=1";

        // Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR cantidad LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR precio LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR descripcion LIKE '%" . $request['search']['value'] . "%' )";
		 $sql .= " OR imagen LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

		public function existeProductoCategoria($idcategoria){

$sql = "SELECT
                idproducto,
                nombre,
                fk_tipoproducto,
                cantidad,
                precio,
		    descripcion,
		    imagen
            FROM productos WHERE fk_tipoproducto =  $idcategoria";
	 	$lstRetorno = DB::select($sql,);
		return (count($lstRetorno) > 0);

}

}	