<?php

use App\Http\Controllers\LibroC;
use App\Http\Controllers\PrestamoC;
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
});

Route::controller(LibroC::class)->group(
    function(){

    }
);

Route::controller(PrestamoC::class)->group(
    function(){
        Route::get('verPrestamos','ver')->name('rutaVer');
        Route::get('crearPrestamos','crear')->name('rutaCrear');
        Route::get('modificarPrestamo/{id}','modificar')->name('rutaModificar');
        Route::post('insertarPrestamos','insertar')->name('rutaInsertar');
        Route::post('modificarPrestamo/{id}','actualizar')->name('rutaActualizar');
    }
);
