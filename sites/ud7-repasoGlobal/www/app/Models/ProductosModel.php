<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class ProductosModel extends BaseDbModel
{

    public function getProductosProveedor(string $cif): false|array
    {
        $sql = "SELECT codigo, nombre, descripcion, coste, margen, iva, stock FROM producto WHERE proveedor = :cif";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":cif" => $cif]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}