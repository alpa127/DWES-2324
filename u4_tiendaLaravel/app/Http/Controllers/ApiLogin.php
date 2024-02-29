<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLogin extends Controller
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
        //
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

    public function login(Request $r){
         //Abrir sesión si us y ps son correctos
        //Validaciones
        $r -> validate(["email"=>"required",
        "ps"=>"required"]);
        //Credenciales de acceso
        $credenciales=["email"=>$r->email,'password'=>$r->ps];
        //Recordar credenciales
        $recordar = $r->has("recordar");
        //Autenticar
        if(Auth::attempt($credenciales,$recordar)){
        
            $cliente = cliente::where('user_id',Auth::user()->id)->first();
            return new UserResource($cliente);
        }
        else{
            return abort(401);
        }
    }
}
