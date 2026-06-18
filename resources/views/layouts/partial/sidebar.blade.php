<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ asset('backend/dist/img/logo_home4.png') }}" alt="Logo" style="opacity: .8; width:235px; height:80px;">
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('/home') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i> <p>Panel De Control</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i> <p>Ventas<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('clientes.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i> <p>Clientes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('metodo_pagos.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-credit-card"></i> <p>Metodo de Pago</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pagos.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-wallet"></i> <p>Pagos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('facturas.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-cash-register"></i> <p>Facturas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('productos.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-boxes"></i> <p>Productos</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>