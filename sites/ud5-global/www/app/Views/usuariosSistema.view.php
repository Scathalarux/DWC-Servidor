<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="/usuarios-sistema">
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
                                <label for="nombre_completo">Nombre:</label>
                                <input type="text" class="form-control" name="nombre_completo" id="nombre_completo"
                                       value="<?php echo $input['nombre_completo'] ?? '' ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_rol">Rol:</label>
                                <select name="id_rol" id="id_rol" class="form-control"
                                        data-placeholder="Rol">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) { ?>
                                        <option value="<?php echo $rol['id_rol'] ?>" <?php echo isset($input['id_rol']) && $rol['id_rol'] === $input['id_rol'] ? 'selected' : '' ?>><?php echo $rol['nombre_rol'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema' ?>" value=""
                           class="btn btn-danger">Reiniciar filtros</a>
                        <input type="submit" value="Aplicar filtros" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Usuarios</h6>
            </div>
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-end">
                <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema/add'; ?>"
                   class="m-0 font-weight-bold text-primary">Añadir Usuario <i
                            class="fa fa-plus-circle"></i></a>
            </div>
            <?php if (!empty($usuarios)){ ?>
                <!-- Card Body -->
                <div class="card-body" id="card_table">
                    <div id="button_container" class="mb-3"></div>
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <table id="tabladatos" class="table table-striped">
                        <thead>
                        <tr>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema?' . $copiaGet . 'order=' . (($order === 1) ? '-' : '') ?>1">Nombre
                                    completo</a>
                                <?php if (abs($order) === 1) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema?' . $copiaGet . 'order=' . (($order === 2) ? '-' : '') ?>2">DNI</a>
                                <?php if (abs($order) === 2) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema?' . $copiaGet . 'order=' . (($order === 3) ? '-' : '') ?>3">Email</a>
                                <?php if (abs($order) === 3) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema?' . $copiaGet . 'order=' . (($order === 4) ? '-' : '') ?>4">Rol</a>
                                <?php if (abs($order) === 4) { ?>
                                    <i class="fas fa-sort-amount-<?php echo $order > 0 ? 'down' : 'up' ?>-alt"></i>
                                <?php } ?>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($usuarios

                                       as $usuario) { ?>
                            <tr class="<?php echo $usuario['baja'] ? 'bg-danger' : '' ?>">
                                <td><?php echo $usuario['nombre_completo'] ?></td>
                                <td><?php echo $usuario['dni'] ?></td>
                                <td><?php echo $usuario['email'] ?></td>
                                <td><?php echo $usuario['nombre_rol'] ?></td>
                                <td>
                                    <!--Editar usuario -->
                                    <?php if (str_contains($_SESSION['permisos']['usuariosSistema'], 'w') !== false) { ?>
                                        <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema/edit/' . $usuario['id_usuario'] ?>"
                                           class="btn btn-success ml-1"
                                           data-toggle="tooltip"
                                           data-placement="top" title="Editar"><i
                                                    class="fas fa-pen"></i></a>
                                        <?php
                                    } ?>
                                    <!--Borrar usuario -->
                                    <?php if (str_contains($_SESSION['permisos']['usuariosSistema'], 'd') !== false) { ?>
                                        <?php if ($_SESSION['id_usuario'] !== $usuario['id_usuario']) { ?>
                                            <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema/delete/' . $usuario['id_usuario'] ?>"
                                               class="btn btn-danger ml-1"
                                               data-toggle="tooltip"
                                               data-placement="top" title="Borrar"><i
                                                        class="fas fa-trash"></i></a>
                                        <?php } else { ?>
                                            <div class="btn btn-danger ml-1" data-toggle="tooltip" data-placement="top"
                                                 title="No se puede borrar a sí mismo"><i
                                                        class="fas fa-ban"></i></div>
                                        <?php }
                                    } ?>
                                    <!--activar/Desactivar usuario -->
                                    <?php if ($_SESSION['id_usuario'] === $usuario['id_usuario']) { ?>
                                        <div class="btn btn-info ml-1" data-toggle="tooltip" data-placement="top"
                                             title="No se puede desactivar a sí mismo"><i
                                                    class="fas fa-ban"></i></div>
                                    <?php } else { ?>
                                        <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema/baja/' . $usuario['id_usuario'] ?>"
                                           class="btn btn-info ml-1" data-toggle="tooltip"
                                           data-placement="top"
                                           title="<?php echo $usuario['baja'] ? 'Activar' : 'Desactivar' ?>"><i
                                                    class="fas fa-wrench"></i></a>
                                    <?php } ?>
                                    <!--Ver detalles usuario-->
                                    <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema/view/' . $usuario['id_usuario'] ?>"
                                       class="btn btn-warning ml-1"
                                       data-toggle="tooltip"
                                       data-placement="top" title="Ver detalles"><i
                                                class="fas fa-eye"></i></a>

                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!--<div class="card-footer">
                                <nav aria-label="Navegacion por paginas">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php /*echo $_ENV['host.folder'] . 'usuarios-sistema?' . 'page=1' */ ?>"
                                               aria-label="First">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">First</span>
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php /*echo $_ENV['host.folder'] . 'usuarios-sistema?' . 'page=' . ($page - 1) */ ?>"
                                               aria-label="Previous">
                                                <span aria-hidden="true">&lt;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>

                                        <li class="page-item active"><a class="page-link"
                                                                        href="<?php /*echo $_ENV['host.folder'] . 'usuarios-sistema?' . 'page=' . $page */ ?>">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php /*echo $_ENV['host.folder'] . 'usuarios-sistema?' . 'page=' . ($page + 1) */ ?>"
                                               aria-label="Next">
                                                <span aria-hidden="true">&gt;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php /*echo $_ENV['host.folder'] . 'usuarios-sistema?' . 'page=' . $maxPage */ ?>"
                                               aria-label="Last">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Last</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>-->
            <?php }else{ ?>
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">No hay datos que mostrar</h6>
                <?php } ?>
            </div>
        </div>
    </div>
    <!--Fin HTML -->