<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\UsuarioModel;

class UsuariosController extends BaseController
{
    public function doConnection()
    {
        $model = new UsuarioModel();
    }
}
