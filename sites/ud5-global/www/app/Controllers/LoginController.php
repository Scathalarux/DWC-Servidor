<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\LogModel;
use Com\Daw2\Models\UsuariosSistemaModel;

class LoginController extends BaseController
{
    public function showLogin(array $errores = [], array $input = []): void
    {
        $data['errores'] = $errores;
        $data['input'] = $input;
        $this->view->show('login.view.php', $data);
    }

    public function doLogin(): void
    {
        if (!empty($_POST['dni']) && !empty($_POST['password'])) {
            //buscar si existe el email en la BBDD
            //ver si coinciden las contraseñas
            $usersSistemaModel = new UsuariosSistemaModel();
            $usuario = $usersSistemaModel->getByDni($_POST['dni']);
            if ($usuario !== false && password_verify($_POST['password'], $usuario['contrasinal'])) {
                if ($usuario['baja'] != 0) {
                    $errores['verificacion'] = 'Su situación de baja no le permite loguearse';
                    $input['dni'] = $usuario['dni'];
                    $this->showLogin($errores, $input);
                } else {
                    //alamacenar datos en session
                    $_SESSION['id_usuario'] = $usuario['id_usuario'];
                    $_SESSION['nombreCompleto'] = $usuario['nombre_completo'];
                    $_SESSION['permisos'] = $this->getPermisos((int)$usuario['id_rol']);

                    //actualizar fecha acceso
                    $usersSistemaModel->upDate((int)$usuario['id_usuario']);

                    //añadir registro en tabla log
                    $logModel = new LogModel();
                    $nombre = $usuario['nombre_completo'];
                    $logModel->addLod(['operacion' => 'Login', 'tabla' => 'usuarios_sistema', 'detalle' => "El usuario '$nombre' accede al sistema."]);

                    header('Location: /usuarios-sistema');
                }
            } else {
                $errores['verificacion'] = 'El email o la contraseña no son válidos';
                $this->showLogin($errores);
            }

        } else {
            $errores['verificacion'] = 'Debe introducir sus credenciales';
            $this->showLogin($errores);
        }

    }

    public function getPermisos(int $idRol): array
    {
        $permisos = [
            'usuariosSistema' => '',
            'categorias' => '',
            'proveedores' => '',
            'productos' => ''
        ];

        return match ($idRol) {
            1 => array_replace($permisos, ['usuariosSistema' => 'rwd',
                'categorias' => 'rwd',
                'proveedores' => 'rwd',
                'productos' => 'rwd']),
            2 => array_replace($permisos, ['usuariosSistema' => 'r',
                'categorias' => 'r',
                'proveedores' => 'r',
                'productos' => 'r']),
            3 => array_replace($permisos, ['usuariosSistema' => 'rd',
                'categorias' => 'rd',
                'proveedores' => 'rd',
                'productos' => 'rd']),
            default => $permisos
        };

    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /login');
    }
}