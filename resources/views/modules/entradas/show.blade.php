@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Eliminar Entrada de Producto</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <h5 class="card-title">¿Estás seguro de eliminar esta entrada?</h5>
            <p>Una vez eliminada, no podrá ser recuperada.</p>

            <!-- Detalles de la entrada -->
            <table class="table table-bordered">
              <tbody>
                <tr><th>Entrada Hecha por</th><td>{{ $items->nombre_usuario }}</td></tr>
                <tr><th>Categoría</th><td>{{ $items->categoria }}</td></tr>
                <tr><th>Proveedor</th><td>{{ $items->proveedor }}</td></tr>
                <tr><th>Producto</th><td>{{ $items->nombre_producto }}</td></tr>
                <tr><th>Cantidad</th><td>{{ $items->cantidad }}</td></tr>
                <tr><th>Marca</th><td>{{ $items->marca }}</td></tr>
                <tr><th>Modelo</th><td>{{ $items->modelo }}</td></tr>
                <tr><th>Fecha de Compra</th>
                  <td>{{ $items->fecha_compra ? \Carbon\Carbon::parse($items->fecha_compra)->format('d/m/Y') : '—' }}</td>
                </tr>
                <tr><th>Fecha de Registro</th>
                  <td>{{ \Carbon\Carbon::parse($items->created_at)->format('d/m/Y H:i') }}</td>
                </tr>
              </tbody>
            </table>

            {{-- Archivos Asociados --}}
            @if ($items->documentos_orden->count())
              <div class="mt-4">
                <h6 class="fw-bold">Orden de Compra:</h6>
                <ul class="list-unstyled">
                  @foreach ($items->documentos_orden as $doc)
                    <li>
                      <i class="fa-solid fa-file text-primary me-1"></i>
                      <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank" class="text-primary">
                        {{ basename($doc->archivo) }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif

            @if ($items->documentos_factura->count())
              <div class="mt-3">
                <h6 class="fw-bold">Facturas:</h6>
                <ul class="list-unstyled">
                  @foreach ($items->documentos_factura as $doc)
                    <li>
                      <i class="fa-solid fa-file text-primary me-1"></i>
                      <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank" class="text-primary">
                        {{ basename($doc->archivo) }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif

            <hr class="mt-4">

            <!-- Botones -->
            <form action="{{ route('entradas.destroy', $items->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <input type="hidden" name="producto_id" value="{{ $items->producto_id }}">
              <div class="text-end">
                <button class="btn btn-danger">Eliminar Entrada</button>
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
