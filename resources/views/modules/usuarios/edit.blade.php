@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar Usuario</h1>
    
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Editar Usuario</h5>
            
            <form action="{{ route("usuarios.update", $item->id) }}" method="POST">
                @csrf
                @method("PUT")
            
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre del Usuario</label>
                    <input type="text" class="form-control" required name="name" id="name" value="{{ $item->name }}">
                </div>
            
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required value="{{ $item->email }}">
                </div>
            
                <div class="mb-3">
                    <label for="rol" class="form-label">Rol de Usuario</label>
                    <select name="rol" id="rol" class="form-select" required>
                        <option value="">Selecciona el Rol</option>
                        <option value="admin" {{ $item->rol == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="invitado" {{ $item->rol == 'invitado' ? 'selected' : '' }}>Invitado</option>
                    </select>
                </div>
            
                <button type="submit" class="btn btn-warning">Actualizar</button>
                <a href="{{ route('usuarios') }}" class="btn btn-info">Cancelar</a>
            </form>
            

          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection
