<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxCountriesModel;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\UsuarioModel;
use Decimal\Decimal;
use Exception;

class UsuariosController extends BaseController
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_SIZE_PAGE = 25;
    public const ORDER_DEFAULT = 1;


    /**
     * Función que obtiene todos los usuarios del modelo y se los manda a la vista
     * @return void
     * @throws Exception
     */
    public function showAllUsuarios(): void
    {
        $data = [];
        $data = [
            'titulo' => 'Todos los usuarios',
            'breadcrumb' => array('Usuarios', 'Todos los usuarios'),
            'seccion' => '/allUsers'
        ];
        $model = new UsuarioModel();
        $data['usuarios'] = $this->calcularNeto($model->getAllUsuarios());
        $this->view->showViews(array('templates/header.view.php', 'showUsers.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * Función que calcula el salario neto de un usuario partiendo de su salario Bruto y retencion de IRPF
     * @param array $usuarios conjunto de usuarios a los que calcularle el salario neto
     * @return array conjunto de usuarios con el salario neto calculado y añadido
     */
    private function calcularNeto(array $usuarios): array
    {
        foreach ($usuarios as &$usuario) {
            $salarioBruto = new Decimal($usuario['salarioBruto']);
            $retencion = new Decimal($usuario['retencionIRPF']);
            $salarioNeto = $salarioBruto - ($salarioBruto * $retencion / new Decimal('100', 2));
            $usuario['salarioNeto'] = $salarioNeto->toFixed(2, true, Decimal::ROUND_HALF_UP);
        }
        return $usuarios;
    }

    /**
     * Función que filtra a los usuarios según lo que le introduce el cliente, obteniendo los latos de los modelos y
     * enviandoselos a la vista
     * @return void
     * @throws Exception
     */
    public function doFilterUsuarios(): void
    {
        $data = [];
        $data = [
            'titulo' => 'Todos los usuarios',
            'breadcrumb' => array('Usuarios', 'Listado de usuarios')
        ];
        //obtenemos el modelo de la tabla usuarios
        $model = new UsuarioModel();
        //obtenemos el modelo y los datos de la tabla aux_rol
        $auxRolModel = new AuxRolModel();
        $data['roles'] = $auxRolModel->getAll();

        //obtenemos el modelo y los datos de la tabla aux_countries
        $auxCountriesModel = new AuxCountriesModel();
        $data['countries'] = $auxCountriesModel->getAll();


        /*
                //Función para pasar los filtros de forma individual, no varios filtros a la vez
                if (!empty($_GET['username'])) {
                    $usuarios = $model->getUsuariosByUsername($_GET['username']);
                } elseif (!empty($_GET['id_rol'])) {
                    $usuarios = $model->getUsuariosByRol((int)$_GET['id_rol']);
                } elseif (
                    (!empty($_GET['salarioMinimo']) && filter_var($_GET['salarioMinimo'], FILTER_VALIDATE_FLOAT))
                    || (!empty($_GET['salarioMaximo']) && filter_var($_GET['salarioMaximo'], FILTER_VALIDATE_FLOAT))
                ) {
                    $salarioMinimo = (!empty($_GET['salarioMinimo']) && filter_var($_GET['salarioMinimo'], FILTER_VALIDATE_FLOAT)) ? new Decimal($_GET['salarioMinimo']) : null;
                    $salarioMaximo = (!empty($_GET['salarioMaximo']) && filter_var($_GET['salarioMaximo'], FILTER_VALIDATE_FLOAT)) ? new Decimal($_GET['salarioMaximo']) : null;
                    $usuarios = $model->getUsuariosBySalario($salarioMinimo, $salarioMaximo);
                } elseif (
                    (!empty($_GET['cotizacionMinima']) && filter_var($_GET['cotizacionMinima'], FILTER_VALIDATE_FLOAT))
                    || (!empty($_GET['cotizacionMaxima']) && filter_var($_GET['cotizacionMaxima'], FILTER_VALIDATE_FLOAT))
                ) {
                    $cotizacionMinima = !empty($_GET['cotizacionMinima']) && filter_var($_GET['cotizacionMinima'], FILTER_VALIDATE_FLOAT) ? new Decimal($_GET['cotizacionMinima']) : null;
                    $cotizacionMaxima = !empty($_GET['cotizacionMaxima']) && filter_var($_GET['cotizacionMaxima'], FILTER_VALIDATE_FLOAT) ? new Decimal($_GET['cotizacionMaxima']) : null;
                    $usuarios = $model->getUsuariosByCotizacion($cotizacionMinima, $cotizacionMaxima);
                } elseif (!empty($_GET['id_country'])) {
                    $usuarios = $model->getUsuariosByPais((array)$_GET['id_country']);
                } else {
                    $usuarios = $model->getAllUsuarios();
                }*/


        //obtenermos la ordenacion
        $order = $this->getOrder();
        $data['order'] = $order;

        //Alternativa simple para multiples filtros
        /*        $usuarios = $model->getUsuariosFiltered($_GET, $order);*/

        //Obtenemos el valor del número máximo de páginas que se podrán mostrar
        $data['maxPages'] = $model->getMaxPages($_GET, self::DEFAULT_SIZE_PAGE);
        //Obtenemos la página en la que está
        $page = $this->getPage($data['maxPages']);
        $data['page'] = $page;

        //mantenemos los filtros
        $copiaGet = $_GET;
        unset($copiaGet['page']);
        $data['copiaGetPage'] = http_build_query($copiaGet);
        if (!empty($data['copiaGetPage'])) {
            $data['copiaGetPage'] .= '&';
        }
        unset($copiaGet['order']);
        $data['copiaGet'] = http_build_query($copiaGet);
        if (!empty($data['copiaGet'])) {
            $data['copiaGet'] .= '&';
        }


        //Usuarios obtenidos con los filtros, la ordenación y el tamaño del listado
        $usuarios = $model->getUsersFilteredPage($_GET, $order, self::DEFAULT_SIZE_PAGE, $page);

        $data['input'] = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['usuarios'] = $this->calcularNeto($usuarios);

        $this->view->showViews(array('templates/header.view.php', 'usuariosFiltro.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * Función que a través de la elección del usuario, se indica qué columna es por la que debemos ordenar
     * @return int número que indica la columna por la que realizar la ordenación
     */
    public function getOrder(): int
    {
        //comprobamos la ordenacion
        if (!empty($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) <= count(UsuarioModel::ORDER_COLUMNS)) {
                return (int)$_GET['order'];
            }
        }
        return self::ORDER_DEFAULT;
    }

    /**
     * @param int $maxPages
     * @return int
     */
    public function getPage(int $maxPages): int
    {
        if (!empty($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
            if (((int)$_GET['page'] > 0) && ((int)$_GET['page'] <= $maxPages)) {
                return (int)$_GET['page'];
            }
        }
        return self::DEFAULT_PAGE;
    }


    /**
     * Función que obtiene los usuarios ordenados por salario y se los manda a la vista
     * @return void
     * @throws Exception
     */
    public function showOrderUsuarioSalario(): void
    {

        $data = [];
        $data = [
            'titulo' => 'Usuarios según salario',
            'breadcrumb' => array('Usuarios', 'Usuarios según salario'),
            'seccion' => '/usersBySalario'
        ];
        $model = new UsuarioModel();
        $data['usuarios'] = $this->calcularNeto($model->getUsuariosSalario());

        $this->view->showViews(array('templates/header.view.php', 'showUsers.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * Función que obtiene los usuarios de tipo 'standard' del modelo y se los manda a la vista
     * @return void
     * @throws Exception
     */
    public function showStandardUsers(): void
    {
        $data = [];
        $data = [
            'titulo' => 'Usuarios standard',
            'breadcrumb' => array('Usuarios', 'Usuarios standard'),
            'seccion' => '/standardUsers'
        ];
        $model = new UsuarioModel();
        $data['usuarios'] = $this->calcularNeto($model->getUsuariosStandard());


        $this->view->showViews(array('templates/header.view.php', 'showUsers.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * Función que obtiene los usuarios que tienen en el nombre 'Carlos' y se los envia a la vista
     * @return void
     * @throws Exception
     */
    public function showUsersCarlos(): void
    {

        $data = [];
        $data = [
            'titulo' => 'Usuarios según nombre',
            'breadcrumb' => array('Usuarios', 'Usuarios según nombre'),
            'seccion' => '/usersByName'
        ];
        $model = new UsuarioModel();
        $data['usuarios'] = $this->calcularNeto($model->getUsuariosCarlos());


        $this->view->showViews(array('templates/header.view.php', 'showUsers.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * Función que muestra la interfaz para poder añadir un usuario
     * @param array $input
     * @param array $errors
     * @return void
     * @throws Exception
     */
    public function showAddUsuario(array $input = [], array $errors = []): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Añadir Usuario',
            'breadcrumb' => array('Usuarios', 'Listado de usuarios', 'Añadir usuario')
        ];


        $data['input'] = $input;
        $data['errors'] = $errors;

        $this->view->showViews(array('templates/header.view.php', 'editUsuarioFiltro.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * Función que obtiene los roles y los paises de la base de datos
     * @return array conjunto de roles y paises
     */
    public function getCommonData(): array
    {
        $data = [];
        //obtenemos el modelo y los datos de la tabla aux_rol
        $auxRolModel = new AuxRolModel();
        $data['roles'] = $auxRolModel->getAll();

        //obtenemos el modelo y los datos de la tabla aux_countries
        $auxCountriesModel = new AuxCountriesModel();
        $data['countries'] = $auxCountriesModel->getAll();
        return $data;
    }

    /**
     * Función que añade un usuario a la base de datos
     * @return void
     */
    public function addUsuario(): void
    {
        if (!empty($_POST)) {
            $errores = $this->checkFormUsuario($_POST);

            if ($errores !== []) {
                $insertData = $_POST;
                //añadimos un elemento para saber si el usuario está activo o no
                $insertData['activo'] = isset($_POST['activo']) ? 1 : 0;
                //controlamos que pueda haber valores null (salario y retencionIRPF)
                foreach ($insertData as $key => $value) {
                    if (empty($value)) {
                        $insertData[$key] = null;
                    }
                }
                //obtenemos el modelo de la tabla usuarios
                $model = new UsuarioModel();
                //realizamos la llamada a la query para añadirlo
                if ($model->addUsuario($insertData)) {
                    header('Location: /users-filter');
                } else {
                    $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $errores['username'] = "No se ha podido realizar el guardado";
                    $this->showAddUsuario($input, $errores);
                }
            } else {
                $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->showAddUsuario($input, $errores);
            }
        }
    }

    /**
     * Función que comprueba que estén correctos los datos recibidos por el formulario y genera un arrray de errores en
     * caso de haberlos
     * @param array $datos datos a comprobar
     * @param string $oldUsername nombre anterior del usuario
     * @return array conjunto de errores encontrados
     */
    public function checkFormUsuario(array $datos, string $oldUsername = ''): array
    {
        $errores = [];

        //Username
        if ($oldUsername === '' || $oldUsername != $datos['username']) {
            if (empty($datos['username'])) {
                $errores['username'] = "El nombre es obligatorio";
            } else {
                //letras, numeros y _
                if (!preg_match('/^[\p{L}\p{N}_]{3,50}$/iu', $datos['username'])) {
                    $errores['username'] = "El nombre debe contener letras, números o '_', y tamaño entre 3 y 50 caracteres";
                }

                //que no esté ya en la bbdd
                //es mejor utilizar '!== []' que emplear '!empty' para saber si está vacio (sin comprobar variable, castear)
                $model = new UsuarioModel();
                if (!is_null($model->getUsuarioUsername($datos['username']))) {
                    $errores['username'] = "El nombre ya existe en la base de datos";
                }
            }
        }

        //SalarioBruto
        if (!empty($datos['salarioBruto'])) {
            if (filter_var($datos['salarioBruto'], FILTER_VALIDATE_FLOAT) === false) {
                $errores['salarioBruto'] = "El salario debe ser decimal";
            } else {
                if ($datos['salarioBruto'] < 600) {
                    $errores['salarioBruto'] = "El salario debe ser mayor o igual a 600€";
                }

                $salarioBrutoDecimal = new Decimal($datos['salarioBruto']);
                if ($salarioBrutoDecimal - $salarioBrutoDecimal->round(2) != 0) {
                    $errores['salarioBruto'] = "El salario solo puede tener 2 cifras decimales";
                }
            }
        }

        //retencionIRFP
        if (!empty($datos['cotizacion'])) {
            if (filter_var($datos['cotizacion'], FILTER_VALIDATE_FLOAT) === false) {
                $errores['cotizacion'] = "La cotización debe ser decimal";
            } else {
                if ($datos['cotizacion'] < 0) {
                    $errores['cotizacion'] = "La cotización debe estar entre el 18 y 30%";
                }

                $cotizacionDecimal = new Decimal($datos['cotizacion']);
                if ($cotizacionDecimal - $cotizacionDecimal->round(2) != 0) {
                    $errores['cotizacion'] = "La cotización solo puede tener 2 cifras decimales";
                }
            }
        }

        //Id-rol
        if (!empty($datos['id_rol'])) {
            if (filter_var($datos['id_rol'], FILTER_VALIDATE_INT) === false) {
                $errores['id_rol'] = "Rol no valido";
            } else {
                $auxRolModel = new AuxRolModel();
                $rol = $auxRolModel->find($datos['id_rol']);
                if (is_null($rol)) {
                    $errores['id_rol'] = "Rol no valido";
                }
            }
        } else {
            $errores['id_rol'] = "El rol es obligatorio";
        }

        //pais
        if (!empty($datos['id_country'])) {
            if (filter_var($datos['id_country'], FILTER_VALIDATE_INT) === false) {
                $errores['id_country'] = "Pais no válido";
            } else {
                $auxCountriesModel = new AuxCountriesModel();
                $country = $auxCountriesModel->find($datos['id_country']);
                if (is_null($country)) {
                    $errores['id_country'] = "País no valido";
                }
            }
        } else {
            $errores['id_country'] = "El pais es obligatorio";
        }

        return $errores;
    }

    public function showEditUsuario(string $username, array $input = [], array $errores = []): void
    {
        $model = new UsuarioModel();
        $usuario = $model->getUsuarioUsername($username);
        if (is_null($usuario)) {
            header('Location: /users-filter');
        }
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Editar Usuario',
            'breadcrumb' => array('Usuarios', 'Listado de usuarios', 'Editar usuario'),
            'username' => $username
        ];

        $data['input'] = ($input === []) ? $usuario : $input;
        $data['errors'] = $errores;


        $this->view->showViews(array('templates/header.view.php', 'editUsuarioFiltro.view.php', 'templates/footer.view.php'), $data);
    }

    public function doEditUsuario(string $username): void
    {
        //obtenemos el modelo de la tabla usuarios
        $model = new UsuarioModel();
        $usuario = $model->getUsuarioUsername($username);
        if (is_null($usuario)) {
            header('Location: /users-filter');
        }
        if (!empty($_POST)) {
            $errores = $this->checkFormUsuario($_POST);

            if ($errores !== []) {
                $insertData = $_POST;
                //añadimos un elemento para saber si el usuario está activo o no
                $insertData['activo'] = isset($_POST['activo']) ? 1 : 0;
                //controlamos que pueda haber valores null (salario y retencionIRPF)
                foreach ($insertData as $key => $value) {
                    if (empty($value)) {
                        $insertData[$key] = null;
                    }
                }
                //realizamos la llamada a la query para añadirlo
                if ($model->editUsuario($insertData, $username)) {
                    header('Location: /users-filter');
                } else {
                    $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $errores['username'] = "No se ha podido realizar el guardado";
                    $this->showEditUsuario($username, $input, $errores);
                }
            } else {
                $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->showEditUsuario($username, $input, $errores);
            }
        }
    }

    /*public function deleteUsuario(string $username): bool
    {
    }*/

}
