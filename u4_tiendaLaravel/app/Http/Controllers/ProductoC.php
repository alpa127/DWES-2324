<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class ProductoC extends Controller
    {
        //Metodo que maneja la ruta productos
        function productos(){
            return 'Pagina para ver todos los productos';
        }
        //Metodo que maneja la ruta crearProductos
        function crear(){
            return view('productos/crear');
        }
        function insertar(){
            return 'Insertar producto';
        }
        //Metodo que maneja la ruta verP
        function ver($idP){
            return 'Pagina para ver el producto'.$idP;
        }
        //Metodo que maneja la ruta modificarP
        function modificar($idP){
            return 'Pagina para modificar el producto'.$idP;
        }
        //Metodo que maneja la ruta borrarP
        function borrar($idP){
            return 'Pagina para borrar el producto'.$idP;
        }


    }
?>