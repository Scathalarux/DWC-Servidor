<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="/centros">
                <input type="hidden" name="order" value="1"/>
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
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
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 col-12 col-lg-10 font-weight-bold text-primary">Centros de Formación</h6>
                <a href="<?php echo $_ENV['host.folder'] . 'centros/new' ?>"
                   class="m-0 col-12 col-lg-2 font-weight-bold text-primary">Añadir Centro
                    <i class="fa fa-plus-circle"></i></a>
            </div>


            <!-- Card Body -->
            <?php if (!empty($centros)) { ?>
                <div class="card-body" id="card_table">
                    <div id="button_container" class="mb-3"></div>
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <table id="tabladatos" class="table table-striped">
                        <thead>
                        <tr>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'centros?order=' ?>1">Nombre del Centro</a>
                                <?php /*if (abs($order) === 1) { */ ?><!--
                                <i class="fas fa-sort-amount-<?php /*echo $order > 0 ? 'down' : 'up' */ ?>-alt"></i>
                            --><?php /*} */ ?>
                            </th>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'centros?order=' ?>2">Concello</a>
                                <?php /*if (abs($order) === 2) { */ ?><!--
                                <i class="fas fa-sort-amount-<?php /*echo $order > 0 ? 'down' : 'up' */ ?>-alt"></i>
                            --><?php /*} */ ?>
                            </th>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'centros?order=' ?>3">Código</a>
                                <?php /*if (abs($order) === 3) { */ ?><!--
                                <i class="fas fa-sort-amount-<?php /*echo $order > 0 ? 'down' : 'up' */ ?>-alt"></i>
                            --><?php /*} */ ?>
                            </th>
                            <th><a href="<?php echo $_ENV['host.folder'] . 'centros?order=' ?>4">Ciclos</a>
                                <?php /*if (abs($order) === 4) { */ ?><!--
                                <i class="fas fa-sort-amount-<?php /*echo $order > 0 ? 'down' : 'up' */ ?>-alt"></i>
                            --><?php /*} */ ?>
                            </th>
                            <th>Opcións</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($centros as $centro){ ?>
                            <tr>
                                <td><?php echo $centro['centro_educativo'] ?></td>
                                <td><?php echo $centro['concello'] ?></td>
                                <td><?php echo $centro['codigo'] ?></td>
                                <td><?php echo $centro['ciclos'] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">No hay datos que mostrar</h6>
                </div>
            <?php } ?>
        </div>
    </div>
</div>