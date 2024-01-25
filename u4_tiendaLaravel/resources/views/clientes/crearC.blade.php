@extends('plantilla/plantilla')

@section('titulo','CREAR PRODUCTOS')
    
@section('contenido')
  <form action="{{route('insertarProducto')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" name="email" id="email" placeholder="Email" >
    </div>
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
    </div>
    <div class="mb-3">
        <label for="telefono" class="form-label">Telefono</label>
        <input type="text" class="form-control" name="telefono" id="telefono" step="0.01">
    </div>
    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" class="form-control" name="stock" id="stock" >
    </div>
    <div class="mb-3">
        <label for="imagen" class="form-label">Imagen</label>
        <input type="file" class="form-control" name="imagen" id="imagen" >
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-outline-primary">Crear</button>
        <a href="{{route('productos')}}" class="btn btn-outiline-primary">Cancelar</a>
    </div>
  </form>
@endsection