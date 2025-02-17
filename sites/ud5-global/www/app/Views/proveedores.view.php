<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="/proveedores">
                <input type="hidden" name="order" value="1"/>
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre"
                                       value="<?php echo $input['nombre'] ?? '' ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="cif">Cif:</label>
                                <input type="text" class="form-control" name="cif" id="cif"
                                       value="<?php echo $input['cif'] ?? '' ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" name="codigo" id="codigo"
                                       value="<?php echo $input['codigo'] ?? '' ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="pais">Pais:</label>
                                <select name="pais[]" id="pais" class="form-control select2"
                                        data-placeholder="Tipo proveedor" multiple>
                                    <?php foreach ($paises as $pais) { ?>
                                        <option value="<?php echo $pais['pais'] ?>" <?php echo (isset($input['pais']) && in_array($pais['pais'], $input['pais'])) ? 'selected' : '' ?>><?php echo $pais['pais'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       value="<?php echo $input['email'] ?? '' ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="telefono">Teléfono:</label>
                                <input type="tel" class="form-control" name="telefono" id="telefono"
                                       value="<?php echo $input['telefono'] ?? '' ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="/proveedores" value="" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Proveedores</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <?php if (!empty($proveedores)) { ?>
                    <table id="tabladatos" class="table table-striped">
                        <thead>
                        <tr>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaPageOrder . '&order=' . ($order == 1 ? '-' : '') ?>1">Cif</a>
                                <?php if (abs($order) === 1) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaPageOrder . '&order=' . ($order == 2 ? '-' : '') ?>2">Código</a>
                                <?php if (abs($order) === 2) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaPageOrder . '&order=' . ($order == 3 ? '-' : '') ?>3">Nombre</a>
                                <?php if (abs($order) === 3) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaPageOrder . '&order=' . ($order == 4 ? '-' : '') ?>4">País</a>
                                <?php if (abs($order) === 4) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaPageOrder . '&order=' . ($order == 5 ? '-' : '') ?>5">Dirección</a>
                                <?php if (abs($order) === 5) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaPageOrder . '&order=' . ($order == 6 ? '-' : '') ?>6">Email</a>
                                <?php if (abs($order) === 6) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($proveedores as $proveedor) { ?>
                            <tr>
                                <td><?php echo $proveedor['cif'] ?></td>
                                <td><?php echo $proveedor['codigo'] ?></td>
                                <td><?php echo $proveedor['nombre'] ?></td>
                                <td><?php echo $proveedor['pais'] ?></td>
                                <td><?php echo $proveedor['direccion'] ?></td>
                                <td><?php echo $proveedor['email'] ?></td>
                                <td>
                                    <a href="<?php echo $_ENV['host.folder'] . 'proveedores/edit/' . $proveedor['cif'] ?>"
                                       target="_blank" class="btn btn-success ml-1"
                                       data-toggle="tooltip"
                                       data-placement="top" title="Editar"><i class="fas fa-pen"></i></a>
                                    <a href="<?php echo $_ENV['host.folder'] . 'proveedores/delete/' . $proveedor['cif'] ?>"
                                       target="_blank" class="btn btn-danger"
                                       data-toggle="tooltip"
                                       data-placement="top" title="Borrar"><i class="fas fa-trash"></i></a>
                                    <a href="<?php echo $_ENV['host.folder'] . 'proveedores/view/' . $proveedor['cif'] ?>"
                                       target="_blank" class="btn btn-primary ml-1" title="Ver más"><i
                                                class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">No hay datos que mostrar</h6>
                    </div>
                <?php } ?>
            </div>
            <div class="card-footer">
                <nav aria-label="Navegacion por paginas">
                    <ul class="pagination justify-content-center">
                        <?php if ($page !== 1) { ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaPage . 'page=1' ?>"
                                   aria-label="First">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">First</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaPage . 'page=' . ($page - 1) ?>"
                                   aria-label="Previous">
                                    <span aria-hidden="true">&lt;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                        <?php } ?>

                        <li class="page-item active">
                            <a class="page-link"
                               href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaPage . 'page=' . $page ?>"><?php echo $page ?></a>
                        </li>

                        <?php if ($page !== $maxPage) { ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaPage . 'page=' . ($page + 1) ?>"
                                   aria-label="Next">
                                    <span aria-hidden="true">&gt;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaPage . 'page=' . $maxPage ?>"
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
    </div>
</div>
<!--Fin HTML -->