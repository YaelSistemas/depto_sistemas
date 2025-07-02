@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar Usuario</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Formulario de Edición</h5>

            <form action="{{ route('usuarios.update', $item->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="card mb-4">
                <div class="card-header"><strong>Datos del Usuario</strong></div>
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-md-12">
                      <label for="name" class="form-label">Nombre del Usuario</label>
                      <input type="text" class="form-control" required name="name" id="name" value="{{ $item->name }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-12">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" name="email" id="email" class="form-control" required value="{{ $item->email }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-12">
                      <label for="rol" class="form-label">Rol de Usuario</label>
                      <select name="rol" id="rol" class="form-select" required>
                        <option value="">Selecciona el Rol</option>
                        <option value="admin" {{ $item->rol == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="invitado" {{ $item->rol == 'invitado' ? 'selected' : '' }}>Invitado</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="text-end">
                <a href="{{ route('usuarios') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-warning">Actualizar Usuario</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
