<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use PDO;

class ProveedorController extends BaseController
{
    public const SELECT_BASE = "SELECT * FROM proveedor ORDER BY nombre";

    public function getAll()
    {
        $sql = self::SELECT_BASE;
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(pdo::FETCH_ASSOC);
    }
}
