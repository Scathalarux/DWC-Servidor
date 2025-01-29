<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Ahc\Jwt\JWT;
use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\UsuariosSistemaModel;

class LoginController2 extends BaseController
{
    private const ROL_ADMIN = 1;
    private const ROL_ENCARGADO = 2;
    private const ROL_STAFF = 3;
    public function login(): void
    {
        //comprobamos que se hayan introducido los campos necesarios para logearse
        if (array_key_exists('email', $_POST) && array_key_exists('password', $_POST)) {
            $modeloUsuarios = new UsuariosSistemaModel();
            $usuario = $modeloUsuarios->getUsuarioEmail($_POST['email']);
            $passOk = false;
            if ($usuario !== false) {
                $passOk = password_verify($_POST['password'], $usuario['pass']);
                if ($passOk) {
                    //creamos el contenido de la JWT
                    $data = [
                        'id_usuario' => $usuario['id_usuario'],
                        'id_rol' => $usuario['id_rol'],
                        'email' => $usuario['email']
                    ];

                    $jwt = new JWT($_ENV['secret'], 'HS256', 3600, 10);
                    $token = $jwt->encode($data);
                    $respuesta = new Respuesta(200, ['mensaje' => 'Sesión iniciada correctamente', 'token' => $token]);

                    //Modificamos la fecha de acceso
                    $modeloUsuarios->editUsuarioSistemaDate((int)$usuario['id_usuario']);
                }
            }
            if ($usuario === false || $passOk === false) {
                $respuesta = new Respuesta(404, ['mensaje' => "Datos inválidos. Vuelva a intentarlo"]);
            }
        } else {
            $respuesta = new Respuesta(400, ['mensaje' => 'El email y la contraseña son obligatorios']);
        }
        $this->view->show('jsonProductos.view.php', ['respuesta' => $respuesta]);
    }

    public static function getPermisos(int $id_rol = -1): array
    {
        $permisos = [
            'categoriaController' => '',
            'productoController' => ''
        ];
        return match ($id_rol) {
            self::ROL_ADMIN => array_replace($permisos, [
                'categoriaController' => 'rwd',
                'productoController' => 'rwd']),
            self::ROL_ENCARGADO => array_replace($permisos, [
                'categoriaController' => 'rw',
                'productoController' => 'rw']),
            self::ROL_STAFF => array_replace($permisos, [
                'productoController' => 'r'])
        };
    }
}
