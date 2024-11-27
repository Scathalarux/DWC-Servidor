<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ProductoModel;

class ProductosController extends BaseController
{
    public function showProducts(): void
    {
        $data = [
          'titulo' => 'Productos',
            'breadcrumb' => ['Inicio','Productos']
        ];
        $modelo = new ProductoModel();
        $productos = $modelo->getProducts();
        $data['productos'] = $productos;

        $this->view->showViews(array('templates/header.view.php', 'productos.view.php', 'templates/footer.view.php'), $data);
    }
}
