<?php
declare(strict_types=1);
//var_dump(mb_internal_encoding());
//$data=array();
//var_dump($_POST);

//si no han enviado algo
if (!empty($_POST)) {
  //saneamos
  $data['input_texto'] = filter_var($_POST["texto"], FILTER_SANITIZE_SPECIAL_CHARS);
  //validamos el formulario
  $errors = checkJson($_POST['texto']);

  //hay o no hay errores
  if (count($errors) > 0) {
    $data['errors'] = $errors;
  } else {
    //procesamiento
    $data['json'] = json_decode($_POST['texto'], true);
    $data['json'] = calcSubject($data['json']);
  }
}

//funcion que calcula la nota media de cada asignatura
//función que calcula los suspensos
//función que calcula los aprobados
//función que calcula el alumno con mejor nota
//función que calcula el alumno con peor nota
function calcSubject(array $json): array
{
  $resultados = [];
  foreach ($json as $asignaturas => $alumnos) {
    $asignatura = [];
    $conjuntoNotas = 0;
    $asignatura['suspensos'] = 0;
    $asignatura['aprobados'] = 0;

    foreach ($alumnos as $alum => $nota) {
      $conjuntoNotas += $nota;
      if ($nota >= 5) {
        $asignatura['aprobados']++;
      } else {
        $asignatura['suspensos']++;
      }
      if ($nota === max($alumnos)) {
        $alumnoMax['alumno'] = $alum;
        $notaMax['nota'] = $nota;
        $asignatura['max'] = array_merge($alumnoMax, $notaMax);
      }
      if ($nota === min($alumnos)) {
        $alumnoMin['alumno'] = $alum;
        $notaMin['nota'] = $nota;
        $asignatura['min'] = array_merge($alumnoMin, $notaMin);
      }
    }

    $asignatura['media'] = $conjuntoNotas / count($alumnos);
    $resultados[$asignaturas] = $asignatura;
  }
  var_dump($resultados);
  return $resultados;
}

//funcion que valida si el json es correcto o presenta algún error
function checkJson(string $text): array
{
  $errors = [];

  if (empty($text)) {
    $errors['texto'][] = 'Inserte un json a analizar';
  } else {
    $array = json_decode($text, true);

    //comprobamos si hay errores de procesamiento del json
    if (is_null($array)) {
      $errors['texto'][] = 'json incorrecto, introduce un json válido';
    } else {
      if (!is_array($array)) {
        $errors['texto'][] = 'json incorrecto, introduce un array de asignaturas';
      } else {

        //comprobamos si la estructura sigue el patrón texto[texto:num(0-10)]
        foreach ($array as $asignaturas => $alumnos) {
          if (!is_string($asignaturas) || mb_strlen(trim($asignaturas)) < 1) {
            $errors['texto'][] = "El nombre de la asignatura '$asignaturas' no es válido, debe ser un texto";
          }
          if (!is_array($alumnos)) {
            $errors['texto'][] = "Cada asignatura debe contener un conjunto de alumnos con sus respectivas notas. Tienes un error en el array $asignaturas";
          } else {
            foreach ($alumnos as $alum => $nota) {
              if (!is_string($alum) || mb_strlen(trim($alum)) < 1) {
                $errors['texto'][] = "El nombre del alumno '$alum' no es válido. Tienes un error en '$asignaturas'";
              }
              if (!is_numeric($nota)) {
                $errors['texto'][] = "La nota debe ser un número. Tienes un error en la nota '$nota' del alumno '$alum'";
              } else if (($nota > 10) || ($nota < 0)) {
                $errors['texto'][] = 'La nota debe estar entre 0 y 10. Tienes un error en la nota del alumno: ' . $alum;
              }
            }
          }
        }
      }
    }
  }
  return $errors;
}

/*
* Llamamos a las vistas
*/
include 'views/templates/header.php';
include 'views/iterativas08.view.php';
include 'views/templates/footer.php';
?>

<!--
coger el texto de json, ponerlo en el text area (se comprueba que reciba ese formato: lista ed asignaturas y cada
asignatura tiene un alista de alumnos y su nota) y utilizar el json_decode.
Sacar array que siga el formato de la imagen

comprobar: array tiene tipo texto que tiene array con tipo texto y un número de 0 a 10
si el json_decode da error enviaremos el aviso de que hay un error en el json


*Ejemplo sencillo visto en la explicación

$array = [
  'saludo' => 'hola',
  'edad' => '28',
  'lenguajes' => array('php','js','java')
];
$string = json_encode($array);
//true para que lo convierta a un array
$nuevoArray = json_decode($string, true);
-->
