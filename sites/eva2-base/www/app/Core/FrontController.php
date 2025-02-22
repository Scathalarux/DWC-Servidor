<?php

namespace Com\Daw2\Core;

use Ahc\Jwt\JWT;
use Ahc\Jwt\JWTException;
use Com\Daw2\Controllers\ErrorController;
use Com\Daw2\Controllers\UsersController;
use Com\Daw2\Controllers\XogadoresController;
use Com\Daw2\Helpers\JwtTool;
use PDOException;
use Steampixel\Route;

class FrontController
{
    private static ?array $jwtData = null;
    private static array $permisos = [];

    public static function main()
    {
        if (JwtTool::requestHasToken()) {
            try {
                $bearer = JwtTool::getBearerToken();
                $jwt = new JWT($_ENV['secret']);

                self::$jwtData = $jwt->decode($bearer);
                self::$permisos = UsersController::getPermisos(self::$jwtData['user_type']);

            } catch (PDOException $e) {
                $controller = new ErrorController(422, ['mensaje' => $e->getMessage()]);
                $controller->showError();
            }
        } else {
            self::$permisos = UsersController::getPermisos();
        }

        Route::add(
            '/login',
            fn() => (new UsersController())->login()
            , 'post'
        );

        Route::add(
            '/xogadores',
            function () {
                if (str_contains(self::$permisos['xogadoresController'], 'r')) {
                    (new XogadoresController())->listarXogadores();
                } else {
                    http_response_code(403);
                }
            }
            , 'get'
        );
        Route::add(
            '/xogadores/(\p{N}{1,})',
            fn($numLicencia) => (new XogadoresController())->getXogador((int)$numLicencia)
            , 'get'
        );
        Route::add(
            '/xogadores',
            fn() => (new XogadoresController())->addXogador()
            , 'post'
        );
        Route::add(
            '/xogadores/(\p{N}{1,})',
            fn($numLicencia) => (new XogadoresController())->deleteXogador((int)$numLicencia)
            , 'delete'
        );
        Route::add(
            '/xogadores/(\p{N}{1,})',
            fn($numLicencia) => (new XogadoresController())->editXogadorPut((int)$numLicencia)
            , 'put'
        );
        Route::add(
            '/xogadores/(\p{N}{1,})',
            fn($numLicencia) => (new XogadoresController())->editXogadorPatch((int)$numLicencia)
            , 'patch'
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
