<?php

declare(strict_types=1);

?>
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="<?php echo $_ENV['host.folder']; ?>users-filter/new">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo ?></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="username">Nombre usuario <span class="text-danger">*</span> :</label>
                                <input type="text" class="form-control" name="username" id="username"
                                       value="<?php echo $input['username'] ?? ''; ?>"
                                       minlength="3"
                                       maxlength="50"
                                       placeholder="my_username"
                                       required/>
                                <p class="text-danger"><?php echo $errores['username'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="id_rol">Tipo usuario <span class="text-danger">*</span> :</label>
                                <select name="id_rol" id="id_rol" class="form-control" required>
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) { ?>
                                        <option value="<?php echo $rol['id_rol']; ?>"
                                            <?php echo isset($input['id_rol']) && $rol['id_rol'] == $input['id_rol'] ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($rol['nombre_rol']) ?></option>
                                    <?php } ?>
                                </select>
                                <p class="text-danger"><?php echo $errores['id_rol'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label for="salarioBruto">Salario Bruto:</label>
                                        <input type="text" class="form-control" name="salarioBruto"
                                               id="salarioBruto"
                                               value="<?php echo $input['salarioBruto'] ?? ''; ?>" maxlength="" placeholder="" />
                                <p class="text-danger"><?php echo $errores['salarioBruto'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label for="cotizacion">Retención IRPF:</label>
                                        <input type="text" class="form-control" name="cotizacion"
                                               id="cotizacion"
                                               value="<?php echo $input['cotizacion'] ?? ''; ?>"
                                               maxlength=""
                                               placeholder="30"
                                        />
                                <p class="text-danger"><?php echo $errores['cotizacion'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label for="id_country">País <span class="text-danger">*</span> :</label>
                                <select name="id_country[]" id="id_country" class="form-control select2"
                                        data-placeholder="Países" required>
                                    <?php foreach ($countries as $country) { ?>
                                        <option value="<?php echo $country['id']; ?>" <?php echo (isset($input['id_country']) && $country['id'] == $input['id_country']) ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($country['country_name']) ?></option>
                                    <?php } ?>
                                </select>
                                <p class="text-danger"><?php echo $errores['id_country'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="activo" id="activo"
                                <?php echo !empty($input['activo']) ? 'checked' : '';?>/>
                                <label for="activo">Usuario Activo</label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12 text-right">
                                <a href="<?php echo $_ENV['host.folder']; ?>users-filter/new" value="" name="reiniciar"
                                   class="btn btn-danger">Cancelar</a>
                                <input type="submit" value="Añadir Usuario" class="btn btn-primary ml-2"/>
                                <!--Si no le introducimos el nombre al botón, no aparecerá su value en la URL-->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>