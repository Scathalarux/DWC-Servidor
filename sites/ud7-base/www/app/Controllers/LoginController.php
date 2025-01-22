<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Ahc\Jwt\JWT;
use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\UsuariosSistemaModel;

class LoginController extends BaseController
{
    private const SECRET_KEY = 'T3SIIhuntnzJj1p';

    public function login(): void
    {
        //comprobamos que hemos recibido todos los datos necesarios para el login
        if (array_key_exists('email', $_POST) === false || array_key_exists('password', $_POST) === false) {
            $respuesta = new Respuesta(400, ['mensaje' => 'El email y la contraseña son obligatorios']);
        } else {
            $modeloUsuariosSistema = new UsuariosSistemaModel();
            //comprobamos que el usuario existe con el email
            $usuario = $modeloUsuariosSistema->getUsuarioEmail($_POST['email']);
            $passOk = false;

            //Si existe el usuario
            if ($usuario !== false) {
                $passOk = password_verify($_POST['password'], $usuario['pass']);
                if ($passOk) {
                    $data = [
                        'id_usuario' => $usuario['id_usuario'],
                        'id_rol' => $usuario['id_rol'],
                        'idioma' => $usuario['idioma'],
                        'nombre' => $usuario['nombre'],
                    ];

                    //Creación JWT
                    //cabecera del JWT
                    $jwt = new JWT(self::SECRET_KEY, 'HS256', 1800, 10);
                    //payload del JWT: id_usuario, id_rol, idioma, nombre
                    $token = $jwt->encode($data);

                    $respuesta = new Respuesta(200, ['mensaje' => 'Inicio de sesión correcto. Bienvenide!', 'token' => $token]);


                    //Modificamos la fecha de acceso
                    $modeloUsuariosSistema->editUsuarioSistemaDate((int)$usuario['id_usuario']);
                }
            }

            if ($usuario === false || $passOk === false) {
                $respuesta = new Respuesta(403, ['mensaje' => 'Los datos no son válidos']);
            }
        }



        $this->view->show('json.view.php', ['respuesta' => $respuesta]);
    }
}
