@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar Producto</h1>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <h5 class="card-title border-bottom pb-3">Formulario de Edición</h5>

            @php use Carbon\Carbon; @endphp

            <form action="{{ route('productos.update', $item->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method("PUT")

              <div class="mb-3">
                <label for="categoria_id" class="form-label">Categoría</label>
                <select name="categoria_id" id="categoria_id" class="form-select" required>
                  <option value="">Selecciona una Categoría</option>
                  @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" data-nombre="{{ $categoria->nombre }}" {{ $item->categoria_id == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="proveedor_id" class="form-label">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-select" required>
                  <option value="">Selecciona un Proveedor</option>
                  @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}" {{ $item->proveedor_id == $proveedor->id ? 'selected' : '' }}>{{ $proveedor->nombre }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="{{ $item->nombre }}" required>
              </div>

              <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="2">{{ $item->descripcion }}</textarea>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="marca" class="form-label">Marca</label>
                  <input type="text" class="form-control" name="marca" id="marca" value="{{ $item->marca }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="modelo" class="form-label">Modelo</label>
                  <input type="text" class="form-control" name="modelo" id="modelo" value="{{ $item->modelo }}" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="no_serie" class="form-label">No. Serie</label>
                  <input type="text" class="form-control" name="no_serie" id="no_serie" value="{{ $item->no_serie }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="cantidad" class="form-label">Cantidad</label>
                  <input type="number" class="form-control" name="cantidad" id="cantidad" value="{{ $item->cantidad }}" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="fecha_compra" class="form-label">Fecha de Compra</label>
                <input type="date" class="form-control" name="fecha_compra" id="fecha_compra" value="{{ old('fecha_compra', Carbon::parse($item->fecha_compra)->format('Y-m-d')) }}">
              </div>

              <div id="hardwareFields" style="display: none;" class="border-top pt-4 mt-4">
                <h6 class="fw-bold mb-3">Características de Hardware</h6>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="ram" class="form-label">RAM</label>
                    <select name="ram" id="ram" class="form-select">
                      @foreach (['4GB','8GB','16GB','32GB','64GB'] as $ram)
                        <option value="{{ $ram }}" {{ $item->ram === $ram ? 'selected' : '' }}>{{ $ram }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="procesador" class="form-label">Procesador</label>
                    <select id="procesador_select" class="form-select" name="procesador">
                      <option value="">Selecciona un Procesador</option>
                      @foreach($procesadores as $proc)
                        <option value="{{ $proc }}" {{ $item->procesador === $proc ? 'selected' : '' }}>{{ $proc }}</option>
                      @endforeach
                      <option value="Otro">Otro</option>
                    </select>
                    <input type="text" id="procesador_input" class="form-control mt-2 {{ in_array($item->procesador, $procesadores) ? 'd-none' : '' }}" name="{{ in_array($item->procesador, $procesadores) ? '' : 'procesador' }}" value="{{ in_array($item->procesador, $procesadores) ? '' : $item->procesador }}" placeholder="Escriba el procesador">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="tipo_almacenamiento" class="form-label">Tipo de Almacenamiento</label>
                    <select name="tipo_almacenamiento" id="tipo_almacenamiento" class="form-select">
                      @foreach (['Disco Duro', 'SSD', 'M.2'] as $tipo)
                        <option value="{{ $tipo }}" {{ $item->tipo_almacenamiento === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="capacidad_almacenamiento" class="form-label">Capacidad</label>
                    <select name="capacidad_almacenamiento" id="capacidad_almacenamiento" class="form-select">
                      @foreach (['128GB','256GB','512GB','1TB','2TB'] as $cap)
                        <option value="{{ $cap }}" {{ $item->capacidad_almacenamiento === $cap ? 'selected' : '' }}>{{ $cap }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              {{-- ARCHIVOS ORDEN DE COMPRA --}}
              <div class="mt-4">
                <label class="form-label">Orden de Compra</label>
                @foreach ($item->documentos_orden as $doc)
                  <div class="form-text text-primary">
                    <i class="fa-solid fa-file me-1"></i>
                    <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank">{{ basename($doc->archivo) }}</a>
                  </div>
                @endforeach
                <input type="file" class="form-control mt-2 border border-2 border-danger file-upload-input" name="orden_compra[]" multiple accept=".pdf,.xml">
              </div>

              {{-- ARCHIVOS FACTURA --}}
              <div class="mt-4">
                <label class="form-label">Facturas</label>
                @foreach ($item->documentos_factura as $doc)
                  <div class="form-text text-primary">
                    <i class="fa-solid fa-file me-1"></i>
                    <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank">{{ basename($doc->archivo) }}</a>
                  </div>
                @endforeach
                <input type="file" class="form-control mt-2 border border-2 border-danger file-upload-input" name="factura[]" multiple accept=".pdf,.xml">
              </div>

              <div class="mt-4 text-end">
                <a href="{{ route('productos') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-warning">Actualizar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const categoriaSelect = document.getElementById('categoria_id');
    const hardwareFields = document.getElementById('hardwareFields');
    const mostrarSi = ['Pc de Escritorio', 'Laptops', 'PC Gaming', 'Equipo de Computo', 'Laptop'];

    function toggleHardwareFields() {
      const selectedOption = categoriaSelect.options[categoriaSelect.selectedIndex];
      const nombreCategoria = selectedOption.getAttribute('data-nombre');
      if (mostrarSi.includes(nombreCategoria)) {
        hardwareFields.style.display = 'block';
      } else {
        hardwareFields.style.display = 'none';
        hardwareFields.querySelectorAll('select').forEach(select => select.value = '');
      }
    }

    categoriaSelect.addEventListener('change', toggleHardwareFields);
    toggleHardwareFields();

    const select = document.getElementById('procesador_select');
    const input = document.getElementById('procesador_input');

    select.addEventListener('change', function () {
      if (this.value === 'Otro') {
        input.classList.remove('d-none');
        input.setAttribute('name', 'procesador');
        input.required = true;
        select.removeAttribute('name');
      } else {
        input.classList.add('d-none');
        input.removeAttribute('name');
        input.required = false;
        select.setAttribute('name', 'procesador');
      }
    });
  });
</script>
@endpush

@endsection
