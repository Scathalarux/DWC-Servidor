<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Models\AuxRolModel;
use Decimal\Decimal;
use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\UsuarioModel;

class UsuariosController extends BaseController
{
    public function showAllUsuarios()
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
        $rolModel = new AuxRolModel();
        $data['roles'] = $rolModel->getAll();

        if (!empty($_GET['nombre'])) {
            $usuarios = $model->getUsuariosByUsername($_GET['nombre']);
        } elseif (!empty($_GET['id_rol'])) {
            $usuarios = $model->getUsuariosByRol((int)$_GET['tipoUsuario']);
        } elseif (!empty($_GET['salarioBruto'])) {
            $usuarios = $model->getUsuariosBySalario((int)$_GET['salarioBruto']);
        } elseif (!empty($_GET['cotizacion'])) {
            $usuarios = $model->getUsuariosByCotizacion((int)$_GET['cotizacion']);
        } else {
            $usuarios = $model->getAllUsuarios();
        }

        $data['input'] = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['usuarios'] = $this->calcularNeto($usuarios);

        $this->view->showViews(array('templates/header.view.php', 'usuariosFiltro.view.php', 'templates/footer.view.php'), $data);
    }

    public function showOrderUsuarioSalario()
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

    public function showStandardUsers()
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

    public function showUsersByName()
    {
        $name = "Carlos";
        $data = [];
        $data = [
            'titulo' => 'Usuarios según nombre',
            'breadcrumb' => array('Usuarios', 'Usuarios según nombre'),
            'seccion' => '/usersByName'
        ];
        $model = new UsuarioModel();
        $data['usuarios'] = $this->calcularNeto($model->getUsuarioByName($name));


        $this->view->showViews(array('templates/header.view.php', 'showUsers.view.php', 'templates/footer.view.php'), $data);
    }
}
