<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\CentrosController;
use Com\Daw2\Controllers\InicioController;
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
            '/centros',
            function () {
                (new CentrosController())->listadoConFiltros();
            },
            'get'
        );
        Route::add(
            '/centros/delete/(\d{8})',
            function ($codigo) {
                (new CentrosController())->delete((int) $codigo);
            },
            'get'
        );


        Route::pathNotFound(
            function () {

            }
        );

        Route::methodNotAllowed(
            function () {

            }
        );

        Route::run();
    }
}
