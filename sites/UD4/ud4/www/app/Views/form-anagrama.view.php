<div class="row">
    <?php if(isset($nombreAnterior)){
        ?>
        <div class="col-12">
            <div class="alert alert-success">
                ¡Hola <?php echo $nombreAnterior?>!
            </div>
        </div>
    <?php };?>
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
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="palabra1">Palabra 1:</label>
                                <input type="text" class="form-control" name="palabra1" id="palabra1" value="" />
                                <label for="palabra2">Palabra 2:</label>
                                <input type="text" class="form-control" name="palabra2" id="palabra2" value="" />
                                <p class="small text-danger"><?php echo $errors['palabra']??'';?></p>
                            </div>
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

