<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseDbModel;
use Com\Daw2\Models\CategoriaModel;
use Com\Daw2\Models\ProductosModel;
use Com\Daw2\Models\ProveedorModel;

class ProductosController extends BaseDbModel
{
    public function doFilteredProducts(): void
    {
        $data = $this->getCommonData();
        $data += [
          'titulo' => 'Productos',
          'breadcrumb' => ['Inicio','Productos']
        ];

        $modeloProducto = new ProductosModel();

        $productos = $modeloProducto->getAllProducts();
        $data['productos'] = $productos;
        $this->view->showViews(array('templates/header.view.php', 'productos.view.php', 'templates/footer.view.php'), $data);
    }
    public function getCommonData(): array
    {
        $data = [];
        $modeloCategoria = new CategoriaModel();
        $modeloProveedor = new ProveedorModel();

        $data['categorias'] = $modeloProveedor->getAll();
        $data['proveedores'] = $modeloCategoria->getAll();
        return $data;
    }
}
