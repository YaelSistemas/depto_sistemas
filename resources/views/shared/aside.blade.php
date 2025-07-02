<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link" href="{{ route('home') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="fa-solid fa-arrow-right-from-bracket"></i><span>Salidas</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li><a href="{{ route('responsivas.index') }}"><i class="bi bi-circle"></i><span>Responsiva</span></a></li>
        <li><a href="#"><i class="bi bi-circle"></i><span>Soporte Técnico</span></a></li>
        <li><a href="{{ route('entrega_cartuchos.index') }}"><i class="bi bi-circle"></i><span>Entrega de Cartuchos</span></a></li>
        <li><a href="#"><i class="bi bi-circle"></i><span>Devolución</span></a></li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Bitácoras</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li><a href="#"><i class="bi bi-circle"></i><span>Consulta Salidas</span></a></li>
        <li><a href="{{ route('consulta-responsiva') }}"><i class="bi bi-circle"></i><span>Consulta Responsiva</span></a></li>
        <li><a href="#"><i class="bi bi-circle"></i><span>Consulta Soporte Técnico</span></a></li>
        <li><a href="{{ route('consulta_entrega_cartuchos') }}"><i class="bi bi-circle"></i><span>Consulta Entrega de Cartuchos</span></a></li>
        <li><a href="#"><i class="bi bi-circle"></i><span>Consulta Devoluciones</span></a></li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('asignaciones.index') }}">
        <i class="fa-solid fa-cart-shopping"></i>
        <span>Asignaciones</span>
      </a>
    </li>

    <li class="nav-heading">Pages</li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#productos-nav" data-bs-toggle="collapse" href="#">
        <i class="fa-solid fa-bag-shopping"></i><span>Productos</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="productos-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li><a href="{{ route('productos') }}"><i class="bi bi-circle"></i><span>Administrar Productos</span></a></li>
        <li><a href="{{ route('reportes_productos') }}"><i class="bi bi-circle"></i><span>Reportes de Productos</span></a></li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('entradas') }}">
        <i class="fa-solid fa-cart-shopping"></i>
        <span>Entradas</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('colaboradores') }}">
        <i class="fa-solid fa-users-gear"></i>
        <span>Colaboradores</span>
      </a>
    </li>

    <li class="nav-heading">Admin</li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#gestionar_colaboradores-nav" data-bs-toggle="collapse" href="#">
        <i class="fa-solid fa-database"></i><span>Gestionar Datos Colaborador</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="gestionar_colaboradores-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li><a href="{{ route('unidades') }}"><i class="bi bi-circle"></i><span>Unidades de Servicio</span></a></li>
        <li><a href="{{ route('areas') }}"><i class="bi bi-circle"></i><span>Área / Departamento</span></a></li>
        <li><a href="{{ route('empresas') }}"><i class="bi bi-circle"></i><span>Empresa</span></a></li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#gestionar_datos_prod-nav" data-bs-toggle="collapse" href="#">
        <i class="fa-solid fa-database"></i><span>Gestionar Datos Productos</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="gestionar_datos_prod-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li><a href="{{ route('categorias') }}"><i class="bi bi-circle"></i><span>Categorías</span></a></li>
        <li><a href="{{ route('proveedores') }}"><i class="bi bi-circle"></i><span>Proveedores</span></a></li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('usuarios') }}">
        <i class="fa-solid fa-users"></i>
        <span>Usuarios</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('productos.ordenes_facturas') }}">
        <i class="fa-solid fa-users"></i>
        <span>Ver Órdenes y Facturas</span>
      </a>
    </li>

  </ul>
</aside>
<!-- End Sidebar -->
