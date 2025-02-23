<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="">
                <input type="hidden" name="order" value="1"/>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Datos del Usuario</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="nombre_completo">Nombre completo:</label>
                                <input type="text" class="form-control" name="nombre_completo" id="nombre_completo"
                                       value="<?php echo $input['nombre_completo'] ?? '' ?>"/>
                            </div>
                            <small class="text-danger"><?php echo $errores['nombre_completo'] ?? '' ?></small>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       value="<?php echo $input['email'] ?? '' ?>"/>
                            </div>
                            <small class="text-danger"><?php echo $errores['email'] ?? '' ?></small>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="dni">DNI:</label>
                                <input type="text" class="form-control" name="dni" id="dni"
                                       value="<?php echo $input['dni'] ?? '' ?>"/>
                            </div>
                            <small class="text-danger"><?php echo $errores['dni'] ?? '' ?></small>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="password">Contraseña:</label>
                                <input type="password" class="form-control" name="password" id="password"
                                       value="<?php echo $input['password'] ?? '' ?>"/>
                            </div>
                            <small class="text-danger"><?php echo $errores['password'] ?? '' ?></small>
                        </div>
                        <?php if ($add) { ?>
                            <div class="col-12 col-lg-3">
                                <div class="mb-3">
                                    <label for="password2">Repita la contraseña:</label>
                                    <input type="password" class="form-control" name="password2" id="password2"
                                           value="<?php echo $input['password2'] ?? '' ?>"/>
                                </div>
                                <small class="text-danger"><?php echo $errores['password2'] ?? '' ?></small>
                            </div>
                        <?php } ?>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="id_rol">Rol:</label>
                                <select name="id_rol" id="id_rol" class="form-control" data-placeholder="Rol">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) { ?>
                                        <option value="<?php echo $rol['id_rol'] ?>" <?php echo (isset($input['id_rol']) && ($input['id_rol'] === $rol['id_rol'])) ? 'selected' : '' ?>><?php echo $rol['nombre_rol'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="idioma">Idioma:</label>
                                <select name="idioma" id="idioma" class="form-control" data-placeholder="Rol">
                                    <option value="">-</option>
                                    <?php foreach ($idiomas as $idioma) { ?>
                                        <option value="<?php echo $idioma ?>" <?php echo (isset($input['idioma']) && ($input['idioma'] === $idioma)) ? 'selected' : '' ?>><?php echo $idioma ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema' ?>" value=""
                           class="btn btn-danger">Cancelar</a>
                        <input type="submit" value="Aplicar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Fin HTML -->