@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Responsiva</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Crear una Nueva Responsiva</h5>
            <p>Crear Responsivas de los productos existentes.</p>

            <button class="btn btn-success mb-3" onclick="abrirModalResponsiva()">
              <i class="fa fa-plus"></i> Crear Responsiva
            </button>

            <table class="table table-striped table-bordered datatable table-condensed">
              <thead>
                <tr>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Descripción</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-center">Marca</th>
                  <th class="text-center">Modelo</th>
                  <th class="text-center">No. Serie</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                <tr>
                  <td>{{ $item->nombre }}</td>
                  <td class="text-center">{{ $item->descripcion }}</td>
                  <td class="text-center">{{ $item->cantidad }}</td>
                  <td class="text-center">{{ $item->marca }}</td>
                  <td class="text-center">{{ $item->modelo }}</td>
                  <td class="text-center">{{ $item->no_serie }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Modal Crear Responsiva -->
<div class="modal fade" id="modalResponsiva" tabindex="-1" aria-labelledby="modalResponsivaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('responsivas.store') }}" class="modal-content">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title" id="modalResponsivaLabel">Crear Responsiva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label for="producto_id" class="form-label">Seleccionar Producto</label>
          <select name="producto_id" id="producto_id" class="form-select" required>
            <option value="">-- Selecciona un producto --</option>
            @foreach ($items as $item)
              <option value="{{ $item->id }}">
                {{ $item->nombre }} - {{ $item->marca }} - {{ $item->modelo }}
              </option>
            @endforeach
          </select>
        </div>
      
        <div class="mb-3">
          <label for="cantidad" class="form-label">Cantidad a Asignar</label>
          <input type="number" name="cantidad_asignada" id="cantidad" class="form-control" min="1" required>
        </div>
      
        <div class="mb-3">
          <label for="fecha_asignacion" class="form-label">Fecha de Asignación</label>
          <input type="date" name="fecha_asignacion" id="fecha_asignacion" class="form-control" required>
        </div>
      
        <div class="mb-3">
          <label for="colaborador_id" class="form-label">Seleccionar Colaborador</label>
          <select name="colaborador_id" id="colaborador_id" class="form-select" required>
            <option value="">-- Selecciona un colaborador --</option>
            @foreach ($colaboradores as $colaborador)
              <option value="{{ $colaborador->id }}">
                {{ $colaborador->nombre }} {{ $colaborador->apellido }} - {{ $colaborador->empresa }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Crear</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function abrirModalResponsiva() {
    let modal = new bootstrap.Modal(document.getElementById('modalResponsiva'));
    modal.show();
  }
</script>
@endpush
