@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar Categoria</h1>
    
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Agregar Nueva Categoria</h5>
            
            <form action="{{ route("categorias.store") }}" method="POST">
                @csrf
                <label for="nombre" class="fw-bold">Nombre de la Categoria</label>
                <input type="text" class="form-control" required name="nombre" id="nombre">
                <button class="btn btn-primary mt-3">Guardar</button>
                <a href="{{ route("categorias")}}" class="btn btn-info mt-3">Cancelar</a>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection
