<?php

namespace Com\Daw2\Core;

use Ahc\Jwt\JWT;
use Com\Daw2\Controllers\CategoriaController;
use Com\Daw2\Controllers\LoginController;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        //comprobamos si en la cabecera tenemos un token del usuario
        $user=JWT::getBearerUser();
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
            '/login',
            fn() => (new LoginController())->login(),
            'post'
        );
        //Solo los usuarios logeados tienen acceso
        if(!is_null($user)){
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
                fn($id) => (new CategoriaController())->updateCategoria((int)$id),
                'put'
            );
        }

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
