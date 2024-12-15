<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class AuxContinenteModel extends BaseDbModel
{

    public function getAll():array
    {
        $sql = 'SELECT * FROM aux_continente ORDER BY nombre_continente';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}