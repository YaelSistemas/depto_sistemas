@extends('layouts.main')

@section('contenido')
<main id="main" class="main">

  <div class="pagetitle d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
    <div>
      <h1 class="mb-0">Dashboard</h1>
    </div>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Sección en dos columnas -->
      <div class="col-12">
        <div class="row">
          <!-- Últimas 5 entradas -->
          <div class="col-md-6">
            <div class="card h-100">
              <div class="card-body">
                <h5 class="card-title">Últimas 5 Entradas de Productos</h5>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Usuario</th>
                        <th class="text-center">Fecha de Compra</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($ultimasEntradas as $entrada)
                        <tr class="text-center">
                          <td>{{ $entrada->producto->nombre }}</td>
                          <td>{{ $entrada->cantidad }}</td>
                          <td>{{ $entrada->usuario->name }}</td>
                          <td>{{ \Carbon\Carbon::parse($entrada->fecha_compra)->format('d-m-Y') }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Productos con stock crítico -->
          <div class="col-md-6">
            <div class="card h-100">
              <div class="card-body">
                <h5 class="card-title">Consumibles con Stock Crítico</h5>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Categoría</th>
                        <th class="text-center">Cantidad</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($productosCriticos as $producto)
                        <tr class="text-center {{ $producto->cantidad == 0 ? 'table-danger' : 'table-warning' }}">
                          <td>{{ $producto->nombre }}</td>
                          <td>{{ $producto->categoria->nombre ?? '-' }}</td>
                          <td>{{ $producto->cantidad }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->
@endsection
