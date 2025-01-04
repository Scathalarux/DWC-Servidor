<?php

declare(strict_types=1);

?>
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="">
                <input type="hidden" name="order" value="1"/>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" id="username" value="<?php echo $input['username'] ?? '' ?>"/>
                                <small class="text-danger"><?php echo $errors['username'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_country">País:</label>
                                <select name="id_country[]" id="id_country" class="form-control select2"
                                        data-placeholder="País" multiple>
                                    <option value="">-</option>
                                    <?php foreach ($countries as $country) { ?>
                                        <option value="<?php echo $country['id'] ?>" <?php echo isset($input['id_country']) && in_array($country['id'], $input['id_country']) ? 'selected' : '' ?>><?php echo $country['country_name'] ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger"><?php echo $errors['id_country'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_rol">Rol:</label>
                                <select name="id_rol" id="id_continente" class="form-control" data-placeholder="Rol">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) { ?>
                                        <option value="<?php echo $rol['id_rol'] ?>" <?php echo isset($input['id_rol']) && $rol['id_rol'] === $input['id_rol'] ? 'selected' : '' ?>><?php echo $rol['nombre_rol'] ?></option>
                                    <?php } ?>
                                </select>
                                <small class="text-danger"><?php echo $errors['id_rol'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5">
                            <div class="mb-3">
                                <label for="salarioBruto">Salario Bruto:</label>
                                <input type="number" class="form-control" name="salarioBruto" id="salarioBruto" value="<?php echo $input['salarioBruto'] ?? '' ?>" />
                                <small class="text-danger"><?php echo $errors['salarioBruto'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5">
                            <div class="mb-3">
                                <label for="retencion">Retención IRPF:</label>
                                <input type="number" class="form-control" name="retencion" id="retencion" value="<?php echo $input['retencion'] ?? '' ?>" />
                                <small class="text-danger"><?php echo $errors['retencion'] ?? '' ?></small>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <div class="mb-3 text-center">
                                <label for="activo">Usuario activo:</label>
                                <div class="row">
                                    <input type="checkbox" class="form-control" name="activo" id="activo" value="<?php echo $input['activo'] ?? '' ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="<?php echo $_ENV['host.folder']?>usuarios" value="" class="btn btn-danger">Cancelar</a>
                        <input type="submit" value="Aplicar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
