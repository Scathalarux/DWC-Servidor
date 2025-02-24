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
            if (str_contains($_SESSION['permisos']['usuariosSistema'], 'r') !== false) {
                Route::add(
                    '/usuarios-sistema',
                    function () {
                        $controlador = new UsusariosSistemaController();
                        $controlador->listar();
                    },
                    'get'
                );
                Route::add(
                    '/usuarios-sistema/view/([0-9]{1,})',
                    function ($idUsuario) {
                        $controlador = new UsusariosSistemaController();
                        $controlador->getUsuario((int)$idUsuario);
                    },
                    'get'
                );

            }
            if (str_contains($_SESSION['permisos']['usuariosSistema'], 'w') !== false) {
                Route::add(
                    '/usuarios-sistema/add',
                    function () {
                        $controlador = new UsusariosSistemaController();
                        $controlador->showAddUsuario();
                    },
                    'get'
                );
                Route::add(
                    '/usuarios-sistema/add',
                    function () {
                        $controlador = new UsusariosSistemaController();
                        $controlador->doAddUsuario();
                    },
                    'post'
                );
                Route::add(
                    '/usuarios-sistema/edit/([0-9]{1,})',
                    function ($idUsuario) {
                        $controlador = new UsusariosSistemaController();
                        $controlador->showEditUsuario((int)$idUsuario);
                    },
                    'get'
                );
                Route::add(
                    '/usuarios-sistema/edit/([0-9]{1,})',
                    function ($idUsuario) {
                        $controlador = new UsusariosSistemaController();
                        $controlador->doEditUsuario((int)$idUsuario);
                    },
                    'post'
                );
                Route::add(
                    '/usuarios-sistema/baja/([0-9]{1,})',
                    function ($idUsuario) {
                        $controlador = new UsusariosSistemaController();
                        $controlador->changeBajaUsuario((int)$idUsuario);
                    },
                    'get'
                );
            }
            if (str_contains($_SESSION['permisos']['usuariosSistema'], 'd') !== false) {
                Route::add(
                    '/usuarios-sistema/delete/([0-9]{1,})',
                    function ($idUsuario) {
                        $controlador = new UsusariosSistemaController();
                        $controlador->deleteUsuario((int)$idUsuario);
                    },
                    'get'
                );
            }
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
