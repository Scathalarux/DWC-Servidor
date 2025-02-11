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
use Com\Daw2\Controllers\UsuariosController;
use Com\Daw2\Helpers\JwtTool;
use Com\Daw2\Libraries\Respuesta;
use Steampixel\Route;

class FrontController
{

    public static function main()
    {
        Route::add(
            '/usuariosAll',
            fn() => (new UsuariosController())->listarAllUsuarios(),
            'get'
        );
        Route::add(
            '/usuarios',
            fn() => (new UsuariosController())->listarFilteredUsuarios(),
            'get'
        );
        Route::add(
            '/usuarios/(\p{L}[\p{L}_]{0,48}\p{L})',
            fn($username) => (new UsuariosController())->listarFilteredUsuarios($username),
            'get'
        );
        Route::add(
            '/usuarios',
            fn() => (new UsuariosController())->listarFilteredUsuarios(),
            'post'
        );
        Route::add(
            '/usuarios/(\p{L}[\p{L}_]{0,48}\p{L})',
            fn($username) => (new UsuariosController())->listarFilteredUsuarios($username),
            'delete'
        );
        Route::add(
            '/usuarios/(\p{L}[\p{L}_]{0,48}\p{L})',
            fn($username) => (new UsuariosController())->listarFilteredUsuarios($username),
            'get'
        );


        Route::add(
            '/test',
            fn() => throw new \Exception(),
            'get'
        );

        Route::pathNotFound(
            function () {
                (new ErrorController())->errorWithBody(404, ['mensaje' => 'paǵina no encontrada']);
            }
        );

        Route::methodNotAllowed(
            function () {
                (new ErrorController())->errorWithBody(404, ['mensaje' => 'método no permitido']);
            }
        );

        Route::run();
    }
}
