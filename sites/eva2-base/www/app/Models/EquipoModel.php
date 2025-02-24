<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class EquipoModel extends BaseDbModel
{
    public function find(string $codigo): array|false
    {
        $sql = 'SELECT * FROM equipo where codigo = :codigo';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['codigo' => $codigo]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}