@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Área / Departamento</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Editar Área / Departamento</h5>

            <form action="{{ route('areas.update', $item->id) }}" method="POST">
              @csrf
              @method("PUT")

              <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre del Área / Departamento</label>
                <input type="text" class="form-control" required name="nombre" id="nombre" value="{{ $item->nombre }}">
              </div>

              <div class="mb-3">
                <label for="unidad_servicio_id" class="form-label fw-bold">Unidad de Servicio</label>
                <select name="unidad_servicio_id" id="unidad_servicio_id" class="form-select" required>
                  <option value="">Seleccione una unidad</option>
                  @foreach($unidades as $unidad)
                    <option value="{{ $unidad->id }}" {{ $item->unidad_servicio_id == $unidad->id ? 'selected' : '' }}>
                      {{ $unidad->nombre }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="empresa_id" class="form-label fw-bold">Empresa</label>
                <select name="empresa_id" id="empresa_id" class="form-select" required>
                  <option value="">Seleccione una empresa</option>
                  @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}" {{ $item->empresa_id == $empresa->id ? 'selected' : '' }}>
                      {{ $empresa->nombre }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="text-end">
                <a href="{{ route('areas') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-warning">Actualizar</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
