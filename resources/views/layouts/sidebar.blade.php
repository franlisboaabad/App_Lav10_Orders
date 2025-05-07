<div id="sidebar-menu">
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title">Navegación</li>

        <li class="side-nav-item">
            <a href="{{ route('dashboard') }}" class="side-nav-link">
                <i class="mdi mdi-view-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="menu-title">Gestión</li>

        <li class="side-nav-item">
            <a href="{{ route('users.index') }}" class="side-nav-link">
                <i class="mdi mdi-account-multiple"></i>
                <span>Usuarios</span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('companies.index') }}" class="side-nav-link">
                <i class="mdi mdi-office-building"></i>
                <span>Empresa</span>
            </a>
        </li>

        <li class="menu-title">Dispositivos</li>

        <li class="side-nav-item">
            <a href="{{ route('brands.index') }}" class="side-nav-link">
                <i class="mdi mdi-tag-multiple"></i>
                <span>Marcas</span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('device-types.index') }}" class="side-nav-link">
                <i class="mdi mdi-devices"></i>
                <span>Tipos de Dispositivos</span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('device-models.index') }}" class="side-nav-link">
                <i class="mdi mdi-cellphone-link"></i>
                <span>Modelos</span>
            </a>
        </li>

        <li class="menu-title">Clientes y Servicios</li>

        <li class="side-nav-item">
            <a href="{{ route('customers.index') }}" class="side-nav-link">
                <i class="mdi mdi-account-group"></i>
                <span>Clientes</span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('service-orders.index') }}" class="side-nav-link">
                <i class="mdi mdi-tools"></i>
                <span>Órdenes de Servicio</span>
            </a>
        </li>

        <li class="menu-title">Inventario</li>

        <li class="side-nav-item">
            <a href="{{ route('categories.index') }}" class="side-nav-link">
                <i class="mdi mdi-shape"></i>
                <span>Categorías</span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('suppliers.index') }}" class="side-nav-link">
                <i class="mdi mdi-truck"></i>
                <span>Proveedores</span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('products.index') }}" class="side-nav-link">
                <i class="mdi mdi-package-variant"></i>
                <span>Productos</span>
            </a>
        </li>
    </ul>
</div>
