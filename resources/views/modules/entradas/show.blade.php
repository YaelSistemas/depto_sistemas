@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Eliminar Entrada de Producto</h1>
    
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Eliminar Entradas</h5>
            <p>
              Una vez eliminada la entrada, no podra ser recuperada.
            </p>
            <!-- Table with stripped rows -->
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th class="text-center">Entrada Hecha por</th>
                  <th class="text-center">Categoria</th>
                  <th class="text-center">Proveedor</th>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-center">Marca</th>
                  <th class="text-center">Modelo</th>
                  <th class="text-center">Precio</th>
                  <th class="text-center">Fecha</th>

                </tr>
              </thead>
              <tbody>
                
                  <tr class="text-center">
                    <td>{{ $items->nombre_usuario }}</td>
                    <td>{{ $items->categoria }}</td>
                    <td>{{ $items->proveedor }}</td>
                    <td>{{ $items->nombre_producto }}</td>
                    <td>{{ $items->cantidad }}</td>
                    <td>{{ $items->marca }}</td>
                    <td>{{ $items->modelo }}</td>
                    <td>${{ $items->precio }}</td>
                    <td>{{ $items->created_at }}</td>
                    
                  </tr>
             
              </tbody>
            </table>
            <!-- End Table with stripped rows -->
            <hr>
            <form action="{{ route('entradas.destroy', $items->id) }}" method="post">
                @csrf
                @method('DELETE')
                <input type="text" value="{{ $items->producto_id }}" name="producto_id" hidden>
                <button class="btn btn-danger mt-3">Eliminar Entrada</button>
                <a href="{{ route("entradas") }}" class="btn btn-info mt-3">
                    Cancelar
                </a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection

