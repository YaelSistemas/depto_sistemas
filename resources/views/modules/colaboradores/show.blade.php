@extends('layouts.main')

@section('titulo', 'Eliminar Colaborador')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Eliminar Colaborador</h1>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body pt-3">
        <h5 class="card-title text-danger">
          ¿Estás Seguro de Querer Eliminar al Colaborador?
        </h5>
        <p>Una vez que sea eliminado no podrá ser recuperado.</p>

        <table class="table table-striped table-bordered text-center">
          <thead>
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

        <form method="POST" action="{{ route('colaboradores.destroy', $colaborador->id) }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Eliminar</button>
          <a href="{{ route('colaboradores') }}" class="btn btn-info">Cancelar</a>
        </form>
      </div>
    </div>
  </section>
</main>
@endsection
