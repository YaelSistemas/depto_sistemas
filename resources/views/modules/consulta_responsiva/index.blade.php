@extends('layouts.main')

@section('titulo', $titulo)

<style>
  .v-middle td,
  .v-middle th {
    vertical-align: middle !important;
  }
</style>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Consulta Responsivas</h1>
  </div>

  <section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Historial de Responsivas</h5>

        <!-- Envoltura scroll horizontal -->
        <div class="table-responsive" style="overflow-x: auto;">
          <table class="table table-bordered table-striped datatable v-middle w-100" style="min-width: 1100px;">
            <thead>
              <tr class="text-center">
                <th class="text-center">No. de Salida</th>
                <th class="text-center">Fecha de Solicitud</th>
                <th class="text-center">Nombre del Usuario</th>
                <th class="text-center">Área/Depto/Sede</th>
                <th class="text-center">Motivo de Entrega</th>
                <th class="text-center">Productos Asignados</th>
                <th class="text-center">Fecha de Entrega</th>
                <th class="text-center">Recibió</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($responsivas as $resp)
                <tr class="text-center">
                  <td>OES-{{ str_pad($resp->id, 5, '0', STR_PAD_LEFT) }}</td>
                  <td>{{ \Carbon\Carbon::parse($resp->fecha_asignacion)->format('d/m/Y') }}</td>
                  <td>{{ $resp->colaborador->nombre ?? 'N/D' }} {{ $resp->colaborador->apellido ?? '' }}</td>
                  <td>{{ $resp->unidad ?? '-' }} - {{ $resp->area ?? '-' }}</td>
                  <td>{{ $resp->motivo_entrega }}</td>
                  <td>
                    <ul class="list-unstyled mb-0">
                      @foreach ($resp->productos as $p)
                        <li>{{ $p->nombre }} - {{ $p->pivot->cantidad_asignada }} pz</li>
                      @endforeach
                    </ul>
                  </td>
                  <td>{{ \Carbon\Carbon::parse($resp->fecha_entrega)->format('d/m/Y') }}</td>
                  <td>{{ $resp->recibio?->nombre ?? 'N/D' }} {{ $resp->recibio?->apellido ?? '' }}</td>
                  <td class="align-middle">
                    <div class="d-flex justify-content-center align-items-center gap-1" style="min-height: 38px;">
                      <a href="{{ route('responsivas.show', ['id' => $resp->id, 'from' => 'consulta']) }}" class="btn btn-sm btn-info text-white">Ver</a>
                      <a href="{{ route('responsivas.edit', ['id' => $resp->id, 'from' => 'consulta']) }}" class="btn btn-sm btn-primary">Editar</a>
                      <a href="{{ route('responsivas.pdf', $resp->id) }}" class="btn btn-sm btn-dark" target="_blank">PDF</a>
                      <a href="{{ route('responsivas.transporte.show', ['id' => $resp->id, 'from' => 'consulta']) }}" class="btn btn-sm btn-warning">Transporte</a>
                    </div>
                  </td>
                  
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </section>
</main>
