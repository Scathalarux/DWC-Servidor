<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Iterativas 08</h1>

</div>
<!-- Content Row -->

<?php if (isset($data['json'])) { ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                <table style="border: 1px solid black; text-align: left">
                    <tbody style="border: 1px solid black">
                    <?php foreach ($data['json'] as $asignatura => $datos) { ?>
                        <tr>
                            <td style="padding: 10px">
                              <?php echo $asignatura ?>
                            </td>
                            <td style="padding: 10px"> Media:
                              <?php echo $datos['media'] ?>
                            </td>
                            <td style="padding: 10px"> Suspensos:
                              <?php echo $datos['suspensos'] ?>
                            </td>
                            <td style="padding: 10px"> Aprobados:
                              <?php echo $datos['aprobados'] ?>
                            </td>
                            <td style="padding: 10px"> Max:
                              <?php foreach ($datos['max'] as $key => $value) {
                                echo $key . ": " . $value . "<br/>";
                              } ?>
                            </td>
                            <td style="padding: 10px"> Min:
                              <?php foreach ($datos['min'] as $key => $value) {
                                echo $key . ": " . $value . "<br/>";
                              } ?>
                            </td>
                        </tr>
                    <?php }; ?>
                    </tbody>
                </table>
                <p></p>

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
                          <?php foreach ($data['errors']['texto'] as $key => $value) {
                            echo $value . "<br/>";
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