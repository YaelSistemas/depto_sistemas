@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar Proveedor</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body pt-4">
            <h5 class="card-title">Agregar Nuevo Proveedor</h5>

            <form action="{{ route('proveedores.store') }}" method="POST">
              @csrf

              <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre</label>
                <input type="text" class="form-control" required name="nombre" id="nombre">
              </div>

              <div class="mb-3">
                <label for="telefono" class="form-label fw-bold">Teléfono</label>
                <input type="text" class="form-control" required name="telefono" id="telefono">
              </div>

              <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" class="form-control" required name="email" id="email">
              </div>

              <div class="mb-3">
                <label for="ubicacion" class="form-label fw-bold">Ubicación</label>
                <input type="text" class="form-control" required name="ubicacion" id="ubicacion">
              </div>

              <div class="mb-3">
                <label for="sitio_web" class="form-label fw-bold">Sitio Web</label>
                <input type="text" class="form-control" required name="sitio_web" id="sitio_web">
              </div>

              <div class="mb-3">
                <label for="notas" class="form-label fw-bold">Notas</label>
                <textarea name="notas" id="notas" rows="4" class="form-control"></textarea>
              </div>

              <div class="text-end mt-4">
                <button class="btn btn-primary">Guardar</button>
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
