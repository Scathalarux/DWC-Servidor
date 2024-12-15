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
                values (:id_usuario, :id_rol, :email, :pass, :nombre, :last_date, :idioma, :baja)';

        $stmt = $this->pdo->prepare($sql);

        return  $stmt->execute($data);
    }
}
