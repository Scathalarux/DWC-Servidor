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

class FrontController2
{
    public static function main()
    {
        /*Inicializa o retoma una sesión entre el usuario y el servidor para que los valores
        guardados en $_SESSION sean accesibles en el código */
        session_start();

        if (isset($_SESSION['username'])) {
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


            //lectura CSV
            if (str_contains($_SESSION['permisos']['csvController'], 'r') !== false) {
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
            }
            //Escritura CSV
            if (str_contains($_SESSION['permisos']['csvController'], 'w') !== false) {
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
            }

            //Escritura User
            if (str_contains($_SESSION['permisos']['userController'], 'w') !== false) {
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
            }


            //Lectura Usuarios
            if (str_contains($_SESSION['permisos']['usuariosController'], 'r') !== false) {
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
            }
            //Escriruta Usuarios
            if (str_contains($_SESSION['permisos']['usuariosController'], 'w') !== false) {
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
            }

            //Borrado Usuarios
            if (str_contains($_SESSION['permisos']['usuariosController'], 'd') !== false) {
                Route::add(
                    '/users-filter/delete/([\p{L}\p{N}_]{3,50})',
                    function ($username) {
                        $controlador = new UsuariosController();
                        $controlador->deleteUsuario($username);
                    },
                    'get'
                );
            }

            //Letura Preferencias Usuario
            if (str_contains($_SESSION['permisos']['preferenciasUsuario'], 'r') !== false) {
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
            }

            //Lectura Usuarios Sistema
            if (str_contains($_SESSION['permisos']['usuariosSistemaController'], 'r') !== false) {
                Route::add(
                    '/usuariosSistema',
                    function () {
                        $controlador = new UsuariosSistemaController();
                        $controlador->showUsuariosSistema();
                    },
                    'get'
                );
            }

            //Escritura Usuarios Sistema
            if (str_contains($_SESSION['permisos']['usuariosSistemaController'], 'w') !== false) {
                Route::add(
                    '/usuariosSistema/new',
                    function () {
                        $controlador = new UsuariosSistemaController();
                        $controlador->showAddUsuarioSistema();
                    },
                    'get'
                );
                Route::add(
                    '/usuariosSistema/new',
                    function () {
                        $controlador = new UsuariosSistemaController();
                        $controlador->doAddUsuarioSistema();
                    },
                    'post'
                );
                Route::add(
                    '/usuariosSistema/edit/([\p{N}]{1,})',
                    function ($idUsuario) {
                        $controlador = new UsuariosSistemaController();
                        $controlador->showEditUsuarioSistema($idUsuario);
                    },
                    'get'
                );
                Route::add(
                    '/usuariosSistema/edit/([\p{N}]{1,})',
                    function ($idUsuario) {
                        $controlador = new UsuariosSistemaController();
                        $controlador->doEditUsuarioSistema($idUsuario);
                    },
                    'post'
                );
            }



            //Para que todos los usuarios puedan iniciar/cerrar sesión
            Route::add(
                '/usuariosSistema/google-oauth.php',
                function () {
                    $controlador = new UsuariosSistemaController();
                    $controlador->showLoginUsuariosSistema();
                },
                'get'
            );
            Route::add(
                '/usuariosSistema/login',
                function () {
                    $controlador = new UsuariosSistemaController();
                    $controlador->showLoginUsuariosSistema();
                },
                'get'
            );
            Route::add(
                '/usuariosSistema/login',
                function () {
                    $controlador = new UsuariosSistemaController();
                    $controlador->doLoginUsuariosSistema();
                },
                'post'
            );
            Route::add(
                '/usuariosSistema/logout',
                function () {
                    $controlador = new UsuariosSistemaController();
                    $controlador->doLogout();
                },
                'get'
            );

            if (str_contains($_SESSION['permisos']['inicioController'], 'r') !== false) {
                Route::add(
                    '/demo-proveedores',
                    function () {
                        $controlador = new InicioController();
                        $controlador->demo();
                    },
                    'get'
                );
            }

            Route::pathNotFound(
                function () {
                    $controller = new ErroresController();
                    $controller->error404();
                }
            );


            //REPASO EXAMEN 1ª EV
            /*Route::add(
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
            );*/

            //Ejercicios práctica inicial con php
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
        } else {
            Route::add(
                '/usuariosSistema/login',
                function () {
                    $controlador = new UsuariosSistemaController();
                    $controlador->showLoginUsuariosSistema();
                },
                'get'
            );
            Route::add(
                '/usuariosSistema/login',
                function () {
                    $controlador = new UsuariosSistemaController();
                    $controlador->doLoginUsuariosSistema();
                },
                'post'
            );
            Route::pathNotFound(
                function () {

                    header('Location: /usuariosSistema/login');
                }
            );

            Route::methodNotAllowed(
                function () {
                    $controller = new ErroresController();
                    $controller->error405();
                }
            );
        };


        Route::run();
    }
}
