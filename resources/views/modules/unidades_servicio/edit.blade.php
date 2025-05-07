@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Unidades de Servicio</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Editar Unidad de Servicio</h5>

            <form action="{{ route('unidades.update', $item->id) }}" method="POST">
              @csrf
              @method("PUT")

              <div class="mb-3">
                <label for="nombre" class="fw-bold">Nombre de la Unidad</label>
                <input type="text" class="form-control" required name="nombre" id="nombre" value="{{ $item->nombre }}">
              </div>

              <div class="mb-3">
                <label for="empresa_id" class="fw-bold">Empresa</label>
                <select class="form-select" name="empresa_id" id="empresa_id" required>
                  <option value="">Seleccione una empresa</option>
                  @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}" {{ $item->empresa_id == $empresa->id ? 'selected' : '' }}>
                      {{ $empresa->nombre }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="colaborador_id" class="fw-bold">Responsable</label>
                <select class="form-select" name="colaborador_id" id="colaborador_id" required>
                  <option value="">Seleccione un colaborador</option>
                  @foreach($colaboradores as $colaborador)
                    <option value="{{ $colaborador->id }}" {{ $item->colaborador_id == $colaborador->id ? 'selected' : '' }}>
                      {{ $colaborador->nombre }} {{ $colaborador->apellido }}
                    </option>
                  @endforeach
                </select>
              </div>

              <button class="btn btn-warning mt-3">Actualizar</button>
              <a href="{{ route('unidades') }}" class="btn btn-info mt-3">Cancelar</a>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
