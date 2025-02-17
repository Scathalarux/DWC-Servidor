<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
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
        if(!empty($data['copiaPage'])){
            $data['copiaPage'].='&';
        }

        unset($copiaGet['order']);

        $data['copiaPageOrder'] = http_build_query($copiaGet);
        if(!empty($data['copiaPageOrder'])){
            $data['copiaPageOrder'].='&';
        }

        $data['proveedores'] = $resultado['proveedores'];
        $data['maxPage'] = $resultado['maxPage'];
        $data['page'] = $resultado['page'];
        $data['order'] = $resultado['order'];

        $this->view->showViews(array('templates/header.view.php', 'proveedores.view.php', 'templates/footer.view.php'), $data);

    }

    public function getProveedor(string $cif):void
    {
        $modelProveedor = new ProveedoresModel();
        $proveedor = $modelProveedor->getProveedor($cif);
        if($proveedor !==false){
            $data['input']= $proveedor;
        }else{
            header('Location: /proveedores)');
        }
        $this->view->showViews(array('templates/header.view.php', 'edit.view.php','templates/footer.view.php'), $data);
    }


}