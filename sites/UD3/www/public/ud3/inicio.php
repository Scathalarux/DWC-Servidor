<?php
use \TestClasses\Daw2\Clases\Categoria;

require 'vendor/autoload.php';

$electronica = new Categoria("Electrónica");
$consolas = new Categoria("Consolas", $electronica);
$microsoft = new Categoria("Microsoft", $consolas);
$seriesX= new Categoria("Series X", $microsoft);
echo $seriesX->getFullName();
die();
