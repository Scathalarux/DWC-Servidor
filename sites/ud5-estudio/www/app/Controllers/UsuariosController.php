<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxCountriesModel;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Libraries\Mensaje;
use Com\Daw2\Models\UsuariosModel;
use Decimal\Decimal;

class UsuariosController extends BaseController
{
    /** TODO
     *  - Añadir Login
     *  - Añadir Login con Google
     *  - Añadir Registro
     *  - Añadir Registro con Google
     *  - Añaidr ver perfil específico en ventana individual
     *  - Añadir Logout
     *  - Añadir obtención de permisos
     */
    private const DEFAULT_ORDER = 1;
    private const DEFAULT_PAGE = 1;
    private const DEFAULT_SIZE = 25;

    public function listarUsuarios(): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Usuarios',
            'breadcrumb' => ['Inicio', 'Usuarios'],
        ];

        $order = $this->getOrder();
        $model = new UsuariosModel();

        $copiaGet = $_GET;

        unset($copiaGet['page']);

        $data['copiaGetOrder'] = http_build_query($copiaGet);
        if (!empty($data['copiaGetOrder'])) {
            $data['copiaGetOrder'] .= '&';
        }

        unset($copiaGet['order']);
        $data['copiaGet'] = http_build_query($copiaGet);
        if (!empty($data['copiaGet'])) {
            $data['copiaGet'] .= '&';
        }


        $maxPage = $model->getMaxPage($_GET, self::DEFAULT_SIZE);
        $page = $this->getPage($maxPage);


        /*        $data['usuarios'] = $model->getUsuarios($_GET, $order);*/
        $data['usuarios'] = $model->getUsuariosPage($_GET, $order, self::DEFAULT_SIZE, $page);


        $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['order'] = $order;
        $data['maxPage'] = $maxPage;
        $data['page'] = $page;


        $this->view->showViews(array('templates/header.view.php', 'usuarioSistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function getCommonData(): array
    {
        $data = [];
        $auxCountriesModel = new AuxCountriesModel();
        $auxRolModel = new AuxRolModel();

        $data['countries'] = $auxCountriesModel->getAll();
        $data['roles'] = $auxRolModel->getAll();

        return $data;
    }

    public function getOrder(): int
    {
        if (!empty($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) < count(UsuariosModel::ORDER_COLUMNS)) {
                return (int)$_GET['order'];
            }
        }

        return self::DEFAULT_ORDER;
    }

    public function getPage(int $maxPages): int
    {
        if (!empty($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
            if ((int)$_GET['page'] > 0 && (int)$_GET['page'] <= $maxPages) {
                return (int)$_GET['page'];
            }
        }

        return self::DEFAULT_PAGE;
    }

    public function checkForm(array $data): array
    {
        $errores = [];

        //username
        if (!empty($data['username'])) {
            if (!preg_match('/[\p{L}\p{N}_]{3,50}/ui', $data['username'])){
                $errores['username'] = 'El nombre solo puede contener 3-50 caracteres, números y _';
            }
        } else {
            $errores['username'] = 'El nombre de usuario no puede estar vacio';
        }

        //salarioBruto
        if (!empty($data['salarioBruto'])) {
            if (!filter_var($data['salarioBruto'], FILTER_VALIDATE_FLOAT)) {
                $errores['salarioBruto'] = 'El salario debe ser un numero decimal';
            } else {
                if ($data['salarioBruto'] < 600) {
                    $errores['salarioBruto'] = 'El salario debe ser mayor a 600';
                }

                $salario = new Decimal($data['salarioBruto']);
                if ($salario - $salario->round(2) != 0) {
                    $errores['salarioBruto'] = 'El salario debe tener 2 decimales';
                }
            }
        } else {
            $errores['salarioBruto'] = 'El salario bruto es necesario';
        }

        //retención
        if (!empty($data['retencion'])) {
            if (!filter_var($data['retencion'], FILTER_VALIDATE_FLOAT)) {
                $errores['retencion'] = 'La retencion debe ser un numero decimal';
            }

            $retencion = new Decimal($data['retencion']);
            if ($retencion - $retencion->round(2) != 0) {
                $errores['retencion'] = 'La retención debe tener 2 decimales';
            }
        } else {
            $errores['retencion'] = 'La retención es necesaria';
        }

        //id_rol
        if (!empty($data['id_rol'])) {
            if (!filter_var($data['id_rol'], FILTER_VALIDATE_INT)) {
                $errores['id_rol'] = 'Rol no válido';
            } else {
                //nos aseguramos que es un rol dentro de la bbdd
                $auxRolModel = new AuxRolModel();
                $rol = $auxRolModel->find((int)$data['id_rol']);
                if ($rol === false) {
                    $errores['id_rol'] = 'Rol no válido';
                }
            }
        } else {
            $errores['id_rol'] = 'El rol es necesario';
        }

        //id_country
        if (!empty($data['id_country'])) {
            if (!filter_var($data['id_country'], FILTER_VALIDATE_INT)) {
                $errores['id_country'] = 'País no válido';
            } else {
                //nos aseguramos que es un rol dentro de la bbdd
                $auxCountriesModel = new AuxCountriesModel();
                $country = $auxCountriesModel->find((int)$data['iid_countryd_rol']);
                if ($country === false) {
                    $errores['id_country'] = 'País no válido';
                }

            }
        } else {
            $errores['id_country'] = 'El país es necesario';
        }


        return $errores;
    }

    public function showAddUser(array $errores = [], array $input = []): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Añadir Usuario',
            'breadcrumb' => ['Inicio', 'Usuarios', 'Añadir Usuario'],
        ];

        $data['errores'] = $errores;
        $data['input'] = $input;

        $this->view->showViews(array('templates/header.view.php', 'editUsuario.add.php', 'templates/footer.view.php'), $data);

    }

    public function doAddUser(): void
    {
        $errores = $this->checkForm($_POST);

        if ($errores === []) {
            //comprobamos que tenemos todos los datos
            $insertData = $_POST;
            $insertData['activo'] = isset($_POST['activo']) ? 1 : 0;
            //le pasamos los datos al modelo para que ejecute el add
            $model = new UsuariosModel();
            $resultado = $model->addUsuario($insertData);
            if ($resultado !== false) {
                //mensaje de éxito
                $this->addFlashMessage(new Mensaje('Usuario añadido correctamente.', 'success'));
            } else {
                //mensaje de error
                $this->addFlashMessage(new Mensaje('No se ha podido añadir el usuario.', 'danger'));
            }
            //redirigimos a la lista de usuarios
            header('Location: '.$_ENV['host.folder'].'usuariosSistema');


        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->showAddUser($errores, $input);
        }

    }

    public function showEditUser(int $idUsuario, array $errores = [], array $input = []): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Añadir Usuario',
            'breadcrumb' => ['Inicio', 'Usuarios', 'Añadir Usuario'],
        ];
        $model = new UsuariosModel();
        $usuario = $model->findUsuario($idUsuario);
        //Si no exite el usuario, redirigimos
        if ($usuario === false) {
            header('Location: '.$_ENV['host.folder'].'usuariosSistema');
        }

        $data['errores'] = $errores;
        $data['input'] = ($input === []) ? $usuario : $input;

        $this->view->showViews(array('templates/header.view.php', 'editUsuario.add.php', 'templates/footer.view.php'), $data);
    }

    public function doEditUser(string $username): void
    {

    }

    public function deleteUsuario(string $username): void
    {
        //TODO añadir condición para que si ha iniciado sesión no se pueda borrar a si mismo
        $modelUsuarios = new UsuariosModel();
        $usuario = $modelUsuarios->findUsuario($username);
        if ($usuario !== false) {
            if ($modelUsuarios->deleteUsuario($username)) {
                $this->addFlashMessage(new Mensaje('El usuario ha sido eliminado', 'success'));
            } else {
                $this->addFlashMessage(new Mensaje('El usuario no ha podido ser eliminado', 'danger'));
            }
        }

        header('Location: '.$_ENV['host.folder'].'usuariosSistema');

    }

}