<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Mensaje;
use Com\Daw2\Models\UsuariosSistemaModel;

class LoginController extends BaseController
{
    private const ADMIN_ROLE = 1;

    private const ENCARGADO_ROLE = 2;
    private const STAFF_ROLE = 3;

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
                    $_SESSION['nombre'] = $usuario['nombre'];
                    $_SESSION['rol'] = $usuario['id_role'];
                    $_SESSION['permisos'] = $this->getPermisos((int)$usuario['id_role']);
                    //TODO modificar hora de acceso
                    if ($usuariosModel->updateDateAccess((int)$usuario['id_usuario'])) {
                        header('Location: /centros');
                    } else {
                        $errores['verificacion'] = 'Ha surgido un error, vuelva a intentarlos';
                        $this->showLogin($errores);
                    }
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
        $errores = $this->checkForm($_POST);
        if ($errores === []) {
            $insertData = [];
            $allowedParams = ['id_grupo', 'id_center', 'id_role', 'email', 'pass', 'nombre', 'superadmin', 'bloqueado', 'last_date', 'idioma', 'recover_token', 'recover_time', 'debug', 'baja', 'theme'];
            foreach ($allowedParams as $param) {
                if ($param === 'debug') {
                    $insertData[$param] = !empty($_POST[$param]) ? $_POST[$param] : 0;
                } elseif ($param === 'pass') {
                    $insertData[$param] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                } else {
                    $insertData[$param] = !empty($_POST[$param]) ? $_POST[$param] : null;
                }
            }
            $usuariosModel = new UsuariosSistemaModel();
            $usuario = $usuariosModel->registerUser($insertData);
            if ($usuario === false) {
                $this->addFlashMessage(new Mensaje('No se ha podido registrar al usuario', Mensaje::ERROR, 'Error'));
                $this->showRegister();
            } else {
                $this->addFlashMessage(new Mensaje('Usuario registrado correctamente', Mensaje::SUCCESS, 'Éxito'));
                header('Location: /login');
            }
        } else {
            $this->showRegister($errores);
        }

    }

    public function checkForm(array $data): array
    {
        $errores = [];
        //email
        if (!empty($data['email'])) {
            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errores['email'] = "El email debe estar en formato emai (prueba@email.com";
            }
        } else {
            $errores['email'] = "El email es obligatorio";
        }

        //nombre
        if (!empty($data['nombre'])) {
            if (!preg_match('/^\p{L}[\p{L} ]{1,25}\p{L}$/', $data['nombre'])) {
                $errores['nombre'] = "El nombre debe tener entre 3 y 25 caracteres, sin números";
            }

        } else {
            $errores['nombre'] = "El nombre es obligatorio";
        }

        //idioma
        if (!empty($data['idioma'])) {
            if (!preg_match('/^[\p{L}]{2}$/', $data['idioma'])) {
                $errores['idioma'] = "El idioma debe tener 2 caracteres";
            }
        } else {
            $errores['idioma'] = "El idioma es obligatorio";
        }

        //password
        if (!empty($data['password'])) {
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $data['password'])) {
                $errores['password'] = "La contraseña debe contener al menos 8 caracteres que tengan una mayúscula, una minúscula y un número";
            }
        } else {
            $errores['password'] = "La contraseña es obligatoria";
        }
        if (!empty($data['password2'])) {
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $data['password2'])) {
                $errores['password2'] = "La contraseña debe contener al menos 8 caracteres que tengan una mayúscula, una minúscula y un número";
            }
        } else {
            $errores['password2'] = "La contraseña es obligatoria";
        }

        if ($data['password'] !== $data['password2']) {
            $errores['password'] = 'Las contraseñas no coinciden';
        }

        return $errores;
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

        return match ($id_role) {
            self::ADMIN_ROLE => array_replace($permisos, ['centrosController' => 'rwd']),
            self::ENCARGADO_ROLE => array_replace($permisos, ['centrosController' => 'rw']),
            self::STAFF_ROLE => array_replace($permisos, ['centrosController' => 'r']),
            default => []
        };

    }
}