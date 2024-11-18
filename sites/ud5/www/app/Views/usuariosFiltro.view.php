<!--Filtros-->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="<?php echo $_ENV['host.folder']; ?>users-filter?">
                <input type="hidden" name="order" value="<?php echo $order ?>"/>
                <input type="hidden" name="page" value="<?php echo $page ?>"/>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="username">Nombre usuario:</label>
                                <input type="text" class="form-control" name="username" id="username"
                                       value="<?php echo $input['username'] ?? ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="id_rol">Tipo usuario:</label>
                                <select name="id_rol" class="form-control">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) { ?>
                                        <option value="<?php echo $rol['id_rol']; ?>"
                                            <?php echo isset($input['id_rol']) && $rol['id_rol'] === $input['id_rol'] ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($rol['nombre_rol']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="salarioBruto">Salario Bruto:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="salarioMinimo" id="salarioMinimo"
                                               value="<?php echo $input['salarioMinimo'] ?? ''; ?>"
                                               placeholder="Mí­nimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="salarioMaximo" id="salarioMaximo"
                                               value="<?php echo $input['salarioMaximo'] ?? ''; ?>"
                                               placeholder="Máximo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="cotizacion">Cotización:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="cotizacionMinimo"
                                               id="cotizacionMinimo"
                                               value="<?php echo $input['cotizacionMinimo'] ?? ''; ?>"
                                               placeholder="Mí­nimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="cotizacionMaximo"
                                               id="cotizacionMaximo"
                                               value="<?php echo $input['cotizacionMaximo'] ?? ''; ?>"
                                               placeholder="Máximo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="id_country">País:</label>
                                <select name="id_country[]" id="id_country" class="form-control select2"
                                        data-placeholder="Países" multiple>
                                    <?php foreach ($countries as $country) { ?>
                                        <option value="<?php echo $country['id']; ?>" <?php echo (isset($input['id_country']) && in_array($country['id'], $input['id_country'])) ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($country['country_name']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12 text-right">
                                <a href="<?php echo $_ENV['host.folder']; ?>users-filter" value="" name="reiniciar"
                                   class="btn btn-danger">Reiniciar filtros</a>
                                <input type="submit" value="Aplicar filtros" class="btn btn-primary ml-2"/>
                                <!--Si no le introducimos el nombre al botón, no aparecerá su value en la URL-->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- DataTables -->
<div class="row">
    <div class="col-12">
        <?php
        if (!empty($usuarios)) {
            ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-6">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6>
                    </div>
                    <div class="col-6">
                        <div class="m-0 font-weight-bold justify-content-end">
                            <a href="<?php echo $_ENV['host.folder'] . 'users-filter/new'?>"
                               class="btn btn-primary ml-1 float-right"> Nuevo
                                Usuario <i class="fas fa-plus-circle"></i></a>
                        </div>
                    </div>
                </div>

                <div class="card-body" id="card_table">
                    <table id="tabladatos" class="table table-striped datatable">
                        <thead>
                        <tr>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'users-filter?' . $copiaGet . 'page=' . $page . '&order=' . (($order == 1) ? '-' : ''); ?>1">Nombre
                                    usuario</a>
                                    <?php if (abs($order) == 1) {
                                        ?><i
                                    class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                                    } ?></th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'users-filter?' . $copiaGet . 'page=' . $page . '&order=' . (($order == 2) ? '-' : ''); ?>2">Salario
                                    Bruto</a><?php if (abs($order) == 2) {
                                        ?><i
                                    class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                                             } ?></th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'users-filter?' . $copiaGet . 'page=' . $page . '&order=' . (($order == 3) ? '-' : ''); ?>3">Retención
                                    IRPF</a><?php if (abs($order) == 3) {
                                        ?><i
                                    class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                                            } ?></th>
                            <th>Salario Neto</th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'users-filter?' . $copiaGet . 'page=' . $page . '&order=' . (($order == 4) ? '-' : ''); ?>4">Rol</a><?php if (abs($order) == 4) {
                                    ?><i
                                    class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                                         } ?></th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'users-filter?' . $copiaGet . 'page=' . $page . '&order=' . (($order == 5) ? '-' : ''); ?>5">País</a><?php if (abs($order) == 5) {
                                    ?><i
                                    class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                                         } ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($usuarios as $usuario) { ?>
                            <tr class="<?php echo !($usuario['activo']) ? 'table-danger' : '' ?>">
                                <td><?php echo $usuario['username']; ?></td>
                                <td><?php echo number_format($usuario['salarioBruto'], 2, ',', '.') ?></td>
                                <td><?php echo number_format($usuario['retencionIRPF']) . '%' ?></td>
                                <td><?php echo str_replace([',', '.', '_'], ['_', ',', '.'], $usuario['salarioNeto']) ?></td>
                                <td><?php echo $usuario['nombre_rol'] ?></td>
                                <td><?php echo $usuario['country_name'] ?></td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <nav aria-label="Navegacion por paginas">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1) { ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo $_ENV['host.folder'] . 'users-filter?' . $copiaGetPage . 'page=1'?>"
                                   aria-label="First">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">First</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo $_ENV['host.folder'] . 'users-filter?' . $copiaGetPage . 'page=' . ($page - 1) ?>"
                                   aria-label="Previous">
                                    <span aria-hidden="true">&lt;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <?php } ?>
                            <li class="page-item active">
                                <a class="page-link"
                                   href="<?php echo $_ENV['host.folder'] . 'users-filter?' . $copiaGetPage . 'page=' . $page?>"><?php echo $page; ?></a>
                            </li>
                            <?php if ($page < $maxPages) { ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo $_ENV['host.folder'] . 'users-filter?' . $copiaGetPage . 'page=' . ($page + 1) ?>" aria-label="Next">
                                    <span aria-hidden="true">&gt;</span>
                                    <span class="sr-only">Next</span>
                            </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo $_ENV['host.folder'] . 'users-filter?' . $copiaGetPage . 'page=' . $maxPages ?>"
                                   aria-label="Last">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Last</span>
                                </a>
                            </li>

                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>

        <?php } else {
            ?>
            <div class="alert alert-warning" role="alert">
                No hay registros en la base de datos
            </div>
        <?php } ?>
    </div>
</div>