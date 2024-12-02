<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ProductoModel;

class ProductosController extends BaseController
{
    public const DEFAULT_ORDER = 1;
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_SIZE_PAGE = 25;

    public function doFilteredProducts(): void
    {
        $data = [
          'titulo' => 'Productos',
            'breadcrumb' => ['Inicio','Productos']
        ];
        $modelo = new ProductoModel();
        $productos = $modelo->getFilteredProducts($_GET);

        //obtenermos la ordenacion
        $order = $this->getOrder();
        $data['order'] = $order;

        //Obtenemos el valor del número máximo de páginas que se podrán mostrar
        $data['maxPages'] = $modelo->getMaxPages($_GET, self::DEFAULT_SIZE_PAGE);

        //Obtenemos la página en la que está
        $page = $this->getPage($data['maxPages']);
        $data['page'] = $page;

        //mantenemos los filtros
        $copiaGet = $_GET;
        unset($copiaGet['page']);
        $data['copiaGetPage'] = http_build_query($copiaGet);
        if (!empty($data['copiaGetPage'])) {
            $data['copiaGetPage'] .= '&';
        }
        unset($copiaGet['order']);
        $data['copiaGet'] = http_build_query($copiaGet);
        if (!empty($data['copiaGet'])) {
            $data['copiaGet'] .= '&';
        }

        $data['productos'] = $productos;

        $this->view->showViews(array('templates/header.view.php', 'productos.view.php', 'templates/footer.view.php'), $data);
    }


    public function getOrder(): int
    {
        //comprobamos la ordenacion
        if (!empty($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) <= count(ProductoModel::COLUMNS_ORDER)) {
                return (int)$_GET['order'];
            }
        }
        return self::DEFAULT_ORDER;
    }

    public function getPage(int $maxPages): int
    {
        if (!empty($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
            if (((int)$_GET['page'] > 0) && ((int)$_GET['page'] <= $maxPages)) {
                return (int)$_GET['page'];
            }
        }
        return self::DEFAULT_PAGE;
    }
}
