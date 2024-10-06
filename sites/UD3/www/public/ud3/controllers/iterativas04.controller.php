<?php
declare(strict_types=1);

//comprobamos el envío de datos
if(!empty($_POST)){
  //saneamos
  $data['input_texto']= filter_var($_POST['texto'], FILTER_SANITIZE_SPECIAL_CHARS);
  //contabilizamos los errores
  $errors = checkForm($_POST);

  //si no hay errores
  if(count($errors)>0){
    $data['errors']=$errors;
  }else{
  //procesamiento
    //separamos por espacios
      $aux=explode(" ", $_POST['texto']);
      $aux2 = [];
      $aux2 = implode('',array_merge($aux, $aux2));
      $aux2 =mb_strtolower($aux2);
      $arrayContador = countLetters($aux2);

      arsort($arrayContador, SORT_NUMERIC );

      $data['contador_ordenado']= $arrayContador;

  }

}

//función que comprueba los errores
function checkForm(array $data): array{

  $errors = [];

  //no se introducen valores
  if(empty($data['texto'])){
    $errors['texto'] = 'Inserte el texto en este campo';
  }else{
    //separamos por espacios
    $aux= explode(' ', $data['texto']);

    //hay algo diferente a letras
    $i = 0;
    $hayErrores = false;
    while($i<count($aux) && !$hayErrores){
      if(preg_match('/^a-zA-ZáéíóúÁÉÍÓÚñÑ$/ui',$aux[$i])){
        $hayErrores = true;
      }
      $i++;
    }
    //si hay elementos que no son letras, mostramos el error
    if($hayErrores){
      $errors['texto'] = 'Solo se permiten letras y espacios para la separación';
    }

  }

   return $errors;
}

//función que contabiliza la repetición de cada letra
function countLetters(string $data): array{
   //analizamos cuantas letras diferentes hay
  $differentLetters = count_chars(mb_strtolower($data),3);
  var_dump($differentLetters);
  //dividimos el string resultante en un array
  $array = mb_str_split($differentLetters);
  var_dump($array);
  //recorremos ambos array contabilizando repeticiones
  for($i= 0; $i<count($array); $i++){
      $count = 0;
    for($j=0; $j<mb_strlen($data); $j++){
      if($array[$i]===$data[$j]){
      $count++;
     }
    }
    $arrayAsociativo[$array[$i]] = $count;
  }
  return $arrayAsociativo;
}




/*
* Llamamos a las vistas
*/
include 'views/templates/header.php';
include 'views/iterativas04.view.php';
include 'views/templates/footer.php';