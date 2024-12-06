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


    public function doFilteredProductos(): void
    {
        $data = $this->getCommonData();
        $data += [
          'titulo' => 'Productos',
          'breadcrumb' => ['Inicio', 'Productos']
        ];


        $modelo = new ProductoModel2();
        /*$modelo->addColumn();*/

        $order = $this->getOrder();

        $productos = $modelo->getFilteredProductos($_GET, $order);

        //Mantenemos filtros y los transformamos, eliminando el orden
        $copiaGet = $_GET;
        unset($copiaGet['order']);
        $data['copiaGet'] = http_build_query($copiaGet);
        if (!empty($data['copiaGet'])) {
            $data['copiaGet'] .= '&';
        }


        $data['order'] = $order;
        $data['productos'] = $productos;
        $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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
                return (int)$_GET['order'];
            }
        }
        return self::DEFAULT_ORDER;
    }
}
