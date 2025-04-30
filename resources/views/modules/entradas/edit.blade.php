@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar una Entrada</h1>
    
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edicio de : {{ $item->nombre_producto }}</h5>
            
            <form action="{{ route('entradas.update', $item->id) }}" method="POST">
                @csrf
                @method("PUT")
                <input type="text" value="{{ $item->producto_id }}" id="producto_id" name="producto_id" hidden>

                <label for="cantidad">Cantidad del Producto</label>
                <input type="text" class="form-control" required name="cantidad" id="cantidad" value="{{ $item->cantidad }}">

                <label for="precio">Precio</label>
                <input type="text" class="form-control" required name="precio" id="precio" value="{{ $item->precio }}">

                <button class="btn btn-warning mt-3">Actualizar</button>
                <a href="{{ route("entradas")}}" class="btn btn-info mt-3">Cancelar</a>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection
