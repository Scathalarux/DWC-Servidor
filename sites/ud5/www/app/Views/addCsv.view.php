<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="/anadirMunicipio">
                <input type="hidden" name="order" value="1"/>
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Datos a introducir</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="nombre">Nombre Municipio:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" value="" />
                                <p class="text-danger"><?php echo isset($errores['nombre'])?></p>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="mb-3">
                                <label for="sexo">Sexo:</label><br/>
                                <select name="sexo">
                                    <?php foreach ($sexos as $sexo) {?>
                                        <option value="<?php echo $sexo ?>" <?php echo isset($_POST['sexo']) && $_POST['sexo'] === $sexo ? 'selected' : ''; ?>><?php echo $sexo?></option>
                                    <?php }?>
                                </select>
                                <p class="text-danger"><?php echo isset($errores['sexo'])?></p>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="mb-3">
                                <label for="periodo">Periodo:</label><br/>
                                <select name="periodo">
                                    <?php
                                    for ($i = date('Y'); $i > date('Y') - 100; $i--) {?>
                                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                    <?php } ?>
                                </select>
                                <p class="text-danger"><?php echo isset($errores['periodo'])?></p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="total">Total:</label>
                                <input type="number" class="form-control" name="total" id="total" value="" />
                                <p class="text-danger"><?php echo isset($errores['total'])?></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-12 text-right">
                            <a href="/anadirMunicipio" value="" name="reiniciar" class="btn btn-danger">Reiniciar</a>
                            <input type="submit" value="Añadir Municipio" name="enviar" class="btn btn-primary ml-2"/>
                        </div>
                    </div>
            </form>
        </div>
    </div>
