@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Hacer una Entrada</h1>
    
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Nueva Entrada de : {{ $item->nombre }}</h5>
            
            <form action="{{ route('entradas.store') }}" method="POST">
                @csrf
                
                <input type="text" value="{{ $item->id }}" id="id" name="id" hidden>

                <label for="cantidad">Cantidad del Producto</label>
                <input type="text" class="form-control" required name="cantidad" id="cantidad">

                <label for="precio">Precio</label>
                <input type="text" class="form-control" required name="precio" id="precio">

                <button class="btn btn-primary mt-3">Realizar Entrada</button>
                <a href="{{ route("productos")}}" class="btn btn-info mt-3">Cancelar</a>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection
