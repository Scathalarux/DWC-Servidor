<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class AuxRolModel extends BaseDbModel
{
    public function getAll(): array
    {
        $sql = 'SELECT * FROM aux_rol ORDER BY nombre_rol';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function find(int $id_rol): ?array
    {
        $sql = 'SELECT * FROM aux_rol WHERE id_rol = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_rol]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
