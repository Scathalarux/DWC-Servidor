<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\CategoriaModel;
use Exception;

class CategoriaController extends BaseController
{

    public function respuestaToJson(Respuesta $respuesta)
    {
        $this->view->show('json.view.php', ['respuesta' => $respuesta]);
    }


    public function getAllAPI(): Respuesta
    {
        try {
            $categoriaModel = new CategoriaModel();
            $categorias = $categoriaModel->getAll(['nombre_categoria' => $_GET['categoria'] ?? '']);

            $respuesta = new Respuesta(200, $categorias);

        } catch (Exception $ex) {
            $respuesta = new Respuesta(500, []);
        }

        return $respuesta;
    }

    public function getCategoriaAPI(string $idCategoria): Respuesta
    {
        try {
            $categoriaModel = new CategoriaModel();
            $categoria = $categoriaModel->getCategoria((int)$idCategoria);

            if (!$categoria) {
                $respuesta = new Respuesta(404, []);
            } else {
                $respuesta = new Respuesta(200, $categoria);
            }
        } catch (Exception $ex) {
            $respuesta = new Respuesta(500, []);
        }
        return $respuesta;
    }

    public function addCategoriaAPI(): Respuesta
    {
        try {
            $categoriaModel = new CategoriaModel();

            var_dump($_POST);
            //comprobacion id_padre es válido
            $padre = $categoriaModel->getCategoria($_POST['id_padre']);
            if ($_POST['id_padre'] === null || !empty($padre)) {
                $categoria = $categoriaModel->addCategoria(['id_padre' => $_POST['id_padre'], 'nombre_categoria' => $_POST['nombre_categoria']]);
                if (is_array($categoria)) {
                    $respuesta = new Respuesta(201, $categoria);
                } else {
                    $respuesta = new Respuesta(409, []);
                }
            } else {
                $respuesta = new Respuesta(422, []);
            }
        } catch (Exception $ex) {
            $respuesta = new Respuesta(500, []);
        }

        return $respuesta;
    }

}