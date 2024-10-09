<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Iterativas 08</h1>

</div>
<!-- Content Row -->

<?php if (isset($data['json_calculos'])) { ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                <table class="table table-striped table-hover" style="text-align: left">
                    <thead class="thead-dark">
                    <th>Asignatura</th>
                    <th>Nota media</th>
                    <th>Nº Suspensos</th>
                    <th>Nº Aprobados</th>
                    <th>Nota máxima</th>
                    <th>Nota mínima</th>
                    </thead>
                    <tbody style="border: 1px solid black">
                    <?php foreach ($data['json_calculos'] as $asignatura => $datos) { ?>
                        <tr>
                            <td>
                                <?php echo $asignatura ?>
                            </td>
                            <td> Media:
                                <?php echo $datos['media'] ?>
                            </td>
                            <td > Suspensos:
                                <?php echo $datos['suspensos'] ?>
                            </td>
                            <td > Aprobados:
                                <?php echo $datos['aprobados'] ?>
                            </td>
                            <td > Max:
                                <?php foreach ($datos['max'] as $key => $value) {
                                    echo $key . ": " . $value . "<br/>";
                                } ?>
                            </td>
                            <td> Min:
                                <?php foreach ($datos['min'] as $key => $value) {
                                    echo $key . ": " . $value . "<br/>";
                                } ?>
                            </td>
                        </tr>
                    <?php }; ?>
                    </tbody>
                </table>
                <?php if (isset($data['listaAlumnos'])) {?>
                <h5>- Alumnos sin suspensos:</h5>
                <p><?php echo implode('<br/>',$data['listaAlumnos']['sinSuspensos']) ?></p>
                <h5>- Alumnos con 1 suspenso:</h5>
                    <p>
                    <?php foreach ($data['listaAlumnos']['conSuspensos'] as $alumno => $suspensos) {
                        if($suspensos ===1){
                        echo $alumno . "<br/>";
                        }
                     }   ?></p>
                <h5>- Alumnos que no promocionan (>1 suspenso):</h5>
                    <p> <?php foreach ($data['listaAlumnos']['conSuspensos'] as $alumno => $suspensos) {
                        if($suspensos >1){
                            echo $alumno . "<br/>";
                        }
                        }  ?></p>




                <?php } ?>
            </div>
        </div>
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