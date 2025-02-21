<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\XogadoresModel;

class XogadoresController extends BaseController
{
    public function listarXogadores(): void
    {
        //Licencia, nombre, nacionalidad, equipo, club
        // = , like , multiple, = , like

        $xogadoresModel = new XogadoresModel();

        $xogadores = $xogadoresModel->getFilteredXogadores($_GET);

        if($xogadores === false){
            $respuesta = new Respuesta(404, ['mensaje'=>'No se atoparon xogadores']);
        }else{
            $respuesta = new Respuesta(200, $xogadores);
        }

        $this->view->show('json.view.php', ['respuesta' => $respuesta]);
    }

    public function getXogador(): void
    {

    }

    public function deleteXogador(): void
    {

    }

    public function addXogador(): void
    {

    }

    public function editXogadorPut(): void
    {

    }
}