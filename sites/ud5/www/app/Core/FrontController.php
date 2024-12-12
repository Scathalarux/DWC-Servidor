<?php

declare(strict_types=1);

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\ErroresController;
use Com\Daw2\Controllers\InicioController;
use Com\Daw2\Controllers\PreferenciasUsuario;
use Com\Daw2\Controllers\CsvController;
use Com\Daw2\Controllers\ProductoController3;
use Com\Daw2\Controllers\ProductosController;
use Com\Daw2\Controllers\ProductoController2;
use Com\Daw2\Controllers\UserController;
use Com\Daw2\Controllers\UsuariosController;
use Com\Daw2\Controllers\UsuariosSistemaController;
use Com\Daw2\Models\UsuarioModel;
use Steampixel\Route;

class FrontController
{
    public static function main()
    {
        /*Inicializa o retoma una sesión entre el usuario y el servidor para que los valores
        guardados en $_SESSION sean accesibles en el código */
        session_start();

        Route::add(
            '/',
            function () {
                $controlador = new InicioController();
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
                $controlador->showAllUsuarios();
            },
            'get'
        );
        Route::add(
            '/users-filter',
            function () {
                $controlador = new UsuariosController();
                $controlador->doFilterUsuarios();
            },
            'get'
        );
        Route::add(
            '/users-filter/new',
            function () {
                $controlador = new UsuariosController();
                $controlador->showAddUsuario();
            },
            'get'
        );
        Route::add(
            '/users-filter/new',
            function () {
                $controlador = new UsuariosController();
                $controlador->addUsuario();
            },
            'post'
        );
        Route::add(
            '/users-filter/edit/([\p{L}\p{N}_]{3,50})',
            function ($username) {
                $controlador = new UsuariosController();
                $controlador->showEditUsuario($username);
            },
            'get'
        );
        Route::add(
            '/users-filter/edit/([\p{L}\p{N}_]{3,50})',
            function ($username) {
                $controlador = new UsuariosController();
                $controlador->doEditUsuario($username);
            },
            'post'
        );
        Route::add(
            '/users-filter/delete/([\p{L}\p{N}_]{3,50})',
            function ($username) {
                $controlador = new UsuariosController();
                $controlador->deleteUsuario($username);
            },
            'get'
        );

        Route::add(
            '/preferenciasUsuario',
            function () {
                $controlador = new PreferenciasUsuario();
                $controlador->showPreferenciasUsuario();
            },
            'get'
        );
        Route::add(
            '/preferenciasUsuario',
            function () {
                $controlador = new PreferenciasUsuario();
                $controlador->doPreferenciasUsuario();
            },
            'post'
        );
        Route::add(
            '/usersBySalario',
            function () {
                $controlador = new UsuariosController();
                $controlador->showOrderUsuarioSalario();
            },
            'get'
        );
        Route::add(
            '/standardUsers',
            function () {
                $controlador = new UsuariosController();
                $controlador->showStandardUsers();
            },
            'get'
        );
        Route::add(
            '/usersByName',
            function () {
                $controlador = new UsuariosController();
                $controlador->showUsersCarlos();
            },
            'get'
        );

        Route::add(
            '/usuariosSistema',
            function () {
                $controlador = new UsuariosSistemaController();
                $controlador->showUsuariosSistema();
            },
            'get'
        );


        //REPASO EXAMEN 1ª EV
        Route::add(
            '/productos',
            function () {
                $controlador = new ProductosController();
                $controlador->doFilteredProducts();
            },
            'get'
        );
        Route::add(
            '/productos2',
            function () {
                $controlador = new ProductoController2();
                $controlador->doFilteredProductos();
            },
            'get'
        );
        Route::add(
            '/productos2/new',
            function () {
                $controlador = new ProductoController2();
                $controlador->showAddProducto();
            },
            'get'
        );
        Route::add(
            '/productos2/new',
            function () {
                $controlador = new ProductoController2();
                $controlador->addProducto();
            },
            'post'
        );
        Route::add(
            '/productos2/edit/(\p{L}{2,3}[0-9]{7})',
            function ($codigo) {
                $controlador = new ProductoController2();
                $controlador->showEditProducto($codigo);
            },
            'get'
        );
        Route::add(
            '/productos2/edit/(\p{L}{2,3}[0-9]{7})',
            function ($codigo) {
                $controlador = new ProductoController2();
                $controlador->editProducto($codigo);
            },
            'post'
        );
        Route::add(
            '/productos2/delete/(\p{L}{2,3}[0-9]{7})',
            function ($codigo) {
                $controlador = new ProductoController2();
                $controlador->deleteProducto($codigo);
            },
            'get'
        );
        Route::add(
            '/productos3',
            function () {
                $controlador = new ProductoController3();
                $controlador->doFiltradoProductos();
            },
            'get'
        );
        Route::add(
            '/productos3/new',
            function () {
                $controlador = new ProductoController3();
                $controlador->showAddProducto();
            },
            'get'
        );
        Route::add(
            '/productos3/new',
            function () {
                $controlador = new ProductoController3();
                $controlador->doAddProducto();
            },
            'post'
        );
        Route::add(
            '/productos3/edit/([\p{L}]{2,3}[0-9]{7})',
            function ($codigo) {
                $controlador = new ProductoController3();
                $controlador->showEditProducto($codigo);
            },
            'get'
        );

        Route::add(
            '/productos3/edit/([\p{L}]{2,3}[0-9]{7})',
            function ($codigo) {
                $controlador = new ProductoController3();
                $controlador->doEditProducto($codigo);
            },
            'post'
        );
        Route::add(
            '/productos3/delete/([\p{L}]{2,3}[0-9]{7})',
            function ($codigo) {
                $controlador = new ProductoController3();
                $controlador->doDeleteProducto($codigo);
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
                $controlador = new InicioController();
                $controlador->demo();
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
        Route::run();
    }
}
