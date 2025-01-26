<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class AuxRolModel extends BaseDbModel
{
    public function getAll():array
    {
        $stmt = $this->pdo->query("SELECT * FROM aux_rol");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find(int $id_rol):false|array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM aux_rol WHERE id_rol = :id_rol");
        $stmt->execute(['id_rol' => $id_rol]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}