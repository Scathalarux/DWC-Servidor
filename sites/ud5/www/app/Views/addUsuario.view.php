<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="<?php echo $_ENV['host.folder']; ?>users-filter?">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Alta usuario</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="usernameNew">Nombre usuario:</label>
                                <input type="text" class="form-control" name="usernameNew" id="usernameNew"
                                       value="<?php echo $input['usernameNew'] ?? ''; ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="id_rolNew">Tipo usuario:</label>
                                <select name="id_rolNew" class="form-control">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) { ?>
                                        <option value="<?php echo $rol['id_rol']; ?>"
                                            <?php echo isset($input['id_rolNew']) && $rol['id_rol'] === $input['id_rolNew'] ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($rol['nombre_rol']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label for="salarioBrutoNew">Salario Bruto:</label>
                                        <input type="text" class="form-control" name="salarioBrutoNew"
                                               id="salarioBrutoNew"
                                               value="<?php echo $input['salarioBrutoNew'] ?? ''; ?>"
                                        />
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label for="cotizacionNew">Cotización:</label>
                                        <input type="text" class="form-control" name="cotizacionNew"
                                               id="cotizacionNew"
                                               value="<?php echo $input['cotizacionNew'] ?? ''; ?>"
                                        />
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label for="id_countryNew">País:</label>
                                <select name="id_country[]" id="id_countryNew" class="form-control select2"
                                        data-placeholder="Países">
                                    <?php foreach ($countries as $country) { ?>
                                        <option value="<?php echo $country['id']; ?>" <?php echo (isset($input['id_countryNew']) && in_array($country['id'], $input['id_countryNew'])) ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($country['country_name']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-group">
                                <label for="activoNew">Activo:</label>
                                <input type="checkbox" class="form-control" name="activoNew"
                                       id="activoNew"
                                       <?php  ?>
                                />
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12 text-right">
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