<!-- DataTables -->
<div class="row">
    <div class="col-12">
        <?php
        if (count($data) > 1) {
        ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $titulo; ?></h6>
                <p class="" ><a href="/addCsv.view.php"></a></p>
            </div>
            <div class="card-body">
                <table id="csvTable" class="table table-bordered table-striped dataTable">
                    <?php
                    $first = true;

                    foreach ($data

                             as $fila) {
                    if ($first) {
                    ?>
                    <thead>
                    <tr>
                        <?php foreach ($fila as $columna) { ?>
                            <th><?php echo $columna; ?></th>
                        <?php }

                        //para que no cree más cabeceras
                        $first = false;
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php } else { ?>
                        <tr>
                            <?php foreach ($fila as $columna) { ?>
                                <td><?php echo $columna; ?></td>
                            <?php } ?>
                        </tr>
                        <?php
                    }
                    } ?>
                    </tbody>
                    <?php
                    if (isset($min) && isset($max)) {
                    ?>
                    <tfoot>
                    <tr class="alert-primary">
                        <td>
                            <?php echo $max[0]; ?>
                        </td>
                        <td>
                            <?php echo $max[1]; ?>
                        </td>
                        <td><?php echo $showMinMax ? 'MAX' : '' ?></td>
                        <td>
                            <?php echo $max[3]; ?>
                        </td>
                    </tr>
                    <tr class="alert-secondary">
                        <td>
                            <?php echo $min[0]; ?>
                        </td>
                        <td>
                            <?php echo $min[1]; ?>
                        </td>
                        <td><?php echo $showMinMax ? 'MIN' : ''; ?></td>
                        <td>
                            <?php echo number_format(num: $min[3], thousands_separator: '.'); ?>
                        </td>
                    </tr>
                    </tfoot>
                    <?php } ?>
                </table>
            </div>
        </div>
        <?php } else {
            ?>
        <div class="alert alert-warning" role="alert">
            No hay registros en el fichero
        </div>
        <?php }?>
    </div>
</div>