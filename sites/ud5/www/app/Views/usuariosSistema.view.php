<?php

declare(strict_types=1);

?>
<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Usuarios Sistema</h6>
            </div>
            <div class="col-12">
                <div class="m-0 font-weight-bold justify-content-end">
                    <a href="<?php echo $_ENV['host.folder'] . 'usuariosSistema/new'?>"
                       class="btn btn-primary ml-1 float-right"> Nuevo
                        Usuario <i class="fas fa-plus-circle"></i></a>
                </div>
            </div>
            <!-- Card Body -->
            <?php if (!empty($usuarios)) { ?>
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped table-responsive">
                    <thead>
                    <tr>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuariosSistema?order=' . (($order == 1) ? '-' : '') ?>1">ID </a>
                            <?php if (abs($order) == 1) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuariosSistema?order=' . (($order == 2) ? '-' : '') ?>2">Rol</a>
                            <?php if (abs($order) == 2) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuariosSistema?order=' . (($order == 3) ? '-' : '') ?>3">Email</a>
                            <?php if (abs($order) == 3) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuariosSistema?order=' . (($order == 4) ? '-' : '') ?>4">Pass</a>
                            <?php if (abs($order) == 4) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuariosSistema?order=' . (($order == 5) ? '-' : '') ?>5">Nombre</a>
                            <?php if (abs($order) == 5) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuariosSistema?order=' . (($order == 6) ? '-' : '') ?>6">Última Conexión</a>
                            <?php if (abs($order) == 6) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuariosSistema?order=' . (($order == 7) ? '-' : '') ?>7">Idioma</a>
                            <?php if (abs($order) == 7) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                        <th><a href="<?php echo $_ENV['host.folder'] . 'usuariosSistema?order=' . (($order == 8) ? '-' : '') ?>8">Baja</a>
                            <?php if (abs($order) == 8) { ?>
                                <i class="fas fa-sort-amount-<?php echo ($order > 0) ? 'down' : 'up' ?>-alt"></i>
                            <?php } ?>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($usuarios as $usuario) { ?>
                        <tr>
                            <td><?php echo $usuario['id_usuario'] ?></td>
                            <td><?php echo $usuario['rol'] ?? '-' ?></td>
                            <td><?php echo $usuario['email'] ?? '-' ?></td>
                            <td><?php echo $usuario['pass'] ?? '-' ?></td>
                            <td><?php echo $usuario['nombre'] ?? '-'?></td>
                            <td><?php echo !empty($usuario['last_date']) ? (DateTimeImmutable::createFromFormat('Y-m-d H:i:s',$usuario['last_date'])->format('d/m/Y H:i:s')): '-'?></td>
                            <td><?php echo $usuario['idioma'] ?? '-'?></td>
                            <td><?php echo $usuario['baja'] ? 'Activo' : 'Parado' ?></td>
                            <td>
                                <a href="<?php echo $_ENV['host.folder'] . 'usuariosSistema/edit/' . $usuario['id_usuario'] ?>" target="_blank" class="btn btn-success ml-1 mt-1" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-pen"></i></a>
                                <a href="<?php echo $_ENV['host.folder'] . 'usuariosSistema/delete/' . $usuario['id_usuario']?>" target="_blank" class="btn btn-danger  ml-1 mt-1" data-toggle="tooltip" data-placement="top" title="Borrar"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-warning">
                    <h6 class="m-0 font-weight-bold text-black">No hay datos que mostrar</h6>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

