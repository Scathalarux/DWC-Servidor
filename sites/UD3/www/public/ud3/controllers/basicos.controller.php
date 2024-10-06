<?php
/*
 * Aquí hacemos los ejercicios y rellenamos el array de datos.
 */
$data['titulo'] = "Ejercicios básicos";

//Ejercicio 1
$data["div_titulo_ej1"] = "Ejercicio 1";
$data['ej1_x'] = 24;
$data['ej1_y'] = $data['ej1_x'] **2;

//Ejercicio 2
$data["div_titulo_ej2"] = "Ejercicio 2";
$data['ej2_x'] = 8;
$data['ej2_y'] = 4;
$data['ej2_z'] = $data['ej2_x'] * $data['ej2_y'];

//Ejercicio 3
$data["div_titulo_ej3"] = "Ejercicio 3";
$base = 3;
$altura = 2;
$data["ej3_perimetro"] = $base* 2 + $altura * 2;
$data["ej3_area"]= $base * $altura;


//Ejercicio 4
$data["div_titulo_ej4"] = "Ejercicio 4";
$data["ej4_nombre"] = "Lara Comesaña Varela";
$data["ej4_edad"]= 26;
$data["ej4_nota_media"] = 8.5;

//Ejercicio 5
$data["div_titulo_ej5"] = "Ejercicio 5";
$data["ej5_precio_t_baja"] = 30;
$data["ej5_precio_t_alta"] = 50;
$data["ej5_noches_t_baja"] = 3;
$data["ej5_noches_t_alta"] = 2;
$data["ej5_total_t_baja"] = $data["ej5_precio_t_baja"] * $data["ej5_noches_t_baja"];
$data["ej5_total_t_alta"] = $data["ej5_precio_t_alta"] * $data["ej5_noches_t_alta"];

//Ejercicio 6
$data["div_titulo_ej6"] = "Ejercicio 6";
$radio = 3;
$data["ej6_area"] = round(pi() * $radio **2, 2);
$data["ej6_perimetro"] = round(2 * pi() * $radio, 2);

//Ejercicio 7
$data["div_titulo_ej7"] = "Ejercicio 7";
$data["ej7_vel_kmh"] =100;
$data["ej_vel_ms"] = round($data["ej7_vel_kmh"] * 1000 /3600, 2);

//Ejercicio 8
$data["div_titulo_ej8"] = "Ejercicio 8";
$data["ej8_num_completo"] = 478;

$data["ej9_centenas"] = intval($data["ej8_num_completo"]/100);
$data["ej9_decenas"] = intval(($data["ej8_num_completo"]%100) /10);
$data["ej9_unidades"] = $data["ej8_num_completo"]%10;


//Ejercicio 9
$data["div_titulo_ej9"] = "Ejercicio 9";
$data["ej9_texto"] = "Hola, esto es un texto de prueba";
$data["ej9_caracteres"] = mb_strlen($data["ej9_texto"]);
$data["ej9_palabras"]= str_word_count($data["ej9_texto"], 0);

/*
 * Llamamos a las vistas
 */
include 'views/templates/header.php';
include 'views/basicos.view.php';
include 'views/templates/footer.php';