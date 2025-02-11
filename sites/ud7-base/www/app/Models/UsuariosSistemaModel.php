<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class UsuariosSistemaModel extends BaseDbModel
{
    public const SELECT_BASE = "SELECT u.*, r.rol
                                FROM usuario_sistema u
                                JOIN rol r ON u.id_rol = r.id_rol";

    public const COLUMN_ORDER = ['id_usuario', 'id_rol', 'email', 'pass', 'nombre', 'last_date', 'idioma', 'baja'];

    public const DEFAULT_ORDER = 1;

    public function getAll(int $order): array
    {
        $sentido = $order > 0 ? ' ASC ' : ' DESC ';
        $order = abs($order);

        $sql = self::SELECT_BASE
            . ' ORDER BY ' . self::COLUMN_ORDER[$order - 1] . $sentido;

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addUsuarioSistema(array $data): bool
    {
        $sql = 'INSERT INTO usuario_sistema (id_usuario, id_rol, email, pass, nombre, last_date, idioma, baja) 
                values (:id_usuario, :id_rol, :email, :password, :nombre, :last_date, :idioma, :baja)';

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($data);
    }

    public function getUsuarioID(int $id_usuario): ?array
    {
        $sql = 'SELECT * FROM usuario_sistema WHERE id_usuario = :id_usuario';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_usuario' => $id_usuario]);
        $result = $stmt->fetch();
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function editUsuarioSistema(int $id_usuario, array $data): bool
    {
        $sql = 'UPDATE usuario_sistema SET id_rol = :id_rol, email = :email, pass = :pass, nombre = :nombre, idioma=:idioma, baja =:baja WHERE id_usuario = :id_usuario';
        $stmt = $this->pdo->prepare($sql);
        $data['id_usuario'] = $id_usuario;
        return $stmt->execute($data);
    }

    public function getUsuarioEmail(string $email): false|array
    {
        $sql = 'SELECT * FROM usuario_sistema WHERE email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result;

    }

    public function editUsuarioSistemaDate(int $id_usuario): bool
    {
        $sql = "UPDATE usuario_sistema SET last_date = now() WHERE id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id_usuario' => $id_usuario]);
    }

    public function doDeleteUsuario(int $id_usuario): bool
    {
        $sql = "DELETE FROM usuario_sistema WHERE id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id_usuario' => $id_usuario]);
    }


}
