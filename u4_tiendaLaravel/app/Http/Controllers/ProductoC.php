<?php

    namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

    class ProductoC extends Controller
    {
        //Metodo que maneja la ruta productos
        function productos(){
            //Recuperar los productos para mostrarlos en la 
            //tabñla de la vista
            $productos = Producto::all();
            return view('productos/productos',compact('productos'));
        }
        //Metodo que maneja la ruta crearProductos
        function crear(){
            return view('productos/crear');
        }

        //Este método se llama desde el submit del formulario
        //para acceder a los campos del formulario hay que definir
        //un parámetro de la clase Request
        function insertar(Request $r){
            //Crear un objeto del modelo Producto
            $p = new Producto();
            //Rellenar los datos del producto
            //a partir de los campos del formulario
            $p->nombre = $r->nombre;
            $p->descripcion = $r->desc;
            $p->precio = $r->precio;
            $p->stock = $r->stock;
            //Subir imagen del producto al servidor
            //y rellenar el producto con la ruta de la imagen
            //El fichero se almacena en storage/app/public/img/productos
            $ruta=$r->file('imagen')->store('img/productos','public');
            $p->img=$ruta;
            //Hacemos el insert en la tabla
            if($p->save()){
                //Volvemos a la página anterior(ruta productos) y mostramos
                //mensaje de exito
                return redirect()->route('productos')->with('mensaje','Producto creado con id '.$p->id);

            }
            else{
                //Volvemos a la página anterior(ruta productos) y mostramos
                //mensaje de error
                return back()->with('mensaje','Error al crear el producto');
            }
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
            $p = Producto::find($idP);

            //si tienes pedidos no podemos borrar el producto
            if(sizeof($p->detalle_pedidos())>0){
                return back()->with('mensaje','Error, el producto se ha pedido');
            }
            else{
                if($p->delete()){
                    return back()->with('mensaje', 'Producto borrado');
                }
            }
        }


    }
?>