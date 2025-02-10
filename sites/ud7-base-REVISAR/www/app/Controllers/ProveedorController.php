<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Ahc\Jwt\JWT;
use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\ProveedorModel;
use Com\Daw2\Models\UsuariosSistemaModel;
use Com\Daw2\Models\UsuariosSistemaModel2;
use Com\Daw2\Traits\BaseRestController;

class ProveedorController extends BaseController
{
    private const SIZE_PAGE = 25;
    private const DEFAULT_PAGE = 1;

    private const DEFAULT_ORDER = 1;
    private const DEFAULT_SENTIDO = 'asc';

    private const TYPE_CHECK = ['add' => 'add', 'edit' => 'edit'];


    public function listarProveedor(): void
    {
        //TODO implementar las "Invalid Argument Exceptions y su manejo en el modelo"
        $modelProveedor = new ProveedorModel();
        //obtención del campo para la ordenación
        $order = $this->getOrder();

        //obtenemos el sentido verificado
        $sentido = $this->getSentido();

        //obtención de a página máxima que se puede alcanzar
        $maxPage = $modelProveedor->getMaxPage($_GET, self::SIZE_PAGE);
        //obtención de la página de la que se quieren mostrar los resultados
        $page = $this->getPage($maxPage);

        $proveedores = $modelProveedor->listProveedoresFiltered($_GET, $order, $sentido, $page, self::SIZE_PAGE);

        if ($proveedores === false || $proveedores === []) {
            $respuesta = new Respuesta(400, ['mensaje' => 'ne se han podido encontrar proveedores con esas características']);
        } else {
            $respuesta = new Respuesta(200, $proveedores);
        }

        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);
    }

    public function getOrder(): int
    {
        if (isset($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && (abs((int)$_GET['order'])) <= ProveedorModel::COLUMNS_ORDER) {
                return (int)$_GET['order'];
            }
        }

        return self::DEFAULT_ORDER;
    }

    public function getPage($maxPage): int
    {
        //TODO
        //Si definimos el default page 1 podemos confundir al usuario
        //Es mejor que devuelva un array vacío
        if (isset($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
            if ((int)$_GET['page'] > 0 && (int)$_GET['page'] <= $maxPage) {
                return (int)$_GET['page'];
            }
        }

        return self::DEFAULT_PAGE;
    }

    public function getSentido(): string
    {
        if (isset($_GET['sentido']) && filter_var($_GET['sentido'], FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            if (mb_strtolower(trim($_GET['sentido'])) === 'asc' || mb_strtolower(trim($_GET['sentido'])) === 'desc') {
                return trim($_GET['sentido']);
            }
        }
        return self::DEFAULT_SENTIDO;
    }

    public function getProveedor(string $cif): void
    {
        //TODO en la mayoría de los frameworks hay una función find en la que se les pasa la
        //clave primaria y devuelve null o el elemento a obtener
        $modelProveedor = new ProveedorModel();
        $proveedor = $modelProveedor->getProveedor($cif);
        if ($proveedor === false) {
            $respuesta = new Respuesta(400, ['mensaje' => 'No existe el proveedor']);
        } else {
            $respuesta = new Respuesta(200, $proveedor);
        }
        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);

    }

    public function addProveedor(): void
    {
        $errores = $this->checkForm($_POST, self::TYPE_CHECK['add']);

        if ($errores === []) {
            $modelProveedor = new ProveedorModel();
            $insertData = $_POST;
            $insertData['telefono'] = empty($insertData['telefono']) ? null : $insertData['telefono'];

            $proveedor = $modelProveedor->addProveedor($insertData);
            if ($proveedor !== false) {
                $respuesta = new Respuesta(201, ['url' => $_ENV['base.url'].'/proveedor/' . $proveedor]);
            } else {
                $respuesta = new Respuesta(500, ['mensaje' => 'Ha ocurrido un error']);
            }

        } else {
            $respuesta = new Respuesta(400, $errores);
        }
        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);
    }

    public function checkForm(array $data, string $type, ?string $cif = null): array
    {
        $errores = [];

        $modelProveedor = new ProveedorModel();

        //cif
        if (!empty($data['cif'])) {
            if(!is_string($data['cif'])){
                $errores['cif'] = 'El cif no es válido, debe ser un string';
            }elseif (!preg_match('/^\p{L}[\p{N}]{7,8}[\p{L}]?$/iu', $data['cif'])) {
                $errores['cif'] = 'El cif no es válido, debe ser un string con formato A1234567B o A12345678';
            } else {
                $proveedor = $modelProveedor->getProveedor($data['cif']);
                if ($proveedor !== false) {
                   //TODO: revisar sentencia para mostrar error cuando el cif a cambiar es igual al cif viejo
                }
            }
        } elseif ($type === 'add') {
            $errores['cif'] = 'El cif es obligatorio';
        }


        //codigo -> string 10, unique
        if (!empty($data['codigo'])) {
            if (!is_string($data['codigo'])) {
                $errores['codigo'] = 'El codigo no es válido, debe ser un string';
            } elseif (mb_strlen(trim($data['codigo'])) > 10) {
                $errores['codigo'] = 'El codigo no es válido, solo puede tener 10 caracteres';
            } else {
                if ($modelProveedor->getProveedorCodigo($data['codigo']) !== false) {
                    $errores['codigo'] = 'El codigo ya existe en la BD';
                }
            }

        } elseif ($type === 'add') {
            $errores['codigo'] = 'El codigo es obligatorio';
        }


        //nombre_proveedor --> string 255
        if (!empty($data['nombre_proveedor'])) {
            if (!is_string($data['nombre_proveedor'])) {
                $errores['nombre_proveedor'] = 'El nombre del proveedor no es válido, debe ser un string';
            } elseif (mb_strlen(trim($data['nombre_proveedor'])) > 255) {
                $errores['nombre_proveedor'] = 'El nombre del proveedor no es válido, solo puede tener 255 caracteres';
            }
        } elseif ($type === 'add') {
            $errores['nombre_proveedor'] = 'El nombre_proveedor es obligatorio';
        }


        //dirección --> string 255
        if (!empty($data['direccion'])) {
            if (!is_string($data['direccion'])) {
                $errores['direccion'] = 'La direccion no es válida, debe ser un string';
            } elseif (mb_strlen(trim($data['direccion'])) > 255) {
                $errores['direccion'] = 'La direccion no es válida, solo puede tener 255 caracteres';
            }
        } elseif ($type === 'add') {
            $errores['direccion'] = 'La direccion es obligatoria';
        }


        //website --> url 255
        if (!empty($data['website'])) {
            if (!is_string($data['website'])) {
                $errores['website'] = 'La website no es válida, debe ser un string';
            } elseif (filter_var($data['website'], FILTER_VALIDATE_URL) === false) {
                $errores['website'] = 'La website no es válida';
            } else {
                if (mb_strlen(trim($data['website'])) > 255) {
                    $errores['website'] = 'La website no es válida, solo puede tener 255 caracteres';
                }
            }
        } elseif ($type === 'add') {
            $errores['website'] = 'La website es obligatoria';
        }


        //pais --> string 100, required
        if (!empty($data['pais'])) {
            if (!is_string($data['pais'])) {
                $errores['pais'] = 'El pais no es válido, debe ser un string';
            } elseif (mb_strlen(trim($data['pais'])) > 100) {
                $errores['pais'] = 'El pais no es válido, debe tener máximo 100 caracteres';
            }
        } elseif ($type === 'add') {
            $errores['pais'] = 'El pais es obligatorio';
        }


        //email --> email 255
        if (!empty($data['email'])) {
            if (!is_string($data['email'])) {
                $errores['email'] = 'El email no es válido, debe ser un string';
            } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errores['email'] = 'El email no es válido';
            } else {
                if (mb_strlen(trim($data['email'])) > 255) {
                    $errores['email'] = 'El email no es válido, solo puede tener 255 caracteres';
                }
            }
        } elseif ($type === 'add') {
            $errores['email'] = 'El email es obligatorio';
        }


        //telefono--> numeros 8 o 12
        if (!empty($data['telefono'])) {
            if (!is_string($data['pais'])) {
                $errores['pais'] = 'El pais no es válido, debe ser un string';
            } elseif (filter_var($data['telefono'], FILTER_VALIDATE_INT) === false) {
                $errores['telefono'] = 'El telefono no es válido, solo puede contener números';
            } else {
                if (mb_strlen(trim($data['telefono'])) !== (8 | 12)) {
                    $errores['telefono'] = 'El telefono no es válido, solo puede contener 8 o 12 números';
                }

            }
        }


        return $errores;
    }

    public
    function deleteProveedor(string $cif): void
    {
        $model = new ProveedorModel();
        $proveedor = $model->find($cif);
        if ($proveedor === false) {
            $respuesta = new Respuesta(404, ['mensaje' => 'El proveedor no existe']);
        } else {
            //añadimos el manejo de la excepción en caso de que se quiera borrar un proveedor del que dependen otros productos
            try {
                $resultado = $model->deleteProveedor($cif);
                if ($resultado === false) {
                    $respuesta = new Respuesta(404, ['mensaje' => 'No se ha podido eliminar el proveedor']);
                } else {
                    $respuesta = new Respuesta(200, ['mensaje' => 'El proveedor se ha eliminado correctamente']);
                }
            } catch (\PDOException $e) {
                if (isset($e->errorInfo[0]) && $e->errorInfo[0] == '23000') {
                    $respuesta = new Respuesta(422, ['mensaje' => 'No se puede eliminar el proveedor ya que tiene dependecias con determinados productos']);
                } else {
                    throw $e;
                }

            }
        }

        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);
    }

    use BaseRestController;

    //TODO: revisar alternativa de rafa (HELPER)
    public function editProveedor(string $oldCif): void
    {
        $model = new ProveedorModel();
        $proveedor = $model->find($oldCif);

        if ($proveedor === false) {
            $respuesta = new Respuesta(404, ['mensaje' => 'El proveedor no existe']);
        } else {
            $patch = $this->getParams();
            if(empty($patch)){
                $respuesta = new Respuesta(400, ['mensaje' => 'No se han introducido campos para la edición']);
            }else{
                $errores = $this->checkForm($patch, self::TYPE_CHECK['edit']);
                if ($errores === []) {
                    $keys = array_keys($proveedor);
                    foreach ($keys as $key) {
                        $insertData[$key] = empty($patch[$key]) ? $proveedor[$key] : $patch[$key];
                    }
                    $resultado = $model->editProveedor($oldCif, $insertData);

                    if ($resultado === false) {
                        $respuesta = new Respuesta(404, ['mensaje' => 'No se ha modificado el proveedor']);
                    } else {
                        $respuesta = new Respuesta(200, ['mensaje' => 'Se ha modificado el proveedor correctamente']);
                    }
                } else {
                    $respuesta = new Respuesta(404, $errores);
                }
            }
        }
        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);
    }
}
