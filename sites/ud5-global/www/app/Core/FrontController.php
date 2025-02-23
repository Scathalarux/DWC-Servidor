<?php

declare(strict_types=1);

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\LoginController;
use Com\Daw2\Controllers\ErroresController;
use Com\Daw2\Controllers\InicioController;

use Com\Daw2\Controllers\UsusariosSistemaController;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        session_start();

        if (isset($_SESSION['id_usuario'])) {
            Route::add(
                '/logout',
                function () {
                    $controlador = new LoginController();
                    $controlador->logout();
                },
                'get'
            );
            Route::add(
                '/',
                function () {
                    $controlador = new InicioController();
                    $controlador->index();
                },
                'get'
            );
            Route::add(
                '/usuarios-sistema',
                function () {
                    $controlador = new UsusariosSistemaController();
                    $controlador->listar();
                },
                'get'
            );
            Route::add(
                '/usuarios-sistema/add',
                function () {
                    $controlador = new UsusariosSistemaController();
                    $controlador->doAddUsuario();
                },
                'get'
            );
            Route::pathNotFound(
                function () {
                    $controller = new ErroresController();
                    $controller->error404();
                }
            );
        } else {
            Route::add(
                '/login',
                function () {
                    $controlador = new LoginController();
                    $controlador->showLogin();
                },
                'get'
            );
            Route::add(
                '/login',
                function () {
                    $controlador = new LoginController();
                    $controlador->doLogin();
                },
                'post'
            );
            Route::pathNotFound(
                function () {
                    header("Location: /login");
                }
            );
        }


        Route::methodNotAllowed(
            function () {
                $controller = new ErroresController();
                $controller->error405();
            }
        );

        Route::run();
    }
}
