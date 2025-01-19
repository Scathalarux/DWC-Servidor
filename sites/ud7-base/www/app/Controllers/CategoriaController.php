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
            $id_padre = isset($_POST['id_padre']) ? $_POST['id_padre'] : null;
            //comprobamos que no está repe
            if ((filter_var($id_padre, FILTER_VALIDATE_INT) !== false || is_null($id_padre)) && $_POST['nombre_categoria'] !== '') {
                $row = $model->findByPadreNombre($_POST['nombre_categoria'], $id_padre);
                if ($row) {
                    $respuesta = new Respuesta(409);
                } else {
                    //comprobamos que el padre esté en la BDDD
                    $padre = $model->find($id_padre);
                    if ($padre === false) {
                        $respuesta = new Respuesta(422);
                    } elseif ($padre === null || $padre) {
                        //una vez validamos el id_padre, insertamos la categoria
                        $result = $model->addCategoria($_POST['nombre_categoria'], $id_padre);
                        if ($result) {
                            $respuesta = new Respuesta(201);
                        }
                    }
                }
            } else {
                $respuesta = new Respuesta(400);
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
