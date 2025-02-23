<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class LogModel extends BaseDbModel
{
    public function addLod(array $data): void
    {
        $sql = 'INSERT INTO log (operacion, tabla, detalle, fecha) VALUES (:operacion, :tabla, :detalle, now())';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }
}