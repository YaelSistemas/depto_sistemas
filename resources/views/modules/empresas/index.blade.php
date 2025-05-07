@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Empresas</h1>
  </div><!-- End Page Title -->
  
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar Empresas</h5>
            <p>Gestiona las empresas disponibles en el sistema.</p>
            
            <a href="{{ route('empresas.create') }}" class="btn btn-primary">
              <i class="fa-solid fa-circle-plus"></i> Nueva Empresa
            </a>
            <hr>
            
            <table class="table table-striped table-bordered datatable">
              <thead>
                <tr>
                  <th class="text-center">Empresa</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                <tr class="text-center">
                  <td>{{ $item->nombre }}</td>
                  <td>
                    <a href="{{ route('empresas.edit', $item->id) }}" class="btn btn-warning">
                      <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="{{ route('empresas.show', $item->id) }}" class="btn btn-danger">
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