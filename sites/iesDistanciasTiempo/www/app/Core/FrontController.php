<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\CentrosController;
use Com\Daw2\Controllers\ErroresController;
use Com\Daw2\Controllers\InicioController;
use Com\Daw2\Controllers\LoginController;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        session_start();

        //Nos aseguramos de que solo si hay algún usuario almacenado en sesión, se puedan acceder a los diferentes contenidos de la app
        if (isset($_SESSION['nombre'])) {
            Route::add(
                '/',
                function () {
                    $controlador = new InicioController();
                    $controlador->index();
                },
                'get'
            );
            Route::add(
                '/logout',
                function () {
                    (new LoginController())->logout();
                },
                'get'
            );
            /* Listar, añadir, borrar y editar centros educativos BBDD*/

            if (str_contains($_SESSION['permisos']['centrosController'], 'r')) {
                Route::add(
                    '/centros',
                    function () {
                        (new CentrosController())->listadoConFiltros();
                    },
                    'get'
                );
                Route::add(
                    '/centros/view/(\d{8})',
                    function ($codigo) {
                        (new CentrosController())->showCentro((int)$codigo);
                    },
                    'get'
                );
            }
            if (str_contains($_SESSION['permisos']['centrosController'], 'w')) {
                Route::add(
                    '/centros/new',
                    function () {
                        (new CentrosController())->showAdd();
                    },
                    'get'
                );
                Route::add(
                    '/centros/new',
                    function () {
                        (new CentrosController())->doAdd();
                    },
                    'post'
                );
                Route::add(
                    '/centros/edit/(\d{8})',
                    function ($codigo) {
                        (new CentrosController())->showEditar((int)$codigo);
                    },
                    'get'
                );
                Route::add(
                    '/centros/edit/(\d{8})',
                    function ($codigo) {
                        (new CentrosController())->doEditar((int)$codigo);
                    },
                    'post'
                );
            }

            if (str_contains($_SESSION['permisos']['centrosController'], 'd')) {
                Route::add(
                    '/centros/delete/(\d{8})',
                    function ($codigo) {
                        (new CentrosController())->delete((int)$codigo);
                    },
                    'get'
                );
            }

            Route::pathNotFound(
                function () {
                    (new ErroresController())->error404();
                }
            );

        } else {
            Route::add(
                '/login',
                function () {
                    (new LoginController())->showLogin();
                },
                'get'
            );
            Route::add(
                '/login',
                function () {
                    (new LoginController())->doLogin();
                },
                'post'
            );
            Route::add(
                '/register',
                function () {
                    (new LoginController())->showRegister();
                },
                'get'
            );
            Route::add(
                '/register',
                function () {
                    (new LoginController())->doRegister();
                },
                'post'
            );
            Route::pathNotFound(
                function () {
                    header('Location: /login');
                }
            );
        }




        Route::methodNotAllowed(
            function () {
                (new ErroresController())->error405();
            }
        );

        Route::run();
    }
}
