<?php
declare(strict_types=1);
//VALIDAR LAS ENTRADAS SIEMPRE!

$data = [];

//si hemos recibido datos del formulario
if(!empty($_POST)){
    //Comprobar errores
    $errors = checkForm($_POST);
    //saneamos
    $data['input_numeros'] = filter_var($_POST['numeros'], FILTER_SANITIZE_SPECIAL_CHARS);

    //según si hay o no errores
    if(count($errors) > 0){
        $data['errors'] = $errors;
    }else{
        //procesamos
        $aux = explode(',', $_POST['numeros']);
        $data['max']= max($aux);
        $data['min']= min($aux);

    }
}

//Función para comprobar si hay errores
function checkForm(array $data): array
{
    $errors = [];

    //si no ha introducido valores
    if(empty($data['numeros'])){
        $errors['numeros'] = 'Inserte un valor en este campo';
    }else{
        //separamos el string utilizando como separador las comas
        $aux = explode(',', $data['numeros']);

        //nos recorremos el array y verificamos que todos son números
        $i =0;
        $hayErrores = false;
        while($i<count($aux) && !$hayErrores){
            if(!is_numeric($aux[$i])){
                $hayErrores = true;
            }
            $i++;
        }

        //si hay errores por no haber números mostramos el error
        if($hayErrores){
            $errors['numeros'] = 'Sólo se permiten números y comas';
        }
    }

    return $errors;
}


/*
* Llamamos a las vistas
*/
include 'views/templates/header.php';
include 'views/iterativas01.view.php';
include 'views/templates/footer.php';

