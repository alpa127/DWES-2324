<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class ApiProducto extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Producto::all();
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
        //
        $request->validate([
            "nombre"=>"required|unique:App\Models\Producto,nombre", //Dos validaciones: requerido y único en la tabla
            "descripcion"=>"required",
            "precio"=>"required|gte:0", //Requerido y >=0
            "stock"=>"required|gte:0", //Requerido y >=0
        ]);
        $p = new Producto();
        $p->nombre=$request->nombre;
        $p->descripcion=$request->descripcion;
        $p->precio=$request->precio;
        $p->stock=$request->stock;
        $p->baja=false;
        $p->img='img/productos/tienda1.png';
        if(!$p->save()){
            return abort('Error al crear el producto',500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        //
        return Producto::all();
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
        $p=Producto::find($id);
        if($p->delete()){
            abort(500);
        }
        else{
            return response()->noContent();
        }

    }
}
