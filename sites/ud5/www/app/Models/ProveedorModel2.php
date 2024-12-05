<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ProveedorModel2 extends BaseDbModel
{
    public const SELECT_BASE = "SELECT * FROM proveedor ORDER BY nombre";

    public function getAll(): array
    {
        $stmt = $this->pdo->query(self::SELECT_BASE);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
