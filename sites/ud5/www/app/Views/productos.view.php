<?php

declare(strict_types=1);

?>
<!--Filtros-->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="<?php echo $_ENV['host.folder']; ?>productos">
<!--                <input type="hidden" name="order" value="<?php /*echo $order */?>"/>
                <input type="hidden" name="page" value="<?php /*echo $page */?>"/>-->
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
                                            <?php echo isset($input['categoria'])&& $categoria['id_categoria'] == $input['categoria'] ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($categoria['nombre_categoria'])?></option>
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
                                            <?php echo isset($input['proveedor']) && $proveedor['cif'] === $input['proveedor'] ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($proveedor['nombre']) ?></option>
                                    <?php } ?>
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
                                <a href="<?php echo $_ENV['host.folder']; ?>productos" value="" name="reiniciar"
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
        if (!empty($productos)) {
            ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <div class="col-6">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6>
                    </div>
                    <div class="col-6">
                        <div class="m-0 font-weight-bold justify-content-end">
                            <a href="<?php echo $_ENV['host.folder'] . 'producto/new'?>"
                               class="btn btn-primary ml-1 float-right"> Nuevo
                                producto <i class="fas fa-plus-circle"></i></a>
                        </div>
                    </div>
                </div>

                <div class="card-body" id="card_table">
                    <table id="tabladatos" class="table table-striped datatable">
                        <thead>
                        <tr>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'productos&order='; ?>1">Código</a></th>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'productos&order='; ?>2">Nombre</a></th>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'productos&order='; ?>3">Categoría</a></th>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'productos&order='; ?>4">Proveedor</a></th>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'productos&order='; ?>5">Stock</a></th>
                            <th class="d-none d-lg-table-cell"><a href="<?php echo $_ENV['host.folder'] . 'productos&order='; ?>6">Coste</a></th>
                            <th class="d-none d-lg-table-cell"><a href="<?php echo $_ENV['host.folder'] . 'productos&order='; ?>7">Margen</a></th>
                            <th class="d-none d-lg-table-cell"><a href="<?php echo $_ENV['host.folder'] . 'productos&order='; ?>8">PVP</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($productos as $producto) { ?>
                            <tr>
                                <td><?php echo $producto['codigo']; ?></td>
                                <td><?php echo $producto['nombre']; ?></td>
                                <td><?php echo $producto['nombre_proveedor']; ?></td>
                                <td><?php echo $producto['nombre_categoria']; ?></td>
                                <td><?php echo $producto['stock']; ?></td>
                                <td class="d-none d-lg-table-cell"><?php echo $producto['coste']; ?></td>
                                <td class="d-none d-lg-table-cell"><?php echo $producto['margen']; ?></td>
                                <td class="d-none d-lg-table-cell"><?php echo $producto['pvp']; ?></td>

                                <td>
                                    <a href="" class="btn btn-success ml-1" data-toggle="tooltip" data-placement="top" title="Editar Usuario"><i class="fas fa-edit"></i></a>
                                    <a href="" class="btn btn-danger ml-1" data-toggle="tooltip" data-placement="top" title="Borrar Usuario"><i class="fas fa-trash"></i></a>

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
                                    <a class="page-link"
                                       href=""
                                       aria-label="First">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">First</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link"
                                       href=""
                                       aria-label="Previous">
                                        <span aria-hidden="true">&lt;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="page-item active">
                                <a class="page-link"
                                   href=""><?php echo $page; ?></a>
                            </li>
                            <?php if ($page < $maxPages) { ?>
                                <li class="page-item">
                                    <a class="page-link" href="" aria-label="Next">
                                        <span aria-hidden="true">&gt;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link"
                                       href=""
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

