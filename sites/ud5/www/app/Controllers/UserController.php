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
        /**
         * No hace falta una comprobacion de si está recibiendo algo por POST
         * ya que a través del router ya hacemos esta comprobación
         * (llamar a aesta función si recibe algo por post)
        */

        $data = [];
        $data = [
            'titulo' => "Añadir usuario",
            'breadcrumb' => array('Usuarios', 'Nuevo usuario'),
            'seccion' => "/usuarios/new",
            'tipo_suscripcion' => self::TIPO_SUSCRIPCION
        ];

        $errores = $this->checkUser($_POST);
        if (count($errores) === 0) {
            $data['exito'] = true;
        } else {
            $data['exito'] = false;
        }
        $data['errores'] = $errores;
        $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->view->showViews(array('templates/header.view.php', 'user.view.php', 'templates/footer.view.php'), $data);
    }

    private function checkUser(array $datos): array
    {
        $errores = [];

        //Comprobamos errores en el nombre de usuario
        if (mb_strlen($datos['nombre']) < 1) {
            $errores['nombre'] = "El nombre es requerido";
        } elseif (!preg_match('/^[\p{L}\p{N}_]+$/iu', $datos['nombre'])) {
            $errores['nombre'] = "El nombre solo puede contener letras, números y '_'";
        }

        //comprobamos errores en el email
        if (empty($datos['email'])) {
            $errores['email'] = "El email es requerido";
        } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = "El email no es valido";
        }

        //Comprobamos errores en el tipo de suscripción
        if (!in_array($datos['tipo_suscripcion'], self::TIPO_SUSCRIPCION)) {
            $errores['tipo_suscripcion'] = "Selecciona un tipo de suscripcion válido";
        }


        if (!empty($datos['numTarjeta'])) {
            if (!filter_var($datos['numTarjeta'], FILTER_VALIDATE_INT)) {
                $errores['numTarjeta'] = "El número de la tarjeta no es valido";
            } elseif (mb_strlen((string)$datos['numTarjeta']) !== 16) {
                $errores['numTarjeta'] = "El número de la tarjeta debe estar compuesto por 16 dígitos";
            }
        } else {
            //Comprobamos errores en el número de la tarjeta
            if (in_array($datos['tipo_suscripcion'], ['gold','silver'])) {
                $errores['numTarjeta'] = "La suscripción requiere introducir un número de tarjeta";
            }
        }

        if (!isset($data['acepto'])) {
            $errores['terminos'] = "Debe aceptar los términos y condiciones";
        }
        return $errores;
    }
}
