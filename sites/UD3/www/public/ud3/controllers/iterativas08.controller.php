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


<?php
//declare(strict_types=1);
//var_dump(mb_internal_encoding());

//si no han enviado algo
if(!empty($_POST)){
    //saneamos
    $data['input_texto'] = filter_var($_POST["texto"], FILTER_SANITIZE_SPECIAL_CHARS);
    //validamos el formulario
    $errors = checkJson($_POST['texto']);

    //hay o no hay errores
    if(count($errors) > 0){
        $data['errors'] = $errors;
    }else{
    //procesamiento
        $array = json_decode($_POST['texto'], true);
        foreach ($array as $key => $value) {
            $data['asignatura'] = $key;
            foreach($value as $alum => $nota){
                $data['alumno']= $alum;
                $data['nota'] = $nota;
            }
        }
    }

}

//funcion que valida si el json es correcto o presenta algún error
function checkJson (string $json):array{
    $array = json_decode($json, true);
    $errors= [];

    //comprobamos si hay errores de procesamiento del json
    if(is_null($array)){
        $errors['texto'] = 'json incorrecto, introduce un json válido';
    }


    //comprobamos si la estructura sigue el patrón texto[texto:num(0-10)]
    foreach ($array as $key => $value) {
        //comprobamos que la asingatura sea texto
        if(!is_string($key)){
            $errors['texto']= 'El nombre de la asignatura debe ser tipo texto. Tienes un error en: '.$key;
        }elseif(!is_array($value)){
            $errors['texto']= 'Cada asignatura debe contener un conjunto de alumnos con sus respectivas asignaturas';
        }
        //si la asignatura es tipo texto
        foreach ($value as $alum => $nota) {
            if(!is_string($alum)){
                $errors['texto']= 'El nombre de los alumnos debe ser tipo texto. Tienes un error en: '.$key;
            }elseif(!is_numeric($nota)){
                $errors['texto']= 'La nota debe ser un número. Tienes un error en la nota del alumno :'.$alum;
            }elseif(($nota>10) || ($nota<0)){
                $errors['texto']= 'La nota debe estar entre 0 y 10. Tienes un error en la nota del alumno :'.$alum;
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
