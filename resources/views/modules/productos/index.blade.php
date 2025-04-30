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
            <a href="{{ route('productos.create') }}" class="btn btn-primary">
              <i class="fa-solid fa-circle-plus"></i> Crear Producto
            </a>
            <hr>
            <table class="table table-striped table-bordered datatable">
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
                  <th class="text-center">Activo</th>
                  <th class="text-center">Reabastecer</th>

                  <th class="text-center">
                    Acciones
                  </th>
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
                        <img src="{{ asset('storage/' . $item->imagen_producto) }}" width="80" height="80" alt="{{ $item->nombre }}">
                        <a href="#" class="badge rounded-pill bg-warning text-dark">
                          <i class="fa-solid fa-pen"></i>
                        </a>
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
                    <td>
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="{{ $item->id }}" 
                        {{ $item->activo ? 'checked' : '' }}  >
                    </div>
                    </td>
                    <td>
                      <a href="{{ route('entradas.create', $item->id) }}" class="btn btn-info">Reabastecer</a>
                    </td>
                    <td>
                      <a href="{{ route('productos.edit', $item->id) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pen"></i>
                      </a>
                      <a href="{{ route('productos.show', $item->id) }}" class="btn btn-danger">
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

@push('scripts')
  <script>

    function cambiar_estado(id, estado) {
      $.ajax({
        type : "GET",
        url : "productos/cambiar-estado/" + id + "/" + estado,
        success : function(respuesta) {
          if (respuesta == 1) {
            Swal.fire({
              title: 'Exito',
              text: 'Cambio de Estado Exitoso',
              icon: 'success',
              confirmButtonText: 'Aceptar'
            });
          } else {
            Swal.fire({
              title: 'Fallo',
              text: 'No se Llevo a cabo el Cambio',
              icon: 'error',
              confirmButtonText: 'Aceptar'
            });
          }
        }
      });
    }


    $(document).ready(function() {
      $('.form-check-input').on("change", function(){
        let id = $(this).attr("id");
        let estado = $(this).is(":checked") ? 1 : 0;
        cambiar_estado(id, estado);
      });
    });
  </script>
@endpush
