@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Empresas</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Agregar Nueva Empresa</h5>

            <form action="{{ route('empresas.store') }}" method="POST">
              @csrf
              <label for="nombre" class="fw-bold">Nombre de la Empresa</label>
              <input type="text" class="form-control" required name="nombre" id="nombre">
              <button class="btn btn-primary mt-3">Guardar</button>
              <a href="{{ route('empresas') }}" class="btn btn-info mt-3">Cancelar</a>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
