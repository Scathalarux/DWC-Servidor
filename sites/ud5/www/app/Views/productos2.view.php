<?php

declare(strict_types=1);

?>
<!--Filtros-->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="<?php echo $_ENV['host.folder']; ?>productos2">
                <input type="hidden" name="order" value="<?php echo $order?>"/>
                <!--<input type="hidden" name="page" value="<?php /*echo $page */ ?>"/>-->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="codigo">Codigo producto:</label>
                                <input type="text" class="form-control" name="codigo" id="codigo"
                                       value="<?php echo $input['codigo'] ?? ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="nombre">Nombre producto:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre"
                                       value="<?php echo $input['nombre'] ?? ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="categoria">Categoria producto:</label>
                                <select name="categoria[]" class="form-control select2" multiple>
                                    <?php foreach ($categorias as $categoria) { ?>
                                        <option value="<?php echo $categoria['id_categoria']; ?>"
                                            <?php echo isset($input['categoria']) && in_array($categoria['id_categoria'], $input['categoria']) ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($categoria['nombre_categoria']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="proveedor">Proveedor producto:</label>
                                <select name="proveedor" class="form-control">
                                    <option value="">-</option>
                                    <?php foreach ($proveedores as $proveedor) { ?>
                                        <option value="<?php echo $proveedor['cif']; ?>"
                                            <?php echo isset($input['proveedor']) && $proveedor['cif'] === $input['proveedor'] ? 'selected' : '';  ?>>
                                            <?php echo ucfirst($proveedor['nombre']) ?></option>
                                    <?php }  ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="stock">Stock producto:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="minStock" id="minStock"
                                               value="<?php echo $input['minStock'] ?? ''; ?>"
                                               placeholder="Mí­nimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="maxStock" id="maxStock"
                                               value="<?php echo $input['maxStock'] ?? ''; ?>"
                                               placeholder="Máximo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="pvp">PVP producto:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="minPvp" id="minPvp"
                                               value="<?php echo $input['minPvp'] ?? ''; ?>"
                                               placeholder="Mí­nimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="maxPvp" id="maxPvp"
                                               value="<?php echo $input['maxPvp'] ?? ''; ?>"
                                               placeholder="Máximo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12 text-right">
                                <a href="<?php echo $_ENV['host.folder']; ?>productos2" value="" name="reiniciar"
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
        <?php if (!empty($productos)) { ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-6">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6>
                    </div>
                </div>
                <div class="card-body" id="card_table">
                    <table id="tabladatos" class="table table-striped datatable">
                        <thead>
                        <tr>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'productos2?' . $copiaGet . 'order=' . (($order > 0) ? '-' : '') ?>1">Código</a>
                                <?php if (abs($order) == 1) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order < 0) ? 'up' : 'down'?>-alt"></i>
                                <?php }?></th>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'productos2?' . $copiaGet . 'order=' . (($order > 0) ? '-' : '')  ?>2">Nombre</a>
                                <?php if (abs($order) == 2) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order < 0) ? 'up' : 'down'?>-alt"></i>
                                <?php }?></th>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'productos2?' . $copiaGet . 'order=' . (($order > 0) ? '-' : '')  ?>3">Categoría</a>
                                <?php if (abs($order) == 3) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order < 0) ? 'up' : 'down'?>-alt"></i>
                                <?php }?></th>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'productos2?' . $copiaGet . 'order=' . (($order > 0) ? '-' : '')  ?>4">Proveedor</a>
                                <?php if (abs($order) == 4) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order < 0) ? 'up' : 'down'?>-alt"></i>
                                <?php }?></th>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'productos2?' . $copiaGet . 'order=' . (($order > 0) ? '-' : '') ?>5">Stock</a>
                                <?php if (abs($order) == 5) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order < 0) ? 'up' : 'down'?>-alt"></i>
                                <?php }?></th>
                            <th class="d-none d-lg-table-cell"><a href="<?php echo $_ENV['host.folder'] . 'productos2?' . $copiaGet . 'order=' . (($order > 0) ? '-' : '')  ?>6">Coste</a>
                                <?php if (abs($order) == 6) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order < 0) ? 'up' : 'down'?>-alt"></i>
                                <?php }?></th>
                            <th class="d-none d-lg-table-cell"><a href="<?php echo $_ENV['host.folder'] . 'productos2?' . $copiaGet . 'order=' . (($order > 0) ? '-' : '') ?>7">Margen</a>
                                <?php if (abs($order) == 7) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order < 0) ? 'up' : 'down'?>-alt"></i>
                                <?php }?></th>
                            <th class="d-none d-lg-table-cell"><a href="<?php echo $_ENV['host.folder'] . 'productos2?' . $copiaGet . 'order=' . (($order > 0) ? '-' : '') ?>8">PVP</a>
                                <?php if (abs($order) == 8) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order < 0) ? 'up' : 'down'?>-alt"></i>
                                <?php }?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($productos as $producto) { ?>
                            <tr class="table-<?php if ($producto['stock'] < 10) {
                                echo $producto['stock'] == 0 ? 'danger' : 'warning';
                                             } else {
                                                 echo'';
                                             }; ?>">
                                <td><?php echo $producto['codigo'] ?></td>
                                <td><?php echo ucfirst($producto['nombre']) ?></td>
                                <td><?php echo ucfirst($producto['nombre_categoria']) ?></td>
                                <td><?php echo ucfirst($producto['nombre_proveedor']) ?></td>
                                <td><?php echo $producto['stock'] ?></td>
                                <td class="d-none d-lg-table-cell"><?php echo $producto['coste'] ?></td>
                                <td class="d-none d-lg-table-cell"><?php echo $producto['margen'] ?></td>
                                <td class="d-none d-lg-table-cell"><?php echo $producto['pvp']?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="alert alert-warning" role="alert">
                No hay registros en la base de datos
            </div>
        <?php } ?>
    </div>
</div>
