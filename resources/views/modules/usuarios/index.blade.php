@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Usuarios</h1>
    
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Administrar Usuarios</h5>
            <p>
              Admnistrar Cuentas y Roles de Usuarios.
            </p>
            <!-- Table with stripped rows -->
            <a href="{{ route("usuarios.create")}}" class="btn btn-primary">
              <i class="fa-solid fa-user-plus"></i> Nuevo Usuario
            </a>
            <hr>
            <!-- Sirve para colocar efecto a la tabla -->
            <!-- "table table-striped table-bordered datatable" -->
            <table class="table table-striped table-bordered datatable">
              <thead>
                <tr>
                  <th class="text-center">Email</th>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Rol de Usuario</th>
                  <th class="text-center">Cambio Password</th>
                  <th class="text-center">Activo</th>
                  <th class="text-center">
                    Editar
                  </th>
                </tr>
              </thead>
              <tbody id="tbody-usuarios">
                @include('modules.usuarios.tbody')
              </tbody>
            </table>
            <!-- End Table with stripped rows -->
          </div>
        </div>
      </div>
    </div>
  </section>

</main>
@include('modules.usuarios.modal_cambiar_password')
@endsection

@push('scripts')
  <script>

    function recargar_tbody() {
      $.ajax({
        type : "GET",
        url : "{{ route('usuarios.tbody') }}",
        success : function(respuesta){
          console.log(respuesta);
        }
      });
    }

    function cambiar_estado(id, estado) {
      $.ajax({
        type : "GET",
        url : "usuarios/cambiar-estado/" + id + "/" + estado,
        success : function(respuesta){
          if (respuesta == 1) {
            Swal.fire({
              title: 'Exito',
              text: 'Cambio de Estado Exitoso',
              icon: 'success',
              confirmButtonText: 'Aceptar'
            });
            recargar_tbody();
          } else {
            Swal.fire({
              title: 'Fallo',
              text: 'No se Llevo a cabo el Cambio',
              icon: 'error',
              confirmButtonText: 'Aceptar'
            });
          }
        }
      });
    }

    function agregar_id_usuario(id){
      $('#id_usuario').val(id); 
    }


    function cambio_password(){
      let id = $('#id_usuario').val();
      let password = $('#password').val();

      $.ajax({
        type : "GET",
        url : "usuarios/cambiar-password/" + id + "/" + password,
        success : function(respuesta){
          if (respuesta == 1) {
            Swal.fire({
              title: 'Exito!',
              text: 'Cambio de Password Exitoso!',
              icon: 'success',
              confirmButtonText: 'Aceptar'
            });
            $('#frmPassword')[0].reset();
          } else {
            Swal.fire({
              title: 'Fallo!',
              text: 'Cambio de Password no Exitoso!',
              icon: 'error',
              confirmButtonText: 'Aceptar'
            });
          }
        }
      });

    }

    $(document).ready(function() {
      $('.form-check-input').on("change", function(){
        let id = $(this).attr("id");
        let estado = $(this).is(":checked") ? 1 : 0;
        cambiar_estado(id, estado);
      });
    });
  </script>
@endpush