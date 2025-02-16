<?php

declare(strict_types=1);

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\CategoriasController;
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
            '/categorias',
            function () {
                $controlador = new CategoriasController();
                $controlador->listarCategorias();
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
