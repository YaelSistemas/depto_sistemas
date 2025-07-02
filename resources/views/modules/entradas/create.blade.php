@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Hacer una Entrada</h1>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Nueva Entrada de: {{ $item->nombre }}</h5>

            <form action="{{ route('entradas.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <input type="hidden" name="id" value="{{ $item->id }}">

              <div class="mb-3">
                <label for="cantidad" class="form-label fw-bold">Cantidad del Producto</label>
                <input type="number" class="form-control" name="cantidad" id="cantidad" required>
              </div>

              <div class="mb-3">
                <label for="fecha_compra" class="form-label fw-bold">Fecha de Compra</label>
                <input type="date" class="form-control" name="fecha_compra" id="fecha_compra" required>
              </div>

              <div class="mb-3">
                <label for="orden_compra" class="form-label fw-bold">Orden de Compra (PDF/XML)</label>
                <input type="file" class="form-control" name="orden_compra[]" multiple accept=".pdf,.xml">
              </div>

              <div class="mb-3">
                <label for="factura" class="form-label fw-bold">Factura (PDF/XML)</label>
                <input type="file" class="form-control" name="factura[]" multiple accept=".pdf,.xml">
              </div>

              <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Realizar Entrada</button>
                <a href="{{ route('productos') }}" class="btn btn-secondary">Cancelar</a>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
