<?php
use \TestClasses\Daw2\Clases\Categoria;
use \TestClasses\Daw2\Clases\Proveedor;
use \TestClasses\Daw2\Clases\Producto;

require 'vendor/autoload.php';

$electronica = new Categoria("Electrónica");
$consolas = new Categoria("Consolas", $electronica);
$microsoft = new Categoria("Microsoft", $consolas);
$seriesX= new Categoria("Series X", $microsoft);
echo $seriesX->getFullName();

$proveedor = new Proveedor("A20424511", "123","miEmpresita",null, null, null, null, null);
echo '<br/> Nombre empresa: '.$proveedor->getNombre();

$producto = new Producto("1234","productoPrueba", "Producto para probar funcionamiento",$proveedor, $seriesX, 40, 20, 100, 4);
echo '<br/>Producto - Precio venta: '.$producto->getPrecioVenta(true).'€';
die();
