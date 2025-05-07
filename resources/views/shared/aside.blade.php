 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{ route("home")}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="fa-solid fa-arrow-right-from-bracket"></i><span>Salidas</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route("responsivas.index") }}">
              <i class="bi bi-circle"></i><span>Responsiva</span>
            </a>
          </li>
          <li>
            <a href="components-accordion.html">
              <i class="bi bi-circle"></i><span>Soporte Tecnico</span>
            </a>
          </li>
          <li>
            <a href="components-accordion.html">
              <i class="bi bi-circle"></i><span>Entrega de Cartuchos</span>
            </a>
          </li>
          <li>
            <a href="components-accordion.html">
              <i class="bi bi-circle"></i><span>Devolucion</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Bitacoras</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="forms-elements.html">
              <i class="bi bi-circle"></i><span>Consulta Salidas</span>
            </a>
          </li>
          <li>
            <a href="{{ route("consulta-responsiva") }}">
              <i class="bi bi-circle"></i><span>Consulta Responsiva</span>
            </a>
          </li>
          <li>
            <a href="forms-layouts.html">
              <i class="bi bi-circle"></i><span>Consulta Soporte Tecnico</span>
            </a>
          </li>
          <li>
            <a href="forms-editors.html">
              <i class="bi bi-circle"></i><span>Consulta Entrega de Cartuchos</span>
            </a>
          </li>
          <li>
            <a href="forms-validation.html">
              <i class="bi bi-circle"></i><span>Consulta Devoluciones</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#productos-nav" data-bs-toggle="collapse" href="#">
          <i class="fa-solid fa-bag-shopping"></i><span>Productos</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="productos-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route("productos") }}">
              <i class="bi bi-circle"></i><span>Administrar Productos</span>
            </a>
          </li>
          <li>
            <a href="{{ route('reportes_productos') }}">
              <i class="bi bi-circle"></i><span>Reportes de Productos</span>
            </a>
          </li>
        </ul>
      </li><!-- End Productos Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('entradas') }}">
          <i class="fa-solid fa-cart-shopping"></i>
          <span>Entradas</span>
        </a>
      </li><!-- End Categorias Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route("categorias") }}">
          <i class="fa-solid fa-tags"></i>
          <span>Categorias</span>
        </a>
      </li><!-- End Categorias Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route("proveedores") }}">
          <i class="fa-solid fa-truck-field"></i>
          <span>Proveedores</span>
        </a>
      </li><!-- End Proveedores Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route("colaboradores") }}">
          <i class="fa-solid fa-users-gear"></i>
          <span>Colaboradores</span>
        </a>
      </li><!-- End Colaboradores Nav -->
  

      <li class="nav-heading">Admin</li>


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#gestionar_colaboradores-nav" data-bs-toggle="collapse" href="#">
          <i class="fa-solid fa-database"></i><span>Gestionar Datos</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="gestionar_colaboradores-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route("unidades") }}">
              <i class="bi bi-circle"></i><span>Unidades de Servicio</span>
            </a>
          </li>
          <li>
            <a href="{{ route("areas") }}">
              <i class="bi bi-circle"></i><span>Área / Departamento</span>
            </a>
          </li>
          <li>
            <a href="{{ route("empresas") }}">
              <i class="bi bi-circle"></i><span>Empresa</span>
            </a>
          </li>
        </ul>
      </li><!-- End Colaboradores Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route("usuarios") }}">
          <i class="fa-solid fa-users"></i>
          <span>Usuarios</span>
        </a>
      </li><!-- End Usuarios Nav -->

    </ul>

  </aside><!-- End Sidebar-->