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
            $userModel = new UsersModel();
            $user = $userModel->getUserByEmail($_POST['email']);
            $passOk = false;
            if ($user !== false) {
                $passOk = password_verify($_POST['password'], $user['password']);
                if ($passOk) {
                    $data = [
                        'id_user' => $user['id_user'],
                        'user_type' => $user['user_type'],
                    ];
                    $jwt = new JWT($_ENV['secret'], 'HS256', 3600, 10);
                    $token = $jwt->encode($data);

                    $respuesta = new Respuesta(200, ['token' => $token]);
                }
            }

            if ($user === false && $passOk === false) {
                $respuesta = new Respuesta(403, ['mensaje' => 'Email o contraseña erróneos']);
            }

        } else {
            $respuesta = new Respuesta(400, ['mensaje' => 'Introduce el email y la contraseña para iniciar sesión']);
        }
        $this->view->show('json.view.php', ['respuesta' => $respuesta]);

        //usuario+pswd correcto 200
        //usuario o psw incorrecto 403

    }

    public static function getPermisos(string $userType = ''): array
    {
        $permisos =[
            'xogadoresController' => ''
        ];

        return match ($userType) {
            self::USER_GERENTE => array_replace($permisos, ['xogadoresController'=>'rwd']),
            self::USER_ENTRENADOR => array_replace($permisos, ['xogadoresController'=>'r']),
            default => $permisos
        };

    }
}