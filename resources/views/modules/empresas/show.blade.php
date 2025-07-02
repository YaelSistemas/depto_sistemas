@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Eliminar Empresa</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2"> <!-- Centrado visualmente -->
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-danger">¿Estás seguro de eliminar esta empresa?</h5>
            <p class="text-muted">Una vez eliminada, no podrás recuperarla.</p>

            <form action="{{ route('empresas.destroy', $item->id) }}" method="POST">
              @csrf
              @method('DELETE')

              <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre de la Empresa</label>
                <input type="text" class="form-control" readonly name="nombre" id="nombre" value="{{ $item->nombre }}">
              </div>

              <div class="text-end">
                <a href="{{ route('empresas') }}" class="btn btn-secondary">Cancelar</a>
                <button class="btn btn-danger">Eliminar</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
