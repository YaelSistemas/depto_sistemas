@extends('layouts.main')

@section('titulo', 'Productos Asignados')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Productos Asignados</h1>
    <p class="text-muted">Listado de Productos con Asignaciones</p>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar Asignaciones</h5>
            @if ($asignaciones->isEmpty())
              <p class="text-center mt-3">No hay productos asignados.</p>
            @else
              <div class="table-responsive">
                <table class="table table-striped table-bordered text-center align-middle datatable">
                    <thead class="table-light">
                        <tr>
                          <th class="text-center">Motivo de Entrega</th>
                          <th class="text-center">No. de Salida</th>
                          <th class="text-center">Colaborador</th>
                          <th class="text-center">Puesto</th>
                          <th class="text-center">Unidad de Servicio</th>
                          <th class="text-center">Empresa</th>
                          <th class="text-center">Producto</th>
                          <th class="text-center">Marca</th>
                          <th class="text-center">Modelo</th>
                          <th class="text-center">No. Serie</th>
                          <th class="text-center">Categoría</th>
                          <th class="text-center">RAM</th>
                          <th class="text-center">Procesador</th>
                          <th class="text-center">Tipo Almacenamiento</th>
                          <th class="text-center">Capacidad</th>
                          <th class="text-center">Fecha de Compra</th>
                          <th class="text-center">Fecha de Entrega</th>
                        </tr>
                      </thead>
                  <tbody>
                    @foreach ($asignaciones as $asignacion)
<tr>
    <td>
        @php
            $motivo = $asignacion->responsiva->motivo_entrega;
        @endphp
        <span class="badge 
            @if($motivo === 'Asignacion') bg-success
            @elseif($motivo === 'Prestamo Provisional') bg-warning text-dark
            @elseif($motivo === 'Fallo') bg-danger
            @else bg-secondary
            @endif">
            {{ $motivo }}
        </span>
    </td>
    <td>{{ 'OES-' . str_pad($asignacion->responsiva->id, 5, '0', STR_PAD_LEFT) }}</td>
    <td>{{ $asignacion->responsiva->colaborador->nombre ?? '—' }}</td>
    <td>{{ $asignacion->responsiva->colaborador->puesto ?? '—' }}</td>
    <td>{{ $asignacion->responsiva->colaborador->unidad->nombre ?? '—' }}</td>
    <td>{{ $asignacion->responsiva->colaborador->empresa->nombre ?? '—' }}</td>
    <td>{{ $asignacion->producto->nombre ?? '—' }}</td>
    <td>{{ $asignacion->producto->marca ?? '—' }}</td>
    <td>{{ $asignacion->producto->modelo ?? '—' }}</td>
    <td>{{ $asignacion->producto->no_serie ?? '—' }}</td>
    <td>{{ $asignacion->producto->categoria->nombre ?? '—' }}</td>
    <td>{{ $asignacion->producto->ram ?? '—' }}</td>
    <td>{{ $asignacion->producto->procesador ?? '—' }}</td>
    <td>{{ $asignacion->producto->tipo_almacenamiento ?? '—' }}</td>
    <td>{{ $asignacion->producto->capacidad_almacenamiento ?? '—' }}</td>
    <td>{{ $asignacion->producto->created_at ? \Carbon\Carbon::parse($asignacion->producto->created_at)->format('d/m/Y') : '—' }}</td>
    <td>{{ $asignacion->responsiva->fecha_entrega ? \Carbon\Carbon::parse($asignacion->responsiva->fecha_entrega)->format('d/m/Y') : '—' }}</td>
</tr>
@endforeach

                  </tbody>
                </table>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
