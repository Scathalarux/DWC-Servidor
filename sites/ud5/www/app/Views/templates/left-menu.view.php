<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="<?php echo $_ENV['host.folder']?>" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Inicio
                </p>
            </a>
        </li>
        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
        <li class="nav-item <?php /*//echo in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'].'demo-proveedores']) ? 'menu-open' : ''; */?>">
            <a href="<?php echo $_ENV['host.folder']?>" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Panel de control
                    <i class="right fas fa-angle-left"></i>
                </p>
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
        <li class="nav-item <?php echo in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'].'historicoPoblacionPontevedra', $_ENV['host.folder'].'poblacionGruposEdad', $_ENV['host.folder'].'poblacionPontevedra2020']) ? 'menu-open' : ''; ?>">
            <a href="<?php echo $_ENV['host.folder']?>" class="nav-link">
                <i class="nav-icon fas fa-file-excel"></i>
                <p>
                    Ejercicios de clase
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>historicoPoblacionPontevedra"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'].'historicoPoblacionPontevedra' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Histórico población Pontevedra</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>poblacionGruposEdad"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'].'poblacionGruposEdad' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Población Grupos-Edad</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>poblacionPontevedra2020"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'].'poblacionPontevedra2020' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Población Pontevedra 2020</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>anadirMunicipio"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'].'anadirMunicipio' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Añadir Municipio</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->