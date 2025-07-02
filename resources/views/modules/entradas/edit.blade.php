@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar una Entrada</h1>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Edición de: {{ $item->nombre_producto }}</h5>

            <form action="{{ route('entradas.update', $item->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method("PUT")

              <input type="hidden" name="producto_id" value="{{ $item->producto_id }}">

              <div class="mb-3">
                <label for="cantidad" class="form-label fw-bold">Cantidad del Producto</label>
                <input type="number" class="form-control" required name="cantidad" id="cantidad" value="{{ $item->cantidad }}">
              </div>

              <div class="mb-3">
                <label for="fecha_compra" class="form-label fw-bold">Fecha de Compra</label>
                <input type="date" class="form-control" name="fecha_compra" id="fecha_compra"
                  value="{{ old('fecha_compra', \Carbon\Carbon::parse($item->fecha_compra)->format('Y-m-d')) }}">
              </div>

              {{-- Orden de Compra actual --}}
              @if ($item->documentos_orden->count())
              <div class="mb-3">
                <label class="form-label fw-bold">Orden de Compra:</label>
                @foreach ($item->documentos_orden as $doc)
                  <div class="form-text text-primary">
                    <i class="fa-solid fa-file me-1"></i>
                    <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank">{{ basename($doc->archivo) }}</a>
                  </div>
                @endforeach
              </div>
              @endif

              <div class="mb-3">
                <label for="orden_compra" class="form-label fw-bold">Agregar nueva Orden de Compra (PDF/XML)</label>
                <input type="file" class="form-control border border-danger" name="orden_compra[]" multiple accept=".pdf,.xml">
                <small class="text-muted">* Los nuevos archivos se agregarán sin eliminar los anteriores.</small>
              </div>

              {{-- Facturas actuales --}}
              @if ($item->documentos_factura->count())
              <div class="mb-3">
                <label class="form-label fw-bold">Facturas:</label>
                @foreach ($item->documentos_factura as $doc)
                  <div class="form-text text-primary">
                    <i class="fa-solid fa-file me-1"></i>
                    <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank">{{ basename($doc->archivo) }}</a>
                  </div>
                @endforeach
              </div>
              @endif

              <div class="mb-3">
                <label for="factura" class="form-label fw-bold">Agregar nueva Factura (PDF/XML)</label>
                <input type="file" class="form-control border border-danger" name="factura[]" multiple accept=".pdf,.xml">
                <small class="text-muted">* Los nuevos archivos se agregarán sin eliminar los anteriores.</small>
              </div>

              <div class="text-end mt-4">
                <button type="submit" class="btn btn-warning">Actualizar Entrada</button>
                <a href="{{ route('entradas') }}" class="btn btn-secondary">Cancelar</a>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
