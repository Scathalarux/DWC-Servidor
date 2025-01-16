<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Libraries\Mensaje;

class InicioController extends \Com\Daw2\Core\BaseController
{
    public function index()
    {
        $data = array(
            'titulo' => 'Página de inicio',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio'
        );
        $this->addFlashMessage(new Mensaje('Bienvenid@ al examen Diciembre 24', Mensaje::SUCCESS, 'Bienvenid@'));
        $this->view->showViews(
            array(
                'templates/header.view.php',
                'inicio.view.php',
                'templates/footer.view.php'),
            $data
        );
    }

    public function demo()
    {
        $data = array(
            'titulo' => 'Demo html proveedores',
            'breadcrumb' => ['Inicio', 'Demo proveedores'],
            'seccion' => '/demo-proveedores'
        );
        $this->view->showViews(
            array(
                'templates/header.view.php',
                'proveedores.sample.php',
                'templates/footer.view.php'),
            $data
        );
    }
}
