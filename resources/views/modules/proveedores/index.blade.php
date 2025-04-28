@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Proveedores</h1>
    
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar Proveedores</h5>
            <p>
              Admnistrar los proveedores de nuestros productos.
            </p>
            <!-- Table with stripped rows -->
            <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
              <i class="fa-solid fa-circle-plus"></i> Nuevo Proveedor
            </a>
            <hr>
            <table class="table table-striped table-bordered datatable">
              <thead>
                <tr>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Telefono</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Ubicacion</th>
                  <th class="text-center">Sitio Web</th>
                  <th class="text-center">Nota</th>
                  <th class="text-center">
                    Acciones
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                  <tr class="text-center">
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->telefono }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->ubicacion }}</td>
                    <td>{{ $item->sitio_web }}</td>
                    <td>{{ $item->notas }}</td>
                    <td>
                      <a href="{{ route('proveedores.edit', $item->id) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pen"></i>
                      </a>
                      <a href="{{ route('proveedores.show', $item->id) }}" class="btn btn-danger">
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
