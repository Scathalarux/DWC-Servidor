<?php

  namespace Com\Daw2\Core;

use Com\Daw2\Libraries\Mensaje;

abstract class BaseController
{
    protected View $view;

    public function __construct()
    {
        $this->view = new View(get_class($this));
    }

    /**
     * Cuando no es nuestro framework hacemos una clase intermedia que descienda de
     * BaseController sin modificar directamente BaseController
     */
    public function addFlashMessage(Mensaje $message): void
    {
        /*Inicializamos solo cuando no lo está previamnete*/
        if (!isset($_SESSION['flashMessages']) || !is_array($_SESSION['flashMessages'])) {
            $_SESSION['flashMessages'] = [];
        }
        /*Añadimos el mensaje en el array*/
        $_SESSION['flashMessages'][] = $message;
    }
}
