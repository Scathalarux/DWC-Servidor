<?php

namespace Com\Daw2\Core;

use Steampixel\Route;

class FrontController {

    static function main() {
        /*
         * Página de inicio 
         */
        Route::add('/(inicio)?',
                fn() => (new \Com\Daw2\Controllers\InicioController())->index(),
                'get');
        
        /*
         * Controlador de categorías
         */
        
        Route::add('/categoria',
                fn() => (new \Com\Daw2\Controllers\CategoriaController())->index(),
                'get');        
        Route::add('/categoria/test-insert',
                fn() => (new \Com\Daw2\Controllers\CategoriaController())->insertCategoriaObject(),
                'get');
        //Cargamos el formulario de alta categoría
        Route::add('/categoria/new',
                fn() => (new \Com\Daw2\Controllers\CategoriaController())->newShowForm(),
                'get');
        //Recibimos el formulario de alta categoría
        Route::add('/categoria/new',
                fn() => (new \Com\Daw2\Controllers\CategoriaController())->newProcessForm(),
                'post');
        //Cargamos el formulario de editar categoría
        Route::add('/categoria/edit/([0-9]+)',
                fn($id) => (new \Com\Daw2\Controllers\CategoriaController())->editShowForm((int)$id),
                'get');
        //Recibimos el formulario de alta categoría
        Route::add('/categoria/edit',
                fn() => (new \Com\Daw2\Controllers\CategoriaController())->editProcessForm(),
                'post');
        Route::add('/categoria/delete/([0-9]+)',
                fn($id) => (new \Com\Daw2\Controllers\CategoriaController())->delete((int)$id),
                'get');
        
         /*
         * Controlador de categorías Array
         */
        
        Route::add('/categoria-array',
                fn() => (new \Com\Daw2\Controllers\CategoriaArrayController())->index(),
                'get');   
        Route::add('/categoria-array/test-insert',
                fn() => (new \Com\Daw2\Controllers\CategoriaArrayController())->insertCategoria(),
                'get');
        //Cargamos el formulario de alta categoría
        Route::add('/categoria-array/new',
                fn() => (new \Com\Daw2\Controllers\CategoriaArrayController())->newShowForm(),
                'get');
        //Recibimos el formulario de alta categoría
        Route::add('/categoria-array/new',
                fn() => (new \Com\Daw2\Controllers\CategoriaArrayController())->newProcessForm(),
                'post');
        //Cargamos el formulario de editar categoría
        Route::add('/categoria/edit/([0-9]+)',
                fn($id) => (new \Com\Daw2\Controllers\CategoriaController())->editShowForm((int)$id),
                'get');
        //Recibimos el formulario de alta categoría
        Route::add('/categoria/edit',
                fn() => (new \Com\Daw2\Controllers\CategoriaController())->editProcessForm(),
                'post');
        Route::add('/categoria-array/delete/([0-9]+)',
                fn($id) => (new \Com\Daw2\Controllers\CategoriaArrayController())->delete((int)$id),
                'get');
        
        /*
         * Controlador CSV
         * */
        Route::add('/csv',
                function() {
                    (new \Com\Daw2\Controllers\CsvController())->index();
                },
                'get');
        Route::add('/csv/pontevedra2020',
                function() {
                    (new \Com\Daw2\Controllers\CsvController())->pontevedra2020();
                },
                'get');
        
        /*
         * Controlador ejemplos test
         */
        //No emulado devuelve tipos float e int
        Route::add('/test/index',
                function() {
                    (new \Com\Daw2\Controllers\TestController())->index();
                },
                'get');
        //Emulado devuelve todo strings
        Route::add('/test/test-emulated',
                function() {
                    (new \Com\Daw2\Controllers\TestController())->testEmulated();
                },
                'get');
        Route::add('/test/insert-categoria',
                function() {
                    (new \Com\Daw2\Controllers\TestController())->insertCategoria();
                },
                'get'); 
        
        Route::add('/test/update-usuario-salar',
                function() {
                    (new \Com\Daw2\Controllers\TestController())->updateUsuarioSalar();
                },
                'get');
        Route::add('/test/delete-usuarios',
                function() {
                    (new \Com\Daw2\Controllers\TestController())->deleteUsuarios();
                },
                'get');
        Route::add('/test/rellenar-aleatorio',
                function() {
                    (new \Com\Daw2\Controllers\TestController())->rellenarAleatorio();
                },
                'get');
        
        Route::add('/test/test-limit',
                function() {
                    (new \Com\Daw2\Controllers\TestController())->testLimit();
                },
                'get');
        Route::add('/test/test-limit-bind',
                function() {
                    (new \Com\Daw2\Controllers\TestController())->testLimitBind();
                },
                'get');
        Route::add('/test/test-order-by',
                function() {
                    (new \Com\Daw2\Controllers\TestController())->testOrderBy();
                },
                'get');
        Route::add('/test/test-search-active',
                function() {
                    (new \Com\Daw2\Controllers\TestController())->testSearchActive();
                },
                'get');        
        /*
         * Métodos generales (fallback cuando no encontramos ruta
         */
        Route::pathNotFound(
            fn() => (new \Com\Daw2\Controllers\ErrorController())->error404()
        );
        Route::methodNotAllowed(
            fn() => (new \Com\Daw2\Controllers\ErrorController())->error404()
        );
        Route::run();       
    }        

}
