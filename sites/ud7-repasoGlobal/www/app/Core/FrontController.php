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
use Com\Daw2\Controllers\ProveedoresController;
use Com\Daw2\Helpers\JwtTool;
use Com\Daw2\Libraries\Respuesta;
use Steampixel\Route;

class FrontController
{
    private static ?array $jwtData = null;
    private static array $permisos = [];

    public static function main()
    {

        Route::add(
            '/proveedores',
            fn() =>(new ProveedoresController())->getProveedores(),
            'get'
        );
        Route::add(
            '/proveedores/(\p{L}[0-9]{7,8}[\p{L}]*)',
            fn($cif) => (new ProveedoresController())->getProveedor($cif),
            'get'
        );
        Route::add(
            '/proveedores/add',
            fn() => (new ProveedoresController())->addProveedor(),
            'post'
        );
        Route::add(
            '/proveedores/delete/(\p{L}[0-9]{7,8}[\p{L}]*)',
            fn($cif) => (new ProveedoresController())->deleteProveedor($cif),
            'delete'
        );
        Route::add(
            '/proveedores/edit/(\p{L}[0-9]{7,8}[\p{L}]*)',
            fn($cif) => (new ProveedoresController())->editProveedor($cif),
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
