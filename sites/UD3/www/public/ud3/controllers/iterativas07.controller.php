<!--función http_build_query-->

<?php
//declare(strict_types=1);
//var_dump(mb_internal_encoding());
//función http_build_query

if(isset($_GET['carton'])){
  echo 'El cartón recibido es: ';
  var_dump($_GET);
  $carton = $_GET['carton'];
  $bolas = $_GET['bolas'];

  //saneamos
  $data['input_carton']=filter_var($_GET['carton'], FILTER_SANITIZE_SPECIAL_CHARS);

}else{
  $bolas = [];
  $carton = [rand(1,90),rand(1,90),rand(1,90),rand(1,90),rand(1,90),rand(1,90),rand(1,90)];
}
//generamos los números de las bolas, sin repetirse
$bolaValida = true;

do{
  $nuevaBola= rand(1,90);
for($i = 0; $i < count($bolas); $i++){
  if($bolas[$i] === $nuevaBola){
      $bolaValida = false;
  }
}
//si no ha habido coincidencias con los números que ya salieron, metemos el número en el array
if($bolaValida){
    $bolas[] = $nuevaBola;
}
}while($bolaValida);


$data = [
  'carton' => implode(',',$carton),
  'bolas' => implode(',',$bolas)
];


/*
* Llamamos a las vistas
*/
include 'views/templates/header.php';
include 'views/iterativas07.view.php';
include 'views/templates/footer.php';
?>

<a href="?sec=test&<?php echo http_build_query($data)?>"></a>
