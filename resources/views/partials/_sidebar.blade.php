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

      <!-- Menú de Dispositivos -->
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#devices" aria-expanded="false" aria-controls="devices">
          <i class="icon-screen-smartphone menu-icon"></i>
          <span class="menu-title">Dispositivos</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="devices">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('brands.index') }}">Marcas</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('device-types.index') }}">Tipos</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('device-models.index') }}">Modelos</a></li>
          </ul>
        </div>
      </li>

      <!-- Menú de Clientes -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('customers.index') }}">
          <i class="icon-people menu-icon"></i>
          <span class="menu-title">Clientes</span>
        </a>
      </li>
    </ul>
  </nav>
