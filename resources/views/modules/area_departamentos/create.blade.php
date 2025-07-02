@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Área / Departamento</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Agregar Nueva Área / Departamento</h5>

            <form action="{{ route('areas.store') }}" method="POST">
              @csrf

              <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre del Área / Departamento</label>
                <input type="text" class="form-control" required name="nombre" id="nombre">
              </div>

              <div class="mb-3">
                <label for="unidad_servicio_id" class="form-label fw-bold">Unidad de Servicio</label>
                <select class="form-select" name="unidad_servicio_id" id="unidad_servicio_id" required>
                  <option value="">Selecciona una unidad</option>
                  @foreach($unidades as $unidad)
                    <option value="{{ $unidad->id }}" data-empresa="{{ $unidad->empresa->id }}">
                      {{ $unidad->nombre }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="empresa_id" class="form-label fw-bold">Empresa</label>
                <select class="form-select" name="empresa_id" id="empresa_id" required>
                  <option value="">Selecciona una empresa</option>
                  @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                  @endforeach
                </select>
              </div>

              <div class="text-end">
                <a href="{{ route('areas') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const unidadSelect = document.getElementById('unidad_servicio_id');
    const empresaSelect = document.getElementById('empresa_id');

    unidadSelect.addEventListener('change', function () {
      const selectedOption = this.options[this.selectedIndex];
      const empresaId = selectedOption.getAttribute('data-empresa');

      if (empresaId) {
        empresaSelect.value = empresaId;
      }
    });
  });
</script>
@endpush

@endsection
