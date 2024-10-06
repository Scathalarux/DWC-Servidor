<?php
declare(strict_types=1);
/*
 * Aquí hacemos los ejercicios y rellenamos el array de datos.
 */
$data['titulo'] = "Ejercicios Decisión";

//Ejercicio 1
$data["div_titulo_ej1"] = "Ejercicio 1";
$data['ej1_x'] = 10;
$data['ej1_y'] = 2;
$data['ej1_es_divisible'] = $data['ej1_x'] % $data['ej1_y'] == 0;


//Ejercicio 2
$data["div_titulo_ej2"] = "Ejercicio 2";
$data['ej2_x'] = -4;
$data['ej2_y'] = 7;
$data['ej2_z'] = 7;
$data['ej2_mayor'] = '';
$data['ej2_mayor'] = max($data['ej2_x'], $data['ej2_y'], $data['ej2_z']);


/*
 * Alternativa más larga

if ($data['ej2_x'] >= $data['ej2_y'] && $data['ej2_x'] >= $data['ej2_z']) {
    $data['ej2_mayor'] = $data['ej2_x'];
} else if ($data['ej2_y'] >= $data['ej2_x'] && $data['ej2_y'] >= $data['ej2_z']) {
    $data['ej2_mayor'] = $data['ej2_y'];
} else {
    $data['ej2_mayor'] = $data['ej2_z'];
}*/


//Ejercicio 3
$data["div_titulo_ej3"] = "Ejercicio 3";
//definimos la constante que representará la duración de un día
define('DURACION_DIA', 24 * 3600);
$data['ej3_numero'] = 3603 * 72;
$data['ej3_segundos'] = intval(($data['ej3_numero'] % 60));
$data['ej3_minutos'] = intval(($data['ej3_numero'] % 3600) / 60);
$data['ej3_horas'] = intval(($data['ej3_numero'] % DURACION_DIA) / 3600);
$data['ej3_dias'] = intval($data['ej3_numero'] / DURACION_DIA);


//Ejercicio 4
$data["div_titulo_ej4"] = "Ejercicio 4";
$data['ej4_ano'] = 2024;
$data['ej4_texto'] = '';
if (($data['ej4_ano'] % 4 == 0 && $data['ej4_ano'] % 100 != 0) || ($data['ej4_ano'] % 400 == 0)) {
    $data['ej4_texto'] = 'success';
} else {
    $data['ej4_texto'] = 'danger';
}


//Ejercicio 5
$data["div_titulo_ej5"] = "Ejercicio5";
$data['ej5_sueldo_bruto'] = 2500;
$data['ej5_descuento'] = calcularDescuento($data['ej5_sueldo_bruto']);
$data['ej5_sueldo_neto'] = $data['ej5_sueldo_bruto'] - $data['ej5_descuento'];

//función que calcula el descuento
function calcularDescuento(float $sueldo): float{
  if($sueldo>0){
    $descuento = $sueldo * 0.1;
    if(($sueldo-1000)>0){
      $descuento = ($sueldo - 1000) * 0.05;
    }
    if(($sueldo-2000)>0){
      $descuento = ($sueldo - 1000) * 0.03;
    }
    return $descuento;
  }else{
    return 0;
  }
}

/*
 * Opción del profe: mejora la escalabilidad y portabilidad del código
$ej6Sueldo = $data['salario'];
$descuento = descuentoTramo($ej6Sueldo, 0, 1000, 0.1) + descuentoTramo($ej6Sueldo, 1000, 2000, 0.15) + descuentoTramo($ej6Sueldo, 2000, INF, 0.18);
$data['ej6_bruto'] = $ej6Sueldo;
$data['ej6_neto'] = $ej6Sueldo - $descuento;
$data['ej6_descuento'] = $descuento;

function descuentoTramo(float $sueldoBruto, float $min, float $max, float $porc) : float{
    if($sueldoBruto > $min){
        if($sueldoBruto > $max){
            $dineroAplicar = $max - $min;
        }
        else{
            $dineroAplicar = $sueldoBruto - $min;
        }
        return $dineroAplicar * $porc;
    }
    else{
        return 0;
    }
}
*/




/*NO ES ASÍ, LO ENTENDÍ MAL

if ($sueldo <= 1000) {
    $descuento_sueldo = $sueldo * 0.1;
    $data['ej5_sueldo_neto'] = $sueldo - $descuento_sueldo;
} else if ($sueldo <= 2000) {
    $descuento_sueldo = $sueldo * 0.15;
    $data['ej5_sueldo_neto'] = $sueldo - $descuento_sueldo;
} else {
    $descuento_sueldo = $sueldo * 0.18;
    $data['ej5_sueldo_neto'] = $sueldo - $descuento_sueldo;
}*/




//Ejercicio 6
$data["div_titulo_ej6"] = "Ejercicio 6";
$nota = 10;
// Si lo queremos coger de la barra $nota = (int)$_GET['Nota'];
// Parseamos para que no nos de errores al ponerlo en modo estricto
// Para comprobar que sea un número utilizamos el is_numeric()
// Para comprobar que la nota se ha introducido debemos utilizar isset()
//$nota = is_numeric((int)$_GET['Nota'])? (int)$_GET['Nota']: -1;

$data['ej6_nota_texto'] = match (true) {
    $nota < 5 => "Suspenso",
    $nota < 6 => "Aprobado",
    $nota < 7 => "Bien",
    $nota < 8.75 => "Notable",
    $nota < 10 => "Sobresaliente",
    $nota == 10 => "Matrícula",
};
$data['ej6_nota_color'] = match (true) {
    $nota < 5 => "danger",
    $nota < 6 => "warning",
    $nota < 8.75 => "info",
    $nota <= 10 => "success",
};

/* ALTERNATIVA 1
$data['ej6_nota_color'] = match ($data['ej6_nota_texto']) {
    "Suspenso" => "danger",
    'Aprobado' => "warning",
    'Bien', 'Notable'=> "info",
    default => "success",
};

ALTERNATIVA 2

$data['ej6_nota_color'] = "";
switch ($data['ej6_nota_texto']) {
    case "Suspenso":
        $data['ej6_nota_color'] = "danger";
        break;
    case "Aprobado":
        $data['ej6_nota_color'] = "warning";
        break;
    case "Bien":
    case "Notable":
        $data['ej6_nota_color'] = "info";
        break;
    case "Sobresaliente":
    case "Matrícula":
        $data['ej6_nota_color'] = "success";
        break;
}*/


//Ejercicio 7
$data["div_titulo_ej7"] = "Ejercicio 7";
$bebida = "Bonka";
$data['ej7_tipo_bebida'] = "";
switch ($bebida) {
    case "Marcilla":
    case "Bonka":
        $data['ej7_tipo_bebida'] = "café";
        break;
    case "Coca-Cola":
    case "Kas":
    case "Pepsi":
        $data['ej7_tipo_bebida'] = "refresco";
        break;
    case "Mondariz":
    case "Cabreiroá":
    case "Sousas":
        $data['ej7_tipo_bebida'] = "agua";
        break;
}

/*
 * Llamamos a las vistas
 */
include 'views/templates/header.php';
include 'views/decision.view.php';
include 'views/templates/footer.php';