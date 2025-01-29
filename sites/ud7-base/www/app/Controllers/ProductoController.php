<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Libraries\Respuesta;
use Com\Daw2\Models\CategoriaModel;
use Com\Daw2\Models\ProductosModel;
use Com\Daw2\Models\ProveedorModel;
use Com\Daw2\Traits\BaseRestController;
use Decimal\Decimal;

class ProductoController extends BaseController
{
    private const CHECK_FORM_TYPE = ['add' => 'add','edit' => 'edit'];
    public function listProductos(): void
    {
        $modeloProductos = new ProductosModel();
        $productos = $modeloProductos->getAll();
        if (is_array($productos)) {
            $respuesta = new Respuesta(200, $productos);
        }
        //El error 500 ya se procesa por otr lado

        $this->view->show('jsonProductos.view.php', ['respuesta' => $respuesta]);
    }

    public function listProductosFiltrados(): void
    {
        $modeloProductos = new ProductosModel();
        $productos = $modeloProductos->getFiltered($_GET);
        if (is_array($productos)) {
            $respuesta = new Respuesta(200, $productos);
        }

        $this->view->show('jsonProductos.view.php', ['respuesta' => $respuesta]);
    }

    public function getProducto(string $codigo): void
    {

        $modeloProductos = new ProductosModel();
        $producto = $modeloProductos->find($codigo);
        if (is_array($producto)) {
            $respuesta = new Respuesta(200, $producto);
        } else {
            $respuesta = new Respuesta(404, ['mensaje' => "No existe el producto"]);
        }

        $this->view->show('jsonProductos.view.php', ['respuesta' => $respuesta]);
    }

    public function addProducto(): void
    {
        $errores = $this->checkForm($_POST, self::CHECK_FORM_TYPE['add']);
        if ($errores === []) {
            $modeloProductos = new ProductosModel();
            if($modeloProductos->find($_POST['codigo'])!==false){
                $respuesta = new Respuesta(409, ['mensaje' => "El producto ya existe"]);
            }else{
                $insertData = $_POST;
                $insertData['id_categoria'] = isset($_POST['categoria']) ? $_POST['categoria'] : null;
                $producto = $modeloProductos->addProducto($insertData);
                if ($producto === false) {
                    $respuesta = new Respuesta(404, ['mensaje' => "No se pudo registrar el producto"]);
                } else {
                    $respuesta = new Respuesta(200, ['mensaje' => "Producto agregado correctamente"]);
                }
            }
        } else {
            $respuesta = new Respuesta(200, $errores);
        }


        $this->view->show('jsonProductos.view.php', ['respuesta' => $respuesta]);
    }

    public function checkForm(array $data, string $type): array
    {
        $errores = [];

        //codigo
        if (!empty($data['codigo'])) {
            if (!preg_match('/\p{L}{2,3}\p{N}{7}/', $data['codigo'])) {
                $errores['codigo'] = "El código debe tener una estrucutura de 2-3 letras seguidas de 7 números";
            }
        } elseif ($type === 'add') {
            $errores['codigo'] = "El código del producto es obligatorio";
        }

        //nombre
        if (!empty($data['nombre'])) {
            if (!preg_match('/[\p{L}\p{N} -]+/', $data['nombre'])) {
                $errores['nombre'] = "El nombre debe tener una estrucutura puede contener letras, números, espacios y -";
            }
        } elseif ($type === 'add') {
            $errores['nombre'] = "El nombre del producto es obligatorio";
        }

        //descripcion
        if ($type === 'add' && empty($data['descripcion'])) {
            $errores['descripcion'] = "La descripcion del producto es obligatoria";
        }

        //proveedor
        if (!empty($data['proveedor'])) {
            if (!preg_match('/[\p{L}]{1,2}[\p{N}]{6,7}[\p{L}]/', $data['proveedor'])) {
                $errores['proveedor'] = "El código debe tener una estrucutura de 2 letras seguidas de 6 números y terminar en 1 letra";
            } else {
                $proveedorModel = new ProveedorModel();
                $proveedor = $proveedorModel->find($data['proveedor']);
                if ($proveedor === false) {
                    $errores['proveedor'] = "El proveedor no es valido";
                }
            }
        } elseif ($type === 'add') {
            $errores['proveedor'] = "El proveedor del producto es obligatorio";
        }

        //coste
        if (!empty($data['coste'])) {
            if (filter_var($data['coste'], FILTER_VALIDATE_FLOAT)) {
                $coste = new Decimal($data['coste']);
                if ($coste - $coste->round(2) != 0) {
                    $errores['coste'] = "El coste debe tener 2 números decimales";
                }
            } else {
                $errores['coste'] = 'El coste debe se un número decimal';
            }
        } elseif ($type === 'add') {
            $errores['coste'] = "El coste del producto es obligatorio";
        }

        //margen
        if (!empty($data['margen'])) {
            if (filter_var($data['margen'], FILTER_VALIDATE_FLOAT)) {
                $margen = new Decimal($data['margen']);
                if ($margen - $margen->round(2) != 0) {
                    $errores['margen'] = "El margen debe tener 2 números decimales";
                }
            } else {
                $errores['coste'] = 'El margen debe se un número decimal';
            }
        } elseif ($type === 'add') {
            $errores['margen'] = "El margen del producto es obligatorio";
        }

        // stock
        if (!empty($data['stock'])) {
            if (!filter_var($data['stock'], FILTER_VALIDATE_INT)) {
                $errores['stock'] = "El stock del producto debe se un número entero";
            } else {
                if ($data['stock'] < 0) {
                    $errores['stock'] = "El stock del producto debe ser mayor o igual que 0";
                }
            }
        } elseif ($type === 'add') {
            $errores['stock'] = "El stock del producto es obligatorio";
        }
        //iva
        if (!empty($data['iva'])) {
            if (!filter_var($data['iva'], FILTER_VALIDATE_INT)) {
                $errores['iva'] = "El iva del producto debe se un número entero";
            }
        } elseif ($type === 'add') {
            $errores['iva'] = "El iva del producto es obligatorio";
        }

        //idCategoria
        if (!empty($data['id_categoria'])) {
            $categoriaModel = new CategoriaModel();
            $categoria = $categoriaModel->find($data['id_categoria']);
            if ($categoria === false) {
                $errores['id_categoria'] = "La categoria no es válida";
            }
        }

        return $errores;
    }

    //Trait
    use BaseRestController;

    public function editProducto(string $oldCodigo): void
    {
        $modeloProductos = new ProductosModel();
        $producto = $modeloProductos->find($oldCodigo);
        if ($producto === false) {
            $respuesta = new Respuesta(404, ['mensaje' => 'No existe el producto']);
        } else {
            $_put = $this->getParams();
            $errores = $this->checkForm($_put, self::CHECK_FORM_TYPE['edit']);
            if ($errores === []) {
                $keys = array_keys($producto);
                foreach ($keys as $key) {
                    if (empty($_put[$key])) {
                        $_put[$key] = $producto[$key];
                    }
                }
                $respuesta = $modeloProductos->editProducto($_put, $oldCodigo);
                if ($respuesta === false) {
                    $respuesta = new Respuesta(404, ['mensaje' => 'No se pudo modificar correctamente el producto']);
                } else {
                    $respuesta = new Respuesta(200, ['mensaje' => 'Producto modificado correctamente']);
                }
            } else {
                $respuesta = new Respuesta(404, $errores);
            }
        }

        $this->view->show('jsonProductos.view.php', ['respuesta' => $respuesta]);
    }

    public function deleteProducto(string $codigo): void
    {
        $modeloProductos = new ProductosModel();
        $producto = $modeloProductos->find($codigo);
        if ($producto === false) {
            $respuesta = new Respuesta(404, ['mensaje' => "No se pudo encontrar el producto"]);
        } else {
            if ($modeloProductos->deleteProducto($codigo) === false) {
                $respuesta = new Respuesta(404, ['mensaje' => "El producto no se ha podido eliminar"]);
            } else {
                $respuesta = new Respuesta(200, ['mensaje' => "El producto ha sido eliminado"]);
            }
        }

        $this->view->show('jsonProductos.view.php', ['respuesta' => $respuesta]);
    }
}
