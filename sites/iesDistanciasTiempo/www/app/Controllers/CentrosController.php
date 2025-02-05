<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CentrosModel;
use Com\Daw2\Models\CiclosModel;

class CentrosController extends BaseController
{
    private const DEFAULT_ORDER = 1;

    public function listadoConFiltros(): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Listado de Centros',
            'breadcrumb' => ['Inicio', 'Listado de Centros'],
        ];

        $centrosModel = new CentrosModel();

        $centros = $centrosModel->getCentros($_GET);

        $data['centros'] = $centros;
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
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) < count(CentrosModel::ORDER_COLUMNS)) {
                return (int)$_GET['order'];
            }

        }
        return self::DEFAULT_ORDER;
    }

}