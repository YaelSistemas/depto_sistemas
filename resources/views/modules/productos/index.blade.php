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
            <table class="table table-bordered datatable">
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
                    <td class="text-center">{{ $item->nombre_categoria }}</td>
                    <td class="text-center">{{ $item->nombre_proveedor }}</td>
                    <td>{{ $item->nombre }}</td>

                    <td>
                      @if ($item->imagen_producto)
                        <a href="#" data-bs-toggle="modal" data-bs-target="#imagenModal" data-img="{{ asset('storage/' . $item->imagen_producto) }}">
                          <img src="{{ asset('storage/' . $item->imagen_producto) }}" width="100" height="100" alt="{{ $item->nombre }}">
                        </a>
                      @else
                        <span>Sin imagen</span>
                      @endif
                    
                      <a href="#" class="badge rounded-pill bg-warning text-dark mt-2 d-inline-block" onclick="abrirModalImagen({{ $item->id }})">
                        <i class="fa-solid fa-pen"></i>
                      </a>
                    </td>

                    <td class="text-center">{{ $item->descripcion }}</td>
                    <td class="text-center">{{ $item->cantidad }}</td>
                    <td class="text-center">{{ $item->marca }}</td>
                    <td class="text-center">{{ $item->modelo }}</td>
                    <td class="text-center">{{ $item->no_serie }}</td>
                    <td class="text-center">${{ $item->precio }}</td>
                    <td class="text-center">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="{{ $item->id }}" 
                        {{ $item->activo ? 'checked' : '' }}  >
                    </div>
                    </td>
                    <td>
                      @php
                        $categoria = strtolower($item->nombre_categoria);
                        $categoriasPermitidas = ['tinta', 'toner', 'cartuchos'];
                      @endphp
                    
                      @if(in_array($categoria, $categoriasPermitidas))
                        <a href="{{ route('entradas.create', $item->id) }}" class="btn btn-info">Reabastecer</a>
                      @endif
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

<!-- Modal para cambiar imagen -->
<div class="modal fade" id="modalCambiarImagen" tabindex="-1" aria-labelledby="modalCambiarImagenLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formCambiarImagen" method="POST" action="{{ route('productos.cambiar.imagen') }}" enctype="multipart/form-data" class="modal-content">
      @csrf
      <input type="hidden" name="producto_id" id="producto_id">

      <div class="modal-header">
        <h5 class="modal-title" id="modalCambiarImagenLabel">Cambiar Imagen del Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label for="nueva_imagen" class="form-label">Seleccionar nueva imagen</label>
          <input type="file" class="form-control" name="nueva_imagen" id="nueva_imagen" accept="image/*" required>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-warning">Actualizar Imagen</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal para ampliar imagen -->
<div class="modal fade" id="imagenModal" tabindex="-1" aria-labelledby="imagenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Vista previa de imagen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <img id="imagenAmpliada" src="" class="img-fluid rounded" alt="Vista previa">
      </div>
    </div>
  </div>
</div>

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

    function abrirModalImagen(id) {
      $('#producto_id').val(id);
      $('#nueva_imagen').val(null); // limpia input
      let modal = new bootstrap.Modal(document.getElementById('modalCambiarImagen'));
      modal.show();
    }


    document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('imagenModal');
    modal.addEventListener('show.bs.modal', function (event) {
      var trigger = event.relatedTarget;
      var rutaImagen = trigger.getAttribute('data-img');
      var modalImg = modal.querySelector('#imagenAmpliada');
      modalImg.src = rutaImagen;
    });
  });
  </script>
@endpush
