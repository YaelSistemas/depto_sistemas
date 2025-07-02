<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center justify-content-between px-3 shadow-sm" style="height: 60px; background-color: #fff; border-bottom: 1px solid #dee2e6;">
  <div class="d-flex align-items-center flex-grow-1">
    <button class="btn p-0 me-3 border-0 bg-transparent toggle-sidebar-btn" type="button" aria-label="Toggle sidebar">
      <i class="bi bi-list fs-4"></i>
    </button>
    <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
      <img src="{{ asset('NiceAdmin/assets/img/GrupoVysisaLogo.png') }}" alt="Logo" height="40" class="me-2">
      <span class="fw-bold text-dark d-none d-sm-inline">Depto Sistemas</span>
    </a>
  </div>

  <div class="d-flex align-items-center text-end flex-shrink-0">
    <div class="d-none d-sm-flex flex-column me-3 text-dark">
      <span class="fw-bold">{{ Auth::user()->name }}</span>
      <small class="text-muted">{{ Auth::user()->rol }}</small>
    </div>
    <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger">Cerrar Sesión</a>
  </div>
</header>
