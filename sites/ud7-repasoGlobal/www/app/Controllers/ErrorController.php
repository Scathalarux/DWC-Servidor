<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use http\Exception;

class ErrorController extends BaseController
{
    public function errorWithBody(int $code, array $body): void
    {
        $respuesta = new Respuesta($code, $body);
        $this->view->show('jsonCategorias.view.php', ['respuesta' => $respuesta]);
    }

}
