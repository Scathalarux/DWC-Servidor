<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductoModel2 extends BaseDbModel
{
    public const ADD_PVP = "alter table producto
                            modify column pvp decimal(10,2) generated always
                            as (coste*margen*((100+iva)/100)) stored;";
    public const SELECT_BASE = "SELECT p.*, c.nombre_categoria, pv.nombre as nombre_proveedor
                                FROM producto p
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

    public function getFilteredProductos(array $datos, int $order): array
    {
    }
}
