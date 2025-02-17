<?php

declare(strict_types=1);

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\ProveedoresController;
use Com\Daw2\Controllers\ErroresController;
use Com\Daw2\Controllers\InicioController;

use Com\Daw2\Models\UsuarioModel;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        Route::add(
            '/',
            function () {
                $controlador = new InicioController();
                $controlador->index();
            },
            'get'
        );
        Route::add(
            '/proveedores',
            function () {
                $controlador = new ProveedoresController();
                //$controlador->listarProveedoresAll();
                $controlador->listarProveedoresFiltrados();
            },
            'get'
        );
        Route::add(
            '/proveedores/view/(\p{L}[0-9]{7,8}[\p{L}]*)',
            function ($cif) {
                $controlador = new ProveedoresController();
                $controlador->getProveedor($cif);
            },
            'get'
        );
        Route::add(
            '/proveedores/add',
            function () {
                $controlador = new ProveedoresController();
                $controlador->showAddProveedor();
            },
            'get'
        );
        Route::add(
            '/proveedores/add',
            function () {
                $controlador = new ProveedoresController();
                $controlador->doAddProveedor();
            },
            'post'
        );
        Route::add(
            '/proveedores/edit/(\p{L}[0-9]{7,8}[\p{L}]*)',
            function ($cif) {
                $controlador = new ProveedoresController();
                $controlador->showEditProveedor($cif);
            },
            'get'
        );
        Route::add(
            '/proveedores/edit/(\p{L}[0-9]{7,8}[\p{L}]*)',
            function ($cif) {
                $controlador = new ProveedoresController();
                $controlador->doEditProveedor($cif);
            },
            'post'
        );
        Route::add(
            '/proveedores/delete/(\p{L}[0-9]{7,8}[\p{L}]*)',
            function ($cif) {
                $controlador = new ProveedoresController();
                $controlador->deleteProveedor($cif);
            },
            'get'
        );

        Route::pathNotFound(
            function () {
                $controller = new ErroresController();
                $controller->error404();
            }
        );

        Route::methodNotAllowed(
            function () {
                $controller = new ErroresController();
                $controller->error405();
            }
        );

        Route::run();
    }
}
