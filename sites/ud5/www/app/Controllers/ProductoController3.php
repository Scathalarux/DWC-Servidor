<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\CategoriaModel;
use Com\Daw2\Models\CategoriasModel3;
use Com\Daw2\Models\ProductoModel3;
use Com\Daw2\Models\ProveedoresModel3;
use Decimal\Decimal;

class ProductoController3 extends BaseController
{
    public const DEFAULT_ORDER = 1;
    public const DEFAULT_PAGE = 1;

    public const DEFAULT_SIZE_PAGE = 25;

    public function doFiltradoProductos()
    {
        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Productos',
            'breadcrumb' => ['Inicio', 'Productos'],
        ];

        $modeloProductos = new ProductoModel3();
        $order = $this->getOrder();

        $maxPages = $modeloProductos->getMaxPages($_GET, self::DEFAULT_SIZE_PAGE);
        $page = $this->getPage($maxPages);


        $copiaGet = $_GET;

        unset($copiaGet['page']);
        $data['copiaGetPage'] = http_build_query($copiaGet);
        if (!empty($data['copiaGetPage'])) {
            $data['copiaGet'] .= '&';
        };

        unset($copiaGet['order']);
        $data['copiaGet'] = http_build_query($copiaGet);
        if (!empty($data['copiaGet'])) {
            $data['copiaGet'] .= '&';
        };


        $productos = $modeloProductos->getFilteredProductsPage($_GET, $order, self::DEFAULT_SIZE_PAGE, $page);

        $data['productos'] = $productos;
        $data['order'] = $order;
        $data['maxPages'] = $maxPages;
        $data['page'] = $page;

        $this->view->showViews(array('templates/header.view.php', 'productos3.view.php', 'templates/footer.view.php'), $data);
    }

    public function getCommonData()
    {
        $modeloCategoria = new CategoriasModel3();
        $modeloProveedor = new ProveedoresModel3();

        $data['categorias'] = $modeloCategoria->getAll();
        $data['proveedores'] = $modeloProveedor->getAll();

        return $data;
    }

    public function getOrder(): int
    {
        if (!empty($_GET['order']) && filter_var($_GET['order'], FILTER_VALIDATE_INT)) {
            if (abs((int)$_GET['order']) > 0 && abs((int)$_GET['order']) <= count(ProductoModel3::ORDER_COLUMNS)) {
                return (int)$_GET['order'];
            }
        }

        return self::DEFAULT_ORDER;
    }

    public function getPage(int $maxPages): int
    {
        if (!empty($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
            if ((int)$_GET['page'] > 0 && (int)$_GET['page'] <= $maxPages) {
                return (int)$_GET['page'];
            }
        }

        return self::DEFAULT_PAGE;
    }

    public function showAddProducto(array $errores = [], array $input = []): void
    {
        $data = $this->getCommonData();

        $data += [
            'titulo' => 'Agregar producto',
            'breadcrumb' => ['Inicio', 'Productos', 'Agregar producto'],
        ];

        $data['input'] = $input;
        $data['errores'] = $errores;

        $this->view->showViews(array('templates/header.view.php', 'editProductos3.view.php', 'templates/footer.view.php'), $data);
    }

    public function doAddProducto(): void
    {
        $errores = $this->checkForm($_POST);

        if (!empty($errores)) {
            $modeloProducto = new ProductoModel3();

            $insertData = $_POST;
            foreach ($_POST as $key => $value) {
                if ($key === '' || empty($key)) {
                    $insertData[$key] = null;
                }
            }


            if ($modeloProducto->addProducto($insertData)) {
                header('Location: /productos3');
            } else {
                $errores['codigo'] = "No se ha podido realizar la operación";
                $input = filter_var($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->showAddProducto($errores, $input);
            }
        } else {
            $input = filter_var($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showAddProducto($errores, $input);
        }
    }

    public function checkForm(array $data): array
    {
        $errores = [];

        //codigo
        if (empty($data['codigo'])) {
            $errores['codigo'] = "EL código es requerido";
        } else {
            if (!preg_match('/[\p{L}]{2,3}[\p{N}]{7}/ui', $data['codigo']) && trim($data['codigo']) > 10) {
                $errores['codigo'] = "El código no sigue la estructura adecuada";
            }
        }
        //nombre
        if (empty($data['nombre'])) {
            $errores['nombre'] = "EL nombre es requerido";
        } else {
            if (!preg_match('/[\p{L}]{1,50} - [\p{N}]{1,50}/ui', $data['nombre'])) {
                $errores['nombre'] = "El nombre no sigue la estructura adecuada";
            }
        }

        //descripcion
        if (empty($data['descripcion'])) {
            $errores['descripcion'] = "La descripcion es requerida";
        }

        //proveedor
        if (empty($data['proveedor'])) {
            $errores['proveedor'] = "EL proveedor es requerido";
        } else {
            if (!preg_match('/\p{L}[\p{N}]{7}\p{L}/ui', $data['proveedor'])) {
                $errores['proveedor'] = "El proveedor no sigue la estructura adecuada";
            } else {
                $modeloProveedor = new ProveedoresModel3();
                $proveedor = $modeloProveedor->find($data['proveedor']);
                if (is_null($proveedor)) {
                    $errores['proveedor'] = "El proveedor no es válido";
                }
            }
        }


        //coste
        if (empty($data['coste'])) {
            $errores['coste'] = "EL coste es requerido";
        } else {
            if (filter_var($data['coste'], FILTER_VALIDATE_FLOAT) === false) {
                $errores['coste'] = "El coste debe ser decimal";
            } else {
                if ($data['coste'] < 1) {
                    $errores['coste'] = "El coste debe ser mayor a 0";
                }

                $coste = new Decimal($data['coste']);
                if ($coste - $coste->round(2) != 0) {
                    $errores['coste'] = "El coste solo puede tener 2 decimales";
                }
            }
        }

        //margen
        if (empty($data['margen'])) {
            $errores['margen'] = "EL margen es requerido";
        } else {
            if (filter_var($data['margen'], FILTER_VALIDATE_FLOAT) === false) {
                $errores['margen'] = "El margen debe ser decimal";
            } else {
                if ($data['margen'] < 1) {
                    $errores['margen'] = "El margen debe ser mayor a 0";
                }

                $margen = new Decimal($data['margen']);
                if ($margen - $margen->round(2) != 0) {
                    $errores['margen'] = "El margen solo puede tener 2 decimales";
                }
            }
        }

        //stock
        if (empty($data['stock'])) {
            $errores['stock'] = "EL stock es requerido";
        } else {
            if (filter_var($data['stock'], FILTER_VALIDATE_INT) === false) {
                $errores['stock'] = "El stock debe ser entero";
            } else {
                if ($data['stock'] < 0) {
                    $errores['stock'] = "El stock debe ser mayor o igual a 0";
                }
            }
        }

        //iva
        if (empty($data['iva'])) {
            $errores['iva'] = "EL iva es requerido";
        } else {
            if (filter_var($data['iva'], FILTER_VALIDATE_INT) === false) {
                $errores['iva'] = "El iva debe ser entero";
            } else {
                if ($data['iva'] < 0) {
                    $errores['iva'] = "El stock iva ser mayor o igual a 0";
                }
            }
        }

        //id_categoria
        if (!empty($data['id_categoria'])) {
            if (filter_var($data['id_categoria'], FILTER_VALIDATE_INT) === false) {
                $errores['id_categoria'] = "El id_categoria debe ser entero";
            } else {
                $modeloCategoria = new CategoriasModel3();
                $categoria = $modeloCategoria->find((int)$data['id_categoria']);
                if (is_null($categoria)) {
                    $errores['id_categoria'] = "El id_categoria no es válida";
                }
            }
        }
        return $errores;
    }

    public function showEditProducto(string $codigo, array $errores = [], array $input = []): void
    {
        $modeloProducto = new ProductoModel3();
        $producto = $modeloProducto->getProducto($codigo);
        if (is_null($producto)) {
            header('Location: /productos3');
        }

        $data = $this->getCommonData();
        $data += [
            'titulo' => 'Editar producto',
            'breadcrumb' => ['Inicio', 'Producto', 'Editar Producto'],
            'codigo' => $codigo
        ];
        $data['errores'] = $errores;
        $data['input'] = $input === [] ? $producto : $input;

        $this->view->showViews(array('templates/header.view.php', 'editProductos3.view.php', 'templates/footer.view.php'), $data);
    }

    public function doEditProducto(string $codigo): void
    {
        $modeloProducto = new ProductoModel3();
        $producto = $modeloProducto->getProducto($codigo);
        if (is_null($producto)) {
            header('Location: /productos3');
        }

        $errores = $this->getCommonData();

        if (empty($errores)) {
            $insertData = $_POST;
            foreach ($_POST as $key => $value) {
                if ($key === '' || empty($key)) {
                    $insertData[$key] = null;
                }
            }

            if ($modeloProducto->editProducto($codigo, $insertData)) {
                header('Location: /productos3');
            } else {
                $errores['codigo'] = "No se ha podido realizar la operación";
                $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->showEditProducto($codigo, $input, $errores);
            }
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $this->showEditProducto($codigo, $input, $errores);
        }
    }

    public function doDeleteProducto(string $codigo): void
    {
    }
}
