<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CategoriaModel;
use Com\Daw2\Models\ProductosModel;
use Com\Daw2\Models\ProveedorModel;

class ProductosController extends BaseController
{


    public const DEFAULT_ORDER = 1;
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

        $data['proveedores'] = $modeloProveedor->getAll();
        $data['categorias'] = $modeloCategoria->getAll();
        return $data;
    }

    public function getOrder(): int
    {
        if (!empty($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) < count(ProductosModel::ORDER_COLUMNS)) {
                return (int)$_GET['order'];
            }
        }
        return self::DEFAULT_ORDER;
    }

    public function getPage(): int
    {
    }
}
