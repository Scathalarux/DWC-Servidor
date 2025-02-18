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
        $proveedor = $proveedorModel->getProveedorByCif($cif);

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
}