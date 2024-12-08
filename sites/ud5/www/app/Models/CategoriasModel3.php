<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class CategoriasModel3 extends BaseDbModel
{
    public function getAll(): array
    {
        $sql = 'SELECT * FROM categoria ORDER BY nombre_categoria';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function find(int $id_categoria): ?array
    {
        $sql = 'SELECT * FROM categoria WHERE id_categoria = :id_categoria';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_categoria' => $id_categoria]);
        $row = $stmt->fetch();
        if ($row) {
            return $row;
        } else {
            return null;
        }
    }
}
