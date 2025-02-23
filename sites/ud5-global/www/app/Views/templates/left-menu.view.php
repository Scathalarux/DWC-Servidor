<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="<?php echo $_ENV['host.folder'] ?>"
               class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-th"></i>
                <p>Inicio</p>
            </a>
        </li>
        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

        <!--        <li class="nav-item">
            <a href="/usuarios/new"
               class="nav-link <?php /*echo '/usuarios/new' ? 'active' : ''; */ ?>">
                <i class="fas fa-table nav-icon"></i>
                <p>Nuevo usuario</p>
            </a>
        </li>-->
        <?php if (str_contains($_SESSION['permisos']['usuariosSistema'], 'r')) { ?>
            <li class="nav-item <?php echo in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'] . 'usuarios-sistema']) ? 'menu-open' : ''; ?>">
                <a href="<?php echo $_ENV['host.folder'] ?>" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Usuarios sistema<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo $_ENV['host.folder'] ?>usuarios-sistema"
                           class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'usuarios-sistema' ? 'active' : ''; ?>">
                            <i class="fas fa-laptop-code nav-icon"></i>
                            <p>Listado Usuarios sistema</p>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>
    </ul>
</nav>
<!-- /.sidebar-menu -->