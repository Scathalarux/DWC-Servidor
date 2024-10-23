 <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="/" class="nav-link active">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inicio
              </p>
            </a>
          </li> 
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                CSV
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/csv" class="nav-link <?php echo isset($seccion) && $seccion === '/csv' ? 'active' : ''; ?>">
                  <i class="far fa-file-excel nav-icon"></i>
                  <p>Fichero totales</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/csv/pontevedra2020" class="nav-link <?php echo isset($seccion) && $seccion === '/csv/pontevedra2020' ? 'active' : ''; ?>">
                  <i class="far fa-file-excel nav-icon"></i>
                  <p>Fichero Pontevedra 2020</p>
                </a>
              </li>              
            </ul>
          </li>       
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Base de datos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/categoria" class="nav-link <?php echo isset($seccion) && $seccion === '/categoria' ? 'active' : ''; ?>">
                  <i class="fas fa-cubes nav-icon"></i>
                  <p>Listado categorías</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/categoria/new" class="nav-link <?php echo isset($seccion) && $seccion === '/categoria/new' ? 'active' : ''; ?>">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Formulario alta</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/categoria-array/test-insert?nombre=" class="nav-link <?php echo isset($seccion) && $seccion === '/categoria-array/test-insert' ? 'active' : ''; ?>">
                  <i class="fas fa-cube nav-icon"></i>
                  <p>Inserción categoría</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/categoria/test-insert?nombre=" class="nav-link <?php echo isset($seccion) && $seccion === '/categoria/test-insert' ? 'active' : ''; ?>">
                  <i class="fas fa-cube nav-icon"></i>
                  <p>Insert con object</p>
                </a>
              </li>              
            </ul>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-stethoscope"></i>
              <p>
                Tests
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/test/index" class="nav-link <?php echo isset($seccion) && $seccion === '/test/index' ? 'active' : ''; ?>">
                  <i class="fas fa-cubes nav-icon"></i>
                  <p>Index</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/test/test-emulated" class="nav-link <?php echo isset($seccion) && $seccion === '/test/test-emulated' ? 'active' : ''; ?>">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Index (Emulado)</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/test/insert-categoria?nombre=" class="nav-link <?php echo isset($seccion) && $seccion === '/test/insert-categoria' ? 'active' : ''; ?>">
                  <i class="fas fa-cube nav-icon"></i>
                  <p>Insert</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/test/update-usuario-salar" class="nav-link <?php echo isset($seccion) && $seccion === '/test/update-usuario-salar' ? 'active' : ''; ?>">
                  <i class="fas fa-cube nav-icon"></i>
                  <p>Update salar</p>
                </a>
              </li>  
              <li class="nav-item">
                <a href="/test/delete-usuarios" class="nav-link <?php echo isset($seccion) && $seccion === '/test/delete-usuarios' ? 'active' : ''; ?>">
                  <i class="fas fa-cube nav-icon"></i>
                  <p>Delete Usuarios</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="/test/rellenar-aleatorio" class="nav-link <?php echo isset($seccion) && $seccion === '/test/rellenar-aleatorio' ? 'active' : ''; ?>">
                  <i class="fas fa-cube nav-icon"></i>
                  <p>Rellenar aleatorio</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/test/test-limit" class="nav-link <?php echo isset($seccion) && $seccion === '/test/test-limit' ? 'active' : ''; ?>">
                  <i class="fas fa-cube nav-icon"></i>
                  <p>Query LIMIT</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/test/test-limit-bind" class="nav-link <?php echo isset($seccion) && $seccion === '/test/test-limit-bind' ? 'active' : ''; ?>">
                  <i class="fas fa-cube nav-icon"></i>
                  <p>Query LIMIT Bind</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/test/test-order-by" class="nav-link <?php echo isset($seccion) && $seccion === '/test/test-order-by' ? 'active' : ''; ?>">
                  <i class="fas fa-cube nav-icon"></i>
                  <p>Order By</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/test/test-search-active" class="nav-link <?php echo isset($seccion) && $seccion === '/test/test-search-active' ? 'active' : ''; ?>">
                  <i class="fas fa-cube nav-icon"></i>
                  <p>Search Active</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->