@extends('layouts.main')

@section('titulo', 'Editar Responsiva')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar Responsiva</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Formulario de Edición</h5>

            <form method="POST" action="{{ route('responsivas.update', $responsiva->id) }}">
              @csrf
              @method('PUT')

              @if(request()->has('from') && request()->from === 'consulta')
    <input type="hidden" name="from" value="consulta">
  @endif
  
              <div class="card mb-4">
                <div class="card-header"><strong>Datos del Usuario</strong></div>
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label for="fecha_asignacion" class="form-label">Fecha de Solicitud</label>
                      <input type="date" name="fecha_asignacion" class="form-control" value="{{ $responsiva->fecha_asignacion }}" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Nombre del Usuario</label>
                      <input type="text" class="form-control" value="{{ $responsiva->colaborador->nombre }} {{ $responsiva->colaborador->apellido }}" readonly>
                      <input type="hidden" name="colaborador_id" value="{{ $responsiva->colaborador->id }}">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label class="form-label">Área/Depto/Sede</label>
                      <input type="text" class="form-control" value="{{ $responsiva->unidad }} - {{ $responsiva->area }}" readonly>
                    </div>
                    <div class="col-md-6">
                      <label for="motivo_entrega" class="form-label">Motivo de Entrega</label>
                      <select name="motivo_entrega" class="form-select" required>
                        @foreach(['Fallo', 'Prestamo Provisional', 'Asignacion'] as $motivo)
                          <option value="{{ $motivo }}" {{ $responsiva->motivo_entrega === $motivo ? 'selected' : '' }}>{{ $motivo }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <strong>Productos Asignados</strong>
                  <button type="button" class="btn btn-sm btn-primary" onclick="agregarProducto()">Agregar Producto</button>
                </div>
                <div class="card-body">
                  <div id="productosContainer">
                    @foreach($responsiva->productos as $p)
                      <div class="row mb-3 producto-row">
                        <div class="col-md-5">
                          <label class="form-label">Producto</label>
                          <select name="producto_id[]" class="form-select" required>
                            <option value="">-- Selecciona un producto --</option>
                            @foreach ($items as $item)
                              <option value="{{ $item->id }}" {{ $item->id == $p->id ? 'selected' : '' }}>{{ $item->nombre }} - {{ $item->marca }} - {{ $item->modelo }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Cantidad</label>
                          <input type="number" name="cantidad_asignada[]" class="form-control" min="1" value="{{ $p->pivot->cantidad_asignada }}" required>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                          <button type="button" class="btn btn-danger w-100" onclick="eliminarProducto(this)">Eliminar</button>
                        </div>
                      </div>
                    @endforeach
                  </div>

                  <div class="row mt-4">
                    <div class="col-md-6">
                      <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
                      <input type="date" name="fecha_entrega" id="fecha_entrega" class="form-control" value="{{ $responsiva->fecha_entrega }}" required>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card mb-4">
                <div class="card-header"><strong>Personal Involucrado</strong></div>
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-md-4">
                      <label for="personal_entrego" class="form-label">Entregó</label>
                      <select name="personal_entrego" class="form-select" required>
                        @foreach ($usuariosAdmin as $admin)
                          <option value="{{ $admin->id }}" {{ $responsiva->personal_entrego == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="personal_recibio" class="form-label">Recibió</label>
                      <select name="personal_recibio" class="form-select" required>
                        @foreach ($colaboradores as $colab)
                          <option value="{{ $colab->id }}" {{ $responsiva->personal_recibio == $colab->id ? 'selected' : '' }}>{{ $colab->nombre }} {{ $colab->apellido }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="personal_autorizo" class="form-label">Autorizó</label>
                      <select name="personal_autorizo" class="form-select" required>
                        @foreach ($usuariosAdmin as $admin)
                          <option value="{{ $admin->id }}" {{ $responsiva->personal_autorizo == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="text-end">
                <a href="{{ 
                  request()->query('from') === 'consulta' && request()->query('back') !== 'show'
                      ? route('consulta-responsiva') 
                      : route('responsivas.show', ['id' => $responsiva->id, 'from' => request()->query('from')]) 
              }}" class="btn btn-secondary">
                  Cancelar
              </a>
                <button type="submit" class="btn btn-success">Actualizar Responsiva</button>
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
