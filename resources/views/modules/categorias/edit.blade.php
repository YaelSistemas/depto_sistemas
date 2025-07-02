@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar Categoría</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Actualizar Categoría</h5>

            <form action="{{ route('categorias.update', $item->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre de la Categoría</label>
                <input type="text" class="form-control" required name="nombre" id="nombre" value="{{ $item->nombre }}">
              </div>

              <div class="text-end mt-4">
                <button class="btn btn-warning">Actualizar</button>
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
