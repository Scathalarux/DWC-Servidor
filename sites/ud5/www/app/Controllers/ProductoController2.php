<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CategoriaModel2;
use Com\Daw2\Models\ProductoModel2;
use Com\Daw2\Models\ProveedorModel2;

class ProductoController2 extends BaseController
{
    public const DEFAULT_ORDER = 1;
    public bool $addedColumn = false;

    public function addColumn(): void
    {
        $modelo = new ProductoModel2();
        $modelo->addColumn();
        $addedColumn = true;
    }
    public function doFilteredProductos(): void
    {
        $data = $this->getCommonData();
        $data += [
          'titulo' => 'Productos',
          'breadcrumb' => ['Inicio', 'Productos']
        ];

        if (!$this->addedColumn) {
            $this->addColumn();
        }
        $modelo = new ProductoModel2();

        $productos = $modelo->getProductos();

        $data['productos'] = $productos;

        $this->view->showViews(array('templates/header.view.php', 'productos2.view.php', 'templates/footer.view.php'), $data);
    }

    public function getCommonData(): array
    {
        $data = [];
        $modeloCategoria = new CategoriaModel2();
        $modeloProveedor = new ProveedorModel2();
        $data['categorias'] = $modeloCategoria->getAll();
        $data['proveedores'] = $modeloProveedor->getAll();
        return $data;
    }

    public function getOrder(): int
    {
        if (!empty($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) <= count(ProductoModel2::ORDER_COLUMNS)) {
                return $_GET['order'];
            }
        }
        return self::DEFAULT_ORDER;
    }
}
