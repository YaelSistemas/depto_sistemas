@extends('layouts.main')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Consulta Responsivas</h1>
      
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Historial de Responsivas</h5>
      
          <table class="table table-bordered table-striped datatable">
            <thead>
              <tr class="text-center">
                <th>Producto</th>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>No. Serie</th>
                <th>Cantidad Asignada</th>
                <th>Colaborador</th>
                <th>Fecha Asignación</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($responsivas as $resp)
                <tr class="text-center">
                  <td>{{ $resp->producto->nombre ?? 'N/A' }}</td>
                  <td>{{ $resp->producto->descripcion ?? 'N/A' }}</td>
                  <td>{{ $resp->producto->marca ?? 'N/A' }}</td>
                  <td>{{ $resp->producto->modelo ?? 'N/A' }}</td>
                  <td>{{ $resp->producto->no_serie ?? 'N/A' }}</td>
                  <td>{{ $resp->cantidad_asignada }}</td>
                  <td>
                    {{ $resp->colaborador->nombre ?? 'N/D' }}
                    {{ $resp->colaborador->apellido ?? '' }}
                  </td>
                  <td>{{ \Carbon\Carbon::parse($resp->fecha_asignacion)->format('d/m/Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
      
        </div>
      </div>
      
    </section>

  </main><!-- End #main -->