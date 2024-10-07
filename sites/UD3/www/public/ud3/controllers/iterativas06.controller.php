<?php
declare(strict_types=1);
//var_dump(mb_internal_encoding());

//comprobamos que se envien datos
if(!empty($_POST)){
  //saneamos
    //equivalencia a filter_var
    $data['input_numeros']=filter_input(INPUT_POST, $_POST['numeros'],FILTER_SANITIZE_SPECIAL_CHARS);
  //validamos el formulario
  $errors = checkForm($_POST['numeros']);
  //hay o no errores
  if(count($errors) > 0){
    $data['errors'] = $errors;
  }else{
    //procesamiento
    $data['numeros_resultantes']= cribaErastotenes($_POST['numeros']);


      /*  Alternativa criba de clase

      $multiplos = [];
      $conjuntoNumeros = range(2,$_POST['numeros']);
      for($i=2; $i <(int)$data['numero']; $i++){
          if(!in_array($i,$multiplos)){
              for($j=2; $j<(int)$data['numero']; $j++) {
                  $multiplos[] = $i * $j;
              }
          }
      }

      $data['numeros_resultantes']= array_diff($conjuntoNumeros, $multiplos);*/
  }

}


//funcion que valida la entrada de datos
function checkForm(string $number): array{

  $errors =[];
  //no se introducen valores
  if(empty($number)){
    $errors['numeros'] = "Inserte un número en este campo";
  }else{
      //usamos filter_var para que solo valgan los números enteros
      //no serviría el is_number
    if(!filter_var($number,FILTER_VALIDATE_INT)){
      $errors['numeros'] = "Solo se pueden intoducir números enteros para realizar la Criba de Erastótenes";
    }
      if((int)$number<2){
          $errors['numeros'] = "Solo se pueden intoducir números enteros mayores o iguales a 2 para realizar la Criba de Erastótenes";
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