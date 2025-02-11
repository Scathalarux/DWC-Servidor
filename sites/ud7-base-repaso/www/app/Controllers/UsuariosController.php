<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\UsuariosModel;

class UsuariosController extends BaseController
{
    public function listarAllUsuarios(): void
    {
        $usuariosModel = new UsuariosModel();
        $usuarios = $usuariosModel->getAllUsuarios();
        if($usuarios !== false){
            $respuesta = new Respuesta(200, $usuarios);
        }else{
            $respuesta = new Respuesta(404, ['mensaje'=>"No se encontraron resultados"]);
        }
        $this->view->show('jsonUsuarios.view.php', ['respuesta' => $respuesta]);
    }

    public function listarFilteredUsuarios(): void
    {
        $usuariosModel = new UsuariosModel();

        $usuarios = $usuariosModel->getFilteredUsuarios($_GET);

        if($usuarios !== false){
            $respuesta = new Respuesta(200, $usuarios);
        }else{
            $respuesta = new Respuesta(404, ['mensaje'=>"No se encontraron resultados"]);
        }



        $this->view->show('jsonUsuarios.view.php', ['respuesta' => $respuesta]);
    }
}