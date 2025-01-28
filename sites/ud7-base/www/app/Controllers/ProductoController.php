<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\ProductosModel;

class ProductoController extends BaseController
{
    public function listProductos(): void
    {
        $modeloProductos = new ProductosModel();
        $productos = $modeloProductos->getAll();
        if (is_array($productos)) {
            $respuesta = new Respuesta(200, $productos);
        }
        //El error 500 ya se procesa por otr lado

        $this->view->show('jsonProductos.view.php', ['respuesta' => $respuesta]);
    }

    public function listProductosFiltrados(): void
    {
        $modeloProductos = new ProductosModel();
        $insertData = [];
        $productos = $modeloProductos->getFiltered($_GET);
        if (is_array($productos)) {
            $respuesta = new Respuesta(200, $productos);
        }

        $this->view->show('jsonProductos.view.php', ['respuesta' => $respuesta]);
    }

    public function getProducto(string $codigo): void
    {

        $modeloProductos = new ProductosModel();
        $producto = $modeloProductos->find($codigo);
        if (is_array($producto)) {
            $respuesta = new Respuesta(200, $producto);
        } else {
            $respuesta = new Respuesta(404, ['mensaje' => "No existe el producto"]);
        }

        $this->view->show('jsonProductos.view.php', ['respuesta' => $respuesta]);
    }

    public function addProducto(): void
    {
        $modeloProductos = new ProductosModel();
        /*        $producto =*/
    }

    public function editProducto(): void
    {

    }

    public function deleteProducto(): void
    {

    }
}
