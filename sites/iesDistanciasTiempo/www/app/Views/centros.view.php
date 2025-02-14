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
                                <label for="centro_educativo">Nombre del Centro:</label>
                                <input type="text" class="form-control" name="centro_educativo" id="centro_educativo"
                                       value="<?php echo $input['centro_educativo'] ?? '' ?>"/>
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
                    <table id="tabladatos" class="table">
                        <thead>
                        <tr>
                            <th>Tiempo</th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'centros?' . $copiaGetOrder . 'order=' . (($order > 0) ? '-' : '') ?>1">Nombre
                                    del Centro</a>
                                <?php if (abs($order) === 1) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'centros?' . $copiaGetOrder . 'order=' . (($order > 0) ? '-' : '') ?>2">Concello</a>
                                <?php if (abs($order) === 2) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'centros?' . $copiaGetOrder . 'order=' . (($order > 0) ? '-' : '') ?>3">Código</a>
                                <?php if (abs($order) === 3) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th>Ciclos</a></th>
                            <th>Opcións</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($centros as $centro) { ?>
                            <tr>
                                <td>
                                    <?php if(isset($centro['weather'])){ ?>
                                    <img src="<?php echo $centro['weather']['img'] ?>" alt="Indicador del tiempo">
                                    <span><?php echo $centro['weather']['temperatura'] ?></span>
                                    <?php }else{ ?>
                                        <i class="fa fa-exclamation-circle"></i>
                                    <?php } ?>
                                </td>
                                <td><?php echo $centro['centro_educativo'] ?></td>
                                <td><?php echo $centro['concello'] ?></td>
                                <td><?php echo $centro['codigo'] ?></td>
                                <td><?php foreach ($centro['ciclos'] as $ciclo) { ?>
                                        <span><?php echo $ciclo ?></span><br/>
                                    <?php } ?></td>
                                <td>
                                    <a href="<?php echo $_ENV['host.folder'] . 'centros/edit/' . $centro['codigo'] ?>"
                                       class="btn btn-success ml-1 mt-1" data-toggle="tooltip" data-placement="top"
                                       title="Editar"><i class="fas fa-pen"></i></a>
                                    <a href="<?php echo $_ENV['host.folder'] . 'centros/view' . $centro['codigo'] ?>"
                                       class="btn btn-info ml-1 mt-1" data-toggle="tooltip" data-placement="top"
                                       title="Ver más"><i class="fas fa-eye"></i></a>
                                    <a href="<?php echo $_ENV['host.folder'] . 'centros/delete/' . $centro['codigo'] ?>"
                                       class="btn btn-danger ml-1 mt-1" data-toggle="tooltip" data-placement="top"
                                       title="Borrar"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <nav aria-label="Navegacion por paginas">
                        <ul class="pagination justify-content-center">
                            <?php if ($page !== 1) { ?>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="<?php echo $_ENV['host.folder'] . 'centros?' . $copiaGetPage . 'page=1' ?>"
                                       aria-label="First">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">First</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="<?php echo $_ENV['host.folder'] . 'centros?' . $copiaGetPage . 'page=' . ($page - 1) ?>"
                                       aria-label="Previous">
                                        <span aria-hidden="true">&lt;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="page-item active"><a class="page-link"
                                                            href="<?php echo $_ENV['host.folder'] . 'centros?' . $copiaGetPage . 'page=' . $page ?>"><?php echo $page ?></a>
                            </li>

                            <?php if ($page !== $maxPage) { ?>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="<?php echo $_ENV['host.folder'] . 'centros?' . $copiaGetPage . 'page=' . ($page + 1) ?>"
                                       aria-label="Next">
                                        <span aria-hidden="true">&gt;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="<?php echo $_ENV['host.folder'] . 'centros?' . $copiaGetPage . 'page=' . $maxPage ?>"
                                       aria-label="Last">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Last</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            <?php } else { ?>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">No hay datos que mostrar</h6>
                </div>
            <?php } ?>
        </div>
    </div>
</div>