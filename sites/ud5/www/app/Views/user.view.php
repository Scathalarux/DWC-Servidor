<!--Inicio HTML -->
<?php if (isset($exito)) { ?>
<div class="row">
    <div class="col-12">
        <?php if ($exito) { ?>
        <div class="alert alert-success">
            <p>Se ha añadido el usuario correctamente!</p>
        </div>
        <?php } else { ?>
        <div class="alert alert-danger">
            <p>No se ha podido añadir el usuario</p>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="/usuarios/new">
                <input type="hidden" name="order" value="1"/>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Datos a introducir</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombre">Nombre usuario:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre"
                                       value="<?php echo $input['nombre']  ?>"/>
                                <p class="text-danger"><?php echo $errores['nombre'] ?? '' ?></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="email">Email usuario:</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       value="<?php echo $input['email']  ?>"/>
                                <p class="text-danger"><?php echo $errores['email'] ?? '' ?></p>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="tipo_suscripcion">Suscripción:</label>
                                <select name="tipo_suscripcion" class="form-control form-select">
                                    <?php foreach ($tipo_suscripcion as $suscripcion) { ?>
                                        <option value="<?php echo $suscripcion ?>" <?php echo (isset($_POST['tipo_suscripcion']) && $_POST['tipo_suscripcion'] === $suscripcion) ? 'selected' : ''; ?>><?php echo $suscripcion ?></option>
                                    <?php } ?>
                                </select>
                                <p class="text-danger"><?php echo $errores['tipo_suscripcion'] ?? '' ?></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="numTarjeta">Número tarjeta:</label>
                                <input type="number" class="form-control" name="numTarjeta" id="numTarjeta"
                                       value="<?php echo $input['numTarjeta']  ?>" <?php echo (isset($_POST['suscripcion']) && $_POST['suscripcion'] === ('gold' || 'silver')) ? 'required' : '' ?>/>
                                <p class="text-danger"><?php echo $errores['numTarjeta'] ?? '' ?></p>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="terminos">Aceptar los términos</label>
                                <input type="checkbox" class="form-control" name="terminos" id="terminos"
                                       value="" <?php echo isset($_POST['terminos']) ? 'required' : '' ?>/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-12 text-right">
                            <a href="/usuarios/new" value="" name="reiniciar" class="btn btn-danger">Reiniciar</a>
                            <input type="submit" value="Añadir usuario" name="enviar" class="btn btn-primary ml-2"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>