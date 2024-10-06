<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $data['titulo']; ?></h1>

</div>

<!-- Content Row -->

<div class="row">
    <!--Ejercicio 1-->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej1']; ?></h6>
            </div>
            <div class="card-body">
                El cuadrado del número <?php echo $data['ej1_x'];?> es <?php echo $data['ej1_y'];?>
            </div>
        </div>
    </div>
    <!--Ejercicio 2-->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej2']; ?></h6>
            </div>
            <div class="card-body">
                El precio hora es <?php echo $data['ej2_x'];?>€, se han trabajado <?php echo $data['ej2_y'];?>
                horas por lo que se pagarán <?php echo $data['ej2_z'];?>€
            </div>
        </div>
    </div>
    <!--Ejercicio 3-->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej3']; ?></h6>
            </div>
            <div class="card-body">
                Área: <?php echo number_format($data["ej3_perimetro"], 2, ',')?> cm2 <br />
                Perímetro: <?php echo number_format($data["ej3_area"], 2, ',')?> cm2
            </div>
        </div>
    </div>
    <!--Ejercicio 4-->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej4']; ?></h6>
            </div>
            <div class="card-body">
                Alumne: <?php echo $data["ej4_nombre"]?> <br />
                Edad: <?php echo $data["ej4_edad"]?> <br />
                Nota media: <?php echo number_format($data["ej4_nota_media"], 2, ',')?>
            </div>
        </div>
    </div>
    <!--Ejercicio 5-->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej5']; ?></h6>
            </div>
            <div class="card-body">
                Temporada baja: El precio/noche es <?php echo $data["ej5_precio_t_baja"]?>€, se han pasado <?php echo $data["ej5_noches_t_baja"]?> noches. El total a pagar es <?php echo $data["ej5_total_t_baja"]?>€ <br />
                Temporada alta: El precio/noche es <?php echo $data["ej5_precio_t_alta"]?>€, se han pasado <?php echo $data["ej5_noches_t_alta"]?> noches. El total a pagar es <?php echo $data["ej5_total_t_alta"]?>€
            </div>
        </div>
    </div>
    <!--Ejercicio 6-->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej6']; ?></h6>
            </div>
            <div class="card-body">
                Área: <?php echo number_format($data["ej6_area"], 2, ',') ?> cm2 <br />
                Perímetro: <?php echo number_format($data["ej6_perimetro"], 2, ',')?> cm2
            </div>
        </div>
    </div>
    <!--Ejercicio 7-->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej7']; ?></h6>
            </div>
            <div class="card-body">
                Velocidad en km/h: <?php echo number_format($data["ej7_vel_kmh"], 2, ',')?> km/h <br />
                Velocidad en m/s: <?php echo number_format($data["ej_vel_ms"], 2, ',')?> m/s
            </div>
        </div>
    </div>
    <!--Ejercicio 8-->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej8']; ?></h6>
            </div>
            <div class="card-body">
                El número <?php echo $data["ej8_num_completo"]?> está formado por <?php echo $data["ej9_centenas"]?>
                centenas, <?php echo $data["ej9_decenas"]?> decenas
                y <?php echo $data["ej9_unidades"]?> unidades. <br />
            </div>
        </div>
    </div>
    <!--Ejercicio 9-->
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['div_titulo_ej9']; ?></h6>
            </div>
            <div class="card-body">
                La cadena de texto "<?php echo $data["ej9_texto"]?>" está formada por <?php echo $data["ej9_caracteres"]?> caracteres y  <?php echo $data["ej9_palabras"]?>palabras.
            </div>
        </div>
    </div>
</div>
