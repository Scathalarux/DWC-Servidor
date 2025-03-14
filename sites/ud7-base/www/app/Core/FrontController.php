<?php

namespace Com\Daw2\Core;

use Ahc\Jwt\JWT;
use Ahc\Jwt\JWTException;
use Com\Daw2\Controllers\CategoriaController;
use Com\Daw2\Controllers\ErrorController;
use Com\Daw2\Controllers\LoginController;
use Com\Daw2\Controllers\LoginController2;
use Com\Daw2\Controllers\LoginController3;
use Com\Daw2\Controllers\ProductoController;
use Com\Daw2\Controllers\ProveedorController;
use Com\Daw2\Helpers\JwtTool;
use Com\Daw2\Libraries\Respuesta;
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
        } else {
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
            },
            'get'
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
            },
            'put'
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
        //comprobamos que en la petición se haya enviado el token de autorización
        /*if (JwtTool::requestHasToken()) {
            try {
                //obtenemos el token que nos trae el portador (bearer)
                $bearer = JwtTool::getBearerToken();
                //creamos un nuevo JWT con el elemento secreto
                $jwt = new JWT($_ENV['secret']);
                //obtenemos los datos del token
                self::$jwtData = $jwt->decode($bearer);
                //obtenemos los permisos asociados al rol del usuario que accede
                self::$permisos = LoginController::getPermisos(self::$jwtData['id_rol']);
            } catch (JWTException $e) {
                $controller = new ErrorController();
                //enviamos el mensaje de error
                $controller->errorWithBody(403, ['mensaje' => $e->getMessage()]);
                //finalizamos el proceso
                die;
            }
        } else {
            self::$permisos = LoginController2::getPermisos();
        }*/


        Route::add(
            '/producto',
            function () {
                if (str_contains(self::$permisos['productoController'], 'r')) {
                    (new ProductoController())->listProductosFiltrados();
                } else {
                    http_response_code(403);
                }
            }
            /* alternativa para mostrar todos sin filtrar por ningún campo
             *
             * fn() => (new ProductoController())->listProductos()
             * fn() => (new ProductoController())->listProductosFiltrados()
             * */,
            'get'
        );

        Route::add(
            '/producto/(\p{L}{2,3}\p{N}{7})',
            function ($codigo) {
                if (str_contains(self::$permisos['productoController'], 'r')) {
                    (new ProductoController())->getProducto($codigo);
                } else {
                    http_response_code(403);
                }
            },
            'get'
        );
        Route::add(
            '/producto',
            function () {
                if (str_contains(self::$permisos['productoController'], 'w')) {
                    (new ProductoController())->addProducto();
                } else {
                    http_response_code(403);
                }
            },
            'post'
        );
        Route::add(
            '/producto/(\p{L}{2,3}\p{N}{7})',
            function ($codigo) {
                if (str_contains(self::$permisos['productoController'], 'd')) {
                    (new ProductoController())->deleteProducto($codigo);
                } else {
                    http_response_code(403);
                }
            },
            'delete'
        );
        Route::add(
            '/producto/(\p{L}{2,3}\p{N}{7})',
            function ($codigo) {
                if (str_contains(self::$permisos['productoController'], 'w')) {
                    (new ProductoController())->editProducto($codigo);
                } else {
                    http_response_code(403);
                }
            },
            'put'
        );
        Route::add(
            '/login-producto',
            fn() => (new LoginController2())->login(),
            'post'
        );


        /**
         *
         *  PROVEEDOR - REPASO EXAMEN
         *
         */
        //comprobamos la existencia del token y obtenemos los permisos asociados al usuario que inicia sesión
        if (JwtTool::requestHasToken()) {
            //OJO, NO OLVIDAR EL TRY-CATCH PARA MANEJAR PROBLEMAS DE TOKEN CADUCADO O MANIPULADO
            try {
                $bearer = JwtTool::getBearerToken();
                $jwt = new Jwt($_ENV['secret']);
                self::$jwtData = $jwt->decode($bearer);
                self::$permisos = LoginController3::getPermisos(self::$jwtData['id_rol']);

            } catch (JWTException $e) {
                $controller = new ErrorController();
                $controller->errorWithBody(403, ['mensaje' => $e->getMessage()]);
                die();
            }

        } else {
            self::$permisos = LoginController3::getPermisos();
        }


        Route::add(
            '/login-proveedor',
            fn() => (new LoginController3())->login(),
            'post'
        );
        Route::add(
            '/proveedor',
            function () {
                if (str_contains(self::$permisos['proveedorController'], 'r')) {
                    (new ProveedorController())->listarProveedor();
                } else {
                    http_response_code(403);
                }
            },
            //fn() => (new ProveedorController())->listarProveedor(),
            'get'
        );
        Route::add(
            '/proveedor/(\p{L}[\p{N}]{7,8}[\p{L}]{0,1})',
            function ($cif) {
                if (str_contains(self::$permisos['proveedorController'], 'r')) {
                    (new ProveedorController())->getProveedor($cif);
                } else {
                    http_response_code(403);
                }
            },
            //fn($cif) => (new ProveedorController())->getProveedor($cif),
            'get'
        );
        Route::add(
            '/proveedor',
            function () {
                if (str_contains(self::$permisos['proveedorController'], 'w')) {
                    (new ProveedorController())->addProveedor();
                } else {
                    http_response_code(403);
                }
            },
            //fn() => (new ProveedorController())->addProveedor(),
            'post'
        );
        Route::add(
            '/proveedor/(\p{L}[\p{N}]{7,8}[\p{L}]{0,1})',
            function ($cif) {
                if (str_contains(self::$permisos['proveedorController'], 'd')) {
                    (new ProveedorController())->deleteProveedor($cif);
                } else {
                    http_response_code(403);
                }
            },
            //fn($cif) => (new ProveedorController())->deleteProveedor($cif),
            'delete'
        );
        Route::add(
            '/proveedor/(\p{L}[\p{N}]{7,8}[\p{L}]{0,1})',
            function ($cif) {
                if (str_contains(self::$permisos['proveedorController'], 'w')) {
                    (new ProveedorController())->editProveedor($cif);
                } else {
                    http_response_code(403);
                }
            },
            //fn($cif) => (new ProveedorController())->editProveedor($cif),
            'patch'
        );


        Route::add(
            '/test',
            fn() => throw new \Exception(),
            'get'
        );

        Route::pathNotFound(
            function () {
                (new ErrorController())->errorWithBody(404, ['mensaje'=>'paǵina no encontrada']);
            }
        );

        Route::methodNotAllowed(
            function () {
                (new ErrorController())->errorWithBody(404, ['mensaje'=>'método no permitido']);
            }
        );

        Route::run();
    }
}
