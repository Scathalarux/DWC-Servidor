<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use http\Encoding\Stream\Inflate;

class ProveedoresModel3 extends BaseDbModel
{
    public function getAll(): array
    {
        $sql = 'SELECT * FROM proveedor ORDER BY nombre';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find(string $proveedor): ?array
    {
        $sql = 'SELECT * FROM proveedor WHERE cif = :proveedor';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['proveedor' => $proveedor]);
        $row = $stmt->fetch();
        if ($row) {
            return $row;
        } else {
            return null;
        }
    }
}
