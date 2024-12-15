<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Mensaje;
use Com\Daw2\Models\AuxContinenteModel;
use Com\Daw2\Models\AuxTipoProveedor;
use Com\Daw2\Models\ProveedorModel;

class ProveedorController extends BaseController
{
    public const DEFAULT_ORDER = 1;
    public const DEFAULT_PAGE = 1;

    public const DEFAULT_SIZE_PAGE = 25;

    public function doFilteredProveedores(): void
    {
        $data = $this->getCommonData();

        $data += [
            'titulo' => 'Proveedores',
            'breadcrumb' => ['Inicio', 'Proveedores'],
        ];

        $modeloProveedor = new ProveedorModel();
        //obtenemos validado el order
        $order = $this->getOrder();
        //obtenemos el número máximo de páginas que se mostrarán con los filtros introducidos
        $maxPage = $modeloProveedor->getMaxPages($_GET, self::DEFAULT_SIZE_PAGE);
        //obtenemos la página
        $page = $this->getPage($maxPage);


        /*$proveedores = $modeloProveedor->getFilteredProveedores($_GET, $order);*/

        //para poder mantener los filtros con la ordenación
        $copiaGet = $_GET;
        //modificamos los datos de get para poder obtener los datos sin la paginación
        unset($copiaGet['page']);
        $data['copiaGetPage'] = http_build_query($copiaGet);
        if (!empty($data['copiaGetPage'])) {
            $data['copiaGetPage'] .= '&';
        }
        //modificamos los datos de get para poder obtener los datos sin la paginación ni la ordenación
        unset($copiaGet['order']);
        $data['copiaGet'] = http_build_query($copiaGet);
        if (!empty($data['copiaGet'])) {
            $data['copiaGet'] .= '&';
        }

        //obtenemos los datos de los proveedores de forma paginada según los datos de paginación default
        $proveedores = $modeloProveedor->getFilteredPageProveedores($_GET, $order, self::DEFAULT_SIZE_PAGE, $page);

        $data['proveedores'] = $proveedores;
        $data['order'] = $order;
        $data['page'] = $page;
        $data['maxPage'] = $maxPage;

        $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $this->view->showViews(array('templates/header.view.php', 'proveedor.view.php', 'templates/footer.view.php'), $data);
    }

    public function getCommonData()
    {
        $modeloAuxContinente = new AuxContinenteModel();
        $modeloAuxTipoProveedor = new AuxTipoProveedor();

        $data['continentes'] = $modeloAuxContinente->getAll();
        $data['tiposProveedores'] = $modeloAuxTipoProveedor->getAll();

        return $data;
    }

    public function getOrder(): int
    {
        if (!empty($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) <= count(ProveedorModel::COLUMNS_ORDER)) {
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

    public function doDeleteProveedor(int $idProveedor): void
    {
        $modeloProveedor = new ProveedorModel();
        $proveedor = $modeloProveedor->getProveedorId($idProveedor);
        if ($proveedor === false) {
            $mensaje = new Mensaje("No se puede borrar el proveedor seleccionado", "warning", "Error");
            $this->addFlashMessage($mensaje);
            header('Location: /proveedores');
        } else {
            if ($modeloProveedor->deleteProveedor($idProveedor)) {
                $mensaje = new Mensaje("Operación realizada con éxito", "success", "Éxito");
                $this->addFlashMessage($mensaje);
            } else {
                $mensaje = new Mensaje("No se puede borrar el proveedor seleccionado", "warning", "Error");
                $this->addFlashMessage($mensaje);
            }
            header('Location: /proveedores');
        }
    }
}
