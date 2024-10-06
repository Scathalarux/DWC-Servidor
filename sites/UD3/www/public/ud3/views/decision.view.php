<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $data['titulo']; ?></h1>

</div>

<!-- Content Row -->

<div class="row">

    <!--Ejercicio 1-->
    <div class="col-6">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej1']; ?></h6>
            </div>
            <div class="card-body">
                <?php echo $data['ej1_x'] ?> <?php echo $data['ej1_es_divisible'] ? '' : 'no'; ?>
                es divisible entre <?php echo $data['ej1_y'] ?>
            </div>
        </div>
    </div>
    <!--Ejercicio 2-->
    <div class="col-6">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej2']; ?></h6>
            </div>
            <div class="card-body">
                Entre <?php echo $data['ej2_x'] ?>, <?php echo $data['ej2_y'] ?> y <?php echo $data['ej2_z'] ?>,
                el mayor número es <strong><?php echo $data['ej2_mayor'] ?></strong>
            </div>
        </div>
    </div>
    <!--Ejercicio 3-->
    <div class="col-6">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej3']; ?></h6>
            </div>
            <div class="card-body">
                <?php echo $data['ej3_numero'] ?> es equivalente a <?php echo $data['ej3_dias'] ?> días,
                <?php echo $data['ej3_horas'] ?> horas,
                <?php echo $data['ej3_minutos'] ?> minutos y
                <?php echo $data['ej3_segundos'] ?> segundos.
            </div>
        </div>
    </div>
    <!--Ejercicio 4-->
    <div class="col-6">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej4']; ?></h6>
            </div>
            <div class="card-body">
                <p class="text-<?php echo $data['ej4_texto'] ?>"><strong><?php echo $data['ej4_ano'] ?> Resultado de cálculo de año bisiesto</strong>
                </p>
            </div>
        </div>
    </div>
    <!--Ejercicio 5-->
    <div class="col-6">
        <div>
            <?php if ($data['ej5_sueldo_neto'] > 2000) {
                echo "<p class='alert alert-success' role='alert'>Felicidades, tienes un salario por encima de la media</p>";
            } else {
                echo '';
            } ?>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej5']; ?></h6>
            </div>
            <div class="col-6">Salario Bruto: <?php echo number_format($data['ej5_sueldo_bruto'], 2, ',', '.'); ?>€</div>
            <div class="col-6">Descuento: <?php echo number_format($data['ej5_descuento'], 2, ',', '.'); ?>€</div>
            <div class="col-12">Salario Neto: <?php echo number_format($data['ej5_sueldo_neto'], 2, ',', '.'); ?>€</div>
        </div>
    </div>
    <!--Ejercicio 6-->
    <div class="col-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej6']; ?></h6>
            </div>
            <div class="card-body">
                <p class='alert alert-<?php echo $data['ej6_nota_color']?>' role='alert'><?php echo $data['ej6_nota_texto'] ?></p>
            </div>
        </div>
    </div>
    <!--Ejercicio 7-->
    <div class="col-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej7']; ?></h6>
            </div>
            <div class="card-body">
                La bebida es tipo <strong><?php echo $data['ej7_tipo_bebida'] ?></strong>
            </div>
        </div>
    </div>
</div>