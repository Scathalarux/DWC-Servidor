<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class AuxTipoProveedor extends BaseDbModel
{
    public function getAll():array
    {
        $sql = 'SELECT * FROM aux_tipo_proveedor ORDER BY nombre_tipo_proveedor';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}