<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Mensaje;
use Com\Daw2\Models\AuxCountryModel;
use Com\Daw2\Models\ProveedoresModel;

class ProveedoresController extends BaseController
{
    public function listarProveedoresAll(): void
    {
        $data = [
            'titulo' => 'Proveedores',
            'breadcrumb' => ['Inicio', 'Listado Proveedores'],
        ];
        $proveedoresModel = new ProveedoresModel();

        $data['proveedores'] = $proveedoresModel->getAll();

        $this->view->showViews(array('templates/header.view.php', 'proveedores.view.php', 'templates/footer.view.php'), $data);
    }

    public function listarProveedoresFiltrados(): void
    {
        $data = [
            'titulo' => 'Proveedores',
            'breadcrumb' => ['Inicio', 'Listado Proveedores'],
        ];
        $proveedoresModel = new ProveedoresModel();

        $resultado = $proveedoresModel->getProveedoresFiltrados($_GET);

        $copiaGet = $_GET;
        unset($copiaGet['page']);

        $data['copiaPage'] = http_build_query($copiaGet);
        if (!empty($data['copiaPage'])) {
            $data['copiaPage'] .= '&';
        }

        unset($copiaGet['order']);

        $data['copiaPageOrder'] = http_build_query($copiaGet);
        if (!empty($data['copiaPageOrder'])) {
            $data['copiaPageOrder'] .= '&';
        }

        $data['proveedores'] = $resultado['proveedores'];
        $data['maxPage'] = $resultado['maxPage'];
        $data['page'] = $resultado['page'];
        $data['order'] = $resultado['order'];

        $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //paises
        $data['paises'] = $proveedoresModel->getPaises();

        $this->view->showViews(array('templates/header.view.php', 'proveedores.view.php', 'templates/footer.view.php'), $data);

    }

    public function getProveedor(string $cif): void
    {
        $modelProveedor = new ProveedoresModel();
        $proveedor = $modelProveedor->getProveedor($cif);
        if ($proveedor !== false) {
            $data['input'] = $proveedor;
        } else {
            header('Location: /proveedores)');
        }
        $this->view->showViews(array('templates/header.view.php', 'edit.view.php', 'templates/footer.view.php'), $data);
    }

    public function showAddProveedor(array $errores = [], array $input = []): void
    {
        $data = [
            'titulo' => 'Agregar Proveedor',
            'breadcrumb' => ['Inicio', 'Agregar Proveedor'],
        ];

        $data['errores'] = $errores;
        $data['input'] = $input;

        $this->view->showViews(array('templates/header.view.php', 'editProveedores.view.php', 'templates/footer.view.php'), $data);
    }

    public function doAddProveedor()
    {
        $errores = $this->checkForm($_POST);
        if ($errores === []) {
            $insertData = $_POST;
            $proveedorModel = new ProveedoresModel();
            $proveedor = $proveedorModel->addProveedor($insertData);
            if ($proveedor !== false) {
                $mensaje = new Mensaje('Proveedor añadido', Mensaje::SUCCESS, 'Éxito');
            } else {
                $mensaje = new Mensaje('Proveedor no añadido', Mensaje::ERROR, 'Error');
            }
            $this->addFlashMessage($mensaje);
            header('Location: /proveedores)');
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showAddProveedor($errores, $input);
        }
    }

    public function checkForm(array $data): array
    {
        $errores = [];

        //cif

        //codigo

        //nombre

        //direccion

        //website

        //pais

        //email

        //telefono

        return $errores;
    }

    public function showEditProveedor($cif, array $errores = [], array $input = []): void
    {
        $data = [
            'titulo' => 'Editar Proveedor',
            'breadcrumb' => ['Inicio', 'Editar Proveedor'],
        ];
        $proveedorModel = new ProveedoresModel();
        $proveedor = $proveedorModel->getProveedor($cif);

        $data['errores'] = $errores;
        $data['input'] = empty($input) ? $proveedor : $input;

        $this->view->showViews(array('templates/header.view.php', 'editProveedores.view.php', 'templates/footer.view.php'), $data);
    }

    public function doEditProveedor($cif)
    {
        $errores = $this->checkForm($_POST);
        if ($errores === []) {
            $insertData = $_POST;
            //comprobar datos
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showEditProveedor($cif, $errores, $input);
        }
    }

    public function deleteProveedor($cif)
    {
        $modelProveedor = new ProveedoresModel();
        $proveedor = $modelProveedor->getProveedor($cif);
        if ($proveedor === false) {
            $mensaje = new Mensaje('No se ha podido borrar el proveedor', Mensaje::ERROR, 'Error');
        } else {
            if ($modelProveedor->deleteProveedor($cif)) {
                $mensaje = new Mensaje('Proveedor borrado', Mensaje::SUCCESS, 'Éxito');
            } else {
                $mensaje = new Mensaje('No se ha podido borrar el proveedor', Mensaje::ERROR, 'Error');
            }
        }

        $this->addFlashMessage($mensaje);
        header('Location: /proveedores)');
    }


}