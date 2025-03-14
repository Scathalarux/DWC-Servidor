<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\PermisosModel;
use Com\Daw2\Models\RolModel;
use Com\Daw2\Models\UsuariosSistemaModel;

class UsuariosSistemaController extends BaseController
{
    public const DEFAULT_ROL = 3;
    public const DEFAULT_IDIOMA = 'es';
    public const CHECK_ADD = 'add';
    public const CHECK_EDIT = 'edit';
    public const CHECK_REGISTER = 'register';

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
        $modeloRol = new RolModel();

        $data['roles'] = $modeloRol->getAll();
        $data['staff'] = $modeloRol->getRol('Staff');
        $data['admin'] = $modeloRol->getRol('Administrator');
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
        $errores = $this->checkForm($_POST, self::CHECK_ADD);

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
            $insertData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

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

    public function checkForm(array $data, string $type): array
    {
        $errores = [];

        if ($type !== 'register') {
            //rol
            if (!empty($data['id_rol'])) {
                if (filter_var($data['id_rol'], FILTER_VALIDATE_INT) === false) {
                    $errores['id_rol'] = "Rol no válido";
                } else {
                    $modeloRol = new RolModel();
                    $rol = $modeloRol->find((int)$data['id_rol']);
                    if (is_null($rol)) {
                        $errores['id_rol'] = "Rol no válido";
                    }
                }
            } else {
                $errores['id_rol'] = "El rol es obligatorio";
            }

            //idioma
            if (!empty($data['idioma'])) {
                if (mb_strlen($data['idioma']) !== 2) {
                    $errores['idioma'] = "El idioma debe tener 2 caracteres";
                }
            } else {
                $errores['idioma'] = "El idioma es obligatorio";
            }
        } else {
            //términos
            if (!isset($data['terminos'])) {
                $errores['terminos'] = "Los términos son obligatorios";
            }
        }

        //nombre
        if (empty($data['nombre'])) {
            $errores['nombre'] = "El nombre es obligatorio";
        }

        //email
        if (!empty($data['email'])) {
            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errores['email'] = "Email con formáto no válido";
            }
        } else {
            $errores['email'] = "El rol es obligatorio";
        }


        //Comprobaremos la contraseña en caso de que se esté añadiendo un nuevo usuario
        //Si está en la edición y no introduce un cambio en la contraseña, se omitirá
        if ($type === "add" || $type === "register") {
            if (empty($data['password'])) {
                $errores['password'] = "La contraseña es obligatoria";
            }
            if (empty($data['password2'])) {
                $errores['password2'] = "Debe repetir la contraseña";
            }
        }
        //contraseña
        $pwd1 = false;
        $pwd2 = false;
        if (!empty($data['password'])) {
            //Comprobamos el contenido de la contraseña1
            if (!preg_match('/^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,}\S$/', $data['password'])) {
                $errores['password'] = "La contraseña debe tener al menos 7 caracteres y contener una mayúscula, un número y un caracter especial ";
            } else {
                $pwd1 = true;
            }
        }

        if (!empty($data['password2'])) {
            if (!preg_match('/^((?=\S *?[A - Z])(?=\S *?[a - z])(?=\S *?[0 - 9]).{6,})\S$/', $data['password2'])) {
                $errores['password2'] = "La contraseña debe tener al menos 7 caracteres y contener una mayúscula, un número y un caracter especial ";
            } else {
                $pwd2 = true;
            }
        }

        //Si ambas contraseñas tienen buena forma, comprobamos que coinciden
        if ($pwd1 && $pwd2) {
            if ($data['password'] !== $data['password2']) {
                $errores['password'] = "Las contraseñas deben coincidir";
            }
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
        $errores = $this->checkForm($_POST, self::CHECK_EDIT);
        if ($errores === []) {
            $insertData = $_POST;
            //Comprobamos si se ha enviado el valor del chechbox de baja
            $insertData['baja'] = isset($_POST['baja']) ? 1 : 0;
            //$insertData['id_rol'] = (int)$_POST['id_rol'];

            if ($_POST['password1'] !== '') {
                //Transformamos a hash la contraseña para introducirlo así en la base de datos
                $insertData['pass'] = password_hash($_POST['password1'], PASSWORD_DEFAULT);
            } else {
                $insertData['pass'] = $usuario['pass'];
            }


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

    public function doDeleteUsuarioSistema(string $idUsuario): void
    {
        $modeloUsuariosSistema = new UsuariosSistemaModel();
        $usuario = $modeloUsuariosSistema->getUsuarioID((int)$idUsuario);

        if (is_null($usuario)) {
            header('Location: /usuariosSistema');
        } else {
            $delete = $modeloUsuariosSistema->doDeleteUsuario((int)$idUsuario);
            header('Location: /usuariosSistema');
        }
    }

    public function showLogin(array $errores = []): void
    {
        $data['errores'] = $errores;
        $this->view->showViews(array('login . view . php'), $data);
    }

    public function doLogin(): void
    {
        $modeloUsuariosSistema = new UsuariosSistemaModel();
        $usuario = $modeloUsuariosSistema->getUsuarioEmail($_POST['email']);
        $passOk = false;

        if (!is_null($usuario)) {
            $passOk = password_verify($_POST['password'], $usuario['pass']);
            if ($passOk) {
                isset($_POST['remember']) ? setcookie('email', $_POST['email']) : '';
                $_SESSION['username'] = ucfirst($usuario['nombre']);
                $_SESSION['id_rol'] = $usuario['id_rol'];
                $_SESSION['permisos'] = $this->getPermisos((int)$usuario['id_rol']);
                if ($modeloUsuariosSistema->editUsuarioSistemaDate((int)$usuario['id_usuario'])) {
                    header('Location: /usuariosSistema');
                } else {
                    $errores['verificacion'] = "Se ha producido un error, vuelva a intentarlo";
                    $this->showLogin($errores);
                }
            }
        }

        if ($usuario === false || $passOk === false) {
            $errores['verificacion'] = "El usuario o la contraseña no son correctos";
            $this->showLogin($errores);
        }
    }

    public function showRegister(array $errores = [], array $input = []): void
    {
        $data['errores'] = $errores;
        $data['input'] = $input;
        $this->view->showViews(array('register . view . php'), $data);
    }

    public function doRegister(): void
    {
        $errors = $this->checkForm($_POST, self::CHECK_REGISTER);
        if ($errors === []) {
            $model = new UsuariosSistemaModel();

            $usuario = $model->addUsuarioSistema(
                [
                    'id_usuario' => null,
                    'id_rol' => self::DEFAULT_ROL,
                    'email' => $_POST['email'],
                    'pass' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    'nombre' => $_POST['nombre'],
                    'last_date' => null,
                    'idioma' => self::DEFAULT_IDIOMA,
                    'baja' => 0
                ]
            );
            /*if ($usuario) {
                $this->addFlashMessage(new Mensaje('Usuario registrado correctamente', Mensaje::SUCCESS, 'Éxito'));
            } else {
                $this->addFlashMessage(new Mensaje('No se ha podido insertar al usuario', Mensaje::ERROR, 'Error'));
            }*/
            header('Location: /login');

        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showRegister($errors, $input);
        }
    }

    public function doLogout(): void
    {
        session_destroy();
        header('Location: /usuariosSistema / login');
    }


    public function getPermisos(int $id_rol): array
    {
        $permisos = [
            'csvController' => '',
            'preferenciasUsuario' => '',
            'usuariosController' => '',
            'userController' => '',
            'usuariosSistemaController' => '',
            'inicioController' => ''
        ];

        //Obtenemos los diferentes roles para relacionarlos con su id_rol
        $rolModel = new RolModel();
        $admin = $rolModel->getRol('admin');
        $encargado = $rolModel->getRol('encargado');
        $staff = $rolModel->getRol('staff');

        //Asignamos los permisos a los diferentes roles de la BBDD
        if ($id_rol == $admin['id_rol']) {
            //Acceso a all
            $permisos['csvController'] = 'rwd';
            $permisos['preferenciasUsuario'] = 'rwd';
            $permisos['usuariosController'] = 'rwd';
            $permisos['userController'] = 'rwd';
            $permisos['usuariosSistemaController'] = 'rwd';
            $permisos['inicioController'] = 'rwd';
        } elseif ($id_rol == $encargado['id_rol']) {
            //Acceso a all - gestión de los usuarios
            $permisos['csvController'] = 'rwd';
            $permisos['preferenciasUsuario'] = 'rwd';
            $permisos['userController'] = 'rwd';
            $permisos['usuariosSistemaController'] = 'rwd';
            $permisos['inicioController'] = 'rwd';

        } elseif ($id_rol == $staff['id_rol']) {
            //Acceso a los usuarios y csv solo vista
            $permisos['csvController'] = 'r';
            $permisos['usuariosController'] = 'r';
        }

        return $permisos;
    }

    public function getPermisosBBDD(int $id_rol): array
    {
        $permisosModel = new PermisosModel();
        $permisos = $permisosModel->getPermisosRol($id_rol);

        return $permisos;
    }

    public function createPermisos(): void
    {
        //Obtenemos los diferentes roles para relacionarlos con su id_rol
        $rolModel = new RolModel();
        $admin = $rolModel->getRol('admin');
        $encargado = $rolModel->getRol('encargado');
        $staff = $rolModel->getRol('staff');

        //Creamos la tabla que almacenará los permisos
        $permisosModel = new PermisosModel();
        $permisosModel->createTablePermisos();

        //Array de secciones a las que se gestiona el acceso
        $secciones = ['csvController', 'preferenciasUsuario', 'usuariosController', 'usuariosSistemaController', 'userController', 'inicioController'];

        //Bucle para introducir los
        if ($admin['id_rol']) {
            foreach ($secciones as $seccion) {
                $permisosModel->addPermiso($admin['id_rol'], $seccion, 'rwd');
            }
        } elseif ($encargado['id_rol']) {

        } elseif ($staff['id_rol']) {

        }
    }

}
