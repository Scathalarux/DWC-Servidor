<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\ErroresController;
use Com\Daw2\Controllers\InicioController;
use Com\Daw2\Controllers\ProveedorController;
use Steampixel\Route;

class FrontController
{
    public static function main(): void
    {
        session_start();
        Route::add(
            '/',
            function () {
                $controlador = new InicioController();
                $controlador->index();
            },
            'get'
        );

        Route::add(
            '/demo-proveedores',
            function () {
                $controlador = new InicioController();
                $controlador->demo();
            },
            'get'
        );
        Route::add(
            '/proveedores',
            function () {
                $controlador = new ProveedorController();
                $controlador->doFilteredProveedores();
            },
            'get'
        );
        Route::add(
            '/proveedores/delete/([\p{N}]{1,3})',
            function ($idProveedor) {
                $controlador = new ProveedorController();
                $controlador->doDeleteProveedor($idProveedor);
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
        Route::run($_ENV['host.folder']);
    }
}
