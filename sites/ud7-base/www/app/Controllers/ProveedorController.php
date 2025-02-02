<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\ProveedorModel;

class ProveedorController extends BaseController
{
    private const SIZE_PAGE = 25;
    private const DEFAULT_PAGE = 1;

    private const DEFAULT_ORDER = 1;

    public function login(): void
    {
    }

    public function listarProveedor(): void
    {
        $modelProveedor = new ProveedorModel();
        //obtención del campo para la ordenación
        $order = $this->getOrder();

        //obtención de a página máxima que se puede alcanzar
        $maxPage = $modelProveedor->getMaxPage($_GET, self::SIZE_PAGE);
        //obtención de la página de la que se quieren mostrar los resultados
        $page = $this->getPage($maxPage);

        $proveedores = $modelProveedor->listProveedoresFiltered($_GET, $order, $page, self::SIZE_PAGE);

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
        if (isset($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
            if ((int)$_GET['page'] > 0 && (int)$_GET['page'] <= $maxPage) {
                return (int)$_GET['page'];
            }
        }

        return self::DEFAULT_PAGE;
    }

    public function getProveedor(string $cif): void
    {
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
        $errores = $this->checkForm($_POST);

        if ($errores === []) {

        } else {
            $respuesta = new Respuesta(400, $errores);
        }
        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);
    }

    public function checkForm(array $data): array
    {
        $errores = [];

        $modelProveedor = new ProveedorModel();

        //cif
        if (!empty($data['cif'])) {
            if (!preg_match('/^\p{L}[\p{N}]{7}\p{L}$/', $data['cif'])) {
                $errores['cif'] = 'El cif no es válido';
            }
        } else {
            $errores['cif'] = 'El cif es obligatorio';
        }


        //codigo -> string 10, unique
        if (!empty($data['codigo'])) {
            if (mb_strlen(trim($data['codigo'])) > 10) {
                $errores['codigo'] = 'El codigo no es válido, solo puede tener 10 caracteres';
            } else {
                if ($modelProveedor->getProveedorCodigo($data['codigo']) !== false) {
                    $errores['codigo'] = 'El codigo ya existe en la BD';
                }
            }
        } else {
            $errores['codigo'] = 'El codigo es obligatorio';
        }


        //nombre_proveedor --> string 255
        if (!empty($data['nombre_proveedor'])) {
            if (mb_strlen(trim($data['nombre_proveedor'])) > 255) {
                $errores['nombre_proveedor'] = 'El nombre_proveedor no es válido, solo puede tener 255 caracteres';
            }
        } else {
            $errores['nombre_proveedor'] = 'El nombre_proveedor es obligatorio';
        }


        //dirección --> string 255
        if (!empty($data['direccion'])) {
            if (mb_strlen(trim($data['direccion'])) > 255) {
                $errores['direccion'] = 'La direccion no es válida, solo puede tener 255 caracteres';
            }
        } else {
            $errores['direccion'] = 'La direccion es obligatoria';
        }


        //website --> url 255
        if (!empty($data['website'])) {
            if (filter_var($data['website'], FILTER_VALIDATE_URL) === false) {
                $errores['website'] = 'La website no es válida';
            } else {
                if (mb_strlen(trim($data['website'])) > 255) {
                    $errores['website'] = 'La website no es válida, solo puede tener 255 caracteres';
                }
            }
        } else {
            $errores['cif'] = 'La website es obligatoria';
        }


        //pais --> string 100, required
        if (!empty($data['pais'])) {
            if (mb_strlen(trim($data['pais'])) > 100) {
                $errores['pais'] = 'El pais no es válido';
            }
        } else {
            $errores['pais'] = 'El pais es obligatorio';
        }


        //email --> email 255
        if (!empty($data['email'])) {
            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errores['email'] = 'El email no es válido';
            } else {
                if (mb_strlen(trim($data['email'])) > 255) {
                    $errores['email'] = 'El email no es válido, solo puede tener 255 caracteres';
                }
            }
        } else {
            $errores['email'] = 'El email es obligatorio';
        }


        //telefono--> numeros 8 o 12
        if (!empty($data['telefono'])) {
            if (filter_var($data['telefono'], FILTER_VALIDATE_INT) === false) {
                $errores['telefono'] = 'El telefono no es válido, solo puede contener números';
            } else {
                if (mb_strlen(trim($data['email'])) != 8 || mb_strlen(trim($data['email'])) != 12) {
                    $errores['telefono'] = 'El telefono no es válido, solo puede contener 8 o 12 números';
                }
            }
        }


        return $errores;
    }

    public
    function deleteProveedor(string $cif): void
    {
    }

    public
    function editProveedor(string $cif): void
    {
    }
}
