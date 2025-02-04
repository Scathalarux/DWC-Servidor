<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Ahc\Jwt\JWT;
use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\UsuariosSistemaModel2;

class LoginController3 extends BaseController
{
    private const ROL_ADMIN = 1;
    private const ROL_ENCARGADO = 2;
    private const ROL_STUFF = 3;


    public function login(): void
    {
        $userModel = new UsuariosSistemaModel2();
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $usuario = $userModel->findUsuarioEmail($_POST['email']);
            $passOk = false;
            if ($usuario !== false) {
                $passOk = password_verify($_POST['password'], $usuario['pass']);
                if ($passOk !== false) {
                    //creamos el token
                    $jwt = new JWT ($_ENV['secret'], 'HS256', 3600, 10);

                    $insertData = [
                        'id_usuario' => $usuario['id_usuario'],
                        'id_rol' => $usuario['id_rol'],
                    ];

                    $token = $jwt->encode($insertData);

                    $respuesta = new Respuesta(200, ['mensaje' => 'Sesión iniciada correctamente', 'token' => $token]);

                    $userModel->updateFechaAcceso((int)$usuario['id_usuario']);

                }

            }
            if ($usuario === false || $passOk === false) {
                $respuesta = new Respuesta(404, ['mensaje' => 'Los datos introducidos son erróneos. Vuelva a intentarlo']);
            }
        }

        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);
    }
    public static function getPermisos(int $idRol= -1): array
    {
        $permisos = [
            'catecoriaController' => '',
            'productoController' => '',
            'proveedorController' => '',
        ];

        return match ($idRol) {
            self::ROL_ADMIN => array_replace($permisos,
                ['catecoriaController' => 'rwd',
                    'productoController' => 'rwd',
                    'proveedorController' => 'rwd']),
            self::ROL_ENCARGADO => array_replace($permisos,
                ['catecoriaController' => 'r',
                    'productoController' => 'r',
                    'proveedorController' => 'r']),
            self::ROL_STUFF => [],
            default => $permisos
        };
    }
}