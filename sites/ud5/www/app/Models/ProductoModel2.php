<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductoModel2 extends BaseDbModel
{
    public const ADD_PVP = "alter table producto
                            add column pvp decimal(10,2) generated always
                            as (coste*margen*((100+iva)/100)) stored;";
    public const SELECT_BASE = "SELECT p.*, c.nombre_categoria, pv.nombre as nombre_proveedor " . self::FROM;

    public const FROM = "FROM producto p
                         JOIN proveedor pv ON pv.cif = p.proveedor
                         LEFT JOIN categoria c ON c.id_categoria = p.id_categoria";

    public const ORDER_COLUMNS = ['codigo', 'nombre', 'nombre_categoria', 'nombre_proveedor', 'stock', 'coste', 'margen', 'pvp'];

    public function addColumn(): void
    {
        $stmt = $this->pdo->query(self::ADD_PVP);
    }

    /**
     * Función que devuelve el listado de productos con los campos pedidos con el formato de la query
     * @return array conjunto de productos
     */
    public function getProductos(): array
    {
        $stmt = $this->pdo->query(self::SELECT_BASE);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function filtrosQuery(array $datos): array
    {
        $condiciones = [];
        $vars = [];

        //Por código artículo (LIKE)
        if (!empty($datos['codigo'])) {
                $condiciones[] = " p.codigo LIKE :codigo";
                $codigo = $datos['codigo'];
                $vars['codigo'] = "%$codigo%";
        }

        //Por nombre artículo (LIKE)
        if (!empty($datos['nombre'])) {
            $condiciones[] = " p.nombre LIKE :nombre";
            $nombre = $datos['nombre'];
            $vars['nombre'] = "%$nombre%";
        }

        //Por categoría (Select múltiple)
        if (!empty($datos['categoria'])) {
            $varsCategoria = [];
            $i = 1;
            foreach ((array)$datos['categoria'] as $categoria) {
                $varsCategoria[':id_categoria' . $i] = $categoria;
                $i++;
            }
            $condiciones[] = " p.id_categoria IN ( " . implode(',', array_keys($varsCategoria)) . " ) ";
            $vars = array_merge($vars, $varsCategoria);
        }

        //Por proveedor (select normal)
        if (!empty($datos['proveedor'])) {
            $condiciones[] = " p.proveedor = :proveedor";
            $vars['proveedor'] = $datos['proveedor'];
        }

        //Por stock (filtro con valor máximo y mínimo)
        if (!empty($datos['minStock']) && filter_var($datos['minStock'], FILTER_VALIDATE_INT)) {
            $condiciones[] = " p.stock >= :minStock";
            $vars['minStock'] = $datos['minStock'];
        }
        if (!empty($datos['maxStock']) && filter_var($datos['maxStock'], FILTER_VALIDATE_INT)) {
            $condiciones[] = " p.stock <= :maxStock";
            $vars['maxStock'] = $datos['maxStock'];
        }


        //Por PVP (filtro con valor máximo y mínimo)
        if (!empty($datos['minPvp']) && filter_var($datos['minPvp'], FILTER_VALIDATE_FLOAT)) {
            $condiciones[] = " p.pvp >= :minPvp";
            $vars['minPvp'] = $datos['minPvp'];
        }
        if (!empty($datos['maxPvp']) && filter_var($datos['maxPvp'], FILTER_VALIDATE_FLOAT)) {
            $condiciones[] = " p.pvp <= :maxPvp";
            $vars['maxPvp'] = $datos['maxPvp'];
        }


        $resultado['condiciones'] = $condiciones;
        $resultado['vars'] = $vars;

        return $resultado;
    }

    public function getFilteredProductos(array $datos, int $order): array
    {
        $filtros = $this->filtrosQuery($datos);

        $sentido = $order > 0 ? "ASC" : "DESC";
        $order = abs($order);

        if (!empty($filtros['condiciones'])) {
            $sql = self::SELECT_BASE
                . " WHERE " . implode(' AND ', $filtros['condiciones'])
                . " ORDER BY " . (self::ORDER_COLUMNS[$order - 1]) . " " . $sentido;

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($filtros['vars']);
        } else {
            $sql = self::SELECT_BASE . " ORDER BY " . (self::ORDER_COLUMNS[$order - 1]) . " " . $sentido;
            $stmt = $this->pdo->query($sql);
        }
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
