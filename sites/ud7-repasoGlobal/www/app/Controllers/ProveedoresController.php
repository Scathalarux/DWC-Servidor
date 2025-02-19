<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\ProveedoresModel;

class ProveedoresController extends BaseController
{

    /**
     * Función que lista los proveedores teniendo en cuenta filtros, un número de página y la ordenación + setido
     * @return void
     */
    public function getProveedores(): void
    {

        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);
    }

    /**
     * Función que obtiene los datos de un proveedor concreto
     * @return void
     */
    public function getProveedor(string $cif): void
    {
        $proveedorModel = new ProveedoresModel();
        $proveedor = $proveedorModel->getProveedorByCif($cif);

        if ($proveedor === false) {
            $respuesta = new Respuesta(404, ['mensaje' => 'No existe el proveedor']);
        } else {
            $respuesta = new Respuesta(200, ['proveedor' => $proveedor]);
        }

        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);
    }

    /**
     * Función que añade un nuevo proveedor
     * @return void
     */
    public function addProveedor(): void
    {
        $proveedorModel = new ProveedoresModel();

        $errores = $this->checkErrors($_POST);
        if ($errores === []) {

        } else {
            $respuesta = new Respuesta(404, ['mensaje' => $errores]);
        }


        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);
    }

    /**
     * Función que borra un proveedor
     * @return void
     */
    public function deleteProveedor(string $cif): void
    {
        $proveedorModel = new ProveedoresModel();
        $proveedor = $proveedorModel->getProveedorByCif($cif);
        if ($proveedor === false) {
            $respuesta = new Respuesta(404, ['mensaje' => 'No existe el proveedor']);
        } else {
            try {
                $resultado = $proveedorModel->deleteProveedor($cif);

                if ($resultado !== false) {
                    $respuesta = new Respuesta(200, ['mensaje' => 'Proveedor eliminado correctamente']);
                }
            } catch (\PDOException $e) {
                if ($e->getCode() == 23000) {
                    $respuesta = new Respuesta(400, ['mensaje' => 'No se puede eliminar un proveedor que tiene dependencias con productos']);
                }
            }
        }

        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);
    }

    /**
     * Función que modifica los datos de un proveedor
     * @return void
     */
    public function editProveedor(string $cif): void
    {
        $proveedorModel = new ProveedoresModel();
        $proveedor = $proveedorModel->getProveedorByCif($cif);

        $this->view->show('jsonProveedor.view.php', ['respuesta' => $respuesta]);
    }

    private function checkErrors(array $data, bool $required): array
    {
        $errores = [];
        $proveedorModel = new ProveedoresModel();
        //cif
        if (!empty($data['cif'])) {
            if (!is_string($data['cif'])) {
                $errores['cif'] = 'El código debe ser un string';
            } elseif (!preg_match("/^\p{L}[0-9]{7,8}[\p{L}]*$/iu", $data['cif'])) {
                $errores['cif'] = 'El cif debe estar compuesto por una letra, seguida de 7 números y una letra u 8 números sin letra';
            } else {
                //nos aseguramos que el cif no está repetido
                if ($proveedorModel->getProveedorByCif($data['cif']) !== false) {
                    $errores['cif'] = 'El cif ya existe';
                }
            }
        } elseif ($required) {
            $errores['cif'] = 'El cif es obligatorio';
        }

        //codigo
        if (!empty($data['codigo'])) {
            if (!is_string($data['codigo'])) {
                $errores['codigo'] = 'El código debe ser un string';
            } elseif (!strlen($data['codigo']) > 10) {
                $errores['codigo'] = 'El codigo debe estar compuesto por máximo 10 caracteres';
            } else {
                //nos aseguramos que el codigo no está repetido
                if ($proveedorModel->getProveedorByCodigo($data['codigo']) !== false) {
                    $errores['codigo'] = 'El codigo ya existe';
                }
            }
        } elseif ($required) {
            $errores['codigo'] = 'El código es obligatorio';
        }

        //nombre
        if (!empty($data['nombre_proveedor'])) {
            if (!is_string($data['nombre_proveedor'])) {
                $errores['nombre_proveedor'] = 'El código debe ser un string';
            } elseif (!strlen($data['nombre_proveedor']) > 10) {
                $errores['nombre_proveedor'] = 'El nombre debe estar compuesto por máximo 10 caracteres';
            } else {
                //nos aseguramos que el nombre no está repetido
                if ($proveedorModel->getProveedorByCodigo($data['nombre_proveedor']) !== false) {
                    $errores['nombre_proveedor'] = 'El nombre ya existe';
                }
            }
        } elseif ($required) {
            $errores['nombre_proveedor'] = 'El código es obligatorio';
        }

        //direccion

        //website

        //pais

        //email

        //telefono


        return $errores;
    }
}