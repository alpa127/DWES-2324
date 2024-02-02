<?php

use App\Http\Controllers\ProductoC;
use App\Http\Controllers\ClientesC;
use App\Http\Controllers\LoginC;

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('inicio');

Route::controller(LoginC::class)->group(function(){
    Route::get('login','login')->name('login');//Carga form login
    Route::get('login/registro','registro')->name('registro');//Carga form registro
    Route::get('login/salir','salir')->name('salir');//Cierra sesión
    Route::post('login','loguear')->name('loguear');//Inicia sesión si us y ps válidos
    Route::post('login/registro','registrar')->name('registrar');//Crear usuario

});


Route::controller(ClientesC::class)->group(function(){
    //Definir una ruta básica para ver todos los productos
    //Ruta para ver todos los productos
    Route::get('clientes','clientes')->name('clientes');

    //Definir ruta apra crear un producto
    // Route::get('clientes/crear','crear')->name('crearCliente');
    // Route::post('clientes/insertar','insertar')->name('insertarCliente');
    //Definir una ruta con un parametro
    //Ruta para ver un producto concreto, pasando el id
    Route::get('clientes/{idC}','ver')->name('verC');

    //Definir una ruta con un parametro
    //Ruta para ver un producto concreto, pasando el id
    Route::delete('clientes/{idC}','borrar')->name('borrarC');

    //Definir una ruta con un parametro
    //Ruta para ver un producto concreto, pasando el id
    Route::get('clientes/modificar/{idC}','modificar')->name('modificarC');
    Route::put('clientes/modificar/{idC}','actualizar')->name('actualizarC');

});


//Definir una ruta con un parametro
//Ruta para ver un producto concreto, pasando el id
Route::get('clientes/modificar/{idC}/{texto}',function($idC,$texto){
    echo '<h1>'.$texto.'</h1>';
    echo 'Pagina para modificar el producto'.$idC;
});


//Definir una ruta con dos parametors uno de ellos opcional
Route::get('clientes/opt/{idC}/{untexto}',function($idC,$texto=null){
    echo '<h1>'.$texto=null?$texto:"".'</h1>';
    echo 'Pagina para ver como se define un párametro opcional '.$idC;
});

Route::controller(ProductoC::class)->group(function(){
    //Definir una ruta básica para ver todos los productos
    //Ruta para ver todos los productos
    Route::get('productos','productos')->name('productos');

    //Definir ruta apra crear un producto
    Route::get('productos/crear','crear')->name('crearProducto');
    Route::post('productos/insertar','insertar')->name('insertarProducto');
    //Definir una ruta con un parametro
    //Ruta para ver un producto concreto, pasando el id
    Route::get('productos/{idP}','ver')->name('verP');

    //Definir una ruta con un parametro
    //Ruta para ver un producto concreto, pasando el id
    Route::delete('productos/{idP}','borrar')->name('borrarP');

    //Definir una ruta con un parametro
    //Ruta para ver un producto concreto, pasando el id
    Route::get('productos/modificar/{idP}','modificar')->name('modificarP');
    Route::put('productos/modificar/{idP}','actualizar')->name('actualizarP');

});


//Definir una ruta con un parametro
//Ruta para ver un producto concreto, pasando el id
Route::get('productos/modificar/{idP}/{texto}',function($idP,$texto){
    echo '<h1>'.$texto.'</h1>';
    echo 'Pagina para modificar el producto'.$idP;
});


//Definir una ruta con dos parametors uno de ellos opcional
Route::get('productos/opt/{idP}/{untexto}',function($idP,$texto=null){
    echo '<h1>'.$texto=null?$texto:"".'</h1>';
    echo 'Pagina para ver como se define un párametro opcional '.$idP;
});

