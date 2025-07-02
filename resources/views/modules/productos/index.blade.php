@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Productos</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar Productos y Stock</h5>
            <p>Admnistrar el Stock del Departamento.</p>

            <a href="{{ route('productos.create', ['reset' => 1]) }}" class="btn btn-primary mb-3">
              <i class="fa-solid fa-circle-plus"></i> Crear Producto
            </a>

            <!-- Tabla responsiva -->
            <div class="table-responsive">
              <table class="table table-bordered table-striped datatable">
                <thead>
                  <tr>
                    <th class="text-center align-middle">Categoria</th>
                    <th class="text-center align-middle">Proveedor</th>
                    <th class="text-center align-middle">Nombre</th>
                    <th class="text-center align-middle">Imagen</th>
                    <th class="text-center align-middle">Descripcion</th>
                    <th class="text-center align-middle">Cantidad</th>
                    <th class="text-center align-middle">Marca</th>
                    <th class="text-center align-middle">Modelo</th>
                    <th class="text-center align-middle">No. Serie</th>
                    <th class="text-center align-middle">RAM</th>
                    <th class="text-center align-middle">Procesador</th>
                    <th class="text-center align-middle">Tipo Almacenamiento</th>
                    <th class="text-center align-middle">Capacidad</th>
                    <th class="text-center align-middle">Reabastecer</th>
                    <th class="text-center align-middle">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($items as $item)
                    <tr class="text-center">
                      <td class="align-middle">{{ $item->nombre_categoria }}</td>
                      <td class="align-middle">{{ $item->nombre_proveedor }}</td>
                      <td class="align-middle">{{ $item->nombre }}</td>
                      <td class="align-middle">
                        @if ($item->imagen_producto)
                          <a href="#" data-bs-toggle="modal" data-bs-target="#imagenModal" data-img="{{ asset('storage/' . $item->imagen_producto) }}">
                            <img src="{{ asset('storage/' . $item->imagen_producto) }}" class="img-fluid rounded border" style="width: 100px; height: 100px; object-fit: contain;">
                          </a>
                        @else
                          <span>Sin imagen</span>
                        @endif
                        <a href="#" class="badge rounded-pill bg-warning text-dark mt-2 d-inline-block" onclick="abrirModalImagen({{ $item->id }})">
                          <i class="fa-solid fa-pen"></i>
                        </a>
                      </td>
                      <td class="align-middle">{{ $item->descripcion }}</td>
                      <td class="align-middle">{{ $item->cantidad }}</td>
                      <td class="align-middle">{{ $item->marca }}</td>
                      <td class="align-middle">{{ $item->modelo }}</td>
                      <td class="align-middle">{{ $item->no_serie }}</td>
                      <td class="align-middle">{{ $item->ram ?? '-' }}</td>
                      <td class="align-middle">{{ $item->procesador ?? '-' }}</td>
                      <td class="align-middle">{{ $item->tipo_almacenamiento ?? '-' }}</td>
                      <td class="align-middle">{{ $item->capacidad_almacenamiento ?? '-' }}</td>
                      <td class="align-middle">
                        @php
                          $categoria = strtolower($item->nombre_categoria);
                          $categoriasPermitidas = ['tinta', 'toner', 'cartuchos'];
                        @endphp
                        @if(in_array($categoria, $categoriasPermitidas))
                          <a href="{{ route('entradas.create', $item->id) }}" class="btn btn-info">Reabastecer</a>
                        @endif
                      </td>
                      <td class="align-middle">
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
            </div>
            <!-- Fin tabla responsiva -->

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

<!-- MODAL para ampliar imagen -->
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

<!-- MODAL para cambiar imagen -->
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

@push('scripts')
<script>
  function abrirModalImagen(id) {
    document.getElementById('producto_id').value = id;
    document.getElementById('nueva_imagen').value = null;
    const modal = new bootstrap.Modal(document.getElementById('modalCambiarImagen'));
    modal.show();
  }

  document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('imagenModal');
    modal.addEventListener('show.bs.modal', function (event) {
      const trigger = event.relatedTarget;
      const rutaImagen = trigger.getAttribute('data-img');
      const modalImg = modal.querySelector('#imagenAmpliada');
      modalImg.src = rutaImagen;
    });
  });
</script>
@endpush
