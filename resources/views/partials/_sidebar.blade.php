<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('companies.index') }}">
          <i class="icon-building menu-icon"></i>
          <span class="menu-title">Empresa</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <i class="icon-head menu-icon"></i>
          <span class="menu-title">Usuarios</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('users.index') }}"> Lista de Usuarios </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('users.create') }}"> Crear Usuario </a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('profile.edit') }}"> Mi Perfil </a></li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>
