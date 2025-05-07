@extends('layouts.main')

@section('titulo', 'Editar Colaborador')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar Colaborador</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Actualizar Información</h5>

        <form method="POST" action="{{ route('colaboradores.update', $colaborador->id) }}">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label fw-bold">Nombre(s)</label>
            <input type="text" name="nombre" class="form-control" value="{{ $colaborador->nombre }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Apellidos</label>
            <input type="text" name="apellido" class="form-control" value="{{ $colaborador->apellido }}" required>
          </div>

          {{-- Empresa --}}
          <div class="mb-3">
            <label class="form-label fw-bold">Empresa</label>
            <select class="form-select" name="empresa_id" id="empresa_select" required>
              <option value="">Seleccione una empresa</option>
              @foreach ($empresas as $empresa)
                <option value="{{ $empresa->id }}" {{ $empresa->id == $colaborador->empresa_id ? 'selected' : '' }}>
                  {{ $empresa->nombre }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Unidad --}}
          <div class="mb-3">
            <label class="form-label fw-bold">Unidad de Servicio</label>
            <select class="form-select" name="unidad_servicio_id" id="unidad_select" required>
              <option value="">Seleccione una unidad</option>
            </select>
          </div>

          {{-- Área --}}
          <div class="mb-3">
            <label class="form-label fw-bold">Área / Departamento</label>
            <select class="form-select" name="area_departamento_id" id="area_select" required>
              <option value="">Seleccione un área</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Puesto</label>
            <input type="text" name="puesto" class="form-control" value="{{ $colaborador->puesto }}" required>
          </div>

          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          <a href="{{ route('colaboradores') }}" class="btn btn-secondary">Cancelar</a>
        </form>
      </div>
    </div>
  </section>
</main>

<script>
  const relaciones = @json($relaciones);
  const colaboradorEmpresa = {{ $colaborador->empresa_id }};
  const colaboradorUnidad = {{ $colaborador->unidad_servicio_id }};
  const colaboradorArea = {{ $colaborador->area_departamento_id }};

  const empresaSelect = document.getElementById('empresa_select');
  const unidadSelect = document.getElementById('unidad_select');
  const areaSelect = document.getElementById('area_select');

  function cargarUnidades(empresaId, selectedUnidadId = null) {
    unidadSelect.innerHTML = '<option value="">Seleccione una unidad</option>';
    areaSelect.innerHTML = '<option value="">Seleccione un área</option>';

    if (relaciones[empresaId]) {
      relaciones[empresaId].unidades.forEach(unidad => {
        const opt = document.createElement('option');
        opt.value = unidad.id;
        opt.textContent = unidad.nombre;
        if (unidad.id == selectedUnidadId) opt.selected = true;
        unidadSelect.appendChild(opt);
      });
    }
  }

  function cargarAreas(empresaId, unidadId, selectedAreaId = null) {
    areaSelect.innerHTML = '<option value="">Seleccione un área</option>';

    if (relaciones[empresaId]) {
      relaciones[empresaId].areas
        .filter(a => a.unidad_id == unidadId)
        .forEach(area => {
          const opt = document.createElement('option');
          opt.value = area.id;
          opt.textContent = area.nombre;
          if (area.id == selectedAreaId) opt.selected = true;
          areaSelect.appendChild(opt);
        });
    }
  }

  empresaSelect.addEventListener('change', function () {
    cargarUnidades(this.value);
  });

  unidadSelect.addEventListener('change', function () {
    cargarAreas(empresaSelect.value, this.value);
  });

  // Precarga inicial
  cargarUnidades(colaboradorEmpresa, colaboradorUnidad);
  cargarAreas(colaboradorEmpresa, colaboradorUnidad, colaboradorArea);
</script>
@endsection
