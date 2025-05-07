@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Productos</h1>
    
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar Productos y Stock</h5>
            <p>
              Admnistrar el Stock del Departamento.
            </p>
            <!-- Table with stripped rows -->
            
            <table class="table  table-bordered datatable">
              <thead>
                <tr>
                  <th class="text-center">Categoria</th>
                  <th class="text-center">Proveedor</th>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Imagen</th>
                  <th class="text-center">Descripcion</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-center">Marca</th>
                  <th class="text-center">Modelo</th>
                  <th class="text-center">No. Serie</th>
                  <th class="text-center">Precio</th>
                  
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                  <tr class="text-center">
                    <td>{{ $item->nombre_categoria }}</td>
                    <td>{{ $item->nombre_proveedor }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>
                      @if ($item->imagen_producto)
                        <img src="{{ asset('storage/' . $item->imagen_producto) }}" alt="{{ $item->nombre }}" width="80" height="80">
                      @else
                        <span>Sin imagen</span>
                      @endif
                    </td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->marca }}</td>
                    <td>{{ $item->modelo }}</td>
                    <td>{{ $item->no_serie }}</td>
                    <td>${{ $item->precio }}</td>
                    
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

