@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Entrega de Consumibles</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Registrar Entrega de Consumibles</h5>
            <p>Registrar entregas de consumibles a los colaboradores.</p>

            <a href="{{ route('entrega_cartuchos.create') }}" class="btn btn-success mb-3">
              <i class="fa fa-plus"></i> Nueva Entrega
            </a>

            <table class="table table-striped table-bordered datatable table-condensed">
              <thead>
                <tr>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Descripción</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-center">Marca</th>
                  <th class="text-center">Modelo</th>
                  <th class="text-center">No. Serie</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                <tr>
                  <td class="text-center">{{ $item->nombre }}</td>
                  <td class="text-center">{{ $item->descripcion }}</td>
                  <td class="text-center">{{ $item->cantidad }}</td>
                  <td class="text-center">{{ $item->marca }}</td>
                  <td class="text-center">{{ $item->modelo }}</td>
                  <td class="text-center">{{ $item->no_serie }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
