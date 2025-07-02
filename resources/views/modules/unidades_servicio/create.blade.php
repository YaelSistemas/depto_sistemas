@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Unidades de Servicio</h1>
    <p class="text-muted">Formulario para registrar una nueva unidad de servicio</p>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Agregar Nueva Unidad de Servicio</h5>

            <form action="{{ route('unidades.store') }}" method="POST">
              @csrf

              <div class="row mb-3">
                <div class="col-md-12">
                  <label for="nombre" class="form-label fw-bold">Nombre de la Unidad</label>
                  <input type="text" class="form-control" required name="nombre" id="nombre" placeholder="Ej. Aztecas, Xoxtla, etc...">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="empresa_id" class="form-label fw-bold">Empresa</label>
                  <select class="form-select" name="empresa_id" id="empresa_id" required>
                    <option value="">Seleccione una empresa</option>
                    @foreach($empresas as $empresa)
                      <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="colaborador_id" class="form-label fw-bold">Responsable</label>
                  <select class="form-select" name="colaborador_id" id="colaborador_id" required>
                    <option value="">Seleccione un colaborador</option>
                    @foreach($colaboradores as $colaborador)
                      <option value="{{ $colaborador->id }}">{{ $colaborador->nombre }} {{ $colaborador->apellido }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="text-end">
                <a href="{{ route('unidades') }}" class="btn btn-secondary">Cancelar</a>
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
