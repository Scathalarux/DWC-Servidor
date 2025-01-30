<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
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


        $this->view->show();
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