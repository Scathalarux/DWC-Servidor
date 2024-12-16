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
<!--        <li class="nav-item">
            <a href="/usuarios/new"
               class="nav-link <?php /*echo '/usuarios/new' ? 'active' : ''; */?>">
                <i class="fas fa-table nav-icon"></i>
                <p>Nuevo usuario</p>
            </a>
        </li>-->
        <li class="nav-item <?php echo in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'] . 'historicoPoblacionPontevedra', $_ENV['host.folder'] . 'poblacionGruposEdad', $_ENV['host.folder'] . 'poblacionPontevedra2020']) ? 'menu-open' : ''; ?>">
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
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'historicoPoblacionPontevedra' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Histórico población Pontevedra</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>poblacionGruposEdad"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'poblacionGruposEdad' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Población Grupos-Edad</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>poblacionPontevedra2020"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'poblacionPontevedra2020' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Población Pontevedra 2020</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>anadirMunicipio"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'anadirMunicipio' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Añadir Municipio</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item <?php echo in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'] . 'allUsers', $_ENV['host.folder'] . 'usersBySalario', $_ENV['host.folder'] . 'standardUsers',$_ENV['host.folder'] . 'usersByName',$_ENV['host.folder'] . 'users-filter', $_ENV['host.folder'] . 'productos', $_ENV['host.folder'] . 'productos2', $_ENV['host.folder'] . 'productos3']) ? 'menu-open' : ''; ?>">
            <a href="<?php echo $_ENV['host.folder']?>" class="nav-link">
                <i class="nav-icon fas fa-file-excel"></i>
                <p>
                    Ejercicios BBDD
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>allUsers"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'allUsers' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Todos los usuarios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>usersBySalario"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'usersBySalario' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Usuarios según salario </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>standardUsers"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'standardUsers' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Usuarios standard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>usersByName"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'usersByName' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Usuarios según nombre</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>users-filter"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'users-filter' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Usuarios filtros</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>productos"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'productos' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Productos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>productos2"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'productos2' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Productos2</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>productos3"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'productos3' ? 'active' : ''; ?>">
                        <i class="fas fa-table nav-icon"></i>
                        <p>Productos3</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item <?php echo in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'] . 'pruebaCookies']) ? 'menu-open' : ''; ?>">
            <a href="<?php echo $_ENV['host.folder']?>" class="nav-link">
                <i class="nav-icon fas fa-cookie"></i>
                <p>
                    Cookies y Sesión
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>preferenciasUsuario"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'preferenciasUsuario' ? 'active' : ''; ?>">
                        <i class="fas fa-cookie-bite nav-icon"></i>
                        <p>Preferencias Usuario</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item <?php echo in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'] . 'usuariosSistema', $_ENV['host.folder'] . 'usuariosSistema/login']) ? 'menu-open' : ''; ?>">
            <a href="<?php echo $_ENV['host.folder']?>" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Usuarios Sistema
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>usuariosSistema/login"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'usuariosSistema/login' ? 'active' : ''; ?>">
                        <i class="fas fa-user-circle nav-icon"></i>
                        <p>Login Usuarios Sistema</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder']?>usuariosSistema"
                       class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'usuariosSistema' ? 'active' : ''; ?>">
                        <i class="fas fa-user-circle nav-icon"></i>
                        <p>Usuarios Sistema</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->