<?php

declare(strict_types=1);

?>
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo ?></h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="id_rol">Tipo usuario <span class="text-danger">*</span>:</label>
                                <select name="id_rol" id="id_rol" class="form-control" >
                                    <option value="">-</option>
                                    <?php if (!isset($_SESSION['username']) || $_SESSION['id_rol'] !== $admin['id_rol']) {?>
                                        <option value="<?php echo $staff['id_rol'] ?>"><?php echo $staff['rol'] ?></option>
                                    <?php } else { ?>
                                        <?php foreach ($roles as $rol) { ?>
                                        <option value="<?php echo $rol['id_rol']; ?>"
                                            <?php echo isset($input['id_rol']) && $rol['id_rol'] == $input['id_rol'] ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($rol['rol']) ?></option>
                                        <?php }
                                    } ?>
                                </select>
                                <p class="text-danger"><?php echo $errores['id_rol'] ?? '';?></p>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre usuario <span class="text-danger">*</span>:</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre"
                                           value="<?php echo $input['nombre'] ?? ''; ?>"
                                           minlength="3"
                                           maxlength="50"
                                           placeholder="my_username"
                                           />
                                    <p class="text-danger"><?php echo $errores['nombre'] ?? '';?></p>
                                </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control" name="email"
                                       id="email"
                                       value="<?php echo $input['email'] ?? ''; ?>" maxlength="" placeholder="user@email.com"/>
                                <p class="text-danger"><?php echo $errores['email'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="password">Contraseña <span class="text-danger">*</span>:</label>
                                <input type="password" class="form-control" name="password"
                                       id="password"
                                       value="<?php echo $input['password'] ?? ''; ?>" maxlength="" placeholder=""/>
                                <p class="text-danger"><?php echo $errores['password'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="password2">Repite la contraseña <span class="text-danger">*</span>:</label>
                                <input type="password" class="form-control" name="password2"
                                       id="password2"
                                       value="<?php echo $input['password2'] ?? ''; ?>" maxlength="" placeholder=""/>
                                <p class="text-danger"><?php echo $errores['password2'] ?? '';?></p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="idioma">Idioma <span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control" name="idioma"
                                       id="cotizacion"
                                       value="<?php echo $input['idioma'] ?? ''; ?>"
                                       maxlength="2"
                                       placeholder="Idioma..."
                                />
                                <p class="text-danger"><?php echo $errores['idioma'] ?? '';?></p>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="baja" id="baja"
                                    <?php echo isset($input['baja']) && $input['baja'] ? 'checked' : '';?>/>
                                <label for="baja">Usuario Activo <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12 text-right">
                                <a href="<?php echo $_ENV['host.folder']; ?>usuariosSistema" value=""
                                   class="btn btn-danger">Cancelar</a>
                                <input type="submit" value="Guardar cambios" class="btn btn-primary ml-2"/>
                                <!--Si no le introducimos el nombre al botón, no aparecerá su value en la URL-->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

