@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Unidades de Servicio</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Agregar Nueva Unidad de Servicio</h5>

            <form action="{{ route('unidades.store') }}" method="POST">
              @csrf

              <div class="mb-3">
                <label for="nombre" class="fw-bold">Nombre de la Unidad</label>
                <input type="text" class="form-control" required name="nombre" id="nombre">
              </div>

              <div class="mb-3">
                <label for="empresa_id" class="fw-bold">Empresa</label>
                <select class="form-select" name="empresa_id" id="empresa_id" required>
                  <option value="">Seleccione una empresa</option>
                  @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="colaborador_id" class="fw-bold">Responsable</label>
                <select class="form-select" name="colaborador_id" id="colaborador_id" required>
                  <option value="">Seleccione un colaborador</option>
                  @foreach($colaboradores as $colaborador)
                    <option value="{{ $colaborador->id }}">{{ $colaborador->nombre }} {{ $colaborador->apellido }}</option>
                  @endforeach
                </select>
              </div>

              <button class="btn btn-primary mt-3">Guardar</button>
              <a href="{{ route('unidades') }}" class="btn btn-info mt-3">Cancelar</a>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
