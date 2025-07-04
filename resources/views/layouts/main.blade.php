<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=0.3, maximum-scale=1.0" name="viewport">

  <title>@yield('titulo')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">


  <!-- Bootstrap CSS Files -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.2/css/buttons.bootstrap5.css">

  <!-- Template Main CSS File -->
  <link href="{{ asset('NiceAdmin/assets/css/style.css') }}" rel="stylesheet">

  <!-- Iconos con FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<style>
  .main {
    margin-left: 240px;
    transition: margin-left 0.3s ease;
  }

  body.toggle-sidebar .main {
    margin-left: 70px;
  }

  @media (max-width: 991px) {
    .main {
      margin-left: 0 !important;
    }

    body.toggle-sidebar .main {
      margin-left: 0 !important;
    }

    .dt-buttons {
      display: none !important;
    }
  }

  .main > .container,
  .main > .row,
  .main > .card {
    width: 100%;
  }
</style>

<body>

  <!-- ======= Header ======= -->
  @include('shared.header')
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('shared.aside')
  <!-- End Sidebar -->

  @yield('contenido')

  <!-- ======= Footer ======= -->
  @include('shared.footer')
  <!-- End Footer -->
 
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('NiceAdmin/assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('NiceAdmin/assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('NiceAdmin/assets/vendor/quill/quill.js') }}"></script>
  
  <script src="{{ asset('NiceAdmin/assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('NiceAdmin/assets/vendor/php-email-form/validate.js') }}"></script>

  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  
  <!-- Datatable -->
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.2/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.bootstrap5.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.print.min.js"></script>

  <!-- Template Main JS FNiceAdmin/ile -->
  <script src="{{ asset('NiceAdmin/assets/js/main.js') }}"></script>


  <script>
    $('.datatable').DataTable({
      pageLength: 25,
      lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
      layout: {
        topStart: {
          buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
      },
      language: {
        decimal: "",
        emptyTable: "No hay información",
        info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
        infoFiltered: "(Filtrado de _MAX_ total entradas)",
        lengthMenu: "Mostrar _MENU_ Entradas",
        loadingRecords: "Cargando...",
        processing: "Procesando...",
        search: "Buscar:",
        zeroRecords: "Sin resultados encontrados",
        paginate: {
          first: "Primero",
          last: "Ultimo",
          next: "Siguiente",
          previous: "Anterior"
        }
      }
    });

    @if(session('success'))
Swal.fire({
  icon: 'success',
  title: 'Éxito',
  text: '{{ session('success') }}',
  confirmButtonText: 'Aceptar',
  confirmButtonColor: '#7c3aed'
});
@endif

@if(session('error'))
Swal.fire({
  icon: 'error',
  title: 'Error',
  text: '{{ session('error') }}',
  confirmButtonText: 'Aceptar',
  confirmButtonColor: '#7c3aed'
});
@endif
    </script> 

  @stack('scripts')

  <!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
      const tabla = document.querySelector(".datatable");
  
      if (tabla) {
      new simpleDatatables.DataTable(tabla, {
        labels: {
          placeholder: "Buscar...",
          perPage: "Mostrar registros por página",
          noRows: "No hay registros para mostrar",
          noResults: "No se encontraron coincidencias",
          info: "Mostrando {start} a {end} de {rows} registros",
          page: "Página",
          pages: "páginas"
        },
        pagination: {
          prev: "Anterior",
          next: "Siguiente"
        }
      });
    }
  });
</script> -->
  
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.querySelector('.toggle-sidebar-btn');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => {
        document.body.classList.toggle('toggle-sidebar');
      });
    }
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.querySelector('.toggle-sidebar-btn');
    const body = document.body;
    const sidebar = document.getElementById('sidebar');

    if (toggleBtn && sidebar) {
      toggleBtn.addEventListener('click', () => {
        body.classList.toggle('toggle-sidebar');
        sidebar.classList.toggle('collapsed');
      });
    }
  });
</script>

</body>

</html>