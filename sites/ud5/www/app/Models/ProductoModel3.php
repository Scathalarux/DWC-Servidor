<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductoModel3 extends BaseDbModel
{
    public const ALTER_TABLE_PVP = "alter table producto add column pvp decimal(10,2) generated always as (coste*margen*((100+iva)/100)) stored";
    public const SELECT_BASE = "SELECT p.*, c.nombre_categoria, pv.nombre as nombre_proveedor " . self::FROM;
    public const COUNT_BASE = "SELECT COUNT(*) " . self::FROM;
    public const FROM = " FROM producto p
                        JOIN proveedor pv ON pv.cif = p.proveedor
                        LEFT JOIN categoria c ON c.id_categoria = p.id_categoria";
    const ORDER_COLUMNS = ['codigo', 'nombre', 'id_categoria', 'proveedor', 'stock', 'coste', 'margen', 'pvp'];

    public function getFilteredProductos(array $data, int $order): array
    {
        $filtros = $this->filtrosQuery($data);
        $sentido = ($order > 0) ? " ASC " : " DESC ";
        $order = abs($order);

        if (!empty($filtros['condiciones'])) {
            $sql = self::SELECT_BASE
                . " WHERE " . implode(" AND ", $filtros['condiciones'])
                . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . $sentido;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $stmt = $this->pdo->query(self::SELECT_BASE
                . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . $sentido);
        }
        var_dump($stmt);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function filtrosQuery(array $data): array
    {
        $condiciones = [];
        $vars = [];

        //codigo
        if (!empty($data['codigo'])) {
            $condiciones[] = " p.codigo LIKE :codigo";
            $codigo = $data['codigo'];
            $vars['codigo'] = "%$codigo%";
        }

        //nombre
        if (!empty($data['nombre'])) {
            $condiciones[] = " p.nombre LIKE :nombre";
            $nombre = $data['nombre'];
            $vars['nombre'] = "%$nombre%";
        }

        //proveedor
        if (!empty($data['proveedor'])) {
            $condiciones[] = " p.proveedor = :proveedor";
            $vars['proveedor'] = $data['proveedor'];
        }

        //stock
        if (!empty($data['minStock'])) {
            $condiciones[] = " p.stock >= :minStock";
            $vars['minStock'] = $data['minStock'];
        }
        if (!empty($data['maxStock'])) {
            $condiciones[] = " p.stock <= :maxStock";
            $vars['maxStock'] = $data['maxStock'];
        }

        //id_categoria
        if (!empty($data['id_categoria'])) {
            $varsCategoria = [];
            $i = 1;
            foreach ($data['id_categoria'] as $categoria) {
                $varsCategoria[':id_categoria' . $i] = $categoria;
                $i++;
            }
            $condiciones[] = " p . id_categoria IN (" . implode(',', array_keys($varsCategoria)) . ")";
            $vars = array_merge($vars, $varsCategoria);
        }

        //pvp
        if (!empty($data['minPvp'])) {
            $condiciones[] = " p.pvp >= :minPvp";
            $vars['minPvp'] = $data['minPvp'];
        }
        if (!empty($data['maxPvp'])) {
            $condiciones[] = " p.pvp <= :maxPvp";
            $vars['maxPvp'] = $data['maxPvp'];
        }

        $resultado['condiciones'] = $condiciones;
        $resultado['vars'] = $vars;

        return $resultado;
    }

    public function getMaxPages(array $data, int $sizePage): int
    {
        $filtros = $this->filtrosQuery($data);

        if (!empty($filtros['condiciones'])) {
            $sql = self::COUNT_BASE . " WHERE " . implode(" AND ", $filtros['condiciones']);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $sql = self::COUNT_BASE;
            $stmt = $this->pdo->query($sql);
        }
        $rows = $stmt->fetchColumn(0);
        $rowsPage = (int)ceil($rows / $sizePage);
        return $rowsPage;
    }

    public function getFilteredProductsPage(array $data, int $order, int $sizePage, int $page): array
    {
        $filtros = $this->filtrosQuery($data);
        $sentido = ($order > 0) ? " ASC " : " DESC ";
        $order = abs($order);
        $offset = ($page - 1) * $sizePage;

        if (!empty($filtros['condiciones'])) {
            $sql = self::SELECT_BASE
                . " WHERE " . implode(" AND ", $filtros['condiciones'])
                . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . $sentido
                . " LIMIT " . $offset . ', ' . $sizePage;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $sql = self::SELECT_BASE
                . " ORDER BY " . self::ORDER_COLUMNS[$order - 1] . $sentido
            . " LIMIT " . $offset . ", " . $sizePage;
            $stmt = $this->pdo->query($sql);
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addProducto(array $data): bool
    {
        $sql = "INSERT INTO producto (codigo, nombre, descripcion, proveedor, coste, margen, stock, iva, id_categoria) 
                values (:codigo, :nombre, :descripcion, :proveedor, :coste, :margen, :stock, :iva, :id_categoria)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function getProducto(string $codigo): ?array
    {

        $sql = "SELECT * FROM producto WHERE codigo = :codigo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['codigo' => $codigo]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function editProducto(string $codigo, array $data): bool
    {
        $sql = " UPDATE producto SET codigo = : codigo, nombre = :nombre, descripcion = :descripcion, proveedor = :proveedor, coste = :coste, margen = :margen, stock = :stock, iva = :iva, id_categoria = :id_categoria WHERE codigo = :oldCodigo";
        $stmt = $this->pdo->prepare($sql);
        $data['oldCodigo'] = $codigo;
        return $stmt->execute($data);
    }
}
