@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Unidades de Servicio</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar Unidades de Servicio</h5>
            <p>Gestiona las unidades de servicio disponibles en el sistema.</p>

            <a href="{{ route('unidades.create') }}" class="btn btn-primary">
              <i class="fa-solid fa-circle-plus"></i> Nueva Unidad de Servicio
            </a>
            <hr>

            <table class="table table-striped table-bordered datatable">
              <thead>
                <tr class="text-center">
                  <th class="text-center">Unidad de Servicio</th>
                  <th class="text-center">Empresa</th>
                  <th class="text-center">Responsable</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                  <tr class="text-center">
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->empresa->nombre ?? 'No asignada' }}</td>
                    <td class="text-center">{{ $item->colaborador->nombre ?? 'No asignado' }}</td>
                    <td>
                      <a href="{{ route('unidades.edit', $item->id) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pen"></i>
                      </a>
                      <a href="{{ route('unidades.show', $item->id) }}" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <!-- End Table with stripped rows -->
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
