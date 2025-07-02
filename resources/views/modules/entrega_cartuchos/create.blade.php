@extends('layouts.main')

@section('titulo', 'Crear Entrega de Cartuchos')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Crear Entrega de Cartuchos</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Nueva Entrega</h5>

            <form method="POST" action="{{ route('entrega_cartuchos.store') }}">
                @csrf

                <div class="card mb-4">
                  <div class="card-header"><strong>Datos del Usuario</strong></div>
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label for="fecha_asignacion" class="form-label">Fecha de Solicitud</label>
                        <input type="date" name="fecha_asignacion" id="fecha_asignacion" class="form-control" required>
                      </div>

                      <div class="col-md-6">
                        <label for="colaborador_id" class="form-label">Nombre del Usuario</label>
                        <select name="colaborador_id" id="colaborador_id" class="form-select" required>
                          <option value="">-- Selecciona un colaborador --</option>
                          @foreach ($colaboradores as $colaborador)
                            <option value="{{ $colaborador->id }}"
                              data-unidad="{{ $colaborador->unidadServicio->nombre ?? '' }}"
                              data-area="{{ $colaborador->areaDepartamento->nombre ?? '' }}">
                              {{ $colaborador->nombre }} {{ $colaborador->apellido }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="form-label">Área/Depto/Sede</label>
                        <input type="text" class="form-control" readonly value="" id="area_sede" placeholder="Se autocompleta al seleccionar usuario">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card mb-4">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Consumibles Asignados</strong>
                    <button type="button" class="btn btn-sm btn-primary" onclick="agregarProducto()">Agregar Consumible</button>
                  </div>
                  <div class="card-body">
                    <div id="productosContainer">
                      <div class="row mb-3 producto-row">
                        <div class="col-md-5">
                          <label class="form-label">Consumible</label>
                          <select name="producto_id[]" class="form-select" required>
                            <option value="">-- Selecciona un Consumible --</option>
                            @foreach ($items as $item)
                              <option value="{{ $item->id }}">{{ $item->nombre }} - {{ $item->marca }} - {{ $item->modelo }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Cantidad</label>
                          <input type="number" name="cantidad_asignada[]" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                          <button type="button" class="btn btn-danger w-100" onclick="eliminarProducto(this)">Eliminar</button>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-md-6">
                        <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
                        <input type="date" name="fecha_entrega" id="fecha_entrega" class="form-control" required>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card mb-4">
                  <div class="card-header"><strong>Personal Involucrado</strong></div>
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label for="personal_entrego" class="form-label">Entregó</label>
                        <select name="personal_entrego" id="personal_entrego" class="form-select" required>
                          <option value="">-- Selecciona un usuario --</option>
                          @foreach ($usuariosAdmin as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="personal_recibio" class="form-label">Recibió</label>
                        <select name="personal_recibio" id="personal_recibio" class="form-select" required>
                          <option value="">-- Selecciona un colaborador --</option>
                          @foreach ($colaboradores as $colaborador)
                            <option value="{{ $colaborador->id }}">{{ $colaborador->nombre }} {{ $colaborador->apellido }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="text-end">
                  <a href="{{ route('entrega_cartuchos.index') }}" class="btn btn-secondary">Cancelar</a>
                  <button type="submit" class="btn btn-success">Crear Entrega</button>
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
    const select = document.getElementById('colaborador_id');
    const areaInput = document.getElementById('area_sede');

    select.addEventListener('change', function () {
      const selected = this.options[this.selectedIndex];
      const unidad = selected.getAttribute('data-unidad') || '-';
      const area = selected.getAttribute('data-area') || '-';
      areaInput.value = `${unidad} - ${area}`;
    });
  });

  function agregarProducto() {
    const container = document.getElementById('productosContainer');
    const row = container.querySelector('.producto-row');
    const clone = row.cloneNode(true);
    clone.querySelectorAll('input').forEach(input => input.value = '');
    clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
    container.appendChild(clone);
  }

  function eliminarProducto(btn) {
    const container = document.getElementById('productosContainer');
    if (container.querySelectorAll('.producto-row').length > 1) {
      btn.closest('.producto-row').remove();
    }
  }
</script>
@endpush
@endsection
