<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\CategoriaModel;

class CategoriaController extends BaseController
{
    public function listCategorias(): void
    {
        try {
            $model = new CategoriaModel();
            $data = $model->get(['nombre_categoria' => $_GET['nombre_categoria'] ?? '']);
            $respuesta = new Respuesta(200, $data);
        } catch (\Exception $e) {
            $respuesta = new Respuesta(500);
        } finally {
            $this->view->show('json.view.php', ['respuesta' => $respuesta]);
        }
    }


    public function get(int $idCategoria): void
    {
        try {
            $model = new CategoriaModel();
            $row = $model->find($idCategoria);
            if ($row === false) {
                $respuesta = new Respuesta(404);
            } else {
                $respuesta = new Respuesta(200, $row);
            }
        } catch (\Exception $e) {
            $respuesta = new Respuesta(500);
        } finally {
            $this->view->show('json.view.php', ['respuesta' => $respuesta]);
        }
    }

    public function addCategoria(): void
    {
        try {
            $model = new CategoriaModel();
            //comprobamos que exista un padre o sea de tipo null
            $idPadre = isset($_POST['id_padre']) ? $_POST['id_padre'] : null;

            if (
                (filter_var($idPadre, FILTER_VALIDATE_INT) !== false || is_null($idPadre))
                && (isset($_POST['categoria']) && $_POST['categoria'] !== '')
            ) {
                //comprobamos que el padre esté en la BDDD
                if (!is_null($idPadre) && $model->find((int)$idPadre) === false) {
                    $respuesta = new Respuesta(422, ['mensaje' => 'El padre no es válido']);
                }
                //comprobamos que no está repetido
                $row = $model->findByPadreNombre($_POST['categoria'], $idPadre);
                if ($row === false) {
                    //una vez validamos el idPadre, insertamos la categoria
                    $result = $model->addCategoria($_POST['categoria'], $idPadre);
                    if ($result) {
                        $respuesta = new Respuesta(201, ['mensaje' => 'Categoria agregada correctamente']);
                    }
                } else {
                    $respuesta = new Respuesta(409, ['mensaje' => 'Ya existe una categoria con estos datos']);
                }
            } else {
                $respuesta = new Respuesta(400, ['mensaje' => 'El id_padre o la categoría no son válidos']);
            }
        } catch (\Exception $e) {
            $respuesta = new Respuesta(500);
        } finally {
            $this->view->show('json.view.php', ['respuesta' => $respuesta]);
        }
    }

    public function deleteCategoria(int $idCategoria): void
    {
        try {
            $model = new CategoriaModel();
            try {
                //comprobamos que exite la categoria
                $row = $model->find($idCategoria);
                if ($row && ($model->deleteCategoria($idCategoria))) {
                    $respuesta = new Respuesta(200, ['mensaje' => 'Categoría eliminada correctamente']);
                } else {
                    //podemos introducir un mensaje de feedback para el usuario
                    $respuesta = new Respuesta(404, ['mensaje' => 'No se ha podido eliminar la categoria']);
                }
            } catch (\PDOException $e) {
                //Excepción recogida para controlar cuando hay FK y no se pueden eliminar categorias de las que dependen
                //otras, sin eliminar previamente las dependientes
                $respuesta = new Respuesta(422);
            }
        } catch (\Exception $e) {
            $respuesta = new Respuesta(500);
        } finally {
            $this->view->show('json.view.php', ['respuesta' => $respuesta]);
        }
    }
}
