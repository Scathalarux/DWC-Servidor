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
            $insertData['baja'] = isset($_POST['baja']) ? 1 : 0;
            $insertData['last_date'] = null;
            $insertData['id_usuario'] = null;
            $insertData['id_rol'] = ($_POST['id_rol'] !== '') ? (int)$_POST['id_rol'] : 1;
            $insertData['pass'] = password_hash($_POST['password1'], PASSWORD_DEFAULT);


            unset($insertData['password1']);
            unset($insertData['password2']);


            //controlamos que pueda haber valores null (salario y retencionIRPF)
            foreach ($insertData as $key => $value) {
                if ($value === '') {
                    $insertData[$key] = null;
                }
            }

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
        }


        //email
        if (!empty($data['email'])) {
            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errores['email'] = "Email con formáto no válido";
            }
        }

        //contraseña
        if (!empty($data['password1'])) {
            $pwd1 = false;
            $pwd2 = false;
            //Comprobamos el contenido de la contraseña1
            if (!preg_match('/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{7,})\S$/', $data['password1'])) {
                $errores['password1'] = "La contraseña debe tener al menos 8 caracteres y contener una mayúscula, un número y un caracter especial ";
            } else {
                $pwd1 = true;
            }
            //En caso de haber introducido la primera contraseña, comprobamos la existencia de la segunda contraseña
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
        }

        //idioma
        if (!empty($data['idioma'])) {
            if (mb_strlen($data['idioma']) > 2) {
                $errores['idioma'] = "El idioma debe tener 2 caracteres";
            }
        }

        return $errores;
    }
}
