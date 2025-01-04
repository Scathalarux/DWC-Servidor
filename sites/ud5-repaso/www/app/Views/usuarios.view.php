<?php

declare(strict_types=1);

?>
<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="/usuariosFiltros">
                <input type="hidden" name="order" value="1"/>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
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
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_country">País:</label>
                                <select name="id_country[]" id="id_country" class="form-control select2"
                                        data-placeholder="País" multiple>
                                    <option value="">-</option>
                                    <?php foreach ($countries as $country) { ?>
                                        <option value="<?php echo $country['id'] ?>" <?php echo isset($input['id_country']) && in_array($country['id'], $input['id_country']) ? 'selected' : '' ?>><?php echo $country['country_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label for="id_rol">Rol:</label>
                                <select name="id_rol" id="id_continente" class="form-control" data-placeholder="Rol">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) { ?>
                                        <option value="<?php echo $rol['id_rol'] ?>" <?php echo isset($input['id_rol']) && $rol['id_rol'] === $input['id_rol'] ? 'selected' : '' ?>><?php echo $rol['nombre_rol'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
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
                        <div class="col-12 col-lg-6">
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
                        <a href="<?php echo $_ENV['host.folder'] ?>usuarios" value="" class="btn btn-danger">Reiniciar
                            filtros</a>
                        <input type="submit" value="Aplicar filtros" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- LOVE YOU -->


    <?php if (!empty($usuarios)) { ?>
        <div class="col-12">
            <div class="card shadow mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="col-10 m-0 font-weight-bold text-primary">Usuarios</h6>
                    <div class="col-2 text-right">
                        <a href="<?php echo $_ENV['host.folder'] . 'usuarios/new' ?>"
                           class="m-0 font-weight-bold text-primary">Usuario Nuevo <i class="fa fa-plus-circle"></i></a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body" id="card_table">
                    <div id="button_container" class="mb-3"></div>
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <table id="tabladatos" class="table table-striped">
                        <thead>
                        <tr>
                            <th>
                                <a href="<?php echo $_ENV['host.folder'] . 'usuarios?' . 'order=' . (($order == 1) ? '-' : '')?>1">Username</a>
                                <i class="fas fa-sort-amount-down-alt"></i>
                            </th>
                            <th><a href="/usuarios?order=2">Salario Bruto</a></th>
                            <th><a href="/usuarios?order=3">Retención IRPF</a></th>
                            <th><a href="/usuarios?order=4">Rol</a></th>
                            <th><a href="/usuarios?order=5">País</a></th>
                            <th><a href="/usuarios?order=6">Activo</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($usuarios as $usuario) { ?>
                            <tr class="">
                                <td><?php echo $usuario['username'] ?></td>
                                <td><?php echo $usuario['salarioBruto'] ?></td>
                                <td><?php echo $usuario['retencionIRPF'] ?></td>
                                <td><?php echo $usuario['nombre_rol'] ?></td>
                                <td><?php echo $usuario['country_name'] ?></td>
                                <td><?php echo $usuario['activo'] ? 'Activo' : 'Baja' ?></td>
                                <td>
                                    <a href="<?php echo $_ENV['host.folder'] . 'usuarios/edit/' . $usuario['username'] ?>"
                                       target="_blank" class="btn btn-success ml-1"
                                       data-toggle="tooltip" data-placement="top" title="Editar"><i
                                                class="fas fa-pen"></i></a>
                                    <a href="<?php echo $_ENV['host.folder'] . 'usuarios/delete/' . $usuario['username'] ?>"
                                       target="_blank" class="btn btn-danger"
                                       data-toggle="tooltip" data-placement="top" title="Borrar"><i
                                                class="fas fa-trash"></i></a>

                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-3 font-weight-bold text-primary bg-danger">No hay datos que mostrar</h6>
        </div>
    <?php } ?>
</div>

