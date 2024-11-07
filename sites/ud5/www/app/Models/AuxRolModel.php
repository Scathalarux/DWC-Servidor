<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class AuxRolModel extends BaseDbModel
{
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM `aux_rol` ORDER BY nombre_rol");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
