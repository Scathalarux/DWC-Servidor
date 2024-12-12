<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class UsuariosSistemaModel extends BaseDbModel
{
    public const SELECT_BASE = "SELECT u.*, ar.nombre_rol
                                FROM usuario_sistema u
                                LEFT JOIN aux_rol ar ON u.id_rol = ar.id_rol";

    public const COLUMN_ORDER = ['id_usuario', 'id_rol', 'email', 'pass', 'nombre', 'last_date', 'idioma', 'baja'];

    public const DEFAULT_ORDER = 1;

    public function getAll(): array
    {

        $sql = self::SELECT_BASE
        . ' ORDER BY ' . self::COLUMN_ORDER[self::DEFAULT_ORDER - 1] ;

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
