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
                                        <td><?php echo number_format($usuario['retencionIRPF']) ?></td>
                                        <td><?php echo $usuario['salarioNeto']?></td>
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