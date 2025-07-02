@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar Usuario</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Nuevo Usuario</h5>

            <form action="{{ route('usuarios.store') }}" method="POST">
              @csrf

              <div class="card mb-4">
                <div class="card-header"><strong>Datos del Usuario</strong></div>
                <div class="card-body">
                  <div class="mb-3">
                    <label for="name" class="form-label">Nombre del Usuario</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                  </div>

                  <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                  </div>

                  <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                  </div>

                  <div class="mb-3">
                    <label for="rol" class="form-label">Rol de Usuario</label>
                    <select name="rol" id="rol" class="form-select" required>
                      <option value="">-- Selecciona el Rol --</option>
                      <option value="admin">Admin</option>
                      <option value="invitado">Invitado</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="text-end">
                <a href="{{ route('usuarios') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Guardar Usuario</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
