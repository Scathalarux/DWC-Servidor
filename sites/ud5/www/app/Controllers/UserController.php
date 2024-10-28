<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;

class UserController extends BaseController
{
    private const TIPO_SUSCRIPCION = ['free','silver','gold'];

    public function showAnadirUser(): void
    {
        $data = array(
            'titulo' => "Añadir usuario",
            'breadcrumb' => array('Usuarios', 'Nuevo usuario'),
            'seccion' => "/usuarios/new",
            'tipo_suscripcion' => self::TIPO_SUSCRIPCION
        );
            $this->view->showViews(array('templates/header.view.php', 'user.view.php', 'templates/footer.view.php'), $data);
    }

    public function doAnadirUser(): void
    {
        $errores = $this->checkUser($_POST);

        $data = array(
            'titulo' => "Añadir usuario",
            'breadcrumb' => array('Usuarios', 'Nuevo usuario'),
            'seccion' => "/usuarios/new",
            'tipo_suscripcion' => self::TIPO_SUSCRIPCION
        );


        if (count($errores) > 0) {
            $data['errores'] = $errores;
        } else {
            $data['exito'] = true;
        }
        $this->view->showViews(array('templates/header.view.php', 'user.view.php', 'templates/footer.view.php'), $data);
    }

    private function checkUser(array $datos): array
    {
        $errores = [];

        //Comprobamos errores en el nombre de usuario
        if (mb_strlen(trim($datos['nombre'])) < 1) {
            $errores['nombre'] = "El nombre es requerido";
        } elseif (!preg_match('/[\p{L}_[0-9]*]/iu', $datos['nombre'])) {
            $errores['nombre'] = "El nombre solo puede contener letras, números y '_'";
        }

        //comprobamos errores en el email
        if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = "El email no es valido";
        }

        //Comprobamos errores en el tipo de suscripción
        if (!in_array($datos['tipo_suscripcion'], self::TIPO_SUSCRIPCION)) {
            $errores['tipo_suscripcion'] = "El tipo de suscripcion solo puede ser 'free', 'silver' o 'gold'";
        }

        //Cmprobamos errores en el número de la tarjeta
        if (!filter_var($datos['email'], FILTER_VALIDATE_INT)) {
            $errores['numTarjeta'] = "El número de la tarjeta no es valido";
        } elseif (!mb_strlen($datos['numTarjeta']) === 16) {
            $errores['numTarjeta'] = "El número de la tarjeta debe estar compuesto por 16 dígitos";
        }

        return $errores;
    }
}
