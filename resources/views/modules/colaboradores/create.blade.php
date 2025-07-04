@extends('layouts.main')

@section('titulo', 'Crear Colaborador')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar Colaborador</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Nuevo Registro</h5>

            <form method="POST" action="{{ route('colaboradores.store') }}">
              @csrf

              <div class="mb-3">
                <label class="form-label fw-bold">Nombre(s)</label>
                <input type="text" name="nombre" class="form-control" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Apellidos</label>
                <input type="text" name="apellido" class="form-control" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Empresa</label>
                <select class="form-select" id="empresa_select" name="empresa_id" required>
                  <option value="">Seleccione una empresa</option>
                  @foreach ($empresas as $empresa)
                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Unidad de Servicio</label>
                <select class="form-select" id="unidad_select" name="unidad_servicio_id" required>
                  <option value="">Seleccione una unidad</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Área / Departamento</label>
                <select class="form-select" id="area_select" name="area_departamento_id" required>
                  <option value="">Seleccione un área</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold">Puesto</label>
                <select class="form-select" id="puesto_select" name="puesto">
                  <option value="">Seleccione un puesto</option>
                  @foreach ($puestos as $puesto)
                    <option value="{{ $puesto }}">{{ $puesto }}</option>
                  @endforeach
                  <option value="otro">Otro...</option>
                </select>
                <input type="text" class="form-control mt-2 d-none" id="puesto_input" placeholder="Escriba el puesto">
              </div>

              <input type="hidden" name="user_id" value="{{ Auth::id() }}">

              <div class="text-end mt-4">
                <a href="{{ route('colaboradores') }}" class="btn btn-secondary">Cancelar</a>
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
  const relaciones = @json($relaciones);

  const empresaSelect = document.getElementById('empresa_select');
  const unidadSelect = document.getElementById('unidad_select');
  const areaSelect = document.getElementById('area_select');

  empresaSelect.addEventListener('change', function () {
    const id = this.value;
    unidadSelect.innerHTML = '<option value="">Seleccione una unidad</option>';
    areaSelect.innerHTML = '<option value="">Seleccione un área</option>';

    if (relaciones[id]) {
      relaciones[id].unidades.forEach(unidad => {
        const opt = document.createElement('option');
        opt.value = unidad.id;
        opt.textContent = unidad.nombre;
        unidadSelect.appendChild(opt);
      });
    }
  });

  unidadSelect.addEventListener('change', function () {
    const empresaId = empresaSelect.value;
    const unidadId = this.value;
    areaSelect.innerHTML = '<option value="">Seleccione un área</option>';

    if (relaciones[empresaId]) {
      const areas = relaciones[empresaId].areas.filter(a => a.unidad_id == unidadId);
      areas.forEach(area => {
        const opt = document.createElement('option');
        opt.value = area.id;
        opt.textContent = area.nombre;
        areaSelect.appendChild(opt);
      });
    }
  });

  const puestoSelect = document.getElementById('puesto_select');
  const puestoInput = document.getElementById('puesto_input');

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
</script>
@endpush
@endsection
