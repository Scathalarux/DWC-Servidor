<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CentrosModel;
use Com\Daw2\Models\CiclosModel;

class CentrosController extends BaseController
{

    private const DEFAULT_ORDER = 1;
    private const DEFAULT_PAGE = 1;

    private const DEFAULT_SIZE_PAGE = 20;

    public function listadoConFiltros(): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Listado de Centros',
            'breadcrumb' => ['Inicio', 'Listado de Centros'],
        ];

        $centrosModel = new CentrosModel();

        $copiaGet = $_GET;
        //mantenemos los filtros sin la pagina
        unset($copiaGet['page']);
        $data['copiaGetPage'] = http_build_query($copiaGet);
        if (!empty($data['copiaGetPage'])) {
            $data['copiaGetPage'] .= '&';
        }

        //mentenemos los filtros sin la pagina ni la ordenación
        unset($copiaGet['order']);
        $data['copiaGetOrder'] = http_build_query($copiaGet);
        if (!empty($data['copiaGetOrder'])) {
            $data['copiaGetOrder'] .= '&';
        }


        $order = $this->getOrder();
        $maxPage = $centrosModel->getMaxPage($_GET, self::DEFAULT_SIZE_PAGE);
        $page = $this->getPage($maxPage);

        $centros = $centrosModel->getCentros($_GET, $order, $page, self::DEFAULT_SIZE_PAGE);

        $data['centros'] = $centros;
        $data['order'] = $order;
        $data['maxPage'] = $maxPage;
        $data['page'] = $page;
        $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $this->view->showViews(array('templates/header.view.php', 'centros.view.php', 'templates/footer.view.php'), $data);
    }

    public function getCommonData(): array
    {
        $data = [];

        $ciclosModel = new CiclosModel();
        $data['ciclos'] = $ciclosModel->getAll();

        return $data;
    }

    public function getOrder(): int
    {
        if (isset($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) <= count(CentrosModel::ORDER_COLUMNS)) {
                return (int)$_GET['order'];
            }

        }
        return self::DEFAULT_ORDER;
    }

    public function getPage(int $maxPage): int
    {
        if (isset($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
            if ((int)$_GET['page'] > 0 && (int)$_GET['page'] <= $maxPage) {
                return (int)$_GET['page'];
            }

        }
        return self::DEFAULT_PAGE;
    }

}