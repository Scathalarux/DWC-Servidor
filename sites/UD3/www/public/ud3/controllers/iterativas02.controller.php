<?php
declare(strict_types=1);
//VALIDAR LAS ENTRADAS SIEMPRE!

$data=[];

//si no hemos recibidos datos del formulario
if(!empty($_POST)){
    //saneamos
    $data['input_numeros'] = filter_var($_POST['numeros'], FILTER_SANITIZE_SPECIAL_CHARS);

    //comprobar errores
    $errors = checkForm($_POST);

    //según haya o no errores
    if(count($errors) > 0){
        $data['errors'] = $errors;
    }else{
    //procesamiento
        $aux = explode(",",$_POST['numeros']);
//        sort($aux);
        $data['num_ordenados'] = implode(",", bubbleSort($aux));
//        var_dump($data['num_ordenados']);
    }
}

//Función que comprueba la presencia de errores
{
function checkForm(array $data): array{
    $errors = [];

    //no se introducen valores
    if(empty($data['numeros'])){
        $errors['numeros'] = "Inserte un valor en este campo";
    }else{
        //separamos los números separados por comas
        $aux = explode(",", $data['numeros']);

        //verificamos que todos son números
        $i =0;
        $hayErrores = false;
        while($i < count($aux) && !$hayErrores){
            if(!is_numeric($aux[$i])){
                $hayErrores = true;
            }
            $i++;
        }

        //si hay elementos que no son números, introducimos el error
        if($hayErrores){
            $errors['numeros'] = "Solo se permiten números y comas!";
        }
    }

    return $errors;
}

//Función que ordena el array a través de ordenación de burbuja
function bubbleSort(array $data): array{

    for($i = 0; $i < count($data); $i++){
        for($j = 0; $j < count($data)-1; $j++){
            if($data[$j] > $data[$j+1]){
                $aux = $data[$j];
                $data[$j] = $data[$j+1];
                $data[$j+1] = $aux;

            }
        }
    }
//var_dump($data);
    return $data;
}
/*
* Llamamos a las vistas
*/
include 'views/templates/header.php';
include 'views/iterativas02.view.php';
include 'views/templates/footer.php';
