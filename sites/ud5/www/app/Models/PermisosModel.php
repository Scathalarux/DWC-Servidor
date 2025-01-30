<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class PermisosModel extends BaseDbModel
{
/*    public const CREATE_PERMISOS = 'CREATE TABLE IF NOT EXISTS permisos (
                                    id_rol INT NOT NULL PRIMARY KEY,
                                    seccion VARCHAR(255) NOT NULL PRIMARY KEY,
                                    permisos VARCHAR(5) NULL,
                                    constraint FK_id_rol
                                        foreign key (id_rol) references rol (id_rol)
                                        on update cascade
                                    )';*/

    public function createTablePermisos(): void
    {
        $stmt = $this->pdo->query(self::CREATE_PERMISOS);
        $stmt->fetch();
    }

    public function addPermiso(int $id_rol, string $seccion, string $permisos): bool
    {
        $sql = "INSERT INTO permisos (id_rol, seccion, permisos) VALUES (:id_rol, :seccion, :permisos) ON DUPLICATE KEY UPDATE";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id_rol' => $id_rol, 'seccion' => $seccion, 'permisos' => $permisos]);
    }

    public function getPermisosRol(int $id_rol): array
    {
        $sql = "SELECT * FROM permisos WHERE id_rol = :id_rol";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_rol' => $id_rol]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}