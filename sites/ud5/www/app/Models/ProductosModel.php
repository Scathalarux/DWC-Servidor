<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductosModel extends BaseDbModel
{
    public const SELECT_BASE = "SELECT p.*, pv.nombre as nombre_proveedor, c.nombre_categoria, (p.coste * p.marge * ((100+p.iva)/100)) as pvp
                            FROM productos p
                            JOIN proveedor pv ON p.proveedor = pv.cif
                            LEFT JOIN categoria c ON p.id_categoria = c-id_categoria";

    public const ORDER_COLUMNS = ['codigo','nombre', 'nombre_proveedor', 'nombre_categoria', 'stock', 'coste','margen', 'pvp'];

    public function getAllProducts(): array
    {
        $stmt = $this->pdo->prepare(self::SELECT_BASE);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
