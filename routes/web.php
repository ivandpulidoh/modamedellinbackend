<?php
 //use Carbon\Carbon; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/*Route::get('/time' , function(){$date =new Carbon;echo $date ; } );*/


Route::group(array('domain' => '127.0.0.1'), function () {

    Route::get('/', 'ControladorWebHome@index');
 

    Route::get('/admin', 'ControladorHome@index');
    Route::post('/admin/patente/nuevo', 'ControladorPatente@guardar');

/* --------------------------------------------- */
/* CONTROLADOR LOGIN                           */
/* --------------------------------------------- */
    Route::get('/admin/login', 'ControladorLogin@index');
    Route::get('/admin/logout', 'ControladorLogin@logout');
    Route::post('/admin/logout', 'ControladorLogin@entrar');
    Route::post('/admin/login', 'ControladorLogin@entrar');

/* --------------------------------------------- */
/* CONTROLADOR RECUPERO CLAVE                    */
/* --------------------------------------------- */
    Route::get('/admin/recupero-clave', 'ControladorRecuperoClave@index');
    Route::post('/admin/recupero-clave', 'ControladorRecuperoClave@recuperar');

/* --------------------------------------------- */
/* CONTROLADOR PERMISO                           */
/* --------------------------------------------- */
    Route::get('/admin/usuarios/cargarGrillaFamiliaDisponibles', 'ControladorPermiso@cargarGrillaFamiliaDisponibles')->name('usuarios.cargarGrillaFamiliaDisponibles');
    Route::get('/admin/usuarios/cargarGrillaFamiliasDelUsuario', 'ControladorPermiso@cargarGrillaFamiliasDelUsuario')->name('usuarios.cargarGrillaFamiliasDelUsuario');
    Route::get('/admin/permisos', 'ControladorPermiso@index');
    Route::get('/admin/permisos/cargarGrilla', 'ControladorPermiso@cargarGrilla')->name('permiso.cargarGrilla');
    Route::get('/admin/permiso/nuevo', 'ControladorPermiso@nuevo');
    Route::get('/admin/permiso/cargarGrillaPatentesPorFamilia', 'ControladorPermiso@cargarGrillaPatentesPorFamilia')->name('permiso.cargarGrillaPatentesPorFamilia');
    Route::get('/admin/permiso/cargarGrillaPatentesDisponibles', 'ControladorPermiso@cargarGrillaPatentesDisponibles')->name('permiso.cargarGrillaPatentesDisponibles');
    Route::get('/admin/permiso/{idpermiso}', 'ControladorPermiso@editar');
    Route::post('/admin/permiso/{idpermiso}', 'ControladorPermiso@guardar');

/* --------------------------------------------- */
/* CONTROLADOR GRUPO                             */
/* --------------------------------------------- */
    Route::get('/admin/grupost', 'ControladorGrupo@index');
    Route::get('/admin/usuarios/cargarGrillaGrupostDelUsuario', 'ControladorGrupo@cargarGrillaGrupostDelUsuario')->name('usuarios.cargarGrillaGrupostDelUsuario'); //otra cosa
    Route::get('/admin/usuarios/cargarGrillaGrupostDisponibles', 'ControladorGrupo@cargarGrillaGrupostDisponibles')->name('usuarios.cargarGrillaGrupostDisponibles'); //otra cosa
    Route::get('/admin/grupost/cargarGrilla', 'ControladorGrupo@cargarGrilla')->name('grupo.cargarGrilla');
    Route::get('/admin/grupo/nuevo', 'ControladorGrupo@nuevo');
    Route::get('/admin/grupo/setearGrupo', 'ControladorGrupo@setearGrupo');
    Route::post('/admin/grupo/nuevo', 'ControladorGrupo@guardar');
    Route::get('/admin/grupo/{idgrupo}', 'ControladorGrupo@editar');
    Route::post('/admin/grupo/{idgrupo}', 'ControladorGrupo@guardar');

/* --------------------------------------------- */
/* CONTROLADOR USUARIO                           */
/* --------------------------------------------- */
    Route::get('/admin/usuarios', 'ControladorUsuario@index');
    Route::get('/admin/usuarios/nuevo', 'ControladorUsuario@nuevo');
    Route::post('/admin/usuarios/nuevo', 'ControladorUsuario@guardar');
    Route::post('/admin/usuarios/{usuario}', 'ControladorUsuario@guardar');
    Route::get('/admin/usuarios/cargarGrilla', 'ControladorUsuario@cargarGrilla')->name('usuarios.cargarGrilla');
    Route::get('/admin/usuarios/buscarUsuario', 'ControladorUsuario@buscarUsuario');
    Route::get('/admin/usuarios/{usuario}', 'ControladorUsuario@editar');

/* --------------------------------------------- */
/* CONTROLADOR MENU                             */
/* --------------------------------------------- */
    Route::get('/admin/sistema/menu', 'ControladorMenu@index');
    Route::get('/admin/sistema/menu/nuevo', 'ControladorMenu@nuevo');
    Route::post('/admin/sistema/menu/guardar', 'ControladorMenu@guardar');
    Route::get('/admin/sistema/menu/cargarGrilla', 'ControladorMenu@cargarGrilla')->name('menu.cargarGrilla');
    Route::get('/admin/sistema/menu/eliminar', 'ControladorMenu@eliminar');
    Route::get('/admin/sistema/menu/{id}', 'ControladorMenu@editar');
    Route::post('/admin/sistema/menu/{id}', 'ControladorMenu@guardar');

});

/* --------------------------------------------- */
/* CONTROLADOR PATENTES                          */
/* --------------------------------------------- */
Route::get('/admin/patentes', 'ControladorPatente@index');
Route::get('/admin/patente/nuevo', 'ControladorPatente@nuevo');
Route::post('/admin/patente/nuevo', 'ControladorPatente@guardar');
Route::get('/admin/patente/cargarGrilla', 'ControladorPatente@cargarGrilla')->name('patente.cargarGrilla');
Route::get('/admin/patente/eliminar', 'ControladorPatente@eliminar');
Route::get('/admin/patente/nuevo/{id}', 'ControladorPatente@editar');
Route::post('/admin/patente/nuevo/{id}', 'ControladorPatente@guardar');
/* --------------------------------------------- */
/* CONTROLADOR CLIENTE                      */
/* --------------------------------------------- */

 route::get('/admin/cliente/nuevo', 'controladorCliente@nuevo');
 route::post('/admin/cliente/nuevo', 'controladorCliente@guardar');
 route::get('/admin/clientes', 'controladorCliente@index');
  Route::get('/admin/clientes/cargarGrilla', 'ControladorCliente@cargarGrilla')->name('cliente.cargarGrilla');
/* --------------------------------------------- */
/* CONTROLADOR PRODUCTOS                      */
/* --------------------------------------------- */

 route::get('/admin/producto/nuevo', 'controladorProducto@nuevo');
 route::post('/admin/producto/nuevo', 'controladorProducto@guardar');
 route::get('/admin/productos', 'controladorProducto@index');
Route::get('/admin/Productos/cargarGrilla', 'ControladorProducto@cargarGrilla')->name('producto.cargarGrilla');
/* --------------------------------------------- */
/* CONTROLADOR PEDIDOS                      */
/* --------------------------------------------- */

 route::get('/admin/pedido/nuevo', 'controladorPedido@nuevo');
 route::post('/admin/pedido/nuevo', 'controladorPedido@guardar');
 route::get('/admin/pedidos', 'controladorPedido@index');
Route::get('/admin/Pedidos/cargarGrilla', 'ControladoPedido@cargarGrilla')->name('pedido.cargarGrilla');
/* --------------------------------------------- */
/* CONTROLADOR postTULACIONES                      */
/* --------------------------------------------- */

 route::get('/admin/postulacion/nuevo', 'controladorPostulacion@nuevo');
 route::post('/admin/postulacion/nuevo', 'controladorPostulacion@guardar');
 route::get('/admin/postulaciones', 'controladorPostulacion@index');
Route::get('/admin/Postulaciones/cargarGrilla', 'ControladorPostulacion@cargarGrilla')->name('postulacion.cargarGrilla');
/* --------------------------------------------- */
/* CONTROLADOR SUCURSALES                      */
/* --------------------------------------------- */

 route::get('/admin/sucursal/nuevo', 'controladorSucursal@nuevo');
 route::post('/admin/sucursal/nuevo', 'controladorSucursal@guardar');
 route::get('/admin/sucursales', 'controladorSucursal@index');
Route::get('/admin/Sucursales/cargarGrilla', 'ControladorSucursal@cargarGrilla')->name('sucursal.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR CATEGORIAS                      */
/* --------------------------------------------- */

 route::get('/admin/categoria/nuevo', 'controladorCategoria@nuevo');
route::post('/admin/categoria/nuevo', 'controladorCategoria@guardar');
route::get('/admin/categorias', 'controladorCategoria@index');
Route::get('/admin/Categorias/cargarGrilla', 'ControladorCategoria@cargarGrilla')->name('categoria.cargarGrilla');
/* --------------------------------------------- */
/* CONTROLADOR PROVEEDORES                      */
/* --------------------------------------------- */

 route::get('/admin/proveedor/nuevo', 'controladorProveedor@nuevo');
 route::post('/admin/proveedor/nuevo', 'controladorProveedor@guardar');
route::get('/admin/proveedores', 'controladorProveedor@index');
Route::get('/admin/Proveedores/cargarGrilla', 'ControladorProveedor@cargarGrilla')->name('proveedor.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR RUBROS                     */
/* --------------------------------------------- */

 route::get('/admin/rubro/nuevo', 'controladorRubro@nuevo');
 route::post('/admin/rubro/nuevo', 'controladorRubro@guardar');
route::get('/admin/rubros', 'controladoRrubro@index');
Route::get('/admin/Rubros/cargarGrilla', 'ControladorRubro@cargarGrilla')->name('rubro.cargarGrilla');




