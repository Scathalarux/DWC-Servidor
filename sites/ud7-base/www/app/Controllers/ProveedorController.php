<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\ProveedorModel;

class ProveedorController extends BaseController
{
    private const SIZE_PAGE = 25;
    private const DEFAULT_PAGE = 1;

    private const DEFAULT_ORDER = 1;
    public function login(): void
    {
    }

    public function listarProveedor(): void
    {
        $modelProveedor = new ProveedorModel();
        //obtención del campo para la ordenación
        $order = $this->getOrder();

        //obtención de a página máxima que se puede alcanzar
        $maxPage = $modelProveedor->getMaxPage($_GET, self::SIZE_PAGE);
        //obtención de la página de la que se quieren mostrar los resultados
        $page = $this->getPage($maxPage);

        $proveedores = $modelProveedor->listProveedoresFiltered($_GET, $order, $page, $maxPage);

        if($proveedores === false){
            $respuesta = new Respuesta(400, ['mensaje'=>'ne se han podido encontrar proveedores con esas características']);
        }else{
            $respuesta = new Respuesta(200, $proveedores);
        }



        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);
    }

    public function getOrder(): int
    {
        if (isset($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && (abs((int)$_GET['order'])) <= ProveedorModel::COLUMNS_ORDER) {
                return (int)$_GET['order'];
            }
        }

        return self::DEFAULT_ORDER;
    }

    public function getPage($maxPage): int
    {
        if (isset($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
            if ((int)$_GET['pge'] > 0 && (int)$_GET['order'] <= $maxPage) {
                return (int)$_GET['page'];
            }
        }

        return self::DEFAULT_PAGE;
    }

    public function getProveedor(string $cif): void
    {
    }

    public function addProveedor(): void
    {
    }

    public function deleteProveedor(string $cif): void
    {
    }

    public function editProveedor(string $cif): void
    {
    }
}
