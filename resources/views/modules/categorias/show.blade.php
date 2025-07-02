@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Eliminar Categoría</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body pt-3">
            <h5 class="card-title text-danger">¿Estás seguro de eliminar esta categoría?</h5>
            <p>Una vez eliminada, no podrá ser recuperada.</p>

            <form action="{{ route('categorias.destroy', $item->id) }}" method="POST">
              @csrf
              @method('DELETE')

              <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre de la Categoría</label>
                <input type="text" class="form-control" readonly name="nombre" id="nombre" value="{{ $item->nombre }}">
              </div>

              <div class="text-end mt-4">
                <button class="btn btn-danger">Eliminar</button>
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
