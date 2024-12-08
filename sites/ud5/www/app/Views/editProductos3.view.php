<?php

declare(strict_types=1);

?>
<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo?></h6>
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
                                <small class="text-danger"><?php echo $errores['codigo'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="nombre">Nombre producto:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre"
                                       value="<?php echo $input['nombre'] ?? '' ?>"/>
                                <small class="text-danger"><?php echo $errores['nombre'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="descripcion">Descripción producto:</label>
                                <input type="text" class="form-control" name="descripcion" id="descripcion"
                                       value="<?php echo $input['descripcion'] ?? '' ?>"/>
                                <small class="text-danger"><?php echo $errores['descripcion'] ?? '' ?></small>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_categoria">Categoria:</label>
                                <select name="id_categoria" id="id_categoria" class="form-control"
                                        data-placeholder="Categoria">
                                    <option value="">-</option>
                                    <?php foreach ($categorias as $categoria) { ?>
                                        <option value="<?php echo $categoria['id_categoria'] ?>"
                                            <?php echo (isset($input['id_categoria']) && ($categoria['id_categoria'] == $input['id_categoria'])) ? 'selected' : ''; ?>>
                                            <?php echo $categoria['nombre_categoria'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger"><?php echo $errores['id_categoria'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="proveedor">Proveedor:</label>
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
                                <small class="text-danger"><?php echo $errores['proveedor'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="coste">Coste:</label>
                                <input type="text" class="form-control" name="coste" id="coste" value="<?php echo $input['coste'] ?? '' ?>">
                                <small class="text-danger"><?php echo $errores['coste'] ?? '' ?></small>
                            </div>

                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="margen">Margen:</label>
                                <input type="text" class="form-control" name="margen" id="margen" value="<?php echo $input['margen'] ?? '' ?>">
                                <small class="text-danger"><?php echo $errores['margen'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="stock">Stock:</label>
                                <input type="text" class="form-control" name="stock" id="stock" value="<?php echo $input['stock'] ?? '' ?>">
                                <small class="text-danger"><?php echo $errores['stock'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="iva">IVA:</label>
                                <input type="text" class="form-control" name="iva" id="iva" value="<?php echo $input['iva'] ?? '' ?>">
                                <small class="text-danger"><?php echo $errores['iva'] ?? '' ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="<?php echo $_ENV['host.folder'] . 'productos3' ?>" value="" name="reiniciar"
                           class="btn btn-danger">Cancelar</a>
                        <input type="submit" value="Ejecutar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
