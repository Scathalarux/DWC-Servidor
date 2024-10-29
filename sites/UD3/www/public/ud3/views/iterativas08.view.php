<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Iterativas 08</h1>

</div>
<!-- Content Row -->

<?php if (isset($data['json_calculos'])) { ?>
    <div class="row">
        <div class="col-12">
            <div class="alert">
                <table class="table table-striped table-hover" style="text-align: left">
                    <thead class="thead-dark">
                    <tr>
                        <th>Asignatura</th>
                        <th>Nota media</th>
                        <th>Nº Suspensos</th>
                        <th>Nº Aprobados</th>
                        <th>Nota máxima</th>
                        <th>Nota mínima</th>
                    </tr>
                    </thead>
                    <tbody style="border: 1px solid black">
                    <?php foreach ($data['json_calculos'] as $asignatura => $datos) { ?>
                        <tr>
                            <td>
                                <strong><?php echo ucwords($asignatura) ?></strong>
                            </td>
                            <td>
                                <?php echo $datos['media'] ?>
                            </td>
                            <td>
                                <?php echo $datos['suspensos'] ?>
                            </td>
                            <td>
                                <?php echo $datos['aprobados'] ?>
                            </td>
                            <td>
                                <?php foreach ($datos['max'] as $key => $value) {
                                    echo ucwords($key) . ": " . $value . "<br/>";
                                } ?>
                            </td>
                            <td>
                                <?php foreach ($datos['min'] as $key => $value) {
                                    echo ucwords($key) . ": " . $value . "<br/>";
                                } ?>
                            </td>
                        </tr>
                    <?php }; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <?php if (isset($data['listaAlumnos'])) { ?>
            <div class="col-4 alert-success">
                <h5>Alumnos sin suspensos:</h5>
                <p><?php echo implode('<br/>', $data['listaAlumnos']['sinSuspensos']) ?></p>
            </div>
            <div class="col-4 alert-info">
                <h5>Alumnos con al menos 1 suspenso:</h5>
                <p>
                    <?php foreach ($data['listaAlumnos']['conSuspensos'] as $alumno => $suspensos) {
                        if ($suspensos >= 1) {
                            echo $alumno . "<br/>";
                        }
                    } ?></p>
            </div>
            <div class="col-4 alert-warning">
                <h5>Alumnos que no promocionan (>1 suspenso):</h5>
                <p> <?php foreach ($data['listaAlumnos']['conSuspensos'] as $alumno => $suspensos) {
                        if ($suspensos > 1) {
                            echo $alumno . "<br/>";
                        }
                    } ?></p>
            </div>
        <?php } ?>
    </div>
    <?php
}
?>



<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Datos asignaturas</h6>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3 col-12">
                        <label for="textarea">Introduce el JSON: </label>
                        <textarea class="form-control" id="texto" name="texto"
                                  rows="3"><?php echo $data['input_texto'] ?? ''; ?></textarea>
                        <p class="text-danger small">
                            <?php if (isset($data['errors'])) {
                                foreach ($data['errors']['texto'] as $key => $value) {
                                    echo $value . "<br/>";
                                }
                            }
                            ?></p>
                        <br/>
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
