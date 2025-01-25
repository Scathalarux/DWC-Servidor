<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxCountriesModel;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\UsuariosModel;

class UsuariosController extends BaseController
{
    private const DEFAULT_ORDER = 1;
    private const DEFAULT_PAGE = 1;
    private const DEFAULT_SIZE = 25;

    public function listarUsuarios(): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Usuarios',
            'breadcrumb' => ['Inicio', 'Usuarios'],
        ];

        $order = $this->getOrder();
        $model = new UsuariosModel();

        $copiaGet = $_GET;

        unset($copiaGet['page']);

        $data['copiaGetOrder'] = http_build_query($copiaGet);
        if (!empty($data['copiaGetOrder'])) {
            $data['copiaGetOrder'] .= '&';
        }

        unset($copiaGet['order']);
        $data['copiaGet'] = http_build_query($copiaGet);
        if (!empty($data['copiaGet'])) {
            $data['copiaGet'] .= '&';
        }


        $maxPage = $model->getMaxPage($_GET, self::DEFAULT_SIZE);
        $page = $this->getPage($maxPage);


        /*        $data['usuarios'] = $model->getUsuarios($_GET, $order);*/
        $data['usuarios'] = $model->getUsuariosPage($_GET, $order, self::DEFAULT_SIZE, $page);


        $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['order'] = $order;
        $data['maxPage'] = $maxPage;
        $data['page'] = $page;


        $this->view->showViews(array('templates/header.view.php', 'usuario.view.php', 'templates/footer.view.php'), $data);
    }

    public function getCommonData(): array
    {
        $data = [];
        $auxCountriesModel = new AuxCountriesModel();
        $auxRolModel = new AuxRolModel();

        $data['countries'] = $auxCountriesModel->getAll();
        $data['roles'] = $auxRolModel->getAll();

        return $data;
    }

    public function getOrder(): int
    {
        if (!empty($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) < count(UsuariosModel::ORDER_COLUMNS)) {
                return (int)$_GET['order'];
            }
        }

        return self::DEFAULT_ORDER;
    }

    public function getPage(int $maxPages): int
    {
        if (!empty($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
            if ((int)$_GET['page'] > 0 && (int)$_GET['page'] <= $maxPages) {
                return (int)$_GET['page'];
            }
        }

        return self::DEFAULT_PAGE;
    }

}