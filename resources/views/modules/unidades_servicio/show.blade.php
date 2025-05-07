@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Eliminar Unidad de Servicio</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">¿Estás seguro de eliminar esta unidad de servicio?</h5>

            <form action="{{ route('unidades.destroy', $item->id) }}" method="POST">
              @csrf
              @method('DELETE')

              <div class="mb-3">
                <label for="nombre" class="fw-bold">Nombre de la Unidad</label>
                <input type="text" class="form-control" readonly name="nombre" id="nombre" value="{{ $item->nombre }}">
              </div>

              <div class="mb-3">
                <label class="fw-bold">Empresa</label>
                <input type="text" class="form-control" readonly value="{{ $item->empresa->nombre ?? 'No asignada' }}">
              </div>

              <div class="mb-3">
                <label class="fw-bold">Responsable</label>
                <input type="text" class="form-control" readonly value="{{ $item->colaborador->nombre ?? 'No asignado' }} {{ $item->colaborador->apellido ?? '' }}">
              </div>

              <button class="btn btn-danger mt-3">Eliminar</button>
              <a href="{{ route('unidades') }}" class="btn btn-info mt-3">Cancelar</a>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
