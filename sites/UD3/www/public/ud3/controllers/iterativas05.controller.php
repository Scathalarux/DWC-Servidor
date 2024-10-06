<?php
declare(strict_types=1);

//Comprobamos el envío de datos
if(!empty($_POST)) {
    //saneamos
    $data['input_texto']= filter_var($_POST['texto'], FILTER_SANITIZE_SPECIAL_CHARS);
    //validamos el formulario
    $errors = checkForm($_POST['texto']);


    //Si hay o no errores
    if(count($errors)>0) {
        //mostramos los errores que haya
        $data['errors'] = $errors;
    }else{
    //Procesamiento

        $data['contador_ordenado'] = countWords($_POST['texto']);

    }
}

//Función que comprueba los errores
function checkForm(string $texto) : array{
    $errors = [];

    //no se introducen valores
    if(empty($texto)){
        $errors['texto'] = 'Inserte el texto en este campo';
    }
    return $errors;
}

//función que contabiliza la repetición de palabras
function countWords(string $texto) : array{
  // "/[^\p{L}]+/u"    es igual a     "/[\P{L}]/u"
  $textoLimpio = trim(preg_replace( "/[^\p{L}]+/u", ' ', $texto));
  $words = preg_split('/[\s]+/u',mb_strtolower($textoLimpio));
//    var_dump($words);
  //recorremos ambos array contabilizando repeticiones
  for($i= 0; $i<count($words); $i++){
    $count = 0;
    for($j=0; $j<count($words); $j++){
      if($words[$i]==$words[$j]){
        $count++;
      }
    }
    $arrayAsociativo[$words[$i]] = $count;
  }

  arsort($arrayAsociativo);
//    var_dump($arrayAsociativo);
  return $arrayAsociativo;
}


/*
* Llamamos a las vistas
*/
include 'views/templates/header.php';
include 'views/iterativas05.view.php';
include 'views/templates/footer.php';