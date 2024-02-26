<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoC extends Controller
{
    function __construct()
    {
    $this->middleware('auth');
    }
    //
    function insertarCarrito(Request $r){

        //Recuperar el producto
        $producto = Producto::find($r->carrito);
        
       
        //El carrito se almacena en una variable de sesión
        if(session('carrito')==null){
            //Crear la variable de sesión carrito
            $carrito=array();
        }else{
            $carrito = session('carrito');
        }
        //Comprobar si el producto está en el carrito
        $actualizado=false;
        foreach($carrito as $clave=>$pc){
            if($pc['producto']->id == $producto->id){
                $carrito[$clave]['cantidad']=$pc['cantidad']+1;
                $actualizado=true;
            }
        }
        if(!$actualizado){
            //Añadir el carrito al producto
            //Cada elemento del carrito es un array asociativo
            //que contiene el producto y la cantidad
            $carrito[]=array('producto'=>$producto,'cantidad'=>1);
        }
        session(['carrito'=>$carrito]);
        return back()->with('mensaje','Producto añadido al carrito'.var_dump($producto));
    }

    function verCarrito(){
        return view('carrito/verCarrito');
    }

    function modificarCarrito(Request $r){
        $carrito = session('carrito');
        if($r->modificarPC!=null){
            //Modificar la cantidad del producto en el carrito
            foreach($carrito as $clave=>$pc){
                if($pc['producto']->id == $r->modificarPC){
                    $carrito[$clave]['cantidad']=$pc['cantidad']+1;
                    return back()->with('mensaje','Producto modificado');
                }
            }
        }elseif($r->borrarPC!=null){
            //Borrar la cantidad del producto en el carrito
            foreach($carrito as $clave=>$pc){
                if($pc['producto']->id == $r->modificarPC){
                    unset($carrito[$clave]);
                    session(['carrito' => $carrito]);
                    return back()->with('mensaje','Producto borrado');
                }
            }
        }
    }
}
