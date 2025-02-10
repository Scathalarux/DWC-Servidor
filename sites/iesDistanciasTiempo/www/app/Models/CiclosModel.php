<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use PDO;

class CiclosModel extends BaseDbModel
{
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM ciclos_formativos ORDER BY nombre");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCiclosByCodigoCentro(int $codigoCentro): array
    {
        $sql = "SELECT concat('[',cf.codigo,'] ', cf.nombre) as nombre_ciclo
                FROM ciclos_formativos cf
                LEFT JOIN rel_centro_ciclo_formativo rcf ON rcf.codigo_ciclo = cf.codigo
                LEFT JOIN centros c ON c.codigo = rcf.codigo_centro
                WHERE codigo_centro = :codigoCentro";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['codigoCentro' => $codigoCentro]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}