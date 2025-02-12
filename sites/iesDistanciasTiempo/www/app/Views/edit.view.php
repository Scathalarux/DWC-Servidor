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
                                <label for="centro">Nombre del Centro:</label>
                                <input type="text" class="form-control" name="centro" id="centro"
                                       value="<?php echo $input['centro'] ?? '' ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="concello">Concello:</label>
                                <input type="text" class="form-control" name="concello" id="concello"
                                       value="<?php echo $input['concello'] ?? '' ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="ciclos">Ciclos:</label>
                                <select name="ciclos[]" id="ciclos" class="form-control select2"
                                        data-placeholder="Ciclos" multiple>
                                    <option value="">-</option>
                                    <?php foreach ($ciclos as $ciclo) { ?>
                                        <option value="<?php echo $ciclo['codigo'] ?>" <?php echo (isset($input['ciclos']) && in_array($ciclo['codigo'], $input['ciclos'])) ? 'selected' : '' ?> ><?php echo $ciclo['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="/centros" value="" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>