<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Ahc\Jwt\JWT;
use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\UsersModel;

class UsersController extends BaseController
{
    private const USER_GERENTE = 'gerente';
    private const USER_ENTRENADOR = 'entrenador';

    public function login(): void
    {
        //verificar email  y password
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            //usuario+pswd correcto 200
            //usuario o psw incorrecto 403

            $usersmodel = new UsersModel();
            $passOk = false;

            $usuario = $usersmodel->getUserByEmail($_POST['email']);
            if ($usuario !== false) {
                $passOk = password_verify($_POST['password'], $usuario['password']);
                if ($passOk) {
                    //creación del token
                    $data = [
                        'id_user' => $usuario['id_user'],
                        'user_type' => $usuario['user_type']
                    ];

                    $jwt = new Jwt($_ENV['secret'], 'HS256', 3600, 10);
                    $token = $jwt->encode($data);


                    $respuesta = new Respuesta(200, ['mensaje' => 'Se ha iniciado sesión correctamente. Token: ' . $token]);
                }
            }

            if ($usuario === false || $passOk === false) {
                $respuesta = new Respuesta(403, ['mensaje' => 'El usuario o la password no son válidos']);
            }

        } else {
            $respuesta = new Respuesta(400, ['mensaje' => 'Debes introducir un email y password para iniciar sesión']);
        }

        $this->view->show('json.view.php', ['respuesta' => $respuesta]);
    }

    public static function getPermisos(string $userType = ''): array
    {
        $permisos = [
            'xogadoresController' => ''
        ];

        return match ($userType) {
            self::USER_ENTRENADOR => array_replace($permisos, ['xogadoresController' => 'rwd']),
            self::USER_GERENTE => array_replace($permisos, ['xogadoresController' => 'r']),
            default => []
        };
    }
}