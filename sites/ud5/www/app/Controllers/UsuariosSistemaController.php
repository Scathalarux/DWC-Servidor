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

        if()

    }

    public function checkForm(array $data): array
    {
        $errores = [];

        return $errores;
    }
}
