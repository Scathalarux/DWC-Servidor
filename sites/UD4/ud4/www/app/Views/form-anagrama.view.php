<div class="row">
    <?php if (isset($resultadoAnagrama)) {
        ?>
        <div class="col-12">
            <div class="alert alert-<?php echo($resultadoAnagrama ? 'success' : 'danger') ?>">
                <?php if ($resultadoAnagrama) { ?>
                    Las palabras '<?php echo $input['palabra1'] ?>' y '<?php echo $input['palabra2'] ?>' sí son un anagrama.
                <?php } else { ?>
                    Las palabras '<?php echo $input['palabra1'] ?>' y '<?php echo $input['palabra2'] ?>' no son un anagrama.
                <?php } ?>
            </div>
        </div>
    <?php }; ?>
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="">
                <input type="hidden" name="order" value="1"/>
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Comprobación de anagramas</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="palabra1">Palabra 1:</label>
                            <input type="text" class="form-control" name="palabra1" id="palabra1"
                                   value="<?php echo $input['palabra1'] ?>"/>
                            <p class="small text-danger">
                                <?php if (isset($errors['palabra1'])) {
                                    echo $errors['palabra1'];
                                } ?></p>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="palabra2">Palabra 2:</label>
                            <input type="text" class="form-control" name="palabra2" id="palabra2"
                                   value="<?php echo $input['palabra2'] ?>"/>
                            <p class="small text-danger">
                                <?php if (isset($errors['palabra2'])) {
                                    echo $errors['palabra2'];
                                } ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="/anagrama" class="btn btn-danger">Cancelar</a>
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

