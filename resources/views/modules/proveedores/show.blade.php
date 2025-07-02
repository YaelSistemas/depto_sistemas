@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Eliminar Proveedor</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body pt-4">
            <h5 class="card-title text-danger">¿Estás seguro de eliminar este proveedor?</h5>
            <p class="mb-4">Una vez eliminado, no podrá ser recuperado.</p>

            <table class="table table-striped table-bordered text-center">
              <thead class="table-light">
                <tr>
                  <th>Nombre</th>
                  <th>Teléfono</th>
                  <th>Email</th>
                  <th>Ubicación</th>
                  <th>Sitio Web</th>
                  <th>Notas</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{ $item->nombre }}</td>
                  <td>{{ $item->telefono }}</td>
                  <td>{{ $item->email }}</td>
                  <td>{{ $item->ubicacion }}</td>
                  <td>{{ $item->sitio_web }}</td>
                  <td>{{ $item->notas }}</td>
                </tr>
              </tbody>
            </table>

            <form method="POST" action="{{ route('proveedores.destroy', $item->id) }}">
              @csrf
              @method('DELETE')
              <div class="text-end mt-4">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a href="{{ route('proveedores') }}" class="btn btn-secondary">Cancelar</a>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
