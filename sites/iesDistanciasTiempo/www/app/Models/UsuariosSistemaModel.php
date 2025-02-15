<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class UsuariosSistemaModel extends BaseDbModel
{
    public function findByEmail(string $email): array|false
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}