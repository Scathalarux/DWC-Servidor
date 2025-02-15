<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\UsuariosSistemaModel;

class LoginController extends BaseController
{
    private const ADMIN_ROLE = 1;

    private const ENCARGADO_ROLE = 2;
    private const STAFF_ = 3;
    public function showLogin(array $errores = []): void
    {
        $data['errores'] = $errores;
        $this->view->show('login.view.php', $data);
    }

    public function doLogin(): void
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $usuariosModel = new UsuariosSistemaModel();
            $usuario = $usuariosModel->findByEmail($_POST['email']);
            $passOk = false;
            if ($usuario !== false) {
                $passOk = password_verify($_POST['password'], $usuario['pass']);
                if ($passOk) {
                    $_SESSION['usuario'] = $usuario['id_usuario'];
                    $_SESSION['rol'] = $usuario['id_role'];
                    $_SESSION['permisos'] = $this->getPermisos($usuario['id_role']);
                    //TODO modificar hora de acceso
                }
            }
            if ($usuario === false || $passOk === false) {
                $errores['verificacion'] = "Email o contraseña incorrectos";
                $this->showLogin($errores);
            }
        } else {
            $errores['verificacion'] = "Introduzca un email y una contraseña";
            $this->showLogin($errores);
        }
    }

    public function showRegister(array $errores = []): void
    {
        $data['errores'] = $errores;
        $this->view->show('register.view.php', $data);
    }

    public function doRegister(): void
    {

    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /login');
    }

    public function getPermisos(int $id_role): array
    {
        $permisos = [
            'centrosController' => ''
        ];

        return match($id_role){
            self::ADMIN_ROLE => array_replace($permisos, ['centrosController' => 'rwd']),
            self::ADMIN_ROLE => array_replace($permisos, ['centrosController' => 'r']),
            self::ADMIN_ROLE => array_replace($permisos, ['centrosController' => '']),
            default => []
        };

    }
}