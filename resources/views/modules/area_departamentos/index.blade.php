@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Áreas / Departamentos</h1>
  </div><!-- End Page Title -->
  
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar Áreas / Departamentos</h5>
            <p>Gestiona las áreas o departamentos disponibles en el sistema.</p>
            
            <a href="{{ route('areas.create') }}" class="btn btn-primary">
              <i class="fa-solid fa-circle-plus"></i> Nueva Área / Departamento
            </a>
            <hr>
            
            <table class="table table-striped table-bordered datatable">
              <thead>
                <tr class="text-center">
                  <th class="text-center">Área / Departamento</th>
                  <th class="text-center">Unidad de Servicio</th>
                  <th class="text-center">Empresa</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                <tr class="text-center">
                  <td>{{ $item->nombre }}</td>
                  <td>{{ $item->unidad->nombre ?? 'No definido' }}</td>
                  <td>{{ $item->empresa->nombre ?? 'No definido' }}</td>
                  <td>
                    <a href="{{ route('areas.edit', $item->id) }}" class="btn btn-warning">
                      <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="{{ route('areas.show', $item->id) }}" class="btn btn-danger">
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
