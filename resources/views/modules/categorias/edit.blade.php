@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Editar Categoria</h1>
    
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Editar Categoria</h5>
            
            <form action="{{ route("categorias.update", $item->id) }}" method="POST">
                @csrf
                @method("PUT")
                <label for="nombre" class="fw-bold">Nombre de la Categoria</label>
                <input type="text" class="form-control" required name="nombre" id="nombre" value="{{ $item->nombre }}">
                <button class="btn btn-warning mt-3">Actualizar</button>
                <a href="{{ route("categorias")}}" class="btn btn-info mt-3">Cancelar</a>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection
