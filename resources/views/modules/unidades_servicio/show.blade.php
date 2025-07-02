@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Unidades de Servicio</h1>
    <p class="text-muted">Confirmación para eliminar una unidad de servicio</p>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">¿Estás seguro de eliminar esta unidad de servicio?</h5>

            <form action="{{ route('unidades.destroy', $item->id) }}" method="POST">
              @csrf
              @method('DELETE')

              <div class="row mb-3">
                <div class="col-md-12">
                  <label for="nombre" class="form-label fw-bold">Nombre de la Unidad</label>
                  <input type="text" class="form-control" readonly name="nombre" id="nombre" value="{{ $item->nombre }}">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Empresa</label>
                  <input type="text" class="form-control" readonly value="{{ $item->empresa->nombre ?? 'No asignada' }}">
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">Responsable</label>
                  <input type="text" class="form-control" readonly value="{{ $item->colaborador->nombre ?? 'No asignado' }} {{ $item->colaborador->apellido ?? '' }}">
                </div>
              </div>

              <div class="text-end">
                <a href="{{ route('unidades') }}" class="btn btn-secondary">Cancelar</a>
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
