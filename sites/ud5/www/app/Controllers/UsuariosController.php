<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxCountriesModel;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\UsuarioModel;
use Decimal\Decimal;

class UsuariosController extends BaseController
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_SIZE_PAGE = 25;
    public const ORDER_DEFAULT = 1;


    /**
     * Función que obtiene todos los usuarios del modelo y se los manda a la vista
     * @return void
     * @throws \Exception
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
     * @throws \Exception
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
        $data['maxPages'] = $model->getMaxPages($_GET);
        //Obtenemos la página en la que está
        $page = $this->getPage($data['maxPages']);
        $data['page'] = $page;

        //mantenemos los filtros
        $copiaGet = $_GET;
        unset($copiaGet['order']);
        unset($copiaGet['page']);
        $data['copiaGet'] = http_build_query($copiaGet);
        if (!empty($data['copiaGet'])) {
            $data['copiaGet'] .= '&';
        }


        //Usuarios obtenidos con los filtros, la ordenación y el tamaño del listado
        $usuarios = $model->getUsuersFilteredPage($_GET, $order, self::DEFAULT_SIZE_PAGE, $page);

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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
}
