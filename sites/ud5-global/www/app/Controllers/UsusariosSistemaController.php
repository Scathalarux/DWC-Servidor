<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Mensaje;
use Com\Daw2\Models\RolModel;
use Com\Daw2\Models\UsuariosSistemaModel;

class UsusariosSistemaController extends BaseController
{
    public function listar(): void
    {
        $data = [
            'titulo' => 'Usuarios Sistema',
            'breadcrumb' => ['Inicio', 'Usuarios Sistema']
        ];
        $usuariosSistemaModel = new UsuariosSistemaModel();
        $usuarios = $usuariosSistemaModel->getAll();
        $data['usuarios'] = $usuarios;

        $this->view->showViews(array('templates/header.view.php', 'usuariosSistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function showAddUsuario(array $errores = [], array $input = []): void
    {
        $data = [
            'titulo' => 'Añadir Usuario',
            'breadcrumb' => ['Inicio', 'Usuarios Sistema', 'Añadir Usuario'],
        ];

        $data['errores'] = $errores;
        $data['input'] = $input;

        $this->view->showViews(array('templates/header.view.php', 'editUsuariosSistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function doAddUsuario(): void
    {
        $errores = $this->checkForm($_POST, false);
        if ($errores === []) {
            $usuariosSistemaModel = new UsuariosSistemaModel();
            $insertData = $_POST;
            $insertData['contrasinal'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            unset($insertData['password2']);

            $resultado = $usuariosSistemaModel->addUsuario($insertData);
            if ($resultado) {
                $mensaje = new Mensaje('Usuario agregado', Mensaje::SUCCESS, 'Éxito');
            } else {
                $mensaje = new Mensaje('Usuario no agregado', Mensaje::ERROR, 'Error');
            }
            $this->addFlashMessage($mensaje);
            header('Location: /usuarios-sistema');

        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showAddUsuario($errores, $input);
        }
    }

    public function checkForm(array $data, bool $edit): array
    {
        $errores = [];
        $usuariosSistemaModel = new UsuariosSistemaModel();

        //nombre completo
        if (!empty($data['nombre_completo'])) {
            if (!is_string($data['nombre_completo']) && (strlen($data['nombre_completo']) > 20 || strlen($data['nombre_completo']) < 5)) {
                $errores['nombre_completo'] = 'El nombre debe tener una longitud entre 5 y 20 caracteres';
            } elseif (!preg_match('/^\p{L}[\p{L} ]+\p{L}$/iu', $data['nombre_completo'])) {
                $errores['nombre_completo'] = 'El nombre debe estar compuesto por letras y espacios';
            } elseif ($usuariosSistemaModel->getByNombre($data['nombre_completo']) !== false) {
                $errores['nombre_completo'] = 'El nombre ya existe en la BBDD';
            }

        } else {
            $errores['nombre_completo'] = 'El nombre completo es obligatorio';
        }

        //password
        if (!empty($data['password'])) {
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/iu', $data['password'])) {
                $errores['password'] = 'El password debe tener al menos 6 caracteres, 1 letra minúscula, 1 letra mayúscula, 1 número';
            }
        } else {
            $errores['password'] = 'El password es obligatorio';
        }
        if (!empty($data['password2'])) {
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/iu', $data['password2'])) {
                $errores['password2'] = 'El password debe tener al menos 6 caracteres, 1 letra minúscula, 1 letra mayúscula, 1 número';
            }
        } else {
            $errores['password2'] = 'El password es obligatorio';
        }

        if ($data['password'] !== $data['password2']) {
            $errores['password'] = 'Ambas contraseñas deben coincidir';
        }

        //email
        if (!empty($data['email'])) {
            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errores['email'] = 'El email debe tener un formato válido';
            }
        } else {
            $errores['email'] = 'El email es obligatorio';
        }

        //dni
        if (!empty($data['dni'])) {
            if (!preg_match('/^\p{N}\p{N}{6,7}[A-Z]$/u', $data['password2'])) {
                $errores['dni'] = 'El dni debe tener 7-8 números seguidos de una letra mayúscula';
            } elseif ($usuariosSistemaModel->getByDni($data['dni']) !== false) {
                $errores['dni'] = 'El dni ya existe en la BBDD';
            }
        } else {
            $errores['dni'] = 'El dni es obligatorio';
        }

        //rol
        if (!empty($data['rol'])) {
            $rolModel = new RolModel();
            if ($rolModel->find($data['rol']) === false) {
                $errores['rol'] = 'El rol no existe. Introduzca un valor válido';
            }
        } else {
            $errores['rol'] = 'El rol es obligatorio';
        }

        //idioma
        if (!empty($data['idioma'])) {
            if (!in_array($data['idioma'], ['es', 'en', 'gl'])) {
                $errores['idioma'] = "El idioma solo puede tomar los valores 'es', 'en' y 'gl'";
            }
        } else {
            $errores['idioma'] = 'El idioma es obligatorio';
        }


        return $errores;
    }

}