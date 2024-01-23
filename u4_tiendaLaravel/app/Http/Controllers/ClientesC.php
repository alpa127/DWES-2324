<?php

    namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

    class ClientesC extends Controller
    {
        //Metodo que maneja la ruta productos
        function clientes(){
            //Recuperar los productos para mostrarlos en la 
            //tabñla de la vista
            $clientes = Cliente::all();
            return view('clientes/clientes',compact('clientes'));
        }
        //Metodo que maneja la ruta crearProductos
        function crear(){
            return view('clientes/crear');
        }

        //Este método se llama desde el submit del formulario
        //para acceder a los campos del formulario hay que definir
        //un parámetro de la clase Request
        function insertar(Request $r){
            //Crear un objeto del modelo Producto
            $c = new Cliente();
            //Rellenar los datos del producto
            //a partir de los campos del formulario
            $c->email = $r->email;
            $c->nombre = $r->nombre;
            $c->telefono = $r->telefono;
            $c->direccion = $r->direccion;
            //Subir imagen del producto al servidor
            //y rellenar el producto con la ruta de la imagen
            //El fichero se almacena en storage/app/public/img/productos
            // $ruta=$r->file('imagen')->store('img/productos','public');
            // $p->img=$ruta;
            //Hacemos el insert en la tabla
            if($c->save()){
                //Volvemos a la página anterior(ruta productos) y mostramos
                //mensaje de exito
                return redirect()->route('clientes')->with('mensaje','Producto creado con id '.$c->id);

            }
            else{
                //Volvemos a la página anterior(ruta productos) y mostramos
                //mensaje de error
                return back()->with('mensaje','Error al crear el producto');
            }
        }
        //Metodo que maneja la ruta verP
        function ver($idC){
            return 'Pagina para ver el producto'.$idC;
        }
        //Metodo que maneja la ruta modificarP
        function modificar($idC){
            $p = Producto::find($idC);
            return view('clientes/modificar',compact('c'));
        }
        //Metodo que maneja la ruta actualizarP
        function actualizar(Request $r,$idC){
            //Recuperar los datos del producto
            //es el producto tal cual está en la BD
            $c = Cliente::find($idC);
            //Modificamos los campos que se hayan podido cambiar en el formulario
            // $r tiene los datos modificados y $p los antiguos
            $c->email = $r->email;
            $c->nombre = $r->nombre;
            $c->telefono = $r->telefono;
            $c->direccion = $r->direccion;

            //Subir nueva imagen solamente si se ha modificado
            if(!empty($r->imagen)){
                //Borrar la imagen antigua
                Storage::delete('public/'.$c->img);
                //Subir la imagen nueva
                $ruta = $r->file('imagen')->store('img/productos','public');
                $c->img=$ruta;
            }

            //Modificar el producto en la BD
            //Sabe que hay que hacer un update porque $p
            //se ha creado con un find.
            if($c->save()){
                return back()->with('mensaje','Clientes modificado correctamente');

            }else{
                return back()->with('mensaje','Error,no se ha modificado el producto');

            }
        }
        //Metodo que maneja la ruta borrarP
        function borrar($idC){
            $c = Cliente::find($idC);

            //si tienes pedidos no podemos borrar el producto
            if(sizeof($c->detalle_pedidos())>0){
                return back()->with('mensaje','Error, el cliente se ha pedido');
            }
            else{
               

                if($c->delete()){
                    //Borrar la imagen
                    Storage::delete('public/'.$c->img);
                    return back()->with('mensaje', 'Cliente borrado');
                }
            }
        }


    }
?>