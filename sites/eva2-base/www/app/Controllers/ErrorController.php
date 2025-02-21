<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;

class ErrorController extends BaseController
{
    public function __construct(
        private int    $code,
        private ?array $data = null
    )
    {
        parent::__construct();
    }

    public function showError()
    {
        $respuesta = new Respuesta($this->code, $this->data);
        $this->view->show('json.view.php', ['respuesta' => $respuesta]);
    }
}