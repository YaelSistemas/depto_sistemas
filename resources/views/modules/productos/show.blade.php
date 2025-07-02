@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Eliminar Producto</h1>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card">
          <div class="card-body p-4">
            <h5 class="card-title">¿Estás seguro de querer eliminar el producto?</h5>
            <p class="mb-4">Una vez eliminado, no podrá ser recuperado.</p>

            <table class="table table-bordered table-striped">
              <tbody>
                <tr><th>Categoría</th><td>{{ $items->nombre_categoria }}</td></tr>
                <tr><th>Proveedor</th><td>{{ $items->nombre_proveedor }}</td></tr>
                <tr><th>Nombre</th><td>{{ $items->nombre }}</td></tr>
                <tr><th>Descripción</th><td>{{ $items->descripcion }}</td></tr>
                <tr><th>Marca</th><td>{{ $items->marca }}</td></tr>
                <tr><th>Modelo</th><td>{{ $items->modelo }}</td></tr>
                <tr><th>No. Serie</th><td>{{ $items->no_serie }}</td></tr>
                <tr><th>Cantidad</th><td>{{ $items->cantidad }}</td></tr>
                <tr><th>Fecha de Compra</th><td>{{ optional($items->fecha_compra)->format('d/m/Y') }}</td></tr>
                <tr><th>Activo</th>
                  <td>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" disabled {{ $items->activo ? 'checked' : '' }}>
                    </div>
                  </td>
                </tr>

                @if(in_array($items->nombre_categoria, ['Laptop', 'Equipo de Computo', 'Pc de Escritorio', 'PC Gaming']))
                  <tr><th>RAM</th><td>{{ $items->ram ?? '—' }}</td></tr>
                  <tr><th>Procesador</th><td>{{ $items->procesador ?? '—' }}</td></tr>
                  <tr><th>Tipo de Almacenamiento</th><td>{{ $items->tipo_almacenamiento ?? '—' }}</td></tr>
                  <tr><th>Capacidad</th><td>{{ $items->capacidad_almacenamiento ?? '—' }}</td></tr>
                @endif

                @if($items->documentos_orden && $items->documentos_orden->count())
                  <tr>
                    <th>Orden de Compra</th>
                    <td>
                      @foreach($items->documentos_orden as $doc)
                        <div><a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank" class="text-primary">{{ basename($doc->archivo) }}</a></div>
                      @endforeach
                    </td>
                  </tr>
                @endif

                @if($items->documentos_factura && $items->documentos_factura->count())
                  <tr>
                    <th>Facturas</th>
                    <td>
                      @foreach($items->documentos_factura as $doc)
                        <div><a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank" class="text-primary">{{ basename($doc->archivo) }}</a></div>
                      @endforeach
                    </td>
                  </tr>
                @endif
              </tbody>
            </table>

            <form action="{{ route('productos.destroy', $items->id) }}" method="POST" class="mt-4 d-flex justify-content-end gap-2">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">Eliminar</button>
              <a href="{{ route('productos') }}" class="btn btn-secondary">Cancelar</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
