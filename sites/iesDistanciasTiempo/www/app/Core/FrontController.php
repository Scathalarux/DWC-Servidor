<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\CentrosController;
use Com\Daw2\Controllers\ErroresController;
use Com\Daw2\Controllers\InicioController;
use Steampixel\Route;

class FrontController
{
    public static function main()
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
            '/centros',
            function () {
                (new CentrosController())->listadoConFiltros();
            },
            'get'
        );
        Route::add(
            '/centros/(\d{8})',
            function ($codigo) {
                (new CentrosController())->verMas((int)$codigo);
            },
            'get'
        );
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
        Route::add(
            '/centros/view/(\d{8})',
            function ($codigo) {
                (new CentrosController())->showCentro((int)$codigo);
            },
            'get'
        );
        Route::add(
            '/centros/delete/(\d{8})',
            function ($codigo) {
                (new CentrosController())->delete((int)$codigo);
            },
            'get'
        );


        Route::pathNotFound(
            function () {
                (new ErroresController())->error404();
            }
        );

        Route::methodNotAllowed(
            function () {
                (new ErroresController())->error405();
            }
        );

        Route::run();
    }
}
