<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="/usuarios">
                <input type="hidden" name="order" value="1"/>
                <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" id="username"
                                       value="<?php echo $input['username'] ?? '' ?>"/>
                            </div>
                        </div>

                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label for="id_country">País:</label>
                                <select name="id_country[]" id="id_country" class="form-control select2"
                                        data-placeholder="País" multiple>
                                    <?php foreach ($countries as $country) { ?>
                                        <option value="<?php echo $country['id']?>" <?php echo isset($input['id_country']) && in_array($country['id'],$input['id_country']) ? 'selected' : '' ?>><?php echo $country['country_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_rol">Rol:</label>
                                <select name="id_rol" id="id_rol" class="form-control" data-placeholder="Rol">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) { ?>
                                        <option value="<?php echo $rol['id_rol']?>" <?php echo isset($input['id_rol']) && $input['id_rol'] === $rol['id_rol'] ? 'selected' : '' ?>><?php echo $rol['nombre_rol'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="salarioBruto">Salario Bruto:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_salario" id="min_salario"
                                               value="<?php echo $input['min_salario'] ?? '' ?>" placeholder="Mí­nimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_salario" id="max_salario"
                                               value="<?php echo $input['max_salario'] ?? '' ?>" placeholder="Máximo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="retencion">Retención IRPF:</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="min_retencion" id="min_retencion"
                                               value="<?php echo $input['min_retencion'] ?? '' ?>"
                                               placeholder="Mí­nimo"/>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="max_retencion" id="max_retencion"
                                               value="<?php echo $input['max_retencion'] ?? '' ?>"
                                               placeholder="Máximo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="/usuarios" value="" class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Usuarios</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped">
                    <thead>
                    <tr>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuarios?'. $copiaGet .'page='.$page .'&order=' . (($order > 0)? '-':'') ?>1">Username</a>
                            <?php if(abs($order) === 1){ ?>
                            <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuarios?'. $copiaGet .'page='.$page .'&order=' . (($order > 0)? '-':'')?>2">Salario Bruto</a>
                            <?php if(abs($order) === 2){ ?>
                                <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuarios?'. $copiaGet .'page='.$page .'&order=' . (($order > 0)? '-':'')?>3">Retención IRPF</a>
                            <?php if(abs($order) === 3){ ?>
                                <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuarios?'. $copiaGet .'page='.$page .'&order='. (($order > 0)? '-':'') ?>4">Rol</a>
                            <?php if(abs($order) === 4){ ?>
                                <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuarios?'. $copiaGet .'page='.$page .'&order='. (($order > 0)? '-':'') ?>5">País</a>
                            <?php if(abs($order) === 5){ ?>
                                <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                        <th>Activo</th>
                        <th></th>
                    </tr>
                    </thead>
                    <?php if (!empty($usuarios)) { ?>
                        <tbody>
                        <?php foreach ($usuarios as $usuario) { ?>
                            <tr <?php echo $usuario['activo'] == false ? 'class=bg-danger' : '' ?>>
                                <td><?php echo $usuario['username'] ?></td>
                                <td><?php echo $usuario['salarioBruto'] ?></td>
                                <td><?php echo $usuario['retencionIRPF'] ?></td>
                                <td><?php echo $usuario['nombre_rol'] ?></td>
                                <td><?php echo $usuario['country_name'] ?></td>
                                <td><?php echo $usuario['activo'] ? 'Sí' : 'No' ?></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    <?php } else { ?>
                    <?php } ?>
                </table>
            </div>
            <div class="card-footer">
                <nav aria-label="Navegacion por paginas">
                    <ul class="pagination justify-content-center">
                        <?php if($page !== 1){ ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $_ENV['host.folder'].'usuarios?'.$copiaGetOrder.'page=' ?>1" aria-label="First">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">First</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $_ENV['host.folder'].'usuarios?'.$copiaGetOrder.'page='.($page-1)?>" aria-label="Previous">
                                <span aria-hidden="true">&lt;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <?php } ?>
                        <li class="page-item active"><a class="page-link" href="<?php echo $_ENV['host.folder'].'usuarios?'.$copiaGetOrder.'page='.$page?>"><?php echo $page ?></a></li>
                        <?php if($page !== $maxPage){ ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $_ENV['host.folder'].'usuarios?'.$copiaGetOrder.'page=' .($page+1)?>" aria-label="Next">
                                <span aria-hidden="true">&gt;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo $_ENV['host.folder'].'usuarios?'.$copiaGetOrder.'page='.$maxPage ?>" aria-label="Last">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Last</span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--Fin HTML -->
