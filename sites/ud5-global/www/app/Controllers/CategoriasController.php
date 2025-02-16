<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CategoriaModel;

class CategoriasController extends BaseController
{
    public function listarCategorias(): void
    {
        $data = [
            'titulo' => 'Categorias',
            'breadcrumb' => ['Inicio', 'Listado Categorias'],
        ];
        $categoriaModel = new CategoriaModel();

        $data['categorias'] = $categoriaModel->getAll();

        $this->view->showViews(array('templates/header.view.php', 'categorias.view.php', 'templates/footer.view.php'), $data);
    }

}