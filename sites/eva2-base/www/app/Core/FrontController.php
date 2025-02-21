<?php

namespace Com\Daw2\Core;

use Ahc\Jwt\JWT;
use Ahc\Jwt\JWTException;
use Com\Daw2\Controllers\ErrorController;
use Com\Daw2\Controllers\UsersController;
use Com\Daw2\Controllers\XogadoresController;
use Com\Daw2\Helpers\JwtTool;
use Steampixel\Route;

class FrontController
{
    private static ?array $jwtData = null;
    private static array $permisos = [];

    public static function main()
    {
        if (JwtTool::requestHasToken()) {
            try {
                $jwt = new JWT($_ENV['secret']);
                $bearer = JwtTool::getBearerToken();
                self::$jwtData = $jwt->decode($bearer);
                self::$permisos = UsersController::getPermisos(self::$jwtData['user_type']);

            } catch (JWTException $e) {
                $controller = new ErrorController(403, ['mensaje' => $e->getMessage()]);
                $controller->showError();
                die();
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
            '/xogadores/([0-9]{1,})',
            function ($numLicencia) {
                if (str_contains(self::$permisos['xogadoresController'], 'r')) {
                    (new XogadoresController())->getXogador($numLicencia);
                } else {

                }
            }
            , 'get'
        );
        Route::add(
            '/xogadores',
            fn() => (new XogadoresController())->addXogador()
            , 'post'
        );
        Route::add(
            '/xogadores/([0-9]{1,})',
            fn($numLicencia) => (new XogadoresController())->deleteXogador($numLicencia)
            , 'delete'
        );
        Route::add(
            '/xogadores/([0-9]{1,})',
            fn($numLicencia) => (new XogadoresController())->editXogadorPut($numLicencia)
            , 'put'
        );
        Route::add(
            '/xogadores/([0-9]{1,})',
            fn($numLicencia) => (new XogadoresController())->editXogadorPatch($numLicencia)
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
