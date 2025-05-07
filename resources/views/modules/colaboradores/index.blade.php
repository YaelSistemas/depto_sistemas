@extends('layouts.main')

@section('titulo', 'Colaboradores')

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Colaboradores</h1>
  </div>
  
  <section class="section">
    <div class="card">
      <div class="card-body">

        <h5 class="card-title">Listado de Colaboradores</h5>

        <a href="{{ route('colaboradores.create') }}" class="btn btn-primary mb-3">
          <i class="fa fa-plus"></i> Agregar Colaborador
        </a>

        <table class="table table-bordered table-striped datatable">
          <thead>
            <tr>
              <th class="text-center">Nombre(s)</th>
              <th class="text-center">Apellidos</th>
              <th class="text-center">Área / Departamento</th>
              <th class="text-center">Unidad de Servicio</th>
              <th class="text-center">Empresa</th>
              <th class="text-center">Puesto</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($colaboradores as $colaborador)
              <tr class="text-center">
                <td>{{ $colaborador->nombre }}</td>
                <td>{{ $colaborador->apellido }}</td>
                <td>{{ $colaborador->areaDepartamento->nombre ?? 'N/A' }}</td>
                <td>{{ $colaborador->unidadServicio->nombre ?? 'N/A' }}</td>
                <td>{{ $colaborador->empresa->nombre ?? 'N/A' }}</td>
                <td>{{ $colaborador->puesto }}</td> 
                <td>
                  <a href="{{ route('colaboradores.edit', $colaborador->id) }}" class="btn btn-warning btn-sm">
                    <i class="fa fa-pen"></i>
                  </a>
                  <a href="{{ route('colaboradores.show', $colaborador->id) }}" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </section>
</main>

@if(session('show_error_modal'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se puede eliminar el colaborador porque tiene responsivas asociadas.',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#7c3aed'
    });
</script>
@endif

@if(session('show_created_modal'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: 'Colaborador creado correctamente.',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#7c3aed'
    });
</script>
@endif

@if(session('show_success_modal'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: 'Colaborador eliminado correctamente.',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#7c3aed'
    });
</script>
@endif

@endsection
