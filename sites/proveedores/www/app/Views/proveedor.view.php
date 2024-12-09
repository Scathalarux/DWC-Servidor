<?php

declare(strict_types=1);

?>
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
                                <label for="alias">Alias:</label>
                                <input type="text" class="form-control" name="alias" id="alias"
                                       value="<?php echo $input['alias'] ?? '' ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="nombre_completo">Nombre completo:</label>
                                <input type="text" class="form-control" name="nombre_completo" id="nombre_completo"
                                       value="<?php echo $input['nombre_completo'] ?? '' ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="id_tipo">Tipo:</label>
                                <select name="id_tipo[]" id="id_tipo" class="form-control select2"
                                        data-placeholder="Tipo proveedor" multiple>
                                    <option value="">-</option>
                                    <?php foreach ($tiposProveedores as $tipoProveedor) { ?>
                                        <option value="<?php echo $tipoProveedor['id_tipo_proveedor'] ?>" <?php echo (isset($input['id_tipo']) && in_array($tipoProveedor['id_tipo_proveedor'], $input['id_tipo'])) ? 'selected' : '' ?>><?php echo $tipoProveedor['nombre_tipo_proveedor'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_continente">Continente:</label>
                                <select name="id_continente" id="id_continente" class="form-control"
                                        data-placeholder="Continente">
                                    <option value="">-</option>
                                    <?php foreach ($continentes as $continente) { ?>
                                        <option value="<?php echo $continente['id_continente'] ?>" <?php echo (isset($input['id_continente']) && ($continente['id_continente'] == $input['id_continente'])) ? 'selected' : '' ?>><?php echo $continente['nombre_continente'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="anho_fundacion">Año fundación:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_anho" id="min_anho" value="<?php echo $input['min_anho'] ?? '' ?>"
                                               placeholder="Mí­nimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_anho" id="max_anho" value="<?php echo $input['max_anho'] ?? '' ?>"
                                               placeholder="Máximo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="/proveedores" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <?php if (!empty($proveedores)) { ?>
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo ?></h6>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped">
                    <thead>
                    <tr>
                        <th>
                            <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaGet . 'page=' . $page . '&order=' . (($order == 1) ? '-' : '') ?>1">Alias</a>
                            <?php if (abs($order) == 1) { ?>
                            <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i></th>
                            <?php } ?>
                        <th>
                            <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaGet . 'page=' . $page . '&order=' . (($order == 2) ? '-' : '') ?>2">Nombre
                                Completo</a>
                            <?php if (abs($order) == 2) { ?>
                            <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i></th>
                            <?php } ?>
                        <th>
                            <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaGet . 'page=' . $page . '&order=' . (($order == 3) ? '-' : '') ?>3">Tipo</a>
                            <?php if (abs($order) == 3) { ?>
                            <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i></th>
                            <?php } ?>
                        <th>
                            <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaGet . 'page=' . $page . '&order=' . (($order == 4) ? '-' : '') ?>4">Continente</a>
                            <?php if (abs($order) == 4) { ?>
                            <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i></th>
                            <?php } ?>

                        <th>
                            <a href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaGet . 'page=' . $page . '&order=' . (($order == 5) ? '-' : '') ?>5">Año
                                fundación</a>
                            <?php if (abs($order) == 5) { ?>
                            <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i></th>
                            <?php } ?>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($proveedores as $proveedor) { ?>
                        <tr class="table-<?php echo $proveedor['continente_avisar'] ? 'warning' : '' ?>" >
                            <td><?php echo $proveedor['alias'] ?></td>
                            <td><?php echo $proveedor['nombre_completo'] ?></td>
                            <td><?php echo $proveedor['nombre_tipo_proveedor'] ?></td>
                            <td><?php echo $proveedor['nombre_continente'] ?></td>
                            <td><?php echo $proveedor['anho_fundacion'] ?></td>
                            <td>
                                <a href="tel: <?php echo $proveedor['telefono'] ?>"
                                   target="_blank" class="btn btn-success ml-1" data-toggle="tooltip"
                                   data-placement="top" title="Teléfono"><i class="fas fa-phone"></i></a>
                                <a href="mailto: <?php echo $proveedor['email'] ?>"
                                   target="_blank" class="btn btn-info" data-toggle="tooltip" data-placement="top"
                                   title="<?php echo $proveedor['email'] ?>"><i class="fas fa-envelope"></i></a>
                                <?php if (!empty($proveedor['website'])) { ?>
                                    <a href="<?php echo $proveedor['website'] ?>"
                                       target="_blank" class="btn btn-light ml-1"><i
                                                class="fas fa-globe-europe"></i></a>
                                <?php } ?>
                                <a href="<?php echo $_ENV['host.folder'] . 'proveedores/delete/' . $proveedor['id_proveedor'] ?>" class="btn btn-danger ml-3"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav aria-label="Navegacion por paginas">
                    <ul class="pagination justify-content-center">
                        <?php if ($page != 1) { ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaGetPage . '&page=1'?>" aria-label="First">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">First</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaGetPage . '&page=' . ($page - 1)?>" aria-label="Previous">
                                <span aria-hidden="true">&lt;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <?php } ?>

                        <li class="page-item active"><a class="page-link" href="#"><?php echo $page ?></a></li>
                        <?php if ($page != $maxPage) { ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaGetPage . '&page=' . ($page + 1)?>" aria-label="Next">
                                <span aria-hidden="true">&gt;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $_ENV['host.folder'] . 'proveedores?' . $copiaGetPage . '&page=' . $maxPage?>" aria-label="Last">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Last</span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
        <?php } else { ?>
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-warning">
            <h6 class="m-0 font-weight-bold text-black">No hay datos que mostrar</h6>
        </div>
        <?php } ?>
    </div>
</div>
<!--Fin HTML -->