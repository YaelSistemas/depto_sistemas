@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar Usuario</h1>
    
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Agregar Nuevo Usuario</h5>
            
            <form action="{{ route("usuarios.store") }}" method="POST">
                @csrf
            
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nombre del Usuario</label>
                    <input type="text" class="form-control" required name="name" id="name">
                </div>
            
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
            
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
            
                <div class="mb-3">
                    <label for="rol" class="form-label fw-bold">Rol de Usuario</label>
                    <select name="rol" id="rol" class="form-select">
                        <option value="">Selecciona el Rol</option>
                        <option value="admin">Admin</option>
                        <option value="invitado">Invitado</option>
                    </select>
                </div>
            
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('usuarios') }}" class="btn btn-info">Cancelar</a>
            </form>
            

          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection
