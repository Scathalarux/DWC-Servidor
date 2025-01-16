<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class RolModel extends BaseDbModel
{
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM `rol` ORDER BY rol");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRol(string $type): bool|array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `rol` WHERE rol LIKE :type");
        $stmt->execute([':type' => "%$type%"]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function find(int $idRol): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `rol` WHERE `id_rol` = ?");
        $stmt->execute([$idRol]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
}
