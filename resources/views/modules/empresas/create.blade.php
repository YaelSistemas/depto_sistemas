@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Empresas</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2"> <!-- Centrado como en otras vistas -->
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Agregar Nueva Empresa</h5>

            <form action="{{ route('empresas.store') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre de la Empresa</label>
                <input type="text" class="form-control" required name="nombre" id="nombre">
              </div>

              <div class="text-end">
                <a href="{{ route('empresas') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
