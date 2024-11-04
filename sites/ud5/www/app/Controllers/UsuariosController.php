<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Decimal\Decimal;
use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\UsuarioModel;

class UsuariosController extends BaseController
{
    public function doAllUsuarios()
    {
        $data = [];
        $data = [
            'titulo' => 'Todos los usuarios',
            'breadcrumb' => array('Usuarios', 'Todos los usuarios'),
            'seccion' => '/allUsers'
            ];
        $model = new UsuarioModel();
        $usuarios = $model->getAllUsuarios();
        foreach ($usuarios as &$usuario) {
            $salarioBruto = new Decimal($usuario['salarioBruto']);
            $retencion = new Decimal($usuario['retencionIRPF']);
            $usuario['salarioNeto'] =  $salarioBruto - ($salarioBruto * $retencion / new Decimal('100', 2)) ;
        }
        $data['usuarios'] = $usuarios;


        $this->view->showViews(array('templates/header.view.php', 'showUsers.view.php', 'templates/footer.view.php'), $data);
    }

    public function doOrderUsuarioSalario()
    {

        $data = [];
        $data = [
            'titulo' => 'Usuarios según salario',
            'breadcrumb' => array('Usuarios', 'Usuarios según salario'),
            'seccion' => '/usersBySalario'
        ];
        $model = new UsuarioModel();
        $data['usuarios'] = $model->getUsuariosBySalario();

        $this->view->showViews(array('templates/header.view.php', 'showUsers.view.php', 'templates/footer.view.php'), $data);
    }

    public function doStandardUsers()
    {
        $data = [];
        $data = [
            'titulo' => 'Usuarios standard',
            'breadcrumb' => array('Usuarios', 'Usuarios standard'),
            'seccion' => '/standardUsers'
        ];
        $model = new UsuarioModel();
        $data['usuarios'] = $model->getUsuariosStandard();

        $this->view->showViews(array('templates/header.view.php', 'showUsers.view.php', 'templates/footer.view.php'), $data);
    }

    public function doUsersByName()
    {
        $name = "Carlos";
        $data = [];
        $data = [
            'titulo' => 'Usuarios según nombre',
            'breadcrumb' => array('Usuarios', 'Usuarios según nombre'),
            'seccion' => '/usersByName'
        ];
        $model = new UsuarioModel();
        $data['usuarios'] = $model->getUsuarioByName($name);

        $this->view->showViews(array('templates/header.view.php', 'showUsers.view.php', 'templates/footer.view.php'), $data);
    }
}
