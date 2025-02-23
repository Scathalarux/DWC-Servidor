<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="/usuarios-sistema">
                <input type="hidden" name="order" value="1"/>
                <!--<div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>-->
                <!-- Card Body -->
                <!--<div class="card-body">-->
                <!--<form action="./?sec=formulario" method="post">                   -->
                <!--<div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="alias">Alias:</label>
                            <input type="text" class="form-control" name="alias" id="alias" value="" />
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="nombre_completo">Nombre completo:</label>
                            <input type="text" class="form-control" name="nombre_completo" id="nombre_completo" value="" />
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="mb-3">
                            <label for="id_tipo">Tipo:</label>
                            <select name="id_tipo[]" id="id_tipo" class="form-control select2" data-placeholder="Tipo proveedor" multiple>
                                <option value="">-</option>
                                <option value="3" >Componentes móviles</option>
                                <option value="4" >Componentes PC</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="id_continente">Continente:</label>
                            <select name="id_continente" id="id_continente" class="form-control" data-placeholder="Continente">
                                <option value="">-</option>
                                <option value="1" >Europa</option>
                                <option value="2" >Asia</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="anho_fundacion">Año fundación:</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control" name="min_anho" id="min_anho" value="" placeholder="Mí­nimo" />
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="max_anho" id="max_anho" value="" placeholder="Máximo" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-12 text-right">
                    <a href="/proveedores" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                    <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                </div>
            </div>
        </form>
    </div>
</div>-->
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Usuarios</h6>
                        </div>
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-end">
                            <a href="<?php echo $_ENV['host.folder'].'usuarios-sistema/add'; ?>" class="m-0 font-weight-bold text-primary">Añadir Usuario <i class="fa fa-plus-circle"></i></a>
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
                                            <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema?' . 'order=' ?>1">Nombre
                                                completo</a> <i class="fas fa-sort-amount-down-alt"></i></th>
                                        <th>
                                            <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema?' . 'order=' ?>2">DNI</a>
                                        </th>
                                        <th>
                                            <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema?' . 'order=' ?>3">Email</a>
                                        </th>
                                        <th>
                                            <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema?' . 'order=' ?>4">Rol</a>
                                        </th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($usuarios as $usuario) { ?>
                                        <tr>
                                            <td><?php echo $usuario['nombre_completo'] ?></td>
                                            <td><?php echo $usuario['dni'] ?></td>
                                            <td><?php echo $usuario['email'] ?></td>
                                            <td><?php echo $usuario['nombre_rol'] ?></td>
                                            <td>
                                                <?php if (str_contains($_SESSION['permisos']['usuariosSistema'], 'w') !== false) { ?>
                                                    <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema/edit/' . $usuario['id_usuario'] ?>"
                                                       target="_blank" class="btn btn-success ml-1"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title="Editar"><i
                                                                class="fas fa-pen"></i></a>
                                                <?php } ?>
                                                <?php if ($_SESSION['id_usuario'] === $usuario['id_usuario']) { ?>
                                                    <a href=""
                                                       target="_blank" class="btn btn-info" data-toggle="tooltip"
                                                       data-placement="top" title="Activar/Desactivar">
                                                        <div>No se puede autodesactivar</div>
                                                        <i class="fas fa-exclamation"></i></a>
                                                <?php } else { ?>
                                                    <a href="<?php echo $_ENV['host.folder'] . 'usuarios-sistema/baja/' . $usuario['id_usuario'] ?>"
                                                       target="_blank" class="btn btn-info" data-toggle="tooltip"
                                                       data-placement="top" title="Activar/Desactivar"><i
                                                                class="fas fa-wrench"></i></a>
                                                <?php } ?>

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