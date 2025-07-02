@extends('layouts.main')

@section('titulo', 'Editar Colaborador')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar Colaborador</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">
        <div class="card shadow-sm">
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

              <div class="mb-3">
                <label class="form-label fw-bold">Unidad de Servicio</label>
                <select class="form-select" name="unidad_servicio_id" id="unidad_select" required>
                  <option value="">Seleccione una unidad</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Área / Departamento</label>
                <select class="form-select" name="area_departamento_id" id="area_select" required>
                  <option value="">Seleccione un área</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Puesto</label>
                <select class="form-select" id="puesto_select" name="puesto">
                  <option value="">Seleccione un puesto</option>
                  @foreach ($puestos as $puesto)
                    <option value="{{ $puesto }}" {{ $colaborador->puesto === $puesto ? 'selected' : '' }}>{{ $puesto }}</option>
                  @endforeach
                  <option value="otro">Otro...</option>
                </select>

                <input type="text" class="form-control mt-2 {{ in_array($colaborador->puesto, $puestos) ? 'd-none' : '' }}"
                       id="puesto_input"
                       name="{{ in_array($colaborador->puesto, $puestos) ? '' : 'puesto' }}"
                       value="{{ in_array($colaborador->puesto, $puestos) ? '' : $colaborador->puesto }}"
                       placeholder="Escriba el puesto">
              </div>

              <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('colaboradores') }}" class="btn btn-secondary">Cancelar</a>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
  const relaciones = @json($relaciones);
  const colaboradorEmpresa = {{ $colaborador->empresa_id }};
  const colaboradorUnidad = {{ $colaborador->unidad_servicio_id }};
  const colaboradorArea = {{ $colaborador->area_departamento_id }};
  const puestoActual = @json($colaborador->puesto);

  const empresaSelect = document.getElementById('empresa_select');
  const unidadSelect = document.getElementById('unidad_select');
  const areaSelect = document.getElementById('area_select');
  const puestoSelect = document.getElementById('puesto_select');
  const puestoInput = document.getElementById('puesto_input');

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

  puestoSelect.addEventListener('change', function () {
    if (this.value === 'otro') {
      puestoInput.classList.remove('d-none');
      puestoInput.setAttribute('name', 'puesto');
      puestoInput.required = true;
      puestoSelect.removeAttribute('name');
    } else {
      puestoInput.classList.add('d-none');
      puestoInput.removeAttribute('name');
      puestoInput.required = false;
      puestoSelect.setAttribute('name', 'puesto');
    }
  });

  // Precarga inicial
  cargarUnidades(colaboradorEmpresa, colaboradorUnidad);
  cargarAreas(colaboradorEmpresa, colaboradorUnidad, colaboradorArea);
</script>
@endsection
