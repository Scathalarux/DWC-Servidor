<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class RolModel extends BaseDbModel
{
    public function find(int $idRol): array|false
    {
        $sql = 'SELECT * FROM aux_rol where id_rol = :id_rol';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_rol' => $idRol]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAll(): array
    {
        $sql = 'SELECT * FROM aux_rol';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}