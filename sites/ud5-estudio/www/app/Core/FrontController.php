<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\ErroresController;
use Com\Daw2\Controllers\InicioController;
use Com\Daw2\Controllers\UsuariosController;
use Steampixel\Route;

class FrontController
{
    public static function main(): void
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
            '/demo-proveedores',
            function () {
                $controlador = new InicioController();
                $controlador->demo();
            },
            'get'
        );
        Route::add(
            '/usuarios',
            function () {
                $controlador = new UsuariosController();
                $controlador->listarUsuarios();
            },
            'get'
        );
        Route::add(
            '/usuarios/new',
            function () {
                $controlador = new UsuariosController();
                $controlador->showAddUser();
            },
            'get'
        );
        Route::add(
            '/usuarios/new',
            function () {
                $controlador = new UsuariosController();
                $controlador->doAddUser();
            },
            'post'
        );
        Route::add(
            '/usuarios/edit/([\p{L}\p{N}_]{3,5})',
            function ($username) {
                $controlador = new UsuariosController();
                $controlador->showEditUser($username);
            },
            'get'
        );
        Route::add(
            '/usuarios/edit/([\p{L}\p{N}_]{3,5})',
            function ($username) {
                $controlador = new UsuariosController();
                $controlador->doEditUser($username);
            },
            'post'
        );
        Route::add(
            '/usuarios/delete/([\p{L}\p{N}_]{3,5})',
            function ($username) {
                $controlador = new UsuariosController();
                $controlador->deleteUsuario($username);
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
        Route::run($_ENV['host.folder']);
    }
}
