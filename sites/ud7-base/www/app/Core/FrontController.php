<?php

namespace Com\Daw2\Core;

use Ahc\Jwt\JWT;
use Com\Daw2\Controllers\CategoriaController;
use Com\Daw2\Controllers\LoginController;
use Com\Daw2\Helpers\JwtTool;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        //comprobamos si en la cabecera tenemos un token del usuario
        if (JwtTool::requestHasToken()) {
            $bearer = JwtTool::getBearerToken();
            $jwt = new JWT($_ENV['secret']);
            //si hay manipulación de token o ha caducado, nos salta una excepción
            $decoded = $jwt->decode($bearer);
            /**
             * Con servidor apache podríamos usar esto y procesar
             * $headers2 = getallheaders();
             * $jwt2 = explode(" ", $headers2['Authorization'])[1];
             * $decode2 = $jwt->decode($jwt2);
             * */
        }


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
            function () {
                if (isset($decoded)) {
                    (new CategoriaController())->addCategoria();
                } else {
                    http_response_code(403);
                }
            }
            , 'post'
        );
        Route::add(
            '/login',
            fn() => (new LoginController())->login(),
            'post'
        );
        //Solo los usuarios logeados tienen acceso

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

        Route::add(
            '/test',
            fn() => throw new \Exception(),
            'get'
        );

        Route::pathNotFound(
            function () {
                http_response_code(404);
            }
        );

        Route::methodNotAllowed(
            function () {
                http_response_code(405);
            }
        );

        Route::run();
    }
}
