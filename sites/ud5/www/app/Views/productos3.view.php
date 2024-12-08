<?php

declare(strict_types=1);

?>
<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="<?php echo $_ENV['host.folder'] . 'productos3' ?>">
                <input type="hidden" name="order" value="<?php echo $order ?>"/>
                <input type="hidden" name="page" value="<?php echo $page ?>"/>
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
                                <label for="codigo">Codigo Producto:</label>
                                <input type="text" class="form-control" name="codigo" id="codigo"
                                       value="<?php echo $input['codigo'] ?? '' ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="nombre">Nombre producto:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre"
                                       value="<?php echo $input['nombre'] ?? '' ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="id_categoria">Tipo:</label>
                                <select name="id_categoria[]" id="id_categoria" class="form-control select2"
                                        data-placeholder="Categoria" multiple>
                                    <option value="">-</option>
                                    <?php foreach ($categorias as $categoria) { ?>
                                        <option value="<?php echo $categoria['id_categoria'] ?>"
                                            <?php echo (isset($input['id_categoria']) && in_array($categoria['id_categoria'], $input['id_categoria'])) ? 'selected' : ''; ?>>
                                            <?php echo $categoria['nombre_categoria'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="proveedor">Continente:</label>
                                <select name="proveedor" id="proveedor" class="form-control"
                                        data-placeholder="Proveedor">
                                    <option value="">-</option>
                                    <?php foreach ($proveedores as $proveedor) { ?>
                                        <option value="<?php echo $proveedor['cif'] ?>"
                                            <?php echo (isset($input['proveedor']) && ($proveedor['cif'] == $input['proveedor'])) ? 'selected' : ''; ?>>
                                            <?php echo $proveedor['nombre'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="stock">Stock:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="minStock" id="minStock"
                                               value="<?php echo $input['minStock'] ?? '' ?>"
                                               placeholder="Mí­nimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="maxStock" id="maxStock"
                                               value="<?php echo $input['maxStock'] ?? '' ?>"
                                               placeholder="Máximo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="pvp">PVP:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="minPvp" id="minPvp"
                                               value="<?php echo $input['minPvp'] ?? '' ?>"
                                               placeholder="Mí­nimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="maxPvp" id="maxPvp"
                                               value="<?php echo $input['maxPvp'] ?? '' ?>"
                                               placeholder="Máximo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="<?php echo $_ENV['host.folder'] . 'productos3' ?>'>" value="" name="reiniciar"
                           class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <?php if (!empty($productos)) { ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo ?></h6>
            </div>
            <div class="col-6">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <a href="<?php echo $_ENV['host.folder'] . 'productos3/new'?>">Nuevo producto <i class="fa fa-plus-circle"></i></a>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped">
                    <thead>
                    <tr>
                        <th>
                            <a href="<?php echo $_ENV['host.folder'] . 'productos3?order=' . (($order == 1) ? '-' : '') ?>1">Codigo</a>
                            <?php if (abs($order) == 1) {
                                ?><i
                                class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                            } ?>
                        </th>
                        <th>
                            <a href="<?php echo $_ENV['host.folder'] . 'productos3?order=' . (($order == 2) ? '-' : '') ?>2">Nombre</a>
                            <?php if (abs($order) == 2) {
                                ?><i
                                class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                            } ?>
                        </th>
                        <th>
                            <a href="<?php echo $_ENV['host.folder'] . 'productos3?order=' . (($order == 3) ? '-' : '') ?>3">Categoria</a>
                            <?php if (abs($order) == 3) {
                                ?><i
                                class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                            } ?>
                        </th>
                        <th>
                            <a href="<?php echo $_ENV['host.folder'] . 'productos3?order=' . (($order == 4) ? '-' : '') ?>4">Proveedor</a>
                            <?php if (abs($order) == 4) {
                                ?><i
                                class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                            } ?>
                        </th>
                        <th>
                            <a href="<?php echo $_ENV['host.folder'] . 'productos3?order=' . (($order == 5) ? '-' : '') ?>5">Stock</a>
                            <?php if (abs($order) == 5) {
                                ?><i
                                class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                            } ?>
                        </th>
                        <th class="d-none d-lg-table-cell"><a
                                    href="<?php echo $_ENV['host.folder'] . 'productos3?order=' . (($order == 6) ? '-' : '') ?>6">Coste</a>
                            <?php if (abs($order) == 6) {
                                ?><i
                                class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                            } ?>
                        </th>
                        <th class="d-none d-lg-table-cell"><a
                                    href="<?php echo $_ENV['host.folder'] . 'productos3?order=' . (($order == 7) ? '-' : '') ?>7">Margen</a>
                            <?php if (abs($order) == 7) {
                                ?><i
                                class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                            } ?>
                        </th>
                        <th class="d-none d-lg-table-cell"><a
                                    href="<?php echo $_ENV['host.folder'] . 'productos3?order=' . (($order == 8) ? '-' : '') ?>8">PVP</a>
                            <?php if (abs($order) == 8) {
                                ?><i
                                class="fas fa-sort-amount-<?php echo $order < 0 ? 'up' : 'down'; ?>-alt"></i><?php
                            } ?>
                        </th>
                        <th>Opciones</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($productos as $producto) { ?>
                    <tr class="table-<?php if ($producto['stock'] < 10 && $producto['stock'] != 0) {
                        echo 'warning';
                                     } elseif ($producto['stock'] == 0) {
                                         echo 'danger';
                                     } ?>">
                        <td><?php echo $producto['codigo'] ?></td>
                        <td><?php echo $producto['nombre'] ?></td>
                        <td><?php echo $producto['nombre_categoria'] ?? '-' ?></td>
                        <td><?php echo $producto['nombre_proveedor'] ?></td>
                        <td><?php echo $producto['stock'] ?></td>
                        <td class="d-none d-lg-table-cell"><?php echo $producto['coste'] ?></td>
                        <td class="d-none d-lg-table-cell"><?php echo $producto['margen'] ?></td>
                        <td class="d-none d-lg-table-cell"><?php echo $producto['pvp'] ?></td>
                        <td>
                            <a href="<?php echo $_ENV['host.folder'] . 'productos3/edit/' . $producto['codigo']?>" class="btn btn-success ml-1" data-toggle="tooltip" data-placement="top" title="Editar Usuario"><i class="fa fa-pen"></i></a>
                            <a href="<?php echo $_ENV['host.folder'] . 'productos3/delete/' . $producto['codigo']?>" class="btn btn-danger ml-1" data-toggle="tooltip" data-placement="top" title="Editar Usuario"><i class="fa fa-trash"></i></a>
                        </td>
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
                                    <a class="page-link" href="<?php echo $_ENV['host.folder'] . 'productos3?' . $copiaGetPage . '&page='?>1" aria-label="First">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">First</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $_ENV['host.folder'] . 'productos3?' . $copiaGetPage . '&page=' . ($page - 1)?>" aria-label="Previous">
                                        <span aria-hidden="true">&lt;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="page-item active"><a class="page-link" href="#"><?php echo $page?></a></li>
                            <?php if ($page < $maxPages) {  ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $_ENV['host.folder'] . 'productos3?' . $copiaGetPage . '&page=' . ($page + 1)?>" aria-label="Next">
                                        <span aria-hidden="true">&gt;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $_ENV['host.folder'] . 'productos3?' . $copiaGetPage . '&page=' . $maxPages?>" aria-label="Last">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Last</span>
                                    </a>
                                </li>
                            <?php }?>
                        </ul>
                    </nav>
                </div>
        </div>
        <?php } else { ?>
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">No hay datos en la tabla que mostrar</h6>
        </div>
        <?php } ?>
    </div>
</div>
<!--Fin HTML -->
