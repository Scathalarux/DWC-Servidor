<?php
declare(strict_types=1);
//var_dump(mb_internal_encoding());

//comprobamos que se envien datos
if(!empty($_POST)){
  //saneamos
  $data['input_numeros']= filter_var($_POST['numeros'], FILTER_SANITIZE_SPECIAL_CHARS);
  //validamos el formulario
  $errors = checkForm($_POST['numeros']);
  //hay o no errores
  if(count($errors) > 0){
    $data['errors'] = $errors;
  }else{
    //procesamiento
    //separamos los números

    $data['numeros_resultantes']= cribaErastotenes($_POST['numeros']);
  }

}

//funcion que valida la entrada de datos
function checkForm(string $number): array{

  $errors =[];
  //no se introducen valores
  if(empty($number)){
    $errors['numeros'] = "Inserte un valor en este campo";
  }else{
    if(!is_numeric($number)){
      $errors['numeros'] = "Solo se pueden intoducir números para realizar la Criba de Erastótenes";
    }

  }

  return $errors;
}


//funcion que implementa la criba de erastótenes
function cribaErastotenes(string $n): array{

  $primos = [];

  //llenamos un array con los números desde el 2 (primer primo) hasta el límite
  //indicado por el usuario, asumiendo que todos son primos
  for($i = 2; $i <= $n; $i++){
    $primos[$i]= true;
  };

  //nos recorremos la lista de numeros que tenemos
  for($j=2; $j<=sqrt((float)$n); $j++){
    if($primos[$j]){
      //descartamos los múltiplos de ese primo
      for($k=2; $j * $k <= $n; $k++){
        $primos[$j*$k]= false;
      }
    }
  }

  //el empezar en j=2 y k=2 mantenemos que el 2 y el 3 son primos, contrastamos a partir de ahí

  return $primos;
}


/*
* Llamamos a las vistas
*/
include 'views/templates/header.php';
include 'views/iterativas06.view.php';
include 'views/templates/footer.php';