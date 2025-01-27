<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\CategoriaModel;
use Com\Daw2\Traits\BaseRestController;

class CategoriaController extends BaseController
{
    //Trait
    use BaseRestController;

    public function traitPut(int $id)
    {
        $model = new CategoriaModel();
        $_put = $this->getParams();
        $errores = $this->checkForm($_put);
        $categoria = $model->find($id);
        if($categoria === false){
            $respuesta = new Respuesta(404, ['mansaje'=>'La categoria no existe']);
        }else{
            if($errores === []){
                if($model->updateCategoria($id, ['id_padre'=> $_put['id_padre'] ?? null, 'nombre_categoria' =>$_put['nombre_categoria']])){
                    $respuesta = new Respuesta(200);
                }else{
                    $respuesta = new Respuesta(500, ['mansaje'=>'Ha ocurrido un error']);
                }

            }else{
                $respuesta = new Respuesta(400, $errores);
            }
        }
    }


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

            $errores = $this->checkForm($_POST);

            if ($errores === []) {
                $idPadre = $this->getPadre($_POST);

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
                if (isset($errores["categoria"])) {
                    $respuesta = new Respuesta(400, ['mensaje' => 'La categoría no es válida']);
                }
                if (isset($errores["id_padre"])) {
                    $respuesta = new Respuesta(422, ['mensaje' => 'El padre no es válido']);
                }
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

    public function updateCategoria(int $idCategoria): void
    {
        $model = new CategoriaModel();
        $categoria = $model->find($idCategoria);

        if ($categoria === false) {
            $respuesta = new Respuesta(404, ['mensaje' => 'La categoría no existe']);
        } else {
            $vars = $this->getBodyData();

            $padreValido = $this->getPadre($_POST);
            if ($padreValido !== false) {
                if (isset($_POST['categoria']) && $_POST['categoria'] !== '') {
                    //comprobamos que no está repetido
                    $row = $model->findByPadreNombre($_POST['categoria'], $padreValido);
                    if ($row === false) {
                        //una vez validamos el idPadre, insertamos la categoria
                        $result = $model->updateCategoria($vars);
                        if ($result) {
                            $respuesta = new Respuesta(201, ['mensaje' => 'Categoria agregada correctamente']);
                        }
                    } else {
                        $respuesta = new Respuesta(409, ['mensaje' => 'Ya existe una categoria con estos datos']);
                    }
                } else {
                    $respuesta = new Respuesta(400, ['mensaje' => 'La categoría no es válida']);
                }
            } else {
                $respuesta = new Respuesta(422, ['mensaje' => 'El padre no es válido']);
            }
        }

        $this->view->show('json.view.php', ['respuesta' => $respuesta]);
    }

    public function checkForm(array $data): array
    {
        $errores = [];
        if (empty($data['categoria'])) {
            $errores['categoria'] = 'La categoria es obligatoria';
        } elseif (!preg_match('/^\p{L}[\p{L} \p{N}]*\p{L}$/', $data['categoria'])) {
            $errores['categoria'] = 'La categoria debe empezar y terminar por letras, y puede contener letras, espacios y números';
        }

        if ($this->getPadre($data) === false) {
            $errores['id_padre'] = 'El padre no es válido';
        }

        return $errores;
    }

    public function getPadre(array $data): bool|int|null
    {
        $model = new CategoriaModel();

        //comprobamos que exista un padre o sea de tipo null
        $idPadre = isset($data['id_padre']) ? $data['id_padre'] : null;

        if (filter_var($idPadre, FILTER_VALIDATE_INT) !== false || is_null($idPadre)) {
            //comprobamos que el padre esté en la BDDD
            if (is_null($idPadre)) {
                return null;
            } elseif ($model->find((int)$idPadre) !== false) {
                return (int)$idPadre;
            }
        }
        return false;
    }

    public function initBodyData(): array
    {

        $peticion = file_get_contents('php://input');
        if (!empty($peticion)) {
            $typeContenido = $_SERVER["CONTENT_TYPE"] ?? 'plain/text';
            if ($typeContenido == 'application/json') {
                $vars = json_decode($peticion, true);
            } else {
                //parsea string a variables y lo almacena en la variable indicada
                parse_str($peticion, $vars);
            }
            return $vars;
        }
        return [];
    }

    public function getBodyData(): array
    {
        if (is_null($this->bodyData)) {
            return $this->bodyData = $this->initBodyData();
        }
        return $this->bodyData;
    }

   
}
