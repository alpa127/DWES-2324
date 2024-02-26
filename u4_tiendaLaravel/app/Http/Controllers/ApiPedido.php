<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use App\Models\Pedido;
use App\Models\Pedido_Producto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDOException;

class ApiPedido extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Crea un pedido con un producto
        //Parámetros: idP, idC, Cantidad
        $request->validate([
            'idP'=>'required',
            'idC'=>'required',
            'cantidad'=>'required|gte:1',

        ]);
        $p = Producto::find($request->idP);
        if($p==null){
            return response()->json('Error, no existe el producto',500);
        }
        if($p->stock<$request->cantidad){
            return response()->json('Error, no hay stock',500);
        }else{
            $cant=$request->cantidad;
        }
        $c = Producto::find($request->idC);
        if($c==null){
            return response()->json('Error, no existe el cliente',500);
        }
       
        $error=false;
        $ped=null;
        try{
        //Creamos el pedido en una transacción
        //ya que hay que hacer el insert en 2 tablas: pedidos y pedido_productos
        DB::transaction(function () use ($p , $c, $cant, $ped) {
        //Crear el pedido a partir del variable de sesión
        //y del usuario logueado
        $ped = new Pedido();
        $ped->fecha=date('YmdhHi');
        $ped->cliente_id=$c->id;
        //Guardar pedido
        if($ped->save()){
        //Guardar producto en pedido
      
            $nuevo = new Pedido_Producto();
            $nuevo->cantidad = $cant;
            $nuevo->precioU=$p->precio;
            $nuevo->pedido_id=$ped->id;
            $nuevo->producto=$p->id;
            if($nuevo->save()){
                //Decrementar el stock del producto
                $p->stock=$p->stock-$cant;
                $p->save();
            }
        
    }
    });

        }
        catch(PDOException $e){
            $error=true;
            return response()->json($e->getMessage(),500);
        }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
