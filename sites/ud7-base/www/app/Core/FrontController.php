<?php

namespace Com\Daw2\Core;

use Ahc\Jwt\JWT;
use Ahc\Jwt\JWTException;
use Com\Daw2\Controllers\CategoriaController;
use Com\Daw2\Controllers\ErrorController;
use Com\Daw2\Controllers\LoginController;
use Com\Daw2\Controllers\ProductoController;
use Com\Daw2\Helpers\JwtTool;
use Steampixel\Route;

class FrontController
{
    private static ?array $jwtData = null;
    private static array $permisos = [];

    public static function main()
    {

        //comprobamos si en la cabecera tenemos un token del usuario
        if (JwtTool::requestHasToken()) {
            //manejamos la posibilidad de que el token esté caducado o sea NO válido
            try {
                $bearer = JwtTool::getBearerToken();
                $jwt = new JWT($_ENV['secret']);
                //si hay manipulación de token o ha caducado, nos salta una excepción
                self::$jwtData = $jwt->decode($bearer);
                self::$permisos = LoginController::getPermisos(self::$jwtData['id_rol']);
                /**
                 * Con servidor apache podríamos usar esto y procesar
                 * $headers2 = getallheaders();
                 * $jwt2 = explode(" ", $headers2['Authorization'])[1];
                 * $decode2 = $jwt->decode($jwt2);
                 * */
            } catch (JWTException $e) {
                $controller = new ErrorController();
                $controller->errorWithBody(403, ['mensaje' => $e->getMessage()]);
                //para que finalice la ejecución
                die;
            }
        }else{
            self::$permisos = LoginController::getPermisos();
        }

        Route::add(
            '/login',
            fn() => (new LoginController())->login(),
            'post'
        );

        //Solo los usuarios logeados tienen acceso
        //Obtenemos los permisos de los usuarios según el rol que tengan

        Route::add(
            '/categoria',
            function () {
                if (str_contains(self::$permisos['categoriaController'], 'r')) {
                    (new CategoriaController())->listCategorias();
                } else {
                    http_response_code(403);
                }
            }, 'get'
        );
        Route::add(
            '/categoria/(\p{N}+)',
            function ($id) {
                if (str_contains(self::$permisos['categoriaController'], 'r')) {
                    (new CategoriaController())->get((int)$id);
                } else {
                    http_response_code(403);
                }
            },
            'get'
        );


        Route::add(
            '/categoria',
            function () {
                if (str_contains(self::$permisos['categoriaController'], 'w')) {
                    (new CategoriaController())->addCategoria();
                } else {
                    http_response_code(403);
                }
            },
            'post'
        );

        Route::add(
            '/categoria/(\p{N}+)',
            function ($id) {
                if (str_contains(self::$permisos['categoriaController'], 'w')) {
                    (new CategoriaController())->updateCategoria((int)$id);
                } else {
                    http_response_code(403);
                }
            },'put'
        );


        Route::add(
            '/categoria/(\p{N}+)',
            function ($id) {
                if (str_contains(self::$permisos['categoriaController'], 'd')) {
                    (new CategoriaController())->deleteCategoria((int)$id);
                } else {
                    http_response_code(403);
                }
            },
            'delete'
        );


        /**
         *
         *  PRODUCTOS - REPASO EXAMEN
         *
         */
        Route::add(
            '/producto',
            fn() => (new ProductoController())->listProductosFiltrados()
            /* alternativa para mostrar todos sin filtrar por ningún campo
             *
             * fn() => (new ProductoController())->listProductos()*/,
            'get'
        );

        Route::add(
            '/producto/(\p{L}{2,3}\p{N}{7})',
            fn($codigo) => (new ProductoController())->getProducto($codigo),
            'get'
        );
        Route::add(
            '/producto',
            fn() => (new ProductoController())->addProducto(),
            'post'
        );





        Route::add(
            '/test',
            fn() => throw new \Exception(),
            'get'
        );

        Route::pathNotFound(
            function ()
            {
                http_response_code(404);
            }
        );

        Route::methodNotAllowed(
            function ()
            {
                http_response_code(405);
            }
        );

        Route::run();
    }

}





