<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class CategoriaModel extends BaseDbModel
{
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM categoria order by nombre_categoria ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}