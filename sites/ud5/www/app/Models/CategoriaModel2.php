<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class CategoriaModel2 extends BaseDbModel
{
    public const SELECT_BASE = "SELECT * FROM categoria ORDER BY nombre_categoria";

    public function getAll(): array
    {
        $stmt = $this->pdo->query(self::SELECT_BASE);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find(int $id_categoria): ?array
    {
        $stmt = $this->pdo->prepare("select * from categoria where id_categoria = ?");
        $stmt->execute([$id_categoria]);
        $row = $stmt->fetch();
        if ($row) {
            return $row;
        } else {
            return null;
        }
    }
}
