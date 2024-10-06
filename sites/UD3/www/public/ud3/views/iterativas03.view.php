<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Iterativas 03</h1>

</div>

<!-- Content Row -->

<!--En caso de que no haya errores-->
<?php if (isset($data['array_ordenado'])) { ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                <p> Matriz ordenada: <?php echo $data['array_ordenado']; ?></p>

            </div>
        </div>
    </div>
    <?php
}
?>
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Ordenación de matrices</h6>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3 col-12">
                        <label for="textarea">Inserte los valores de la matriz bidimensional en formato: 1,2,3|4,5,6|7,8,9 </label>
                        <textarea class="form-control" id="numeros" name="numeros"
                                  rows="3"><?php echo $data['input_numeros'] ?? ''; ?></textarea>
                        <p class="text-danger small"><?php echo $data['errors']['numeros'] ?? ''; ?></p>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
