<?php

use App\Http\Controllers\ProductoC;
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
    Route::get('productos/{idP}','modificar')->name('modificarP');

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