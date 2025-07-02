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
    <h1>Consulta Entrega de Cartuchos</h1>
  </div>

  <section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Historial de Entregas</h5>

        <table class="table table-bordered table-striped datatable v-middle">
          <thead>
            <tr class="text-center">
              <th>No. de Salida</th>
              <th>Fecha de Solicitud</th>
              <th>Nombre del Usuario</th>
              <th>Unidad/Área</th>
              <th>Cartuchos Asignados</th>
              <th>Fecha de Entrega</th>
              <th>Recibió</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($entregas as $entrega)
              <tr class="text-center">
                <td>SEC-{{ str_pad($entrega->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td>{{ \Carbon\Carbon::parse($entrega->fecha_asignacion)->format('d/m/Y') }}</td>
                <td>{{ $entrega->colaborador->nombre ?? 'N/D' }} {{ $entrega->colaborador->apellido ?? '' }}</td>
                <td>{{ $entrega->unidad ?? '-' }} - {{ $entrega->area ?? '-' }}</td>
                <td>
                  <ul class="list-unstyled">
                    @foreach ($entrega->productos as $p)
                      <li>{{ $p->nombre }} - {{ $p->pivot->cantidad_asignada }} pz</li>
                    @endforeach
                  </ul>
                </td>
                <td>{{ \Carbon\Carbon::parse($entrega->fecha_entrega)->format('d/m/Y') }}</td>
                <td>{{ $entrega->recibio?->nombre ?? 'N/D' }} {{ $entrega->recibio?->apellido ?? '' }}</td>
                <td class="text-center">
                  <div class="d-flex justify-content-center align-items-center gap-1">
                    <a href="{{ route('entrega_cartuchos.show', ['id' => $entrega->id, 'from' => 'consulta']) }}" class="btn btn-sm btn-info text-white">
                      Ver
                    </a>
                    <a href="{{ route('entrega_cartuchos.edit', ['id' => $entrega->id, 'from' => 'consulta']) }}" class="btn btn-sm btn-primary">
                      Editar
                    </a>
                    <a href="{{ route('entrega_cartuchos.pdf', $entrega->id) }}" class="btn btn-sm btn-dark" target="_blank">
                      PDF
                    </a>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </section>
</main>
