<?php

declare(strict_types=1);

?>
<!--Filtros-->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="">
                <!--<input type="hidden" name="order" value="<?php /*echo $order*/?>"/>-->
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
                                <p class="text-danger"><?php echo $errores['codigo'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="nombre">Nombre producto:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre"
                                       value="<?php echo $input['nombre'] ?? ''; ?>"/>
                                <p class="text-danger"><?php echo $errores['nombre'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="descripcion">Descripción producto:</label>
                                <input type="text" class="form-control" name="descripcion" id="descripcion"
                                       value="<?php echo $input['descripcion'] ?? ''; ?>"/>
                                <p class="text-danger"><?php echo $errores['descripcion'] ?? '';?></p>
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
                                <p class="text-danger"><?php echo $errores['proveedor'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="id_categoria">Categoria producto:</label>
                                <select name="id_categoria[]" class="form-control select2" multiple>
                                    <?php foreach ($categorias as $categoria) { ?>
                                        <option value="<?php echo $categoria['id_categoria']; ?>"
                                            <?php echo isset($input['id_categoria']) && in_array($categoria['id_categoria'], $input['id_categoria']) ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($categoria['nombre_categoria']) ?></option>
                                    <?php } ?>
                                </select>
                                <p class="text-danger"><?php echo $errores['id_categoria'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="stock">Stock producto:</label>
                                <input type="text" class="form-control" name="stock" id="stock"
                                 value="<?php echo $input['stock'] ?? ''; ?>"/>
                                <p class="text-danger"><?php echo $errores['stock'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="coste">Coste producto:</label>
                                <input type="text" class="form-control" name="coste" id="coste"
                                       value="<?php echo $input['coste'] ?? ''; ?>"/>
                                <p class="text-danger"><?php echo $errores['coste'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="margen">Margen producto:</label>
                                <input type="text" class="form-control" name="margen" id="margen"
                                       value="<?php echo $input['margen'] ?? ''; ?>"/>
                                <p class="text-danger"><?php echo $errores['margen'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="iva">IVA producto:</label>
                                <input type="text" class="form-control" name="iva" id="iva"
                                       value="<?php echo $input['iva'] ?? ''; ?>"/>
                                <p class="text-danger"><?php echo $errores['iva'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12 text-right">
                                <a href="<?php echo $_ENV['host.folder']; ?>productos2" value="" name="reiniciar"
                                   class="btn btn-danger">Cancelar</a>
                                <input type="submit" value="Ejecutar" class="btn btn-primary ml-2"/>
                                <!--Si no le introducimos el nombre al botón, no aparecerá su value en la URL-->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>