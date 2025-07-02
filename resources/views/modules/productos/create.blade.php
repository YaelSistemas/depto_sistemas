@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Crear Producto</h1>
  </div>

  <section class="section">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <h5 class="card-title border-bottom pb-3">Nuevo Producto</h5>

            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <!-- Datos Generales -->
              <div class="mb-3">
                <label for="categoria_id" class="form-label">Categoría</label>
                <select name="categoria_id" id="categoria_id" class="form-select" required>
                  <option value="">Selecciona una Categoría</option>
                  @foreach ($categorias as $item)
                    <option value="{{ $item->id }}" data-nombre="{{ $item->nombre }}">{{ $item->nombre }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="proveedor_id" class="form-label">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-select" required>
                  <option value="">Selecciona un Proveedor</option>
                  @foreach ($proveedores as $item)
                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
              </div>

              <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="2"></textarea>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="marca" class="form-label">Marca</label>
                  <input type="text" class="form-control" name="marca" id="marca" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="modelo" class="form-label">Modelo</label>
                  <input type="text" class="form-control" name="modelo" id="modelo" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="no_serie" class="form-label">No. Serie</label>
                  <input type="text" class="form-control" name="no_serie" id="no_serie" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="cantidad" class="form-label">Cantidad</label>
                  <input type="number" class="form-control" name="cantidad" id="cantidad" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="fecha_compra" class="form-label">Fecha de Compra</label>
                <input type="date" class="form-control" name="fecha_compra" id="fecha_compra" value="{{ old('fecha_compra', session('fecha_compra_guardada')) }}">
                @if(session()->has('fecha_compra_guardada'))
                  <div class="text-muted small mt-1">
                    <i class="bi bi-info-circle"></i> Usando la fecha anterior: {{ session('fecha_compra_guardada') }}
                  </div>
                @endif
              </div>

              <!-- Campos de Hardware (condicional) -->
              <div id="hardwareFields" style="display: none;" class="border-top pt-4 mt-4">
                <h6 class="fw-bold mb-3">Características de Hardware</h6>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="ram" class="form-label">RAM</label>
                    <select name="ram" id="ram" class="form-select">
                      <option value="">Selecciona la RAM</option>
                      @foreach (['4GB','8GB','16GB','32GB','64GB'] as $ram)
                        <option value="{{ $ram }}">{{ $ram }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="procesador" class="form-label">Procesador</label>
                    <select class="form-select" id="procesador_select" name="procesador">
                      <option value="">Selecciona un Procesador</option>
                      @foreach ($procesadores as $proc)
                        <option value="{{ $proc }}">{{ $proc }}</option>
                      @endforeach
                      <option value="Otro">Otro</option>
                    </select>
                    <input type="text" class="form-control mt-2 d-none" id="procesador_input" placeholder="Escribe el procesador">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="tipo_almacenamiento" class="form-label">Tipo de Almacenamiento</label>
                    <select name="tipo_almacenamiento" id="tipo_almacenamiento" class="form-select">
                      @foreach (['Disco Duro', 'SSD', 'M.2'] as $tipo)
                        <option value="{{ $tipo }}">{{ $tipo }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="capacidad_almacenamiento" class="form-label">Capacidad</label>
                    <select name="capacidad_almacenamiento" id="capacidad_almacenamiento" class="form-select">
                      @foreach (['128GB','256GB','512GB','1TB','2TB'] as $cap)
                        <option value="{{ $cap }}">{{ $cap }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <!-- Archivos - SIEMPRE AL FINAL -->
              <div class="row mt-4">
                <div class="col-md-4 mb-3">
                  <label for="imagen" class="form-label">Imagen</label>
                  <input type="file" class="form-control" name="imagen" id="imagen">
                </div>

                @if (!session()->has('orden_compra_ids') && !session()->has('factura_ids'))
                  <div class="col-md-4 mb-3">
                    <label for="orden_compra" class="form-label">Orden de Compra (PDF/XML)</label>
                    <input type="file" class="form-control" name="orden_compra[]" id="orden_compra" multiple accept=".pdf,.xml">
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="factura" class="form-label">Factura (PDF/XML)</label>
                    <input type="file" class="form-control" name="factura[]" id="factura" multiple accept=".pdf,.xml">
                  </div>
                @else
                  <input type="hidden" name="usar_facturas_guardadas" value="1">
                  <div class="col-md-8 mb-3">
                    <div class="alert alert-info mt-4 d-flex justify-content-between align-items-center">
                      <span>Archivos de factura y orden de compra ya están cargados. Se reutilizarán.</span>
                      <a href="{{ route('productos.create.limpiar_docs') }}" class="btn btn-warning btn-sm ms-3">Cargar nuevos archivos</a>
                    </div>
                  </div>
                @endif
              </div>

              <div class="mt-4 text-end">
                <a href="{{ route('productos') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" name="accion" value="guardar" class="btn btn-primary">Guardar</button>
                <button type="submit" name="accion" value="guardar_y_nuevo" class="btn btn-success">Guardar y crear otro</button>
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
    const mostrarSi = ['Pc de Escritorio', 'Laptops', 'PC Gaming'];

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
  });

  const procesadorSelect = document.getElementById('procesador_select');
  const procesadorInput = document.getElementById('procesador_input');

  procesadorSelect.addEventListener('change', function () {
    if (this.value === 'Otro') {
      procesadorInput.classList.remove('d-none');
      procesadorInput.setAttribute('name', 'procesador');
      procesadorSelect.removeAttribute('name');
    } else {
      procesadorInput.classList.add('d-none');
      procesadorInput.removeAttribute('name');
      procesadorSelect.setAttribute('name', 'procesador');
    }
  });
</script>
@endpush

@endsection
