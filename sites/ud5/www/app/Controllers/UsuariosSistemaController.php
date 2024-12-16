<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\UsuariosSistemaModel;

class UsuariosSistemaController extends BaseController
{
    public function showUsuariosSistema(): void
    {
        $data = [
            'titulo' => 'Usuarios Sistema',
            'breadcrumb' => ['Inicio', 'Usuarios Sistema'],
        ];

        $order = $this->getOrder();

        $modeloUsuariosSistema = new UsuariosSistemaModel();

        $usuarios = $modeloUsuariosSistema->getAll($order);

        $data['usuarios'] = $usuarios;
        $data['order'] = $order;

        $this->view->showViews(array('templates/header.view.php', 'usuariosSistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function getOrder(): int
    {
        if (!empty($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) < count(UsuariosSistemaModel::COLUMN_ORDER)) {
                return (int)$_GET['order'];
            }
        }
        return UsuariosSistemaModel::DEFAULT_ORDER;
    }

    public function getCommonData(): array
    {
        $modeloAuxRol = new AuxRolModel();

        $data['roles'] = $modeloAuxRol->getAll();
        return $data;
    }

    public function showAddUsuarioSistema(array $errores = [], array $input = []): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Nuevo Usuario',
            'breadcrumb' => ['Inicio', 'Usuarios Sistema', 'Nuevo Usuario'],
        ];

        $data['errores'] = $errores;
        $data['input'] = $input;

        $this->view->showViews(array('templates/header.view.php', 'editUsuariosSistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function doAddUsuarioSistema(): void
    {
        $errores = $this->checkForm($_POST);

        if ($errores === []) {
            $insertData = $_POST;
            //Comprobamos si se ha enviado el valor del chechbox de baja
            $insertData['baja'] = isset($_POST['baja']) ? 1 : 0;
            //Establecemos como null la fecha en la creación
            $insertData['last_date'] = null;
            //Establecemos como null el identificador del usuario ya que se lo generará la base de datos de forma autoincremental
            $insertData['id_usuario'] = null;
            //$insertData['id_rol'] = (int)$_POST['id_rol'];


            //Transformamos a hash la contraseña para introducirlo así en la base de datos
            $insertData['password1'] = password_hash($_POST['password1'], PASSWORD_DEFAULT);

            unset($insertData['password2']);

            $modeloUsuariosSistema = new UsuariosSistemaModel();

            if ($modeloUsuariosSistema->addUsuarioSistema($insertData)) {
                header('Location: /usuariosSistema');
            } else {
                $errores['nombre'] = "No se ha podido realizar la operación";
                $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->showAddUsuarioSistema($errores, $input);
            }
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showAddUsuarioSistema($errores, $input);
        }
    }

    public function checkForm(array $data): array
    {
        $errores = [];

        //rol
        if (!empty($data['id_rol'])) {
            if (filter_var($data['id_rol'], FILTER_VALIDATE_INT) === false) {
                $errores['id_rol'] = "Rol no válido";
            } else {
                $modeloAuxRol = new AuxRolModel();
                $rol = $modeloAuxRol->find((int)$data['id_rol']);
                if (is_null($rol)) {
                    $errores['id_rol'] = "Rol no válido";
                }
            }
        } else {
            $errores['id_rol'] = "El rol es obligatorio";
        }


        //email
        if (!empty($data['email'])) {
            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errores['email'] = "Email con formáto no válido";
            }
        } else {
            $errores['email'] = "El rol es obligatorio";
        }

        //contraseña
        $pwd1 = false;
        $pwd2 = false;
        if (!empty($data['password1'])) {
            //Comprobamos el contenido de la contraseña1
            if (!preg_match('/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{7,})\S$/', $data['password1'])) {
                $errores['password1'] = "La contraseña debe tener al menos 8 caracteres y contener una mayúscula, un número y un caracter especial ";
            } else {
                $pwd1 = true;
            }
        } else {
            $errores['password1'] = "La contraseña es obligatoria";
        }
        if (!empty($data['password2'])) {
            if (!preg_match('/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{7,})\S$/', $data['password2'])) {
                $errores['password2'] = "La contraseña debe tener al menos 8 caracteres y contener una mayúscula, un número y un caracter especial ";
            } else {
                $pwd2 = true;
            }
        } else {
            $errores['password2'] = "Debe repetir la contraseña";
        }

        //Si ambas contraseñas tienen buena forma, comprobamos que coinciden
        if ($pwd1 && $pwd2) {
            if ($data['password1'] !== $data['password2']) {
                $errores['password1'] = "Las contraseñas deben coincidir";
            }
        }

        //idioma
        if (!empty($data['idioma'])) {
            if (mb_strlen($data['idioma']) !== 2) {
                $errores['idioma'] = "El idioma debe tener 2 caracteres";
            }
        } else {
            $errores['idioma'] = "El idioma es obligatorio";
        }

        return $errores;
    }

    public function showEditUsuarioSistema(string $idUsuario, array $errores = [], array $input = []): void
    {
        //obtenemos los datos del usuario
        $modeloUsuariosSistema = new UsuariosSistemaModel();
        $usuario = $modeloUsuariosSistema->getUsuarioID((int)$idUsuario);

        if (is_null($usuario)) {
            header('Location: /usuariosSistema');
        }

        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Editar Usuario',
            'breadcrumb' => ['Inicio', 'Usuarios Sistema', 'Editar Usuario'],
        ];

        $data['errores'] = $errores;
        $data['input'] = ($input === []) ? $usuario : $input;

        $this->view->showViews(array('templates/header.view.php', 'editUsuariosSistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function doEditUsuarioSistema(string $idUsuario): void
    {
        //obtenemos los datos del usuario
        $modeloUsuariosSistema = new UsuariosSistemaModel();
        $usuario = $modeloUsuariosSistema->getUsuarioID((int)$idUsuario);

        if (is_null($usuario)) {
            header('Location: /usuariosSistema');
        }

        //comprobamos la existencia de errores
        $errores = $this->checkForm($_POST);
        if ($errores === []) {
            $insertData = $_POST;
            //Comprobamos si se ha enviado el valor del chechbox de baja
            $insertData['baja'] = isset($_POST['baja']) ? 1 : 0;
            //$insertData['id_rol'] = (int)$_POST['id_rol'];


            //Transformamos a hash la contraseña para introducirlo así en la base de datos
            $insertData['pass'] = password_hash($_POST['password1'], PASSWORD_DEFAULT);


            unset($insertData['password1']);
            unset($insertData['password2']);

            $modeloUsuariosSistema = new UsuariosSistemaModel();

            if ($modeloUsuariosSistema->editUsuarioSistema((int)$idUsuario, $insertData)) {
                header('Location: /usuariosSistema');
            } else {
                $errores['nombre'] = "No se ha podido realizar la operación";
                $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->showEditUsuarioSistema($idUsuario, $errores, $input);
            }
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showEditUsuarioSistema($idUsuario, $errores, $input);
        }
    }

    public function showLoginUsuariosSistema(array $errores = []): void
    {
        $data = [
          'titulo' => 'Login',
          'breadcrumb' => ['Login', 'Usuarios Sistema'],
        ];
        $data['errores'] = $errores;
        $this->view->showViews(array('templates/header.view.php', 'loginUsuariosSistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function doLoginUsuariosSistema(): void
    {
        $modeloUsuariosSistema = new UsuariosSistemaModel();
        $usuario = $modeloUsuariosSistema->getUsuarioEmail($_POST['email']);

        if ($usuario) {
            if (password_verify($_POST['password'], $usuario['pass'])) {
                isset($_POST['remember']) ? setcookie('email', $_POST['email']) : '';
                if ($modeloUsuariosSistema->editUsuarioSistemaDate((int)$usuario['id_usuario'])) {
                    header('Location: /usuariosSistema');
                };
            } else {
                $errores['verificacion'] = "El usuario o la contraseña no son correctos";
                $this->showLoginUsuariosSistema($errores);
            }
        } else {
            $errores['verificacion'] = "El usuario o la contraseña no son correctos";
            $this->showLoginUsuariosSistema($errores);
        }
    }
}
