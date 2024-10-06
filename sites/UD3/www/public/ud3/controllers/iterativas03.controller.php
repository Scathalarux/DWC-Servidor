<?php
declare(strict_types=1);

/*$_matriz = array(
  0 => array(17, 35, 21, 8),
  1 => array(14, 11, 31, 22),
  2 => array(5, 13, 12, 4),
  3 => array(36, 24, 17, 10)
);*/

//comprobación envio de datos
if(!empty($_POST)){
  //saneamos
  $data['input_numeros']= filter_var($_POST['numeros'], FILTER_SANITIZE_SPECIAL_CHARS);

  //comprobar errores
    $errors = checkForm($_POST);
    //según haya o no errores
    if(count($errors) > 0){
        $data['errors'] = $errors;
    }else{
    //procesamiento

        $auxCompleto = [];
        //separamos los números separados por |
        $aux = explode("|", $_POST['numeros']);
        //separamos los números separados por comas y los metemos en el array conjunto
        for($i = 0; $i < count($aux); $i++){
            $aux2 = explode(",", $aux[$i]);
            $numeroColumnas = count($aux2);
            for($j = 0; $j < count($aux2); $j++){
                $auxCompleto[] = $aux2[$j];
            }
        }
        //ordenamos todos los números
        sort($auxCompleto);
        $auxCompleto = array_chunk($auxCompleto, $numeroColumnas);
        for ($i=0; $i < count($auxCompleto); $i++) {
            $auxCompleto[$i]= implode(",", $auxCompleto[$i]);
        }
        $auxCompleto = implode("|", $auxCompleto);
        $data['array_ordenado'] = $auxCompleto;
    }
}


//Función que comprueba la presencia de errores

    function checkForm(array $data): array{
        $errors = [];

        //no se introducen valores
        if(empty($data['numeros'])){
            $errors['numeros'] = "Inserte un valor en este campo";
        }else{
            //separamos los números separados por |
            $aux = explode("|", $data['numeros']);
            //separamos los números separados por comas
            for($i = 0; $i < count($aux); $i++){
                $aux2 = explode(",", $aux[$i]);
            }

            //CHECK DE QUE TODAS LAS FILAS TIENEN LOS MISMOS ELEMENTOS
            $numrosPrimeraFila = explode(",", $aux[0]);
          for($i = 1; $i < count($aux); $i++ ){
            $fila = explode(",", $aux[$i]);
            if(count($numrosPrimeraFila) !== count($fila)){
              $errors['numeros'] = 'Todas las filas deben tener el mismo número de elementos.';
              return $errors;
            }
          }

            //verificamos que todos son números
            $i =0;
            $hayErrores = false;
            while($i < count($aux2) && !$hayErrores){
                if(!is_numeric($aux2[$i])){
                    $hayErrores = true;
                }
                $i++;
            }

            //si hay elementos que no son números, introducimos el error
            if($hayErrores){
                $errors['numeros'] = "Solo se permiten números, comas y |";
            }

            //PODEMOS AÑADIR UN PASO EN EL QUE INDIQUEMOS QUÉ VALORES SON ERRÓNEOS
        }

        return $errors;
    }



/*
* Llamamos a las vistas
*/
include 'views/templates/header.php';
include 'views/iterativas03.view.php';
include 'views/templates/footer.php';