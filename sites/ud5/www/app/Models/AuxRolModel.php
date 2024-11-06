<?php

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class AuxRolModel extends BaseDbModel
{
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM aux_rol ORDER BY nombre_rol ASC");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
