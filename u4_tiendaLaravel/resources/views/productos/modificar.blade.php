@extends('plantilla/plantilla')

@section('titulo','MODIFICAR PRODUCTO '.$p->nombre);
    
@section('contenido')
  <form action="{{route('actualizarP',$p->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nombre" class="form-label">ID:</label>
        <input type="text" class="form-control" name="id" id="id" value="{{$p->id}}" disabled="disabled">
    </div>
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" name="nombre" id="nombre" value="{{$p->nombre}}">
    </div>
    <div class="mb-3">
        <label for="desc" class="form-label">Descripción</label>
        <input type="text" class="form-control" name="desc" id="desc" value="{{$p->descripcion}}" placeholder="Descripcion">
    </div>
    <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" class="form-control" name="precio" id="precio" value="{{$p->precio}}" step="0.01">
    </div>
    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" class="form-control" name="stock" id="stock" value="{{$p->stock}}" >
    </div>
    <div class="mb-3">
        <label for="imagen" class="form-label">Imagen</label>
        <img src="{{asset('storage/'.$p->img)}}" width="50px"/>
        <input type="file" class="form-control" name="imagen" id="imagen" >
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-outline-primary">Modificar</button>
        <a href="{{route('productos')}}" class="btn btn-outiline-primary">Cancelar</a>
    </div>
  </form>
@endsection