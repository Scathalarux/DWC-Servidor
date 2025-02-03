<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class UsuariosSistemaModel2 extends BaseDbModel
{
    public function findUsuarioEmail(string $email): false|array
    {
        $sql = "SELECT * FROM usuario_sistema WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateFechaAcceso(int $idUsuario):void
    {
        $sql = "UPDATE usuario_sistema SET last_date = now() WHERE id_usuario = :idUsuario";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['idUsuario' => $idUsuario]);
    }
}