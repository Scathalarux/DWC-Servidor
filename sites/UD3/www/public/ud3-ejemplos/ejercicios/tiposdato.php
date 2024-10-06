<?php

/*
 * Suponiendo que estas poniendo datos de una personal real, inicializa las siguientes variables seleccionando el tipo de datos correcto
 */

$dni = "35582324J";
$observaciones = "escribiendo una observación";
$estaCasado = false;
$provincia = "Pontevedra";
$sueldo = 1500;
$alturaCm =151;

echo strlen($observaciones);
echo mb_strlen($observaciones);


/*
 * Sobre una vivienda
 */
$precio = 150000;
$direccion = "calle mi casa 23";
$tieneGaraje = true;
$superficieparcela = 200;
$referenciaCatastral = "1234abc5678";
$ubicacionLatitud = 42.189;
$ubicacionLongitud = -36.725;
$enlaceFotoCasa = "www.fotocasa.com/micasita";
$necesitaReforma = false;


var_dump($dni,
$observaciones,
$estaCasado,
$provincia,
$sueldo,
$alturaCm,$precio,
$direccion,
$tieneGaraje,
$superficieparcela,
$referenciaCatastral,
$ubicacionLatitud,
$ubicacionLongitud,
$enlaceFotoCasa,
$necesitaReforma);