@extends('layouts.main')

@section('titulo', 'Transportista - Responsiva No. ' . $responsiva->id)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Responsiva de Transporte</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Colaborador Transportista</h5>

            <form action="{{ route('responsivas.transporte.store', $responsiva->id) }}" method="POST">
              @csrf

              @php
                $nombresColaboradores = $colaboradores->map(function($c) {
                    return $c->nombre . ' ' . $c->apellido;
                })->toArray();

                $valorSeleccionado = $responsiva->nombre_transportista ?? null;
                $esOtro = $valorSeleccionado && !in_array($valorSeleccionado, $nombresColaboradores);
              @endphp

              <div class="mb-3">
                <label for="nombre_transportista" class="form-label fw-bold">Selecciona transportista</label>
                <select name="nombre_transportista" id="nombre_transportista" class="form-select" onchange="mostrarCampoOtro()" required>
                  <option value="" disabled {{ is_null($valorSeleccionado) ? 'selected' : '' }}>-- Selecciona un colaborador --</option>
                  @foreach ($colaboradores as $colab)
                    @php $nombreCompleto = $colab->nombre . ' ' . $colab->apellido; @endphp
                    <option value="{{ $nombreCompleto }}" {{ $valorSeleccionado === $nombreCompleto ? 'selected' : '' }}>
                      {{ $nombreCompleto }}
                    </option>
                  @endforeach
                  <option value="otro" {{ $esOtro ? 'selected' : '' }}>Otro</option>
                </select>
              </div>

              <div class="mb-3" id="campoOtro" style="{{ $esOtro ? '' : 'display: none;' }}">
                <label for="nombre_otro" class="form-label fw-bold">Escribe el nombre del transportista</label>
                <input type="text" name="nombre_otro" id="nombre_otro" class="form-control"
                       value="{{ $esOtro ? $valorSeleccionado : '' }}">
              </div>

              <div class="text-end mt-4">
                <a href="{{ route('responsivas.show', $responsiva->id) }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Generar PDF Transporte</button>
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
  function mostrarCampoOtro() {
    const select = document.getElementById('nombre_transportista');
    const campoOtro = document.getElementById('campoOtro');

    if (select.value === 'otro') {
      campoOtro.style.display = 'block';
      document.getElementById('nombre_otro').setAttribute('required', 'required');
    } else {
      campoOtro.style.display = 'none';
      document.getElementById('nombre_otro').removeAttribute('required');
    }
  }

  // Ejecutar al cargar si ya existe transportista personalizado
  window.addEventListener('DOMContentLoaded', mostrarCampoOtro);
</script>
@endpush
@endsection
