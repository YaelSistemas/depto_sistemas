@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Eliminar Área / Departamento</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">¿Estás seguro de eliminar esta área / departamento?</h5>

            <form action="{{ route('areas.destroy', $item->id) }}" method="POST">
              @csrf
              @method('DELETE')

              <div class="mb-3">
                <label class="form-label fw-bold">Nombre del Área / Departamento</label>
                <input type="text" class="form-control" readonly value="{{ $item->nombre }}">
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Unidad de Servicio</label>
                <input type="text" class="form-control" readonly value="{{ $item->unidad->nombre ?? 'No asignada' }}">
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Empresa</label>
                <input type="text" class="form-control" readonly value="{{ $item->empresa->nombre ?? 'No asignada' }}">
              </div>

              <div class="text-end">
                <a href="{{ route('areas') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-danger">Eliminar</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
