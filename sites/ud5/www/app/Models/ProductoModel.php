<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProductoModel extends BaseDbModel
{
    public const SELECT_BASE = "SELECT pr.*, c.nombre_categoria, pv.nombre as nombre_proveedor, (pr.coste * pr.margen * ((100+pr.iva)/100)) as pvp
                                FROM producto pr
                                JOIN proveedor pv ON pv.cif=pr.proveedor
                                LEFT JOIN categoria c ON c.id_categoria=pr.id_categoria";


    /**
     * Función que obtiene los datos de los productos
     * @return array
     */
    public function getProducts(): array
    {
        $sql = self::SELECT_BASE;
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
