<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class AuxCountriesModel extends BaseDbModel
{
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM `aux_countries` ORDER BY `country_name`");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find(int $idCountry): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `aux_countries` WHERE `id` = ?");
        $stmt->execute([$idCountry]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
}
