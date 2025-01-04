<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxCountriesModel;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\UsuariosModel;
use Decimal\Decimal;

class UsuariosController extends BaseController
{
    public function showUsuarios(): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Usuarios',
            'breadcrumb' => ['Inicio', 'Usuarios'],
        ];

        $usuariosModel = new UsuariosModel();

        $usuarios = $usuariosModel->getUsuarios();

        $data['usuarios'] = $usuarios;

        $this->view->showViews(array('templates/header.view.php', 'usuarios.view.php', 'templates/footer.view.php'), $data);
    }

    public function showFilteredUsuarios()
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Usuarios',
            'breadcrumb' => ['Inicio', 'Usuarios'],
        ];

        $usuariosModel = new UsuariosModel();

        $usuarios = $usuariosModel->getFilteredUsuarios($_GET);
        $input = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data['usuarios'] = $usuarios;
        $data['input'] = $input;

        $this->view->showViews(array('templates/header.view.php', 'usuarios.view.php', 'templates/footer.view.php'), $data);
    }

    public function getCommonData(): array
    {
        $auxRolModel = new AuxRolModel();
        $auxCountriesModel = new AuxCountriesModel();

        $roles = $auxRolModel->getAll();
        $countries = $auxCountriesModel->getAll();

        $data['roles'] = $roles;
        $data['countries'] = $countries;

        return $data;
    }

    public function showNewUsuario(array $errors = [], array $input = []): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Nuevo Usuario',
            'breadcrumb' => ['Inicio', 'Usuarios', 'Nuevo Usuario'],
        ];

        $data['input'] = $input;
        $data['errors'] = $errors;


        $this->view->showViews(array('templates/header.view.php', 'usuariosEdit.view.php'), $data);
    }

    public function doNewUsuario()
    {
        $errors = $this->checkForm($_POST);
        if ($errors === []) {
            $insertData = $_POST;
            $insertData['activo'] = isset($_POST['activo']) ? 1 : 0;

            $userModel = new UsuariosModel();
            if ($userModel->addUsuario($insertData)) {
                header('Location: /usuarios');
            } else {
                $errors['username'] = "No se ha podido realizar la operación";
                $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->showNewUsuario($errors, $input);
            }
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showNewUsuario($errors, $input);
            /*header('Location: /usuarios');*/
        }
    }

    public function checkForm(array $data): array
    {
        $errors = [];
        //username
        if (!empty($data['username'])) {
            if (!preg_match('/^[\p{L}\p{N}_]{3,50}$/', $data['username'])) {
                $errors['username'] = 'El username debe tener 3 y 50 caracteres, números y _';
            }
            $userModel = new UsuariosModel();
            $usuario = $userModel->getUsuarioByUsername($data['username']);
            if ($usuario) {
                $errors['username'] = 'El nombre de usuario ya existe';
            }
        } else {
            $errors['username'] = 'El nombre de usuario es obligatorio';
        }

        //pais
        if (!empty($data['id_country'])) {
            if (filter_var($data['id_country'], FILTER_VALIDATE_INT) === false) {
                $errors['id_country'] = 'País no válido 1';
            } else {
                //comprobamos que esté dentro de uno de los roles de la BBDD
                $countriesModel = new AuxCountriesModel();

                $country = $countriesModel->find((int)$data['id_country']);
                if (is_null($country)) {
                    $errors['id_country'] = 'País no válido2';
                }
            }
        } else {
            $errors['id_country'] = 'El país es obligatorio';
        }

        //rol
        if (!empty($data['id_rol'])) {
            if (filter_var($data['id_rol'], FILTER_VALIDATE_INT) === false) {
                $errors['id_rol'] = 'Rol no válido';
            } else {
                //comprobamos que esté dentro de uno de los roles de la BBDD
                $rolModel = new AuxRolModel();

                $rol = $rolModel->find((int)$data['id_rol']);
                if (is_null($rol)) {
                    $errors['id_rol'] = 'Rol no válido';
                }
            }
        } else {
            $errors['id_rol'] = 'El rol es obligatorio';
        }

        //salarioBruto
        if (!empty($data['salarioBruto'])) {
            if (filter_var($data['salarioBruto'], FILTER_VALIDATE_FLOAT) === false) {
                $errors['salarioBruto'] = 'El salario bruto debe ser decimal';
            } else {
                if ($data['salarioBruto'] < 600) {
                    $errors['salarioBruto'] = 'El salario debe ser mayor o igual 600€';
                }
                $salarioBruto = new Decimal($data['salarioBruto']);
                if ($salarioBruto - $salarioBruto->round(2) != 0) {
                    $errors['salarioBruto'] = 'El salario debe tener 2 números decimales';
                }
            }
        } else {
            $errors['salarioBruto'] = 'El salario bruto es obligatorio';
        }

        //retencionIRPF
        if (!empty($data['retencion'])) {
            if (filter_var($data['retencion'], FILTER_VALIDATE_FLOAT) === false) {
                $errors['retencion'] = 'La retencion debe ser decimal';
            } else {
                $retencion = new Decimal($data['retencion']);
                if ($retencion - $retencion->round(2) != 0) {
                    $errors['retencion'] = 'La retencion debe tener 2 números decimales';
                }
            }
        } else {
            $errors['retencion'] = 'La retencion es obligatorio';
        }


        return $errors;
    }
}
