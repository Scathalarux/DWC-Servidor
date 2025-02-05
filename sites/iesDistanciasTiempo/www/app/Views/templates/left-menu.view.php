<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="<?php echo $_ENV['host.folder']?>" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-th"></i>
                <p>Inicio</p>
            </a>
        </li>
        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
        <li class="nav-item <?php /*//echo in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'].'demo-proveedores']) ? 'menu-open' : ''; */?>">
            <a href="<?php echo $_ENV['host.folder']?>" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p> Panel de control <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>demo-proveedores"
                       class="nav-link <?php /*//echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'].'demo-proveedores' ? 'active' : ''; */?>">
                        <i class="fas fa-laptop-code nav-icon"></i>
                        <p>Demo Proveedores</p>
                    </a>
                </li>
            </ul>
        </li>
<!--        <li class="nav-item">
            <a href="/usuarios/new"
               class="nav-link <?php /*echo '/usuarios/new' ? 'active' : ''; */?>">
                <i class="fas fa-table nav-icon"></i>
                <p>Nuevo usuario</p>
            </a>
        </li>-->
       <!-- --><?php /*if (str_contains($_SESSION['permisos']['csvController'], 'r') !== false) { */?>
        <li class="nav-item <?php echo in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'] . 'historicoPoblacionPontevedra', $_ENV['host.folder'] . 'poblacionGruposEdad', $_ENV['host.folder'] . 'poblacionPontevedra2020']) ? 'menu-open' : ''; ?>">
            <a href="<?php echo $_ENV['host.folder']?>" class="nav-link">
                <i class="nav-icon fas fa-file-excel"></i>
                <p>
                    Centros
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>centros"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'centros' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Listado de Centros</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->