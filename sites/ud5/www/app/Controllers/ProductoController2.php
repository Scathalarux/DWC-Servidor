<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CategoriaModel2;
use Com\Daw2\Models\ProductoModel2;
use Com\Daw2\Models\ProveedorModel2;
use Decimal\Decimal;

class ProductoController2 extends BaseController
{
    public const DEFAULT_ORDER = 1;


    public function doFilteredProductos(): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Productos',
            'breadcrumb' => ['Inicio', 'Productos']
        ];


        $modelo = new ProductoModel2();
        /*$modelo->addColumn();*/

        $order = $this->getOrder();

        $productos = $modelo->getFilteredProductos($_GET, $order);

        //Mantenemos filtros y los transformamos, eliminando el orden
        $copiaGet = $_GET;
        unset($copiaGet['order']);
        $data['copiaGet'] = http_build_query($copiaGet);
        if (!empty($data['copiaGet'])) {
            $data['copiaGet'] .= '&';
        }


        $data['order'] = $order;
        $data['productos'] = $productos;
        $data['input'] = filter_var_array($_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $this->view->showViews(array('templates/header.view.php', 'productos2.view.php', 'templates/footer.view.php'), $data);
    }

    public function getCommonData(): array
    {
        $data = [];
        $modeloCategoria = new CategoriaModel2();
        $modeloProveedor = new ProveedorModel2();
        $data['categorias'] = $modeloCategoria->getAll();
        $data['proveedores'] = $modeloProveedor->getAll();
        return $data;
    }

    public function getOrder(): int
    {
        if (!empty($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) <= count(ProductoModel2::ORDER_COLUMNS)) {
                return (int)$_GET['order'];
            }
        }
        return self::DEFAULT_ORDER;
    }

    public function addProducto(): void
    {
        //comprobamos si hay errores en los datos introducidos para añadir un nuevo producto
        $errores = $this->chechForm($_POST);

        if ($errores === []) {
            $modelo = new ProductoModel2();
            if ($modelo->addProducto($_POST)) {
                //si se añade correctamente redirigimos a la view productos 2
                header('Location: /productos2');
            } else {
                //si no se añade correctamente mostramos la vista de añadir con los errores
                $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $errores['codigo'] = "No se ha podido agregar el producto";
                $this->showAddProducto($errores, $input);
            }
        } else {
            // mostramos la vista con los errores
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showAddProducto($errores, $input);
        }
    }

    public function showAddProducto(array $errores = [], array $input = []): void
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Agregar producto',
            'breadcrumb' => ['Inicio', 'Productos', 'Nuevo producto']
        ];

        $data['input'] = $input;
        $data['errores'] = $errores;

        $this->view->showViews(array('templates/header.view.php', 'editProductos2.view.php', 'templates/footer.view.php'), $data);
    }

    public function chechForm(array $data): array
    {
        $errores = [];

        //Codigo
        if (!empty($data['codigo'])) {
            if (!preg_match('/^\p{L}{2,3}[0-9]{7}$/', $data['codigo'])) {
                $errores['codigo'] = "El código no sigue la estructura adecuada";
            }
        } else {
            $errores['codigo'] = "El codigo es requerido";
        }

        //nombre
        if (!empty($data['nombre'])) {
            if (!preg_match("/[\p{L}]{1,20} - [\p{L}]{1,20}/ui", $data['nombre'])) {
                $errores['nombre'] = "El nombre no sigue la estructura adecuada";
            }
        } else {
            $errores['nombre'] = "El nombre es requerido";
        }

        //Descripcion
        if (empty($data['descripcion'])) {
            $errores['descripcion'] = "La descripcion es requerido";
        }

        //proveedor
        if (!empty($data['proveedor'])) {
            if (!preg_match("/\p{L}[\p{N}]{7}\p{L}/ui", $data['proveedor'])) {
                $errores['proveedor'] = "El nombre no sigue la estructura adecuada";
            } else {
                $proveedorModel = new ProveedorModel2();
                $proveedor = $proveedorModel->find($data['proveedor']);
                if (is_null($proveedor)) {
                    $errores['proveedor'] = "El proveedor no es válido";
                }
            }
        } else {
            $errores['proveedor'] = "El proveedor es requerido";
        }

        //coste
        if (!empty($data['coste']) || $data['iva'] == 0) {
            if (filter_var($data['coste'], FILTER_VALIDATE_FLOAT) === false) {
                $errores['coste'] = "El coste debe ser decimal";
            } else {
                if ($data['coste'] < 0) {
                    $errores['coste'] = "El coste debe ser mayor a cero";
                }
                $coste = new Decimal($data['coste']);
                if ($coste - $coste->round(2) != 0) {
                    $errores['coste'] = "El coste solo puede tener 2 decimales";
                }
            }
        } else {
            $errores['coste'] = "El coste es requerido";
        }

        //margen
        if (!empty($data['margen']) || $data['iva'] == 0) {
            if (filter_var($data['margen'], FILTER_VALIDATE_FLOAT) === false) {
                $errores['margen'] = "El margen debe ser decimal";
            } else {
                if ($data['margen'] < 0) {
                    $errores['margen'] = "El margen debe ser mayor a cero";
                }

                $margen = new Decimal($data['margen']);
                if ($margen - $margen->round(2) != 0) {
                    $errores['margen'] = "El margen solo puede tener 2 decimales";
                }
            }
        } else {
            $errores['margen'] = "El margen es requerido";
        }

        //stock
        if (!empty($data['stock']) || $data['iva'] == 0) {
            if (filter_var($data['stock'], FILTER_VALIDATE_INT) === false) {
                $errores['stock'] = "El stock debe ser un número entero";
            } else {
                if ($data['stock'] < 0) {
                    $errores['stock'] = "El stock debe ser mayor o igual a cero";
                }
            }
        } else {
            $errores['stock'] = "El stock es requerido";
        }

        //iva
        if (!empty($data['iva']) || $data['iva'] == 0) {
            if (filter_var($data['iva'], FILTER_VALIDATE_INT) === false) {
                $errores['iva'] = "El iva debe ser un número entero";
            } else {
                if ($data['iva'] < 0) {
                    $errores['iva'] = "El iva debe ser mayor o igual a cero";
                }
            }
        } else {
            $errores['iva'] = "El iva es requerido";
        }

        //id_categoria
        if (!empty($data['id_categoria'])) {
            foreach ($data['id_categoria'] as $id_categoria) {
                if (filter_var($id_categoria, FILTER_VALIDATE_INT) === false) {
                    $errores['id_categoria'] = "La categoría no tiene un formato válido";
                } else {
                    $categoriaModel = new CategoriaModel2();
                    $categoria = $categoriaModel->find((int)$data['id_categoria']);
                    if (is_null($categoria)) {
                        $errores['id_categoria'] = "La categoría no es válida";
                    }
                }
            }
        }
        return $errores;
    }

    public function showEditProducto(string $codigo, array $errores = [], array $input = []): void
    {
        $modeloProducto = new ProductoModel2();
        $producto = $modeloProducto->getProductoCodigo($codigo);

        if (is_null($producto)) {
            header("Location: /productos2");
        }

        $data = $this->getCommonData();
        $data += [
          'titulo' => 'Editar producto',
          'breadcrumb' => ['Inicio', 'Productos', 'Editar Producto'],
          'producto' => $producto
        ];

        $data['input'] = ($input == []) ? $producto : $input;
        $data['errores'] = $errores;
        $this->view->showViews(array('templates/header.view.php', 'editProductos2.view.php', 'templates/footer.view.php'), $data);
    }

    public function editProducto(string $codigo): void
    {
        $modeloProducto = new ProductoModel2();
        $producto = $modeloProducto->getProductoCodigo($codigo);

        if (is_null($producto)) {
            header("Location: /productos2");
        }

        $errores = $this->chechForm($_POST);

        if ($errores === []) {
            if ($modeloProducto->editProducto($codigo, $_POST)) {
                header("Location: /productos2");
            } else {
                $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $errores["codigo"] = "No se ha podido editar el producto";
                $this->showEditProducto($codigo, $input, $errores);
            }
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showEditProducto($codigo, $input, $errores);
        }
    }

    public function deleteProducto(string $codigo): void
    {
        $modeloProducto = new ProductoModel2();
        $producto = $modeloProducto->getProductoCodigo($codigo);

        if ($producto !== [] || $producto !== false) {
            if ($modeloProducto->deleteProducto($codigo)) {
                header('Location: /productos2');
            }
        }
    }
}
