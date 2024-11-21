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

    public function showAddUsuario(array $input = [], array $errors = []): void
    {
        $data = [
            'titulo' => 'Añadir Usuario',
            'breadcrumb' => array('Usuarios', 'Listado de usuarios', 'Añadir usuario')
        ];

        //obtenemos el modelo y los datos de la tabla aux_rol
        $auxRolModel = new AuxRolModel();
        $data['roles'] = $auxRolModel->getAll();

        //obtenemos el modelo y los datos de la tabla aux_countries
        $auxCountriesModel = new AuxCountriesModel();
        $data['countries'] = $auxCountriesModel->getAll();

        $data['input'] = $input;
        $data['errors'] = $errors;

        $this->view->showViews(array('templates/header.view.php', 'addUsuarioFiltro.view.php', 'templates/footer.view.php'), $data);
    }

    public function addUsuario(): void
    {
        $data = [
            'titulo' => 'Añadir Usuario',
            'breadcrumb' => array('Usuarios', 'Listado de usuarios', 'Añadir usuario')
        ];
        //obtenemos el modelo de la tabla usuarios
        $model = new UsuarioModel();
        //obtenemos el modelo y los datos de la tabla aux_rol
        $auxRolModel = new AuxRolModel();
        $roles = $auxRolModel->getAll();
        $data['roles'] = $roles;

        //obtenemos el modelo y los datos de la tabla aux_countries
        $auxCountriesModel = new AuxCountriesModel();
        $countries = $auxCountriesModel->getAll();
        $data['countries'] = $countries;


        if (!empty($_POST)) {
            //Validamos los datos
            $resultado = $this->checkFormAddUsuario($_POST, $roles, $countries, $model);


            //Saneamos el input
            $data['input'] = filter_var($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (!empty($resultado['errores'])) {
                $data['errores'] = $resultado['errores'];
            } else {
                //realizamos la llamada a la query para añadirlo
                if ($model->addUsuario($resultado['data'])) {
                    header('Location: /users-filter');
                } else {
                }
            }
        }
        $this->view->showViews(array('templates/header.view.php', 'addUsuarioFiltro.view.php', 'templates/footer.view.php'), $data);
    }

    public function showEditUsuario(string $username): void
    {

        $data = [
            'titulo' => 'Editar Usuario',
            'breadcrumb' => array('Usuarios', 'Listado de usuarios', 'Editar usuario'),
            'username' => $username
        ];

        $model = new UsuarioModel();
        //obtenemos el modelo y los datos de la tabla aux_rol
        $auxRolModel = new AuxRolModel();
        $roles = $auxRolModel->getAll();
        $data['roles'] = $roles;

        //obtenemos el modelo y los datos de la tabla aux_countries
        $auxCountriesModel = new AuxCountriesModel();
        $countries = $auxCountriesModel->getAll();
        $data['countries'] = $countries;

        $usuario = $model->getUsuarioUsername($username);

        if (empty($usuario)) {
            $data['noExisteUsuario'] = "El nombre de usuario $username no existe";
/*            header('Location: /users-filter');*/
        } else {
            $data['usuario'] = $usuario[0];
        }


        $this->view->showViews(array('templates/header.view.php', 'editUsuarioFiltro.view.php', 'templates/footer.view.php'), $data);
    }

    public function checkFormAddUsuario(array $datos, array $roles, array $countries, UsuarioModel $model): array
    {
        $errores = [];
        $data = [];

        //Username
        if (!empty($datos['username'])) {
            //letras, numeros y _
            if (!preg_match('/^[\p{L}\p{N}_]{3,50}$/iu', $datos['username'])) {
                $errores['username'] = "El nombre debe contener letras, números o '_'";
            }

            //entre 3 y 50
            if (mb_strlen(trim($datos['username'])) > 50 || mb_strlen(trim($datos['username'])) < 3) {
                $errores['username'] = "El nombre debe teñer un tamaño entre 3 y 50 caracteres";
            }

            //que no esté ya en la bbdd
            //es mejor utilizar '!== []' que emplear '!empty' para saber si está vacio (sin comprobar variable, castear)
            if ($model->getUsuarioUsername($datos['username']) !== []) {
                $errores['username'] = "El nombre ya existe en la base de datos";
            }

            $data[':username'] = $datos['username'];
        } else {
            $errores['username'] = "El nombre es obligatorio";
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
                    $errores['salarioBruto'] = "El salario debe tener 2 cifras decimales";
                }
                $data[':salarioBruto'] = $datos['salarioBruto'];
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
                    $errores['cotizacion'] = "La cotización debe tener 2 cifras decimales";
                }

                $data[':retencionIRPF'] = $datos['cotizacion'];
            }
        }

        //Id-rol
        if (!empty($datos['id_rol'])) {
            if (
                (filter_var($datos['id_rol'], FILTER_VALIDATE_INT) === false)
                || (!key_exists($datos['id_rol'], $roles))
            ) {
                $errores['id_rol'] = "Rol no valido";
            }

            $data[':id_rol'] = $datos['id_rol'];
        } else {
            $errores['id_rol'] = "El rol es obligatorio";
        }

        //pais
        if (!empty($datos['id_country'])) {
            if (
                (filter_var($datos['id_country'], FILTER_VALIDATE_INT) === false)
                || (!key_exists($datos['id_country'], $countries))
            ) {
                $errores['id_country'] = "Pais no válido";
            }
            $data[':id_country'] = $datos['id_country'];
        } else {
            $errores['id_country'] = "El pais es obligatorio";
        }

        //situacion activa o no
        $data[':activo'] = isset($data['activo']);

        $result['errores'] = $errores;
        $result['data'] = $data;

        return $result;
    }

    public function doEditUsuario(string $username): void
    {
        $data = [
            'titulo' => 'Editar Usuario',
            'breadcrumb' => array('Usuarios', 'Listado de usuarios', 'Editar usuario'),
            'username' => $username
        ];

        //obtenemos el modelo de la tabla usuarios
        $model = new UsuarioModel();
        //obtenemos el modelo y los datos de la tabla aux_rol
        $auxRolModel = new AuxRolModel();
        $roles = $auxRolModel->getAll();
        $data['roles'] = $roles;

        //obtenemos el modelo y los datos de la tabla aux_countries
        $auxCountriesModel = new AuxCountriesModel();
        $countries = $auxCountriesModel->getAll();
        $data['countries'] = $countries;

        $data['usuario'] = $model->getUsuarioUsername($username);

        if (!empty($_POST)) {
            //Validamos los datos
            $resultado = $this->checkFormAddUsuario($_POST, $roles, $countries, $model);



            if (!empty($resultado['errores'])) {
                $data['errores'] = $resultado['errores'];
                $insertData = $_POST;
                $insertData['activo'] = isset($insertData['activo']) ? 1 : 0;
                foreach ($insertData as $key => $value) {
                    if (empty($value)) {
                        $insertData[$key] = null;
                    }
                }
                $model = new UsuarioModel();
                if ($model->addUsuario($insertData)) {
                    header('Location: /usuarios-filtro');
                } else {
                    $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $resultado['errores']['username'] = 'No se ha podido realizar el guardado';
                    $this->showAddUsuario($input, $resultado['errores']['username']);
                }
            } else {
                //realizamos la llamada a la query para añadirlo
                if ($model->editUsuario($resultado['data'])) {
                    header('Location: /users-filter');
                } else {
                    //Saneamos el input
                    $input = filter_var($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $this->showAddUsuario($input, $resultado['errores']);
                }
            }
        }

        $this->view->showViews(array('templates/header.view.php', 'editUsuarioFiltro.view.php', 'templates/footer.view.php'), $data);
    }
}
