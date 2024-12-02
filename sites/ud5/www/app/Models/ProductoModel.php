<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class ProductoModel extends BaseDbModel
{
    public const SELECT_BASE = "SELECT pr.*, c.nombre_categoria, pv.nombre as nombre_proveedor, (pr.coste * pr.margen * ((100+pr.iva)/100)) as pvp
                                FROM producto pr
                                JOIN proveedor pv ON pv.cif=pr.proveedor
                                LEFT JOIN categoria c ON c.id_categoria=pr.id_categoria";

    public const SELECT_BASE_COUNT = "SELECT COUNT(*)
                                        FROM producto pr
                                        JOIN proveedor pv ON pv.cif=pr.proveedor
                                        LEFT JOIN categoria c ON c.id_categoria=pr.id_categoria";
    public const ALTER_TABLE_PVP = "CREATE TABLE";
    public const COLUMNS_ORDER = ['codigo', 'nombreProducto', 'categoria', 'nombreProveedor', 'stock', 'coste', 'margen', 'pvp'];


    /**
     * Modifica la tabla para poder añadir la columna pvp
     */
    public function alterTable(): void
    {
    }

    /**
     * Función que obtiene los datos de los productos
     * @return array
     */
    public function getAllProducts(): array
    {
        $sql = self::SELECT_BASE;
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Función que filtra y devuelve los productos según los filtros introducidos
     * @param array $datos datos a procesar para ver si hay filtros establecidos por el usuario
     * @return array conjunto de productos resultantes del filtrado (si lo hubiese)
     */
    public function getFilteredProducts(array $datos): array
    {
        //filtros
        $resultado = $this->getFiltrosQuery($datos);

        //procesamiento
        $sql = self::SELECT_BASE . " WHERE " . implode(" AND ", $resultado['condiciones']);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($resultado['vars']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMaxPages(array $data, int $sizePages): int
    {
        //Obtenemos las condiciones (filtros) y las variables asociadas
        $filtrosQuery = $this->getFiltrosQuery($data);

        //calculamos cuantos registros hay
        //si hay filtros los procesamos
        if (!empty($filtrosQuery['condiciones'])) {
            $query = self::SELECT_BASE_COUNT . " WHERE " . implode(" AND ", $filtrosQuery['condiciones']);
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($filtrosQuery['vars']);
        } else {
            //si no hay filtros mostramos todos los usuarios
            $stmt = $this->pdo->query(self::SELECT_BASE_COUNT);
        }

        $numFilas = $stmt->fetchColumn(0);

        //dividimos entre el tamaño de cada página y nos quedamos con el ceil
        $maxPages = (int)ceil($numFilas / $sizePages);

        return $maxPages;
    }

    public function getFiltrosQuery(array $datos): array
    {
        $resultado = [];
        $condiciones = [];
        $vars = [];

        //codigo
        if (!empty($datos['codigo'])) {
            $condiciones[] = "pr.codigo LIKE :codigo";
            $codigo = $datos['codigo'];
            $vars['codigo'] = "%$codigo%";
        }

        //nombre
        if (!empty($datos['nombre'])) {
            $condiciones[] = "pr.nombre LIKE :nombre";
            $nombre = $datos['nombre'];
            $vars['nombre'] = "%$nombre%";
        }

        //categoria (selector multiple)
        if (!empty($datos['id_categoria'])) {
            $varsCondiciones = [];
            $i = 0;

            foreach ((array)$datos['id_categoria'] as $categoria) {
                $varsCondiciones[':id_categoria' . $i] = $categoria;
                $i++;
            }

            $condiciones[] = "pr.id_categoria IN (" . implode(",", array_keys($varsCondiciones)) . ")";
            $vars = array_merge($vars, $varsCondiciones);
        }

        //proveedor (selector normal)
        if (!empty($datos['proveedor'])) {
            $condiciones[] = "pr.proveedor = :proveedor";
            $vars['proveedor'] = $datos['proveedor'];
        }

        //stock minimo
        if (!empty($datos['min_stock'])) {
            $condiciones[] = "pr.stock >= :min_stock";
            $vars['min_stock'] = $datos['min_stock'];
        }

        //stock maximo
        if (!empty($datos['max_stock'])) {
            $condiciones[] = "pr.stock <= :max_stock";
            $vars['max_stock'] = $datos['max_stock'];
        }

        //stock minimo
        if (!empty($datos['min_pvp'])) {
            $condiciones[] = "pvp >= :min_pvp";
            $vars['min_pvp'] = $datos['min_pvp'];
        }

        //stock maximo
        if (!empty($datos['max_pvp'])) {
            $condiciones[] = "pvp <= :max_pvp";
            $vars['max_pvp'] = $datos['max_pvp'];
        }

        $resultado['condiciones'] = $condiciones;
        $resultado['vars'] = $vars;

        return $resultado;
    }

    public function getFilteredPage(array $data, int $order, int $sizePage, int $page): array
    {
        $filtrosQuery = $this->getFiltrosQuery($data);

        $sentido = ($order < 0) ? "DESC" : "ASC";

        $order = abs($order);

        $offset = ($page - 1) * $sizePage;

        if (!empty($filtrosQuery['condiciones'])) {
            $query = self::SELECT_BASE
                . " WHERE " . implode(" AND ", $filtrosQuery['condiciones'])
                . " ORDER BY " . $order . " " . $sentido
                . " LIMIT " . $offset . "," . $sizePage;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($filtrosQuery['vars']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $query = self::SELECT_BASE
                . " ORDER BY " . $order . " " . $sentido
                . " LIMIT " . $offset . "," . $sizePage;
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
