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
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateDateAccess(int $id_usuario): bool
    {
        $stmt = $this->pdo->prepare('UPDATE usuarios SET last_date = current_date() WHERE id_usuario = :id_usuario');
        return $stmt->execute(['id_usuario' => $id_usuario]);
    }

    public function registerUser(array $data): bool
    {
        $sql = "INSERT INTO usuarios (id_grupo, id_center, id_role, email, pass, nombre, superadmin, bloqueado, last_date, idioma, recover_token, recover_time, debug, baja, theme) 
                VALUES (:id_grupo, :id_center, :id_role, :email, :pass, :nombre, :superadmin, :bloqueado, :last_date, :idioma, :recover_token, :recover_time, :debug, :baja, :theme)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
}