@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar Categoría</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Agregar Nueva Categoría</h5>

            <form action="{{ route('categorias.store') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre de la Categoría</label>
                <input type="text" class="form-control" required name="nombre" id="nombre">
              </div>

              <div class="text-end mt-4">
                <button class="btn btn-primary">Guardar</button>
                <a href="{{ route('categorias') }}" class="btn btn-secondary">Cancelar</a>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
