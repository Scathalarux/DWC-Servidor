<!--Filtros-->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="get" action="/allUsers">
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
                                <label for="username">Nombre usuario:</label>
                                <input type="text" class="form-control" name="username" id="username" value="" />
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
    </div>
</div>
<!-- DataTables -->
<div class="row">
    <div class="col-12">
        <?php
        if (count($usuarios) > 1) {
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
                            <th>Rol </th>
                            <th>País</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($usuarios as $usuario) {?>
                                    <tr class="<?php echo !($usuario['activo']) ? 'table-danger' : '' ?>">
                                        <td><?php echo $usuario['username']; ?></td>
                                        <td><?php echo number_format($usuario['salarioBruto'], 2, ',', '.') ?></td>
                                        <td><?php echo number_format($usuario['retencionIRPF']) . '%' ?></td>
                                        <td><?php echo str_replace([',','.','_'], ['_',',','.'], $usuario['salarioNeto'])?></td>
                                        <td><?php echo $usuario['nombre_rol'] ?></td>
                                        <td><?php echo $usuario['country_name'] ?></td>
                                    </tr>
                                <?php }?>

                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else {
            ?>
            <div class="alert alert-warning" role="alert">
                No hay registros en la base de datos
            </div>
        <?php }?>
    </div>
</div>