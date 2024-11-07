<!--Filtros-->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="<?php echo $_ENV['host.folder']; ?>users-filter">
                <input type="hidden" name="order" value="1"/>
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="username">Nombre usuario:</label>
                                <input type="text" class="form-control" name="username" id="username"
                                       value="<?php echo isset($input['username']) ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="id_rol">Tipo usuario:</label>
                                <select name="id_rol" class="form-control">
                                    <option value="">-</option>
                                    <?php foreach ($roles as $rol) { ?>
                                    <option value="<?php echo $rol['id_rol']; ?>"
                                        <?php echo isset($input['id_rol']) && $rol['id_rol'] === $input['id_rol'] ? 'selected' : ''; ?>>
                                        <?php echo ucfirst($rol['nombre_rol']) ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="salarioMinimo">Salario Bruto mínimo:</label>
                                <input type="number" class="form-control" name="salarioMinimo" id="salarioMinimo"
                                       value="<?php echo isset($input['salarioMinimo']) ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                            <label for="salarioMaximo">Salario Bruto máximo:</label>
                            <input type="number" class="form-control" name="salarioMaximo" id="salarioMaximo"
                                   value="<?php echo isset($input['salarioMaximo']) ?>"/>
                        </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="cotizacion">Cotizacion:</label>
                                <input type="number" class="form-control" name="cotizacion" id="cotizacion"
                                       value="<?php echo isset($input['cotizacion']) ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    </div>
                    <div class="card-footer">
                        <div class="col-12 text-right">
                            <a href="<?php echo $_ENV['host.folder']; ?>users-filter" value="" name="reiniciar"
                               class="btn btn-danger">Reiniciar filtros</a>
                            <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
<!-- DataTables -->
<div class="row">
    <div class="col-12">
        <?php
        if (!empty($usuarios)) {
            ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6>
                </div>
                <div class="card-body" id="card_table">
                    <table id="tabladatos" class="table table-striped datatable">
                        <thead>
                        <tr>
                            <th>Nombre usuario</th>
                            <th>Salario Bruto</th>
                            <th>Retención IRPF</th>
                            <th>Salario Neto</th>
                            <th>Rol</th>
                            <th>País</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($usuarios as $usuario) { ?>
                            <tr class="<?php echo !($usuario['activo']) ? 'table-danger' : '' ?>">
                                <td><?php echo $usuario['username']; ?></td>
                                <td><?php echo number_format($usuario['salarioBruto'], 2, ',', '.') ?></td>
                                <td><?php echo number_format($usuario['retencionIRPF']) . '%' ?></td>
                                <td><?php echo str_replace([',', '.', '_'], ['_', ',', '.'], $usuario['salarioNeto']) ?></td>
                                <td><?php echo $usuario['nombre_rol'] ?></td>
                                <td><?php echo $usuario['country_name'] ?></td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else {
            ?>
            <div class="alert alert-warning" role="alert">
                No hay registros en la base de datos
            </div>
        <?php } ?>
    </div>
</div>