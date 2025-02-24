<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Mensaje;
use Com\Daw2\Models\RolModel;
use Com\Daw2\Models\UsuariosSistemaModel;

class UsusariosSistemaController extends BaseController
{
    private const ALLOWED_PARAMS = ['id_rol', 'dni', 'email', 'nombre_completo', 'contrasinal', 'idioma'];
    private const DEFAULT_ORDER = 1;

    public function getCommonData(): array
    {
        $data = [];

        $rolModel = new RolModel();
        $data['roles'] = $rolModel->getAll();

        $data['idiomas'] = ['es', 'en', 'gl'];

        return $data;
    }

    public function listar(): void
    {
        $data = [
            'titulo' => 'Usuarios Sistema',
            'breadcrumb' => ['Inicio', 'Usuarios Sistema']
        ];
        $data += $this->getCommonData();
        $usuariosSistemaModel = new UsuariosSistemaModel();
        $order = $this->getOrder();

        $copiaGet = $_GET;
        unset($copiaGet['order']);
        $data['copiaGet'] = http_build_query($copiaGet);
        if (!empty($data['copiaGet'])) {
            $data['copiaGet'] .= '&';
        }

        $usuarios = $usuariosSistemaModel->getAll($_GET, $order);
        $data['usuarios'] = $usuarios;
        $data['order'] = $order;
        $data['input']= filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $this->view->showViews(array('templates/header.view.php', 'usuariosSistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function getUsuario(int $idUsuario)
    {
        $data = [
            'titulo' => 'Usuarios Sistema',
            'breadcrumb' => ['Inicio', 'Usuarios Sistema']
        ];
        $data += $this->getCommonData();
        $usuariosSistemaModel = new UsuariosSistemaModel();
        $usuario = $usuariosSistemaModel->getById($idUsuario);
        $data['input'] = $usuario;
        $data['onlyRead'] = true;
        $data['add'] = false;
        $this->view->showViews(array('templates/header.view.php', 'editUsuariosSistema.view.php', 'templates/footer.view.php'), $data);

    }

    public function getOrder(): int
    {
        if (isset($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) <= count(UsuariosSistemaModel::ORDER_COLUMNS)) {
                return (int)$_GET['order'];
            }
        }
        return self::DEFAULT_ORDER;
    }

    public function showAddUsuario(array $errores = [], array $input = []): void
    {
        $data = [
            'titulo' => 'Añadir Usuario',
            'breadcrumb' => ['Inicio', 'Usuarios Sistema', 'Añadir Usuario'],
        ];
        $data += $this->getCommonData();

        $data['errores'] = $errores;
        $data['input'] = $input;
        $data['onlyRead'] = false;
        $data['add'] = true;

        $this->view->showViews(array('templates/header.view.php', 'editUsuariosSistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function doAddUsuario(): void
    {
        $errores = $this->checkForm($_POST, false);
        if ($errores === []) {
            $usuariosSistemaModel = new UsuariosSistemaModel();
            $insertData = [];
            foreach (self::ALLOWED_PARAMS as $param) {
                if ($param === 'contrasinal') {
                    $insertData[$param] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                } else {
                    $insertData[$param] = $_POST[$param];
                }
            }
            //baja por defecto
            $insertData['baja'] = 0;


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

    public function checkForm(array $data, bool $edit, array $userData = []): array
    {
        $errores = [];
        $usuariosSistemaModel = new UsuariosSistemaModel();

        if ($edit) {
            //nombre
            if ($data['nombre_completo'] !== $userData['nombre_completo']) {
                if ($usuariosSistemaModel->getByNombre($data['nombre_completo']) !== false) {
                    $errores['nombre_completo'] = 'El nombre de usuario ya existe';
                }
            }
            //email
            if ($data['email'] !== $userData['email']) {
                if ($usuariosSistemaModel->getByEmail($data['email']) !== false) {
                    $errores['email'] = 'El email de usuario ya existe';
                }
            }

            //dni
            if ($data['dni'] !== $userData['dni']) {
                if ($usuariosSistemaModel->getByDni($data['dni']) !== false) {
                    $errores['dni'] = 'El dni de usuario ya existe';
                }
            }
        }

        //nombre completo
        if (!empty($data['nombre_completo'])) {
            if (!is_string($data['nombre_completo'])) {
                $errores['nombre_completo'] = 'El nombre debe ser de tipo texto';
            } elseif (!preg_match('/^\p{L}[\p{L} ]{3,18}\p{L}$/iu', $data['nombre_completo'])) {
                $errores['nombre_completo'] = 'El nombre debe estar compuesto por letras y espacios';
            } elseif ($edit === false && $usuariosSistemaModel->getByNombre($data['nombre_completo']) !== false) {
                $errores['nombre_completo'] = 'El nombre ya existe en la BBDD';
            }

        } else {
            $errores['nombre_completo'] = 'El nombre completo es obligatorio';
        }

        //password
        if (!empty($data['password'])) {
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/u', $data['password'])) {
                $errores['password'] = 'El password debe tener al menos 6 caracteres, 1 letra minúscula, 1 letra mayúscula, 1 número';
            }
        } elseif ($edit === false) {
            $errores['password'] = 'El password es obligatorio';
        }
        if (!empty($data['password2'])) {
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/u', $data['password2'])) {
                $errores['password2'] = 'El password debe tener al menos 6 caracteres, 1 letra minúscula, 1 letra mayúscula, 1 número';
            }
        } elseif ($edit === false) {
            $errores['password2'] = 'El password es obligatorio';
        }
        if ($edit === false) {
            if ($data['password'] !== $data['password2']) {
                $errores['password'] = 'Ambas contraseñas deben coincidir';
            }
        }

        //email
        if (!empty($data['email'])) {
            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errores['email'] = 'El email debe tener un formato válido';
            } elseif ($edit === false && $usuariosSistemaModel->getByEmail($data['email']) !== false) {
                $errores['email'] = 'El email ya existe en la BBDD';
            }
        } else {
            $errores['email'] = 'El email es obligatorio';
        }

        //dni
        if (!empty($data['dni'])) {
            if (!preg_match('/^\p{N}\p{N}{6,7}[A-Z]$/u', $data['dni'])) {
                $errores['dni'] = 'El dni debe tener 7-8 números seguidos de una letra mayúscula';
            } elseif ($edit === false && $usuariosSistemaModel->getByDni($data['dni']) !== false) {
                $errores['dni'] = 'El dni ya existe en la BBDD';
            }
        } else {
            $errores['dni'] = 'El dni es obligatorio';
        }

        //rol
        if (!empty($data['id_rol'])) {
            $rolModel = new RolModel();
            if ($rolModel->find((int)$data['id_rol']) === false) {
                $errores['id_rol'] = 'El rol no existe. Introduzca un valor válido';
            }
        } else {
            $errores['id_rol'] = 'El rol es obligatorio';
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

    public
    function showEditUsuario(int $idUsuario, array $errores = [], array $input = []): void
    {
        $data = [
            'titulo' => 'Editar Usuario',
            'breadcrumb' => ['Inicio', 'Usuarios Sistema', 'Editar Usuario'],
        ];
        $data += $this->getCommonData();

        $userModel = new UsuariosSistemaModel();
        $user = $userModel->getById((int)$idUsuario);
        if ($user === false) {
            header('Location: /usuarios-sistema');
        }

        $data['errores'] = $errores;
        $data['input'] = $input === [] ? $user : $input;;
        $data['onlyRead'] = false;
        $data['add'] = false;
        $data['sameUser'] = ((int)$_SESSION['id_usuario'] === $idUsuario) ? true : false;

        $this->view->showViews(array('templates/header.view.php', 'editUsuariosSistema.view.php', 'templates/footer.view.php'), $data);
    }

    public
    function doEditUsuario(int $idUsuario): void
    {
        $usuariosSistemaModel = new UsuariosSistemaModel();
        $usuario = $usuariosSistemaModel->getById($idUsuario);

        $errores = $this->checkForm($_POST, true, $usuario);
        if ($errores === []) {
            $insertData = [];
            foreach (self::ALLOWED_PARAMS as $param) {
                if ($param === 'contrasinal') {
                    $insertData[$param] = (isset($_POST['password'])) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $usuario['constrasinal'];
                } else {
                    $insertData[$param] = $_POST[$param];
                }
            }

            $resultado = $usuariosSistemaModel->editUsuario($idUsuario, $insertData);
            if ($resultado) {
                $mensaje = new Mensaje('Usuario modificado', Mensaje::SUCCESS, 'Éxito');
            } else {
                $mensaje = new Mensaje('Usuario no modificado', Mensaje::ERROR, 'Error');
            }
            $this->addFlashMessage($mensaje);
            header('Location: /usuarios-sistema');

        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showEditUsuario($idUsuario, $errores, $input);
        }
    }

    public
    function changeBajaUsuario(int $idUsuario): void
    {
        $usuariosSistemaModel = new UsuariosSistemaModel();
        $usuario = $usuariosSistemaModel->getById($idUsuario);
        if ($usuario === false) {
            header('Location: /usuarios-sistema');
        } else {
            $usuario['baja'] = !$usuario['baja'];
            if ($usuariosSistemaModel->changeBaja($idUsuario, (int)$usuario['baja'])) {
                $mensaje = new Mensaje('Usuario modificado', Mensaje::SUCCESS, 'Éxito');
            } else {
                $mensaje = new Mensaje('Usuario no modificado', Mensaje::ERROR, 'Error');
            }
            $this->addFlashMessage($mensaje);
            header('Location: /usuarios-sistema');
        }
    }

    public function deleteUsuario(int $idUsuario): void
    {
        $usuariosSistemaModel = new UsuariosSistemaModel();
        $usuario = $usuariosSistemaModel->getById($idUsuario);
        if ($usuario === false) {
            header('Location: /usuarios-sistema');
        } else {
            if ($usuariosSistemaModel->deleteUsuario($idUsuario, (int)$usuario['baja'])) {
                $mensaje = new Mensaje('Usuario modificado', Mensaje::SUCCESS, 'Éxito');
            } else {
                $mensaje = new Mensaje('Usuario no modificado', Mensaje::ERROR, 'Error');
            }
            $this->addFlashMessage($mensaje);
            header('Location: /usuarios-sistema');
        }
    }


}