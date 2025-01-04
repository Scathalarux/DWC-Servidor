<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class AuxCountriesModel extends BaseDbModel
{
    public function getAll(): array
    {
        $sql = 'SELECT * FROM aux_countries ORDER BY country_name';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find(int $id_country): ?array
    {
        $sql = 'SELECT * FROM aux_countries WHERE id_country = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_country]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
