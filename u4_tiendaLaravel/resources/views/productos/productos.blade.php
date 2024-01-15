@extends('plantilla/plantilla')

@section('titulo','PRODUCTOS')
    
@section('mensaje')

    <h3 class="text-danger">Espacio para mensaje</h3>

@endsection

@section('contenido')
   <a class="btn btn-outline-info" href="{{route('crearProducto')}}">Crear Producto.0</a>
    <table class="table table-striped">
        <thead class="table-info">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Precio</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
    </table>
@endsection