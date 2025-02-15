<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="">
                <input type="hidden" name="order" value="1"/>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo ?></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="centro_educativo">Nombre del Centro:</label>
                                <input type="text" class="form-control" name="centro_educativo" id="centro_educativo"
                                       placeholder="IES Ejemplo"
                                       value="<?php echo $input['centro_educativo'] ?? '' ?>"<?php echo $disabled ? 'disabled' : '' ?>/>
                            </div>
                            <small class="text-danger"><?php echo $errores['centro_educativo'] ?? '' ?></small>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="concello">Concello:</label>
                                <input type="text" class="form-control" name="concello" id="concello" placeholder="Vigo"
                                       value="<?php echo $input['concello'] ?? '' ?>" <?php echo $disabled ? 'disabled' : '' ?>/>
                            </div>
                            <small class="text-danger"><?php echo $errores['concello'] ?? '' ?></small>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="codigo">Código: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="codigo" id="codigo" placeholder="12345678"
                                       value="<?php echo $input['codigo'] ?? '' ?>" <?php echo $disabled ? 'disabled' : '' ?>/>
                            </div>
                            <small class="text-danger"><?php echo $errores['codigo'] ?? '' ?></small>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" name="telefono" id="telefono"
                                       placeholder="986986986"
                                       value="<?php echo $input['telefono'] ?? '' ?>" <?php echo $disabled ? 'disabled' : '' ?>/>
                            </div>
                            <small class="text-danger"><?php echo $errores['telefono'] ?? '' ?></small>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="provincia">Provincia:</label>
                                <input type="text" class="form-control" name="provincia" id="provincia"
                                       placeholder="Pontevedra"
                                       value="<?php echo $input['provincia'] ?? '' ?>" <?php echo $disabled ? 'disabled' : '' ?>/>
                            </div>
                            <small class="text-danger"><?php echo $errores['provincia'] ?? '' ?></small>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="latitud">Latitud:</label>
                                <input type="text" class="form-control" name="latitud" id="latitud"
                                       placeholder="42.123456"
                                       value="<?php echo $input['latitud'] ?? '' ?>" <?php echo $disabled ? 'disabled' : '' ?>/>
                            </div>
                            <small class="text-danger"><?php echo $errores['latitud'] ?? '' ?></small>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="longitud">Longitud:</label>
                                <input type="text" class="form-control" name="longitud" id="longitud"
                                       placeholder="-8.123456"
                                       value="<?php echo $input['longitud'] ?? '' ?>" <?php echo $disabled ? 'disabled' : '' ?>/>
                            </div>
                            <small class="text-danger"><?php echo $errores['longitud'] ?? '' ?></small>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="link_fp">Link informática:</label>
                                <input type="text" class="form-control" name="link_fp" id="link_fp"
                                       placeholder="http://www.edu.xunta.gal/fp/centroEjemplo"
                                       value="<?php echo $input['link_fp'] ?? '' ?>" <?php echo $disabled ? 'disabled' : '' ?>/>
                            </div>
                            <small class="text-danger"><?php echo $errores['link_fp'] ?? '' ?></small>
                        </div>
                        <?php if($disabled){ ?>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="ciclos">Ciclos:</label>
                                <select name="ciclos[]" id="ciclos" class="form-control select2"
                                        data-placeholder="Ciclos" multiple <?php echo $disabled ? 'disabled' : '' ?>>
                                    <option value="">-</option>
                                    <?php foreach ($ciclos as $ciclo) { ?>
                                        <option value="<?php echo $ciclo['codigo'] ?>" <?php echo (isset($input['ciclos']) && in_array($ciclo['codigo'], $input['ciclos'])) ? 'selected' : '' ?> ><?php echo $ciclo['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="familia_informatica">Familia informática:</label>
                                <input type="checkbox" class="form-control" name="familia_informatica"
                                       id="familia_informatica" <?php echo isset($input['familia_informatica']) ? 'checked' : '' ?> <?php echo $disabled ? 'disabled' : '' ?>/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="/centros" class="btn btn-danger">Volver</a>
                        <?php if ($disabled === false) { ?>
                            <input type="submit" value="Aplicar" class="btn btn-primary ml-2"/>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>