@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Entradas de Productos</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar Entradas</h5>
            <p>Administrar la entrada de productos.</p>

            <!-- Tabla -->
            <table class="table table-striped table-bordered datatable">
              <thead>
                <tr>
                  <th class="text-center align-middle">Entrada Hecha por</th>
                  <th class="text-center align-middle">Categoría</th>
                  <th class="text-center align-middle">Proveedor</th>
                  <th class="text-center align-middle">Nombre</th>
                  <th class="text-center align-middle">Cantidad</th>
                  <th class="text-center align-middle">Marca</th>
                  <th class="text-center align-middle">Modelo</th>
                  <th class="text-center align-middle">Fecha de Compra</th>
                  <th class="text-center align-middle">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                  <tr class="text-center">
                    <td class="text-center align-middle">{{ $item->nombre_usuario }}</td>
                    <td class="text-center align-middle">{{ $item->categoria }}</td>
                    <td class="text-center align-middle">{{ $item->proveedor }}</td>
                    <td class="text-center align-middle">{{ $item->nombre_producto }}</td>
                    <td class="text-center align-middle">{{ $item->cantidad }}</td>
                    <td class="text-center align-middle">{{ $item->marca }}</td>
                    <td class="text-center align-middle">{{ $item->modelo }}</td>
                    <td class="text-center align-middle">{{ \Carbon\Carbon::parse($item->fecha_compra)->format('Y-m-d') }}</td>
                    <td class="text-center align-middle">
                      <a href="{{ route('entradas.edit', $item->id) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pen"></i>
                      </a>
                      <a href="{{ route('entradas.show', $item->id) }}" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <!-- Fin Tabla -->

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
