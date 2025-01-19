<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\CategoriaController;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        Route::add(
            '/categoria',
            fn() => (new CategoriaController())->listCategorias(),
            'get'
        );
        Route::add(
            '/categoria/(\p{N}+)',
            fn($id) => (new CategoriaController())->get((int)$id),
            'get'
        );
        Route::add(
            '/categoria',
            fn() => (new CategoriaController())->addCategoria(),
            'post'
        );
        Route::add(
            '/categoria/(\p{N}+)',
            fn($id) => (new CategoriaController())->deleteCategoria((int)$id),
            'delete'
        );
        Route::add(
            '/categoria/(\p{N}+)',
            fn($id) => (new CategoriaController())->get((int)$id),
            'put'
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
