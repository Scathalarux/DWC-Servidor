<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\CsvController;
use Com\Daw2\Controllers\UserController;
use Com\Daw2\Controllers\UsuariosController;
use Com\Daw2\Models\UsuarioModel;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        Route::add(
            '/',
            function () {
                $controlador = new \Com\Daw2\Controllers\InicioController();
                $controlador->index();
            },
            'get'
        );

        /*Route::add(
            '/test',
            function () {
                $controlador = new CsvController();
                $controlador->showFormularioNombre();
            },
            'get'
        );

        Route::add(
            '/test',
            function () {
                $controlador = new CsvController();
                $controlador->doFormularioNombre();
            },
            'post'
        );*/
        Route::add(
            '/historicoPoblacionPontevedra',
            function () {
                $controlador = new CsvController();
                $controlador->showPoblacionPontevedra();
            },
            'get'
        );
        Route::add(
            '/poblacionGruposEdad',
            function () {
                $controlador = new CsvController();
                $controlador->showPoblacionGruposEdad();
            },
            'get'
        );
        Route::add(
            '/poblacionPontevedra2020',
            function () {
                $controlador = new CsvController();
                $controlador->showPoblacionPontevedra2020();
            },
            'get'
        );
        Route::add(
            '/anadirMunicipio',
            function () {
                $controlador = new CsvController();
                $controlador->addRow();
            },
            'post'
        );
        Route::add(
            '/anadirMunicipio',
            function () {
                $controlador = new CsvController();
                $controlador->showAnadirPoblacion();
            },
            'get'
        );

        Route::add(
            '/usuarios/new',
            function () {
                $controlador = new UserController();
                $controlador->showAnadirUser();
            },
            'get'
        );
        Route::add(
            '/usuarios/new',
            function () {
                $controlador = new UserController();
                $controlador->doAnadirUser();
            },
            'post'
        );

        Route::add(
            '/allUsers',
            function () {
                $controlador = new UsuariosController();
                $controlador->doAllUsuarios();
            },
            'get'
        );
        Route::add(
            '/usersBySalario',
            function () {
                $controlador = new UsuariosController();
                $controlador->doOrderUsuarioSalario();
            },
            'get'
        );
        Route::add(
            '/standardUsers',
            function () {
                $controlador = new UsuariosController();
                $controlador->doStandardUsers();
            },
            'get'
        );
        Route::add(
            '/usersByName',
            function () {
                $controlador = new UsuariosController();
                $controlador->doUsersByName();
            },
            'get'
        );

        /*Route::add(
            '/anagrama',
            function () {
                $controlador = new CsvController();
                $controlador->showAnagrama();
            },
            'get'
        );

        Route::add(
            '/anagrama',
            function () {
                $controlador = new CsvController();
                $controlador->doAnagrama();
            },
            'post'
        );

        Route::add(
            '/mismas-letras',
            function () {
                $controlador = new CsvController();
                $controlador->showMismasLetras();
            },
            'get'
        );

        Route::add(
            '/mismas-letras',
            function () {
                $controlador = new CsvController();
                $controlador->doMismasLetras();
            },
            'post'
        );*/


        Route::add(
            '/demo-proveedores',
            function () {
                $controlador = new \Com\Daw2\Controllers\InicioController();
                $controlador->demo();
            },
            'get'
        );

        Route::pathNotFound(
            function () {
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error404();
            }
        );

        Route::methodNotAllowed(
            function () {
                $controller = new \Com\Daw2\Controllers\ErroresController();
                $controller->error405();
            }
        );
        Route::run();
    }
}
