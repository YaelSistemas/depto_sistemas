@extends('layouts.main')

@section('titulo', 'Eliminar Colaborador')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Eliminar Colaborador</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body pt-4">
            <h5 class="card-title text-danger">¿Estás seguro de eliminar al colaborador?</h5>
            <p class="text-muted">Esta acción es irreversible y no podrá recuperarse.</p>

            <table class="table table-bordered text-center align-middle">
              <thead class="table-light">
                <tr>
                  <th>Nombre</th>
                  <th>Apellidos</th>
                  <th>Área / Departamento</th>
                  <th>Unidad de Servicio</th>
                  <th>Empresa</th>
                  <th>Puesto</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{ $colaborador->nombre }}</td>
                  <td>{{ $colaborador->apellido }}</td>
                  <td>{{ $colaborador->areaDepartamento->nombre ?? '-' }}</td>
                  <td>{{ $colaborador->unidadServicio->nombre ?? '-' }}</td>
                  <td>{{ $colaborador->empresa->nombre ?? '-' }}</td>
                  <td>{{ $colaborador->puesto }}</td>
                </tr>
              </tbody>
            </table>

            <form method="POST" action="{{ route('colaboradores.destroy', $colaborador->id) }}" class="text-end mt-4">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">Eliminar</button>
              <a href="{{ route('colaboradores') }}" class="btn btn-secondary">Cancelar</a>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
